import { useEffect, useState } from "react";

import { apiRequest } from "../api/client";
import { Alert } from "../components/ui/Alert";
import { Card } from "../components/ui/Card";
import { LoadingState } from "../components/ui/LoadingState";
import { PageHeader } from "../components/ui/PageHeader";
import type {
    Customer,
    CustomerListResponse,
} from "../types/customer";

function formatDate(value: string | null): string {
    if (!value) {
        return "-";
    }

    const date = new Date(value);

    if (Number.isNaN(date.getTime())) {
        return value;
    }

    return date.toLocaleDateString("ar-EG");
}

function statusLabel(status: string): string {
    switch (status) {
        case "active":
            return "\u0646\u0634\u0637";

        case "inactive":
            return "\u063a\u064a\u0631 \u0646\u0634\u0637";

        case "suspended":
            return "\u0645\u0648\u0642\u0648\u0641";

        default:
            return status;
    }
}

export function CustomersPage() {
    const [customers, setCustomers] = useState<Customer[]>([]);
    const [page, setPage] = useState(1);
    const [pagination, setPagination] =
        useState<CustomerListResponse["meta"] | null>(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState("");

    useEffect(() => {
        async function loadCustomers() {
            setLoading(true);
            setError("");

            try {
                const response = await apiRequest<CustomerListResponse>(
                    `/customers?page=${page}`,
                );

                setCustomers(response.data);
                setPagination(response.meta);
            } catch (exception) {
                setError(
                    exception instanceof Error
                        ? exception.message
                        : "Unable to load customers.",
                );
            } finally {
                setLoading(false);
            }
        }

        void loadCustomers();
    }, [page]);

    return (
        <main dir="rtl" className="mx-auto max-w-7xl px-6 py-8">
            <PageHeader
                title={"\u0627\u0644\u0639\u0645\u0644\u0627\u0621"}
                description={
                    "\u0625\u062f\u0627\u0631\u0629 \u0648\u0645\u0631\u0627\u062c\u0639\u0629 \u0627\u0644\u0639\u0645\u0644\u0627\u0621"
                }
            />

            {loading && <LoadingState />}

            {error && <Alert variant="error">{error}</Alert>}

            {!loading && !error && (
                <Card className="overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="min-w-full divide-y divide-slate-200">
                            <thead className="bg-slate-50">
                                <tr>
                                    <th className="px-6 py-4 text-right text-xs font-semibold text-slate-500">
                                        #
                                    </th>

                                    <th className="px-6 py-4 text-right text-xs font-semibold text-slate-500">
                                        {"\u0627\u0644\u0627\u0633\u0645"}
                                    </th>

                                    <th className="px-6 py-4 text-right text-xs font-semibold text-slate-500">
                                        {"\u0627\u0644\u0647\u0627\u062a\u0641"}
                                    </th>

                                    <th className="px-6 py-4 text-right text-xs font-semibold text-slate-500">
                                        {"\u0627\u0644\u0628\u0631\u064a\u062f \u0627\u0644\u0625\u0644\u0643\u062a\u0631\u0648\u0646\u064a"}
                                    </th>

                                    <th className="px-6 py-4 text-right text-xs font-semibold text-slate-500">
                                        {"\u0627\u0644\u062d\u0627\u0644\u0629"}
                                    </th>

                                    <th className="px-6 py-4 text-right text-xs font-semibold text-slate-500">
                                        {"\u062a\u0627\u0631\u064a\u062e \u0627\u0644\u0625\u0646\u0634\u0627\u0621"}
                                    </th>
                                </tr>
                            </thead>

                            <tbody className="divide-y divide-slate-200 bg-white">
                                {customers.map((customer) => (
                                    <tr
                                        key={customer.id}
                                        className="hover:bg-slate-50"
                                    >
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-slate-500">
                                            {customer.id}
                                        </td>

                                        <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900">
                                            {customer.name}
                                        </td>

                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                            {customer.phone}
                                        </td>

                                        <td className="px-6 py-4 text-sm text-slate-600">
                                            {customer.email ?? "-"}
                                        </td>

                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                            {statusLabel(customer.status)}
                                        </td>

                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-slate-500">
                                            {formatDate(customer.created_at)}
                                        </td>
                                    </tr>
                                ))}

                                {customers.length === 0 && (
                                    <tr>
                                        <td
                                            colSpan={6}
                                            className="px-6 py-10 text-center text-sm text-slate-500"
                                        >
                                            {
                                                "\u0644\u0627 \u064a\u0648\u062c\u062f \u0639\u0645\u0644\u0627\u0621 \u0644\u0639\u0631\u0636\u0647\u0645."
                                            }
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>

                    {pagination && (
                        <div className="flex items-center justify-between border-t border-slate-200 px-6 py-4">
                            <p className="text-sm text-slate-500">
                                {`\u0639\u0631\u0636 ${pagination.from ?? 0} - ${pagination.to ?? 0} \u0645\u0646 ${pagination.total}`}
                            </p>

                            <div className="flex items-center gap-2">
                                <button
                                    type="button"
                                    disabled={pagination.current_page <= 1}
                                    onClick={() =>
                                        setPage((current) =>
                                            Math.max(1, current - 1),
                                        )
                                    }
                                    className="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
                                >
                                    {"\u0627\u0644\u0633\u0627\u0628\u0642"}
                                </button>

                                <span className="px-3 text-sm text-slate-600">
                                    {pagination.current_page} /{" "}
                                    {pagination.last_page}
                                </span>

                                <button
                                    type="button"
                                    disabled={
                                        pagination.current_page >=
                                        pagination.last_page
                                    }
                                    onClick={() =>
                                        setPage((current) =>
                                            Math.min(
                                                pagination.last_page,
                                                current + 1,
                                            ),
                                        )
                                    }
                                    className="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
                                >
                                    {"\u0627\u0644\u062a\u0627\u0644\u064a"}
                                </button>
                            </div>
                        </div>
                    )}
                </Card>
            )}
        </main>
    );
}