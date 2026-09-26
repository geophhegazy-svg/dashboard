import { useEffect, useState } from "react";

import { apiRequest } from "../api/client";
import { Alert } from "../components/ui/Alert";
import { LoadingState } from "../components/ui/LoadingState";
import { PageHeader } from "../components/ui/PageHeader";
import { SectionCard } from "../components/dashboard/SectionCard";
import { StatusBadge } from "../components/dashboard/StatusBadge";
import type {
    Invoice,
    InvoiceListResponse,
} from "../types/invoice";

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

function formatDateTime(value: string | null): string {
    if (!value) {
        return "-";
    }

    const date = new Date(value);

    if (Number.isNaN(date.getTime())) {
        return value;
    }

    return date.toLocaleString("ar-EG");
}

function formatAmount(value: string | number): string {
    const amount = Number(value);

    if (Number.isNaN(amount)) {
        return String(value);
    }

    return amount.toLocaleString("ar-EG", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });
}

function statusLabel(status: string): string {
    switch (status) {
        case "paid":
            return "مدفوعة";
        case "pending":
            return "معلقة";
        case "unpaid":
            return "غير مدفوعة";
        case "overdue":
            return "متأخرة";
        case "cancelled":
            return "ملغاة";
        case "draft":
            return "مسودة";
        default:
            return status;
    }
}

function statusTone(
    status: string,
): "success" | "info" | "neutral" {
    switch (status) {
        case "paid":
            return "success";
        case "pending":
        case "overdue":
            return "info";
        default:
            return "neutral";
    }
}

export function InvoicesPage() {
    const [invoices, setInvoices] = useState<Invoice[]>([]);
    const [page, setPage] = useState(1);
    const [pagination, setPagination] =
        useState<InvoiceListResponse["meta"] | null>(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState("");

    useEffect(() => {
        async function loadInvoices() {
            setLoading(true);
            setError("");

            try {
                const response = await apiRequest<InvoiceListResponse>(
                    `/invoices?page=${page}`,
                );

                setInvoices(response.data);
                setPagination(response.meta);
            } catch (exception) {
                setError(
                    exception instanceof Error
                        ? exception.message
                        : "Unable to load invoices.",
                );
            } finally {
                setLoading(false);
            }
        }

        void loadInvoices();
    }, [page]);

    return (
        <main
            dir="rtl"
            className="mx-auto max-w-7xl px-4 py-6 sm:px-6 sm:py-8"
        >
            <PageHeader
                title="الفواتير"
                description="مراجعة الفواتير وحالتها المالية"
            />

            {loading && <LoadingState />}

            {error && <Alert variant="error">{error}</Alert>}

            {!loading && !error && (
                <SectionCard
                    title="قائمة الفواتير"
                    description={
                        pagination
                            ? `إجمالي الفواتير: ${pagination.total.toLocaleString(
                                  "ar-EG",
                              )}`
                            : undefined
                    }
                >
                    {invoices.length === 0 ? (
                        <div className="rounded-xl border border-dashed border-slate-300 px-6 py-12 text-center">
                            <p className="font-medium text-slate-700">
                                لا توجد فواتير لعرضها.
                            </p>

                            <p className="mt-2 text-sm text-slate-500">
                                ستظهر الفواتير هنا عند توفرها.
                            </p>
                        </div>
                    ) : (
                        <div className="overflow-x-auto">
                            <table className="min-w-[900px] w-full">
                                <thead>
                                    <tr className="border-b border-slate-200">
                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            #
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            رقم الفاتورة
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            العميل
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            المبلغ
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            الحالة
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            تاريخ الاستحقاق
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            تاريخ السداد
                                        </th>
                                    </tr>
                                </thead>

                                <tbody className="divide-y divide-slate-100">
                                    {invoices.map((invoice) => (
                                        <tr
                                            key={invoice.id}
                                            className="transition hover:bg-slate-50"
                                        >
                                            <td className="whitespace-nowrap px-4 py-4 text-sm text-slate-500">
                                                {invoice.id}
                                            </td>

                                            <td className="whitespace-nowrap px-4 py-4 text-sm font-semibold text-slate-900">
                                                {invoice.invoice_number}
                                            </td>

                                            <td className="whitespace-nowrap px-4 py-4 text-sm text-slate-700">
                                                {invoice.customer ?? "-"}
                                            </td>

                                            <td className="whitespace-nowrap px-4 py-4">
                                                <p className="text-sm font-semibold text-slate-900">
                                                    {formatAmount(
                                                        invoice.amount,
                                                    )}
                                                </p>

                                                <p className="mt-1 text-xs text-slate-500">
                                                    جنيه
                                                </p>
                                            </td>

                                            <td className="whitespace-nowrap px-4 py-4">
                                                <StatusBadge
                                                    label={statusLabel(
                                                        invoice.status,
                                                    )}
                                                    tone={statusTone(
                                                        invoice.status,
                                                    )}
                                                />
                                            </td>

                                            <td className="whitespace-nowrap px-4 py-4 text-sm text-slate-500">
                                                {formatDate(
                                                    invoice.due_date,
                                                )}
                                            </td>

                                            <td className="whitespace-nowrap px-4 py-4 text-sm text-slate-500">
                                                {formatDateTime(
                                                    invoice.paid_at,
                                                )}
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    )}

                    {pagination && pagination.last_page > 1 && (
                        <div className="mt-5 flex flex-col gap-4 border-t border-slate-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                            <p className="text-sm text-slate-500">
                                عرض{" "}
                                {(pagination.from ?? 0).toLocaleString(
                                    "ar-EG",
                                )}{" "}
                                -{" "}
                                {(pagination.to ?? 0).toLocaleString(
                                    "ar-EG",
                                )}{" "}
                                من{" "}
                                {pagination.total.toLocaleString("ar-EG")}
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
                                    className="rounded-xl border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
                                >
                                    السابق
                                </button>

                                <span className="min-w-20 text-center text-sm font-medium text-slate-600">
                                    {pagination.current_page.toLocaleString(
                                        "ar-EG",
                                    )}{" "}
                                    /{" "}
                                    {pagination.last_page.toLocaleString(
                                        "ar-EG",
                                    )}
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
                                    className="rounded-xl border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
                                >
                                    التالي
                                </button>
                            </div>
                        </div>
                    )}
                </SectionCard>
            )}
        </main>
    );
}
