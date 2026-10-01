import {
    FormEvent,
    useEffect,
    useState,
} from "react";

import { ApiError, apiRequest } from "../api/client";
import { Alert } from "../components/ui/Alert";
import { LoadingState } from "../components/ui/LoadingState";
import { PageHeader } from "../components/ui/PageHeader";
import { SectionCard } from "../components/dashboard/SectionCard";
import { StatusBadge } from "../components/dashboard/StatusBadge";
import type {
    HotspotSubscription,
    HotspotSubscriptionListResponse,
} from "../types/hotspotSubscription";
import type {
    Customer,
    CustomerListResponse,
} from "../types/customer";
import type {
    Package,
    PackageListResponse,
} from "../types/package";

type HotspotSubscriptionForm = {
    tenant_id: string;
    customer_id: string;
    package_id: string;
    hotspot_username: string;
    hotspot_password: string;
    start_date: string;
    end_date: string;
    monthly_price: string;
    mikrotik_profile: string;
};

type FormErrors = Record<string, string[]>;

const emptyForm: HotspotSubscriptionForm = {
    tenant_id: "",
    customer_id: "",
    package_id: "",
    hotspot_username: "",
    hotspot_password: "",
    start_date: "",
    end_date: "",
    monthly_price: "",
    mikrotik_profile: "default",
};

const statusLabels: Record<string, string> = {
    active: "نشطة",
    suspended: "موقوفة",
    expired: "منتهية",
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

function formatDateInput(value: string | null): string {
    return value ? value.slice(0, 10) : "";
}

function formatPrice(value: number | string): string {
    return new Intl.NumberFormat("ar-EG", {
        style: "currency",
        currency: "EGP",
        maximumFractionDigits: 2,
    }).format(Number(value));
}

function getStatusLabel(status: string): string {
    return statusLabels[status] ?? status;
}

function getStatusTone(
    status: string,
): "success" | "info" | "neutral" {
    if (status === "active") {
        return "success";
    }

    if (status === "expired") {
        return "info";
    }

    return "neutral";
}

function inputClass(error?: string): string {
    return `w-full rounded-xl border px-3 py-2.5 text-sm outline-none transition focus:ring-2 ${
        error
            ? "border-red-300 focus:border-red-400 focus:ring-red-100"
            : "border-slate-300 focus:border-slate-400 focus:ring-slate-100"
    }`;
}

function fieldError(
    errors: FormErrors,
    field: keyof HotspotSubscriptionForm,
): string | null {
    return errors[field]?.[0] ?? null;
}

export function HotspotSubscriptionsPage() {
    const [subscriptions, setSubscriptions] = useState<
        HotspotSubscription[]
    >([]);

    const [customers, setCustomers] = useState<Customer[]>([]);
    const [packages, setPackages] = useState<Package[]>([]);

    const [page, setPage] = useState(1);
    const [pagination, setPagination] =
        useState<HotspotSubscriptionListResponse["meta"] | null>(null);

    const [loading, setLoading] = useState(true);
    const [loadingFormData, setLoadingFormData] = useState(false);
    const [error, setError] = useState("");

    const [showForm, setShowForm] = useState(false);
    const [form, setForm] =
        useState<HotspotSubscriptionForm>(emptyForm);
    const [formErrors, setFormErrors] =
        useState<FormErrors>({});
    const [formError, setFormError] = useState("");
    const [saving, setSaving] = useState(false);

    const [viewingSubscription, setViewingSubscription] =
        useState<HotspotSubscription | null>(null);

    const [deletingSubscription, setDeletingSubscription] =
        useState<HotspotSubscription | null>(null);
    const [deleting, setDeleting] = useState(false);

    const [actionId, setActionId] =
        useState<number | null>(null);

    async function loadSubscriptions() {
        setLoading(true);
        setError("");

        try {
            const response =
                await apiRequest<HotspotSubscriptionListResponse>(
                    `/hotspot-subscriptions?page=${page}`,
                );

            setSubscriptions(response.data);
            setPagination(response.meta);
        } catch (exception) {
            setError(
                exception instanceof Error
                    ? exception.message
                    : "تعذر تحميل اشتراكات Hotspot.",
            );
        } finally {
            setLoading(false);
        }
    }

    async function loadFormData() {
        setLoadingFormData(true);
        setFormError("");

        try {
            const [customersResponse, packagesResponse] =
                await Promise.all([
                    apiRequest<CustomerListResponse>(
                        "/customers?per_page=100",
                    ),
                    apiRequest<PackageListResponse>(
                        "/packages?per_page=100",
                    ),
                ]);

            setCustomers(customersResponse.data);
            setPackages(packagesResponse.data);
        } catch (exception) {
            setFormError(
                exception instanceof Error
                    ? exception.message
                    : "تعذر تحميل العملاء والباقات.",
            );
        } finally {
            setLoadingFormData(false);
        }
    }

    useEffect(() => {
        void loadSubscriptions();
    }, [page]);

    function openCreate() {
        setForm(emptyForm);
        setFormErrors({});
        setFormError("");
        setShowForm(true);
        void loadFormData();
    }

    function closeForm() {
        if (saving) {
            return;
        }

        setShowForm(false);
        setForm(emptyForm);
        setFormErrors({});
        setFormError("");
    }

    function updateField<K extends keyof HotspotSubscriptionForm>(
        field: K,
        value: HotspotSubscriptionForm[K],
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

    async function submitForm(
        event: FormEvent<HTMLFormElement>,
    ) {
        event.preventDefault();

        setSaving(true);
        setFormErrors({});
        setFormError("");
        setError("");

        const payload = {
            tenant_id: Number(form.tenant_id),
            customer_id: Number(form.customer_id),
            package_id: Number(form.package_id),
            hotspot_username: form.hotspot_username,
            hotspot_password: form.hotspot_password,
            start_date: form.start_date,
            end_date: form.end_date,
            monthly_price: Number(form.monthly_price),
            mikrotik_profile:
                form.mikrotik_profile || "default",
        };

        try {
            await apiRequest<HotspotSubscription>(
                "/hotspot-subscriptions",
                {
                    method: "POST",
                    body: JSON.stringify(payload),
                },
            );

            closeForm();
            await loadSubscriptions();
        } catch (exception) {
            if (
                exception instanceof ApiError &&
                exception.status === 422
            ) {
                setFormErrors(exception.errors);
                setFormError(exception.message);
            } else {
                setFormError(
                    exception instanceof Error
                        ? exception.message
                        : "تعذر إنشاء اشتراك Hotspot.",
                );
            }
        } finally {
            setSaving(false);
        }
    }

    async function handleView(
        subscription: HotspotSubscription,
    ) {
        setError("");

        try {
            const response =
                await apiRequest<HotspotSubscription>(
                    `/hotspot-subscriptions/${subscription.id}`,
                );

            setViewingSubscription(response);
        } catch (exception) {
            setError(
                exception instanceof Error
                    ? exception.message
                    : "تعذر تحميل تفاصيل الاشتراك.",
            );
        }
    }

    async function handleLifecycle(
        subscription: HotspotSubscription,
        action: "activate" | "suspend",
    ) {
        const message =
            action === "activate"
                ? "هل تريد تفعيل اشتراك Hotspot؟"
                : "هل تريد إيقاف اشتراك Hotspot؟";

        if (!window.confirm(message)) {
            return;
        }

        setActionId(subscription.id);
        setError("");

        try {
            await apiRequest(
                `/hotspot-subscriptions/${subscription.id}/${action}`,
                {
                    method: "POST",
                },
            );

            await loadSubscriptions();

            if (
                viewingSubscription?.id ===
                subscription.id
            ) {
                const response =
                    await apiRequest<HotspotSubscription>(
                        `/hotspot-subscriptions/${subscription.id}`,
                    );

                setViewingSubscription(response);
            }
        } catch (exception) {
            setError(
                exception instanceof Error
                    ? exception.message
                    : "تعذر تنفيذ العملية.",
            );
        } finally {
            setActionId(null);
        }
    }

    async function confirmDelete() {
        if (!deletingSubscription) {
            return;
        }

        setDeleting(true);
        setError("");

        try {
            await apiRequest<void>(
                `/hotspot-subscriptions/${deletingSubscription.id}`,
                {
                    method: "DELETE",
                },
            );

            const deletedId = deletingSubscription.id;

            setDeletingSubscription(null);

            if (
                subscriptions.length === 1 &&
                page > 1
            ) {
                setPage((current) => current - 1);
            } else {
                await loadSubscriptions();
            }

            if (viewingSubscription?.id === deletedId) {
                setViewingSubscription(null);
            }
        } catch (exception) {
            setError(
                exception instanceof Error
                    ? exception.message
                    : "تعذر حذف الاشتراك.",
            );
        } finally {
            setDeleting(false);
        }
    }

    return (
        <div
            dir="rtl"
            className="space-y-6 p-4 sm:p-6 lg:p-8"
        >
            <PageHeader
                title="اشتراكات Hotspot"
                description="إدارة اشتراكات MikroTik Hotspot المرتبطة بالعملاء والباقات."
            />

            <div className="flex justify-end">
                <button
                    type="button"
                    onClick={openCreate}
                    className="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800"
                >
                    إضافة اشتراك Hotspot
                </button>
            </div>

            {error && <Alert>{error}</Alert>}

            <SectionCard
                title="قائمة اشتراكات Hotspot"
                description={
                    pagination
                        ? `إجمالي الاشتراكات: ${pagination.total.toLocaleString(
                              "ar-EG",
                          )}`
                        : undefined
                }
            >
                {loading ? (
                    <LoadingState />
                ) : subscriptions.length === 0 ? (
                    <div className="py-12 text-center text-sm text-slate-500">
                        لا توجد اشتراكات Hotspot.
                    </div>
                ) : (
                    <div className="overflow-x-auto">
                        <table className="min-w-full text-right text-sm">
                            <thead>
                                <tr className="border-b border-slate-200 text-slate-500">
                                    <th className="px-4 py-3 font-medium">
                                        العميل
                                    </th>
                                    <th className="px-4 py-3 font-medium">
                                        الباقة
                                    </th>
                                    <th className="px-4 py-3 font-medium">
                                        Hotspot Username
                                    </th>
                                    <th className="px-4 py-3 font-medium">
                                        Profile
                                    </th>
                                    <th className="px-4 py-3 font-medium">
                                        السعر
                                    </th>
                                    <th className="px-4 py-3 font-medium">
                                        الحالة
                                    </th>
                                    <th className="px-4 py-3 font-medium">
                                        الإجراءات
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                {subscriptions.map(
                                    (subscription) => (
                                        <tr
                                            key={subscription.id}
                                            className="border-b border-slate-100 last:border-0"
                                        >
                                            <td className="px-4 py-4">
                                                {subscription.customer
                                                    ?.name ??
                                                    `#${subscription.customer_id}`}
                                            </td>

                                            <td className="px-4 py-4">
                                                {subscription.package
                                                    ?.name ??
                                                    `#${subscription.package_id}`}
                                            </td>

                                            <td className="px-4 py-4 font-mono text-xs">
                                                {
                                                    subscription.hotspot_username
                                                }
                                            </td>

                                            <td className="px-4 py-4">
                                                {
                                                    subscription.mikrotik_profile
                                                }
                                            </td>

                                            <td className="px-4 py-4">
                                                {formatPrice(
                                                    subscription.monthly_price,
                                                )}
                                            </td>

                                            <td className="px-4 py-4">
                                                <StatusBadge
                                                    label={getStatusLabel(
                                                        subscription.status,
                                                    )}
                                                    tone={getStatusTone(
                                                        subscription.status,
                                                    )}
                                                />
                                            </td>

                                            <td className="px-4 py-4">
                                                <div className="flex flex-wrap gap-2">
                                                    <button
                                                        type="button"
                                                        onClick={() =>
                                                            void handleView(
                                                                subscription,
                                                            )
                                                        }
                                                        className="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50"
                                                    >
                                                        عرض
                                                    </button>

                                                    {subscription.status !==
                                                        "active" && (
                                                        <button
                                                            type="button"
                                                            disabled={
                                                                actionId ===
                                                                subscription.id
                                                            }
                                                            onClick={() =>
                                                                void handleLifecycle(
                                                                    subscription,
                                                                    "activate",
                                                                )
                                                            }
                                                            className="rounded-lg border border-emerald-300 px-3 py-1.5 text-xs font-medium text-emerald-700 hover:bg-emerald-50 disabled:opacity-50"
                                                        >
                                                            تفعيل
                                                        </button>
                                                    )}

                                                    {subscription.status ===
                                                        "active" && (
                                                        <button
                                                            type="button"
                                                            disabled={
                                                                actionId ===
                                                                subscription.id
                                                            }
                                                            onClick={() =>
                                                                void handleLifecycle(
                                                                    subscription,
                                                                    "suspend",
                                                                )
                                                            }
                                                            className="rounded-lg border border-amber-300 px-3 py-1.5 text-xs font-medium text-amber-700 hover:bg-amber-50 disabled:opacity-50"
                                                        >
                                                            إيقاف
                                                        </button>
                                                    )}

                                                    <button
                                                        type="button"
                                                        onClick={() =>
                                                            setDeletingSubscription(
                                                                subscription,
                                                            )
                                                        }
                                                        className="rounded-lg border border-red-300 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-50"
                                                    >
                                                        حذف
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    ),
                                )}
                            </tbody>
                        </table>
                    </div>
                )}

                {pagination &&
                    pagination.last_page > 1 && (
                        <div className="mt-4 flex items-center justify-between border-t border-slate-200 pt-4">
                            <button
                                type="button"
                                disabled={page <= 1}
                                onClick={() =>
                                    setPage((current) =>
                                        Math.max(
                                            1,
                                            current - 1,
                                        ),
                                    )
                                }
                                className="rounded-lg border border-slate-300 px-3 py-2 text-xs font-medium text-slate-700 disabled:opacity-40"
                            >
                                السابق
                            </button>

                            <span className="text-xs text-slate-500">
                                صفحة {pagination.current_page} من{" "}
                                {pagination.last_page}
                            </span>

                            <button
                                type="button"
                                disabled={
                                    page >=
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
                                className="rounded-lg border border-slate-300 px-3 py-2 text-xs font-medium text-slate-700 disabled:opacity-40"
                            >
                                التالي
                            </button>
                        </div>
                    )}
            </SectionCard>

            {showForm && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 p-4">
                    <div className="max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-2xl bg-white shadow-2xl">
                        <div className="border-b border-slate-200 px-6 py-5">
                            <h2 className="text-lg font-semibold text-slate-900">
                                إضافة اشتراك Hotspot
                            </h2>

                            <p className="mt-1 text-sm text-slate-500">
                                اختر العميل والباقـة ثم حدد بيانات الاشتراك.
                            </p>
                        </div>

                        <form
                            onSubmit={submitForm}
                            className="space-y-5 p-6"
                        >
                            {formError && (
                                <Alert>{formError}</Alert>
                            )}

                            {loadingFormData ? (
                                <LoadingState />
                            ) : (
                                <>
                                    <div className="grid gap-4 sm:grid-cols-2">
                                        <label className="block">
                                            <span className="mb-2 block text-sm font-medium text-slate-700">
                                                Tenant ID
                                            </span>
                                            <input
                                                type="number"
                                                value={form.tenant_id}
                                                onChange={(event) =>
                                                    updateField(
                                                        "tenant_id",
                                                        event.target.value,
                                                    )
                                                }
                                                className={inputClass(
                                                    fieldError(
                                                        formErrors,
                                                        "tenant_id",
                                                    ) ?? undefined,
                                                )}
                                            />
                                            {fieldError(
                                                formErrors,
                                                "tenant_id",
                                            ) && (
                                                <p className="mt-1 text-xs text-red-600">
                                                    {fieldError(
                                                        formErrors,
                                                        "tenant_id",
                                                    )}
                                                </p>
                                            )}
                                        </label>

                                        <label className="block">
                                            <span className="mb-2 block text-sm font-medium text-slate-700">
                                                العميل
                                            </span>
                                            <select
                                                value={form.customer_id}
                                                onChange={(event) =>
                                                    updateField(
                                                        "customer_id",
                                                        event.target.value,
                                                    )
                                                }
                                                className={inputClass(
                                                    fieldError(
                                                        formErrors,
                                                        "customer_id",
                                                    ) ?? undefined,
                                                )}
                                            >
                                                <option value="">
                                                    اختر العميل
                                                </option>
                                                {customers.map(
                                                    (customer) => (
                                                        <option
                                                            key={
                                                                customer.id
                                                            }
                                                            value={
                                                                customer.id
                                                            }
                                                        >
                                                            {customer.name} — #{customer.id}
                                                        </option>
                                                    ),
                                                )}
                                            </select>
                                            {fieldError(
                                                formErrors,
                                                "customer_id",
                                            ) && (
                                                <p className="mt-1 text-xs text-red-600">
                                                    {fieldError(
                                                        formErrors,
                                                        "customer_id",
                                                    )}
                                                </p>
                                            )}
                                        </label>

                                        <label className="block">
                                            <span className="mb-2 block text-sm font-medium text-slate-700">
                                                الباقة
                                            </span>
                                            <select
                                                value={form.package_id}
                                                onChange={(event) =>
                                                    updateField(
                                                        "package_id",
                                                        event.target.value,
                                                    )
                                                }
                                                className={inputClass(
                                                    fieldError(
                                                        formErrors,
                                                        "package_id",
                                                    ) ?? undefined,
                                                )}
                                            >
                                                <option value="">
                                                    اختر الباقة
                                                </option>
                                                {packages.map(
                                                    (pkg) => (
                                                        <option
                                                            key={pkg.id}
                                                            value={pkg.id}
                                                        >
                                                            {pkg.name} — #{pkg.id}
                                                        </option>
                                                    ),
                                                )}
                                            </select>
                                            {fieldError(
                                                formErrors,
                                                "package_id",
                                            ) && (
                                                <p className="mt-1 text-xs text-red-600">
                                                    {fieldError(
                                                        formErrors,
                                                        "package_id",
                                                    )}
                                                </p>
                                            )}
                                        </label>

                                        <label className="block">
                                            <span className="mb-2 block text-sm font-medium text-slate-700">
                                                Hotspot Username
                                            </span>
                                            <input
                                                type="text"
                                                value={form.hotspot_username}
                                                onChange={(event) =>
                                                    updateField(
                                                        "hotspot_username",
                                                        event.target.value,
                                                    )
                                                }
                                                autoComplete="off"
                                                className={inputClass(
                                                    fieldError(
                                                        formErrors,
                                                        "hotspot_username",
                                                    ) ?? undefined,
                                                )}
                                            />
                                            {fieldError(
                                                formErrors,
                                                "hotspot_username",
                                            ) && (
                                                <p className="mt-1 text-xs text-red-600">
                                                    {fieldError(
                                                        formErrors,
                                                        "hotspot_username",
                                                    )}
                                                </p>
                                            )}
                                        </label>

                                        <label className="block">
                                            <span className="mb-2 block text-sm font-medium text-slate-700">
                                                Hotspot Password
                                            </span>
                                            <input
                                                type="password"
                                                value={form.hotspot_password}
                                                onChange={(event) =>
                                                    updateField(
                                                        "hotspot_password",
                                                        event.target.value,
                                                    )
                                                }
                                                autoComplete="new-password"
                                                className={inputClass(
                                                    fieldError(
                                                        formErrors,
                                                        "hotspot_password",
                                                    ) ?? undefined,
                                                )}
                                            />
                                            {fieldError(
                                                formErrors,
                                                "hotspot_password",
                                            ) && (
                                                <p className="mt-1 text-xs text-red-600">
                                                    {fieldError(
                                                        formErrors,
                                                        "hotspot_password",
                                                    )}
                                                </p>
                                            )}
                                        </label>

                                        <label className="block">
                                            <span className="mb-2 block text-sm font-medium text-slate-700">
                                                MikroTik Profile
                                            </span>
                                            <input
                                                type="text"
                                                value={
                                                    form.mikrotik_profile
                                                }
                                                onChange={(event) =>
                                                    updateField(
                                                        "mikrotik_profile",
                                                        event.target.value,
                                                    )
                                                }
                                                className={inputClass(
                                                    fieldError(
                                                        formErrors,
                                                        "mikrotik_profile",
                                                    ) ?? undefined,
                                                )}
                                            />
                                        </label>

                                        <label className="block">
                                            <span className="mb-2 block text-sm font-medium text-slate-700">
                                                تاريخ البداية
                                            </span>
                                            <input
                                                type="date"
                                                value={form.start_date}
                                                onChange={(event) =>
                                                    updateField(
                                                        "start_date",
                                                        event.target.value,
                                                    )
                                                }
                                                className={inputClass(
                                                    fieldError(
                                                        formErrors,
                                                        "start_date",
                                                    ) ?? undefined,
                                                )}
                                            />
                                        </label>

                                        <label className="block">
                                            <span className="mb-2 block text-sm font-medium text-slate-700">
                                                تاريخ النهاية
                                            </span>
                                            <input
                                                type="date"
                                                value={form.end_date}
                                                onChange={(event) =>
                                                    updateField(
                                                        "end_date",
                                                        event.target.value,
                                                    )
                                                }
                                                className={inputClass(
                                                    fieldError(
                                                        formErrors,
                                                        "end_date",
                                                    ) ?? undefined,
                                                )}
                                            />
                                        </label>

                                        <label className="block sm:col-span-2">
                                            <span className="mb-2 block text-sm font-medium text-slate-700">
                                                السعر الشهري
                                            </span>
                                            <input
                                                type="number"
                                                min="0"
                                                step="0.01"
                                                value={
                                                    form.monthly_price
                                                }
                                                onChange={(event) =>
                                                    updateField(
                                                        "monthly_price",
                                                        event.target.value,
                                                    )
                                                }
                                                className={inputClass(
                                                    fieldError(
                                                        formErrors,
                                                        "monthly_price",
                                                    ) ?? undefined,
                                                )}
                                            />
                                        </label>
                                    </div>

                                    <div className="flex justify-end gap-3 border-t border-slate-200 pt-5">
                                        <button
                                            type="button"
                                            onClick={closeForm}
                                            disabled={saving}
                                            className="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 disabled:opacity-50"
                                        >
                                            إلغاء
                                        </button>

                                        <button
                                            type="submit"
                                            disabled={saving}
                                            className="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white disabled:opacity-50"
                                        >
                                            {saving
                                                ? "جاري الحفظ..."
                                                : "إنشاء الاشتراك"}
                                        </button>
                                    </div>
                                </>
                            )}
                        </form>
                    </div>
                </div>
            )}

            {viewingSubscription && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 p-4">
                    <div className="w-full max-w-xl rounded-2xl bg-white shadow-2xl">
                        <div className="border-b border-slate-200 px-6 py-5">
                            <h2 className="text-lg font-semibold text-slate-900">
                                تفاصيل اشتراك Hotspot
                            </h2>
                        </div>

                        <div className="grid gap-4 p-6 sm:grid-cols-2">
                            <div>
                                <p className="text-xs text-slate-500">
                                    العميل
                                </p>
                                <p className="mt-1 text-sm font-medium">
                                    {viewingSubscription.customer
                                        ?.name ??
                                        `#${viewingSubscription.customer_id}`}
                                </p>
                            </div>

                            <div>
                                <p className="text-xs text-slate-500">
                                    الباقة
                                </p>
                                <p className="mt-1 text-sm font-medium">
                                    {viewingSubscription.package
                                        ?.name ??
                                        `#${viewingSubscription.package_id}`}
                                </p>
                            </div>

                            <div>
                                <p className="text-xs text-slate-500">
                                    Hotspot Username
                                </p>
                                <p className="mt-1 font-mono text-sm font-medium">
                                    {
                                        viewingSubscription.hotspot_username
                                    }
                                </p>
                            </div>

                            <div>
                                <p className="text-xs text-slate-500">
                                    Profile
                                </p>
                                <p className="mt-1 text-sm font-medium">
                                    {
                                        viewingSubscription.mikrotik_profile
                                    }
                                </p>
                            </div>

                            <div>
                                <p className="text-xs text-slate-500">
                                    تاريخ البداية
                                </p>
                                <p className="mt-1 text-sm font-medium">
                                    {formatDate(
                                        viewingSubscription.start_date,
                                    )}
                                </p>
                            </div>

                            <div>
                                <p className="text-xs text-slate-500">
                                    تاريخ النهاية
                                </p>
                                <p className="mt-1 text-sm font-medium">
                                    {formatDate(
                                        viewingSubscription.end_date,
                                    )}
                                </p>
                            </div>

                            <div>
                                <p className="text-xs text-slate-500">
                                    السعر الشهري
                                </p>
                                <p className="mt-1 text-sm font-medium">
                                    {formatPrice(
                                        viewingSubscription.monthly_price,
                                    )}
                                </p>
                            </div>

                            <div>
                                <p className="text-xs text-slate-500">
                                    الحالة
                                </p>
                                <div className="mt-1">
                                    <StatusBadge
                                        label={getStatusLabel(
                                            viewingSubscription.status,
                                        )}
                                        tone={getStatusTone(
                                            viewingSubscription.status,
                                        )}
                                    />
                                </div>
                            </div>

                            {viewingSubscription.hotspot_password && (
                                <div className="sm:col-span-2">
                                    <p className="text-xs text-slate-500">
                                        Hotspot Password
                                    </p>
                                    <p className="mt-1 font-mono text-sm font-medium">
                                        {
                                            viewingSubscription.hotspot_password
                                        }
                                    </p>
                                </div>
                            )}
                        </div>

                        <div className="flex justify-end border-t border-slate-200 px-6 py-4">
                            <button
                                type="button"
                                onClick={() =>
                                    setViewingSubscription(null)
                                }
                                className="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700"
                            >
                                إغلاق
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {deletingSubscription && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 p-4">
                    <div className="w-full max-w-md rounded-2xl bg-white shadow-2xl">
                        <div className="p-6">
                            <h2 className="text-lg font-semibold text-slate-900">
                                حذف اشتراك Hotspot
                            </h2>

                            <p className="mt-2 text-sm leading-6 text-slate-600">
                                هل أنت متأكد من حذف اشتراك{" "}
                                <span className="font-mono font-medium">
                                    {
                                        deletingSubscription.hotspot_username
                                    }
                                </span>
                                ؟
                            </p>
                        </div>

                        <div className="flex justify-end gap-3 border-t border-slate-200 px-6 py-4">
                            <button
                                type="button"
                                onClick={() =>
                                    setDeletingSubscription(null)
                                }
                                disabled={deleting}
                                className="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 disabled:opacity-50"
                            >
                                إلغاء
                            </button>

                            <button
                                type="button"
                                onClick={() =>
                                    void confirmDelete()
                                }
                                disabled={deleting}
                                className="rounded-xl bg-red-600 px-4 py-2.5 text-sm font-medium text-white disabled:opacity-50"
                            >
                                {deleting
                                    ? "جاري الحذف..."
                                    : "حذف"}
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
}
