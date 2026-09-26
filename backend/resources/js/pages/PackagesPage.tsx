import { useEffect, useState } from "react";

import { apiRequest } from "../api/client";
import { Alert } from "../components/ui/Alert";
import { LoadingState } from "../components/ui/LoadingState";
import { PageHeader } from "../components/ui/PageHeader";
import { SectionCard } from "../components/dashboard/SectionCard";
import { StatusBadge } from "../components/dashboard/StatusBadge";
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

    return `${value.toLocaleString("ar-EG")} Mbps`;
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
            return "يومي";
        case "week":
            return "أسبوعي";
        case "month":
            return "شهري";
        case "year":
            return "سنوي";
        default:
            return value ?? "-";
    }
}

function booleanLabel(value: boolean | number): string {
    return Boolean(value) ? "نعم" : "لا";
}

function booleanTone(
    value: boolean | number,
): "success" | "neutral" {
    return Boolean(value) ? "success" : "neutral";
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
        <main
            dir="rtl"
            className="mx-auto max-w-7xl px-4 py-6 sm:px-6 sm:py-8"
        >
            <PageHeader
                title="الباقات"
                description="إدارة ومراجعة باقات الإنترنت"
            />

            {loading && <LoadingState />}

            {error && <Alert variant="error">{error}</Alert>}

            {!loading && !error && (
                <SectionCard
                    title="قائمة الباقات"
                    description={
                        pagination
                            ? `إجمالي الباقات: ${pagination.total.toLocaleString(
                                  "ar-EG",
                              )}`
                            : undefined
                    }
                >
                    {packages.length === 0 ? (
                        <div className="rounded-xl border border-dashed border-slate-300 px-6 py-12 text-center">
                            <p className="font-medium text-slate-700">
                                لا توجد باقات لعرضها.
                            </p>

                            <p className="mt-2 text-sm text-slate-500">
                                ستظهر بيانات الباقات هنا عند توفرها.
                            </p>
                        </div>
                    ) : (
                        <div className="overflow-x-auto">
                            <table className="min-w-[1080px] w-full">
                                <thead>
                                    <tr className="border-b border-slate-200">
                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            #
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            الباقة
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            السرعة
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            السعر
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            الفوترة
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            أيام السماح
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            التعليق التلقائي
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            الإنهاء التلقائي
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            تاريخ الإنشاء
                                        </th>
                                    </tr>
                                </thead>

                                <tbody className="divide-y divide-slate-100">
                                    {packages.map((packageItem) => (
                                        <tr
                                            key={packageItem.id}
                                            className="transition hover:bg-slate-50"
                                        >
                                            <td className="whitespace-nowrap px-4 py-4 text-sm text-slate-500">
                                                {packageItem.id}
                                            </td>

                                            <td className="px-4 py-4">
                                                <p className="whitespace-nowrap text-sm font-semibold text-slate-900">
                                                    {packageItem.name}
                                                </p>

                                                {packageItem.description && (
                                                    <p className="mt-1 max-w-xs truncate text-xs text-slate-500">
                                                        {
                                                            packageItem.description
                                                        }
                                                    </p>
                                                )}
                                            </td>

                                            <td className="whitespace-nowrap px-4 py-4">
                                                <div className="flex flex-col gap-1">
                                                    <span className="text-sm font-medium text-slate-900">
                                                        ↓{" "}
                                                        {formatSpeed(
                                                            packageItem.speed_download,
                                                        )}
                                                    </span>

                                                    <span className="text-xs text-slate-500">
                                                        ↑{" "}
                                                        {formatSpeed(
                                                            packageItem.speed_upload,
                                                        )}
                                                    </span>
                                                </div>
                                            </td>

                                            <td className="whitespace-nowrap px-4 py-4">
                                                <p className="text-sm font-semibold text-slate-900">
                                                    {formatPrice(
                                                        packageItem.price,
                                                    )}
                                                </p>

                                                <p className="mt-1 text-xs text-slate-500">
                                                    جنيه
                                                </p>
                                            </td>

                                            <td className="whitespace-nowrap px-4 py-4">
                                                <p className="text-sm text-slate-700">
                                                    {billingCycleLabel(
                                                        packageItem.billing_cycle,
                                                    )}
                                                </p>

                                                {packageItem.billing_interval &&
                                                    packageItem.billing_interval >
                                                        1 && (
                                                        <p className="mt-1 text-xs text-slate-500">
                                                            كل{" "}
                                                            {packageItem.billing_interval.toLocaleString(
                                                                "ar-EG",
                                                            )}
                                                        </p>
                                                    )}
                                            </td>

                                            <td className="whitespace-nowrap px-4 py-4 text-sm text-slate-600">
                                                {(
                                                    packageItem.grace_days ?? 0
                                                ).toLocaleString("ar-EG")}{" "}
                                                يوم
                                            </td>

                                            <td className="whitespace-nowrap px-4 py-4">
                                                <StatusBadge
                                                    label={booleanLabel(
                                                        packageItem.auto_suspend,
                                                    )}
                                                    tone={booleanTone(
                                                        packageItem.auto_suspend,
                                                    )}
                                                />
                                            </td>

                                            <td className="whitespace-nowrap px-4 py-4">
                                                <StatusBadge
                                                    label={booleanLabel(
                                                        packageItem.auto_expire,
                                                    )}
                                                    tone={booleanTone(
                                                        packageItem.auto_expire,
                                                    )}
                                                />
                                            </td>

                                            <td className="whitespace-nowrap px-4 py-4 text-sm text-slate-500">
                                                {formatDate(
                                                    packageItem.created_at,
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
