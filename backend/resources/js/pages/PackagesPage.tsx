import { useEffect, useState } from "react";

import { apiRequest } from "../api/client";
import { Alert } from "../components/ui/Alert";
import { Card } from "../components/ui/Card";
import { LoadingState } from "../components/ui/LoadingState";
import { PageHeader } from "../components/ui/PageHeader";
import type {
    Package,
    PackageListResponse,
} from "../types/package";

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

function formatSpeed(value: number | null): string {
    if (value === null) {
        return "-";
    }

    return `${value} Mbps`;
}

function formatPrice(value: string | number): string {
    const amount = Number(value);

    if (Number.isNaN(amount)) {
        return String(value);
    }

    return amount.toLocaleString("ar-EG", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });
}

function billingCycleLabel(value: string | null): string {
    switch (value) {
        case "day":
            return "\u064a\u0648\u0645\u064a";

        case "week":
            return "\u0623\u0633\u0628\u0648\u0639\u064a";

        case "month":
            return "\u0634\u0647\u0631\u064a";

        case "year":
            return "\u0633\u0646\u0648\u064a";

        default:
            return value ?? "-";
    }
}

function booleanLabel(value: boolean | number): string {
    return Boolean(value)
        ? "\u0646\u0639\u0645"
        : "\u0644\u0627";
}

export function PackagesPage() {
    const [packages, setPackages] = useState<Package[]>([]);
    const [page, setPage] = useState(1);
    const [pagination, setPagination] =
        useState<PackageListResponse["meta"] | null>(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState("");

    useEffect(() => {
        async function loadPackages() {
            setLoading(true);
            setError("");

            try {
                const response = await apiRequest<PackageListResponse>(
                    `/packages?page=${page}`,
                );

                setPackages(response.data);
                setPagination(response.meta);
            } catch (exception) {
                setError(
                    exception instanceof Error
                        ? exception.message
                        : "Unable to load packages.",
                );
            } finally {
                setLoading(false);
            }
        }

        void loadPackages();
    }, [page]);

    return (
        <main dir="rtl" className="mx-auto max-w-7xl px-6 py-8">
            <PageHeader
                title={"\u0627\u0644\u0628\u0627\u0642\u0627\u062a"}
                description={
                    "\u0625\u062f\u0627\u0631\u0629 \u0648\u0645\u0631\u0627\u062c\u0639\u0629 \u0628\u0627\u0642\u0627\u062a \u0627\u0644\u0625\u0646\u062a\u0631\u0646\u062a"
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
                                        {"\u0627\u0644\u0633\u0631\u0639\u0629"}
                                    </th>

                                    <th className="px-6 py-4 text-right text-xs font-semibold text-slate-500">
                                        {"\u0627\u0644\u0633\u0639\u0631"}
                                    </th>

                                    <th className="px-6 py-4 text-right text-xs font-semibold text-slate-500">
                                        {"\u0627\u0644\u0641\u0648\u062a\u0631\u0629"}
                                    </th>

                                    <th className="px-6 py-4 text-right text-xs font-semibold text-slate-500">
                                        {"\u0623\u064a\u0627\u0645 \u0627\u0644\u0633\u0645\u0627\u062d"}
                                    </th>

                                    <th className="px-6 py-4 text-right text-xs font-semibold text-slate-500">
                                        {"\u062a\u0639\u0644\u064a\u0642 \u062a\u0644\u0642\u0627\u0626\u064a"}
                                    </th>

                                    <th className="px-6 py-4 text-right text-xs font-semibold text-slate-500">
                                        {"\u0625\u0646\u0647\u0627\u0621 \u062a\u0644\u0642\u0627\u0626\u064a"}
                                    </th>

                                    <th className="px-6 py-4 text-right text-xs font-semibold text-slate-500">
                                        {"\u062a\u0627\u0631\u064a\u062e \u0627\u0644\u0625\u0646\u0634\u0627\u0621"}
                                    </th>
                                </tr>
                            </thead>

                            <tbody className="divide-y divide-slate-200 bg-white">
                                {packages.map((packageItem) => (
                                    <tr
                                        key={packageItem.id}
                                        className="hover:bg-slate-50"
                                    >
                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-slate-500">
                                            {packageItem.id}
                                        </td>

                                        <td className="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900">
                                            {packageItem.name}
                                        </td>

                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                            {formatSpeed(
                                                packageItem.speed_download,
                                            )}
                                            {" / "}
                                            {formatSpeed(
                                                packageItem.speed_upload,
                                            )}
                                        </td>

                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                            {formatPrice(packageItem.price)}
                                        </td>

                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                            {billingCycleLabel(
                                                packageItem.billing_cycle,
                                            )}
                                            {packageItem.billing_interval &&
                                                packageItem.billing_interval > 1 &&
                                                ` (${packageItem.billing_interval})`}
                                        </td>

                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                            {packageItem.grace_days ?? 0}
                                        </td>

                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                            {booleanLabel(
                                                packageItem.auto_suspend,
                                            )}
                                        </td>

                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                            {booleanLabel(
                                                packageItem.auto_expire,
                                            )}
                                        </td>

                                        <td className="whitespace-nowrap px-6 py-4 text-sm text-slate-500">
                                            {formatDate(packageItem.created_at)}
                                        </td>
                                    </tr>
                                ))}

                                {packages.length === 0 && (
                                    <tr>
                                        <td
                                            colSpan={9}
                                            className="px-6 py-10 text-center text-sm text-slate-500"
                                        >
                                            {
                                                "\u0644\u0627 \u062a\u0648\u062c\u062f \u0628\u0627\u0642\u0627\u062a \u0644\u0639\u0631\u0636\u0647\u0627."
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