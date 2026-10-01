import { useEffect, useState } from "react";

import { apiRequest, ApiError } from "../api/client";
import { Alert } from "../components/ui/Alert";
import { LoadingState } from "../components/ui/LoadingState";
import { PageHeader } from "../components/ui/PageHeader";
import { SectionCard } from "../components/dashboard/SectionCard";
import { StatusBadge } from "../components/dashboard/StatusBadge";
import type {
    Package,
    PackageListResponse,
} from "../types/package";

interface PackageFormData {
    tenant_id: string;
    name: string;
    download_speed: string;
    upload_speed: string;
    price: string;
    quota_gb: string;
    status: "active" | "inactive";
    description: string;
}

const emptyForm: PackageFormData = {
    tenant_id: "",
    name: "",
    download_speed: "",
    upload_speed: "0",
    price: "",
    quota_gb: "",
    status: "active",
    description: "",
};

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

function inputClass(error?: string): string {
    return `w-full rounded-xl border px-3 py-2 text-sm outline-none transition focus:ring-2 ${
        error
            ? "border-red-300 focus:border-red-400 focus:ring-red-100"
            : "border-slate-300 focus:border-slate-400 focus:ring-slate-100"
    }`;
}

export function PackagesPage() {
    const [packages, setPackages] = useState<Package[]>([]);
    const [page, setPage] = useState(1);
    const [pagination, setPagination] =
        useState<PackageListResponse["meta"] | null>(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState("");

    const [showForm, setShowForm] = useState(false);
    const [editingPackage, setEditingPackage] = useState<Package | null>(null);
    const [viewingPackage, setViewingPackage] = useState<Package | null>(null);
    const [deletingPackage, setDeletingPackage] = useState<Package | null>(
        null,
    );

    const [form, setForm] = useState<PackageFormData>(emptyForm);
    const [formErrors, setFormErrors] = useState<Record<string, string[]>>({});
    const [formError, setFormError] = useState("");
    const [saving, setSaving] = useState(false);
    const [deleting, setDeleting] = useState(false);

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

    useEffect(() => {
        void loadPackages();
    }, [page]);

    function openCreate() {
        setEditingPackage(null);
        setForm(emptyForm);
        setFormErrors({});
        setFormError("");
        setShowForm(true);
    }

    function openEdit(packageItem: Package) {
        setEditingPackage(packageItem);
        setForm({
            tenant_id: String(packageItem.tenant_id),
            name: packageItem.name,
            download_speed:
                packageItem.speed_download !== null
                    ? String(packageItem.speed_download)
                    : "",
            upload_speed:
                packageItem.speed_upload !== null
                    ? String(packageItem.speed_upload)
                    : "0",
            price: String(packageItem.price),
            quota_gb:
                packageItem.quota_gb !== null
                    ? String(packageItem.quota_gb)
                    : "",
            status: packageItem.status,
            description: packageItem.description ?? "",
        });
        setFormErrors({});
        setFormError("");
        setShowForm(true);
    }

    function closeForm() {
        if (saving) {
            return;
        }

        setShowForm(false);
        setEditingPackage(null);
        setForm(emptyForm);
        setFormErrors({});
        setFormError("");
    }

    function updateField<K extends keyof PackageFormData>(
        field: K,
        value: PackageFormData[K],
    ) {
        setForm((current) => ({
            ...current,
            [field]: value,
        }));

        setFormErrors((current) => {
            if (!current[field]) {
                return current;
            }

            const next = { ...current };
            delete next[field];
            return next;
        });
    }

    async function submitForm(event: React.FormEvent<HTMLFormElement>) {
        event.preventDefault();

        setSaving(true);
        setFormError("");
        setFormErrors({});

        const payload = {
            tenant_id: Number(form.tenant_id),
            name: form.name,
            download_speed: Number(form.download_speed),
            upload_speed:
                form.upload_speed === ""
                    ? null
                    : Number(form.upload_speed),
            price: Number(form.price),
            quota_gb:
                form.quota_gb === "" ? null : Number(form.quota_gb),
            status: form.status,
            description: form.description || null,
        };

        try {
            if (editingPackage) {
                await apiRequest<Package>(
                    `/packages/${editingPackage.id}`,
                    {
                        method: "PUT",
                        body: JSON.stringify(payload),
                    },
                );
            } else {
                await apiRequest<Package>("/packages", {
                    method: "POST",
                    body: JSON.stringify(payload),
                });
            }

            closeForm();
            await loadPackages();
        } catch (exception) {
            if (exception instanceof ApiError) {
                setFormError(exception.message);
                setFormErrors(exception.errors);
            } else {
                setFormError(
                    exception instanceof Error
                        ? exception.message
                        : "حدث خطأ أثناء حفظ الباقة.",
                );
            }
        } finally {
            setSaving(false);
        }
    }

    async function confirmDelete() {
        if (!deletingPackage) {
            return;
        }

        setDeleting(true);
        setError("");

        try {
            await apiRequest<void>(
                `/packages/${deletingPackage.id}`,
                {
                    method: "DELETE",
                },
            );

            setDeletingPackage(null);

            if (packages.length === 1 && page > 1) {
                setPage((current) => current - 1);
            } else {
                await loadPackages();
            }
        } catch (exception) {
            setError(
                exception instanceof Error
                    ? exception.message
                    : "حدث خطأ أثناء حذف الباقة.",
            );
        } finally {
            setDeleting(false);
        }
    }

    function fieldError(field: string): string | undefined {
        return formErrors[field]?.[0];
    }

    return (
        <main
            dir="rtl"
            className="mx-auto max-w-7xl px-4 py-6 sm:px-6 sm:py-8"
        >
            <PageHeader
                title="الباقات"
                description="إدارة ومراجعة باقات الإنترنت"
            />

            <div className="mb-6 flex justify-start">
                <button
                    type="button"
                    onClick={openCreate}
                    className="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800"
                >
                    إضافة باقة
                </button>
            </div>

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
                            <table className="min-w-[1250px] w-full">
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
                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            الإجراءات
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

                                            <td className="whitespace-nowrap px-4 py-4">
                                                <div className="flex items-center gap-2">
                                                    <button
                                                        type="button"
                                                        onClick={() =>
                                                            setViewingPackage(
                                                                packageItem,
                                                            )
                                                        }
                                                        className="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50"
                                                    >
                                                        عرض
                                                    </button>

                                                    <button
                                                        type="button"
                                                        onClick={() =>
                                                            openEdit(
                                                                packageItem,
                                                            )
                                                        }
                                                        className="rounded-lg border border-blue-200 px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-50"
                                                    >
                                                        تعديل
                                                    </button>

                                                    <button
                                                        type="button"
                                                        onClick={() =>
                                                            setDeletingPackage(
                                                                packageItem,
                                                            )
                                                        }
                                                        className="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-50"
                                                    >
                                                        حذف
                                                    </button>
                                                </div>
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

            {showForm && (
                <div className="fixed inset-0 z-50 overflow-y-auto bg-slate-950/40 px-4 py-8">
                    <div className="mx-auto max-w-2xl rounded-2xl bg-white p-6 shadow-xl">
                        <div className="mb-6 flex items-start justify-between">
                            <div>
                                <h2 className="text-xl font-bold text-slate-900">
                                    {editingPackage
                                        ? "تعديل الباقة"
                                        : "إضافة باقة"}
                                </h2>
                                <p className="mt-1 text-sm text-slate-500">
                                    أدخل بيانات الباقة المطلوبة.
                                </p>
                            </div>

                            <button
                                type="button"
                                onClick={closeForm}
                                className="rounded-lg px-3 py-1 text-slate-500 hover:bg-slate-100"
                            >
                                إغلاق
                            </button>
                        </div>

                        {formError && (
                            <div className="mb-5">
                                <Alert variant="error">{formError}</Alert>
                            </div>
                        )}

                        <form
                            onSubmit={submitForm}
                            className="grid gap-4 sm:grid-cols-2"
                        >
                            <div>
                                <label className="mb-1 block text-sm font-medium text-slate-700">
                                    Tenant ID
                                </label>
                                <input
                                    value={form.tenant_id}
                                    onChange={(event) =>
                                        updateField(
                                            "tenant_id",
                                            event.target.value,
                                        )
                                    }
                                    className={inputClass(
                                        fieldError("tenant_id"),
                                    )}
                                    inputMode="numeric"
                                />
                                {fieldError("tenant_id") && (
                                    <p className="mt-1 text-xs text-red-600">
                                        {fieldError("tenant_id")}
                                    </p>
                                )}
                            </div>

                            <div>
                                <label className="mb-1 block text-sm font-medium text-slate-700">
                                    اسم الباقة
                                </label>
                                <input
                                    value={form.name}
                                    onChange={(event) =>
                                        updateField(
                                            "name",
                                            event.target.value,
                                        )
                                    }
                                    className={inputClass(fieldError("name"))}
                                />
                                {fieldError("name") && (
                                    <p className="mt-1 text-xs text-red-600">
                                        {fieldError("name")}
                                    </p>
                                )}
                            </div>

                            <div>
                                <label className="mb-1 block text-sm font-medium text-slate-700">
                                    سرعة التحميل Mbps
                                </label>
                                <input
                                    type="number"
                                    min="1"
                                    value={form.download_speed}
                                    onChange={(event) =>
                                        updateField(
                                            "download_speed",
                                            event.target.value,
                                        )
                                    }
                                    className={inputClass(
                                        fieldError("download_speed"),
                                    )}
                                />
                                {fieldError("download_speed") && (
                                    <p className="mt-1 text-xs text-red-600">
                                        {fieldError("download_speed")}
                                    </p>
                                )}
                            </div>

                            <div>
                                <label className="mb-1 block text-sm font-medium text-slate-700">
                                    سرعة الرفع Mbps
                                </label>
                                <input
                                    type="number"
                                    min="0"
                                    value={form.upload_speed}
                                    onChange={(event) =>
                                        updateField(
                                            "upload_speed",
                                            event.target.value,
                                        )
                                    }
                                    className={inputClass(
                                        fieldError("upload_speed"),
                                    )}
                                />
                                {fieldError("upload_speed") && (
                                    <p className="mt-1 text-xs text-red-600">
                                        {fieldError("upload_speed")}
                                    </p>
                                )}
                            </div>

                            <div>
                                <label className="mb-1 block text-sm font-medium text-slate-700">
                                    السعر
                                </label>
                                <input
                                    type="number"
                                    min="0"
                                    step="0.01"
                                    value={form.price}
                                    onChange={(event) =>
                                        updateField(
                                            "price",
                                            event.target.value,
                                        )
                                    }
                                    className={inputClass(
                                        fieldError("price"),
                                    )}
                                />
                                {fieldError("price") && (
                                    <p className="mt-1 text-xs text-red-600">
                                        {fieldError("price")}
                                    </p>
                                )}
                            </div>

                            <div>
                                <label className="mb-1 block text-sm font-medium text-slate-700">
                                    الحصة GB
                                </label>
                                <input
                                    type="number"
                                    min="0"
                                    value={form.quota_gb}
                                    onChange={(event) =>
                                        updateField(
                                            "quota_gb",
                                            event.target.value,
                                        )
                                    }
                                    className={inputClass(
                                        fieldError("quota_gb"),
                                    )}
                                />
                                {fieldError("quota_gb") && (
                                    <p className="mt-1 text-xs text-red-600">
                                        {fieldError("quota_gb")}
                                    </p>
                                )}
                            </div>

                            <div>
                                <label className="mb-1 block text-sm font-medium text-slate-700">
                                    الحالة
                                </label>
                                <select
                                    value={form.status}
                                    onChange={(event) =>
                                        updateField(
                                            "status",
                                            event.target.value as
                                                | "active"
                                                | "inactive",
                                        )
                                    }
                                    className={inputClass(
                                        fieldError("status"),
                                    )}
                                >
                                    <option value="active">نشطة</option>
                                    <option value="inactive">غير نشطة</option>
                                </select>
                                {fieldError("status") && (
                                    <p className="mt-1 text-xs text-red-600">
                                        {fieldError("status")}
                                    </p>
                                )}
                            </div>

                            <div className="sm:col-span-2">
                                <label className="mb-1 block text-sm font-medium text-slate-700">
                                    الوصف
                                </label>
                                <textarea
                                    value={form.description}
                                    onChange={(event) =>
                                        updateField(
                                            "description",
                                            event.target.value,
                                        )
                                    }
                                    rows={4}
                                    className={inputClass(
                                        fieldError("description"),
                                    )}
                                />
                                {fieldError("description") && (
                                    <p className="mt-1 text-xs text-red-600">
                                        {fieldError("description")}
                                    </p>
                                )}
                            </div>

                            <div className="mt-2 flex justify-start gap-3 border-t border-slate-100 pt-5 sm:col-span-2">
                                <button
                                    type="submit"
                                    disabled={saving}
                                    className="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50"
                                >
                                    {saving
                                        ? "جاري الحفظ..."
                                        : editingPackage
                                          ? "حفظ التعديلات"
                                          : "إضافة الباقة"}
                                </button>

                                <button
                                    type="button"
                                    onClick={closeForm}
                                    disabled={saving}
                                    className="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 disabled:opacity-50"
                                >
                                    إلغاء
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}

            {viewingPackage && (
                <div className="fixed inset-0 z-50 overflow-y-auto bg-slate-950/40 px-4 py-8">
                    <div className="mx-auto max-w-2xl rounded-2xl bg-white p-6 shadow-xl">
                        <div className="mb-6 flex items-start justify-between">
                            <div>
                                <h2 className="text-xl font-bold text-slate-900">
                                    تفاصيل الباقة
                                </h2>
                                <p className="mt-1 text-sm text-slate-500">
                                    {viewingPackage.name}
                                </p>
                            </div>

                            <button
                                type="button"
                                onClick={() => setViewingPackage(null)}
                                className="rounded-lg px-3 py-1 text-slate-500 hover:bg-slate-100"
                            >
                                إغلاق
                            </button>
                        </div>

                        <div className="grid gap-4 sm:grid-cols-2">
                            {[
                                ["الاسم", viewingPackage.name],
                                ["Tenant ID", viewingPackage.tenant_id],
                                [
                                    "سرعة التحميل",
                                    formatSpeed(
                                        viewingPackage.speed_download,
                                    ),
                                ],
                                [
                                    "سرعة الرفع",
                                    formatSpeed(viewingPackage.speed_upload),
                                ],
                                [
                                    "السعر",
                                    `${formatPrice(viewingPackage.price)} جنيه`,
                                ],
                                [
                                    "دورة الفوترة",
                                    billingCycleLabel(
                                        viewingPackage.billing_cycle,
                                    ),
                                ],
                                [
                                    "الفاصل",
                                    viewingPackage.billing_interval ?? "-",
                                ],
                                [
                                    "أيام السماح",
                                    viewingPackage.grace_days ?? "-",
                                ],
                                [
                                    "التعليق التلقائي",
                                    booleanLabel(
                                        viewingPackage.auto_suspend,
                                    ),
                                ],
                                [
                                    "الإنهاء التلقائي",
                                    booleanLabel(
                                        viewingPackage.auto_expire,
                                    ),
                                ],
                                ["تاريخ الإنشاء", formatDate(viewingPackage.created_at)],
                            ].map(([label, value]) => (
                                <div
                                    key={label}
                                    className="rounded-xl bg-slate-50 p-4"
                                >
                                    <p className="text-xs font-medium text-slate-500">
                                        {label}
                                    </p>
                                    <p className="mt-1 text-sm font-semibold text-slate-900">
                                        {value}
                                    </p>
                                </div>
                            ))}

                            <div className="sm:col-span-2 rounded-xl bg-slate-50 p-4">
                                <p className="text-xs font-medium text-slate-500">
                                    الوصف
                                </p>
                                <p className="mt-1 whitespace-pre-wrap text-sm text-slate-700">
                                    {viewingPackage.description || "-"}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            )}

            {deletingPackage && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 px-4">
                    <div className="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">
                        <h2 className="text-xl font-bold text-slate-900">
                            حذف الباقة
                        </h2>

                        <p className="mt-3 text-sm leading-6 text-slate-600">
                            هل تريد حذف الباقة{" "}
                            <strong>{deletingPackage.name}</strong>؟
                            لا يمكن التراجع عن هذا الإجراء.
                        </p>

                        <div className="mt-6 flex justify-start gap-3">
                            <button
                                type="button"
                                onClick={() => void confirmDelete()}
                                disabled={deleting}
                                className="rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-700 disabled:opacity-50"
                            >
                                {deleting ? "جاري الحذف..." : "حذف"}
                            </button>

                            <button
                                type="button"
                                onClick={() => setDeletingPackage(null)}
                                disabled={deleting}
                                className="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 disabled:opacity-50"
                            >
                                إلغاء
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </main>
    );
}
