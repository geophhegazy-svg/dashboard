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
    Subscription,
    SubscriptionListResponse,
} from "../types/subscription";

type SubscriptionForm = {
    tenant_id: string;
    customer_id: string;
    package_id: string;
    start_date: string;
    end_date: string;
    monthly_price: string;
    status: "draft" | "pending" | "active";
    notes: string;
    pppoe_username: string;
    pppoe_password: string;
    mikrotik_profile: string;
};

type SubscriptionResponse = {
    data: Subscription;
};

type FormErrors = Record<string, string[]>;

const emptyForm: SubscriptionForm = {
    tenant_id: "",
    customer_id: "",
    package_id: "",
    start_date: "",
    end_date: "",
    monthly_price: "",
    status: "pending",
    notes: "",
    pppoe_username: "",
    pppoe_password: "",
    mikrotik_profile: "",
};

const statusLabels: Record<string, string> = {
    draft: "مسودة",
    pending: "معلقة",
    active: "نشطة",
    grace: "فترة سماح",
    suspended: "موقوفة",
    expired: "منتهية",
    cancelled: "ملغاة",
    terminated: "منتهية نهائيًا",
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
    if (!value) {
        return "";
    }

    return value.slice(0, 10);
}

function formatPrice(value: number): string {
    return new Intl.NumberFormat("ar-EG", {
        style: "currency",
        currency: "EGP",
        maximumFractionDigits: 2,
    }).format(value);
}

function getStatusLabel(status: string): string {
    return statusLabels[status] ?? status;
}

function getStatusTone(
    status: string,
): "success" | "info" | "neutral" {
    switch (status) {
        case "active":
            return "success";

        case "pending":
        case "grace":
            return "info";

        default:
            return "neutral";
    }
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
    field: keyof SubscriptionForm,
): string | null {
    return errors[field]?.[0] ?? null;
}

function subscriptionToForm(
    subscription: Subscription,
): SubscriptionForm {
    return {
        tenant_id: String(subscription.tenant_id),
        customer_id: String(subscription.customer_id),
        package_id: String(subscription.package_id),
        start_date: formatDateInput(subscription.start_date),
        end_date: formatDateInput(subscription.end_date),
        monthly_price: String(subscription.monthly_price),
        status:
            subscription.status === "draft" ||
            subscription.status === "active"
                ? subscription.status
                : "pending",
        notes: subscription.notes ?? "",
        pppoe_username: subscription.pppoe_username ?? "",
        pppoe_password: "",
        mikrotik_profile: subscription.mikrotik_profile ?? "",
    };
}

function canActivate(status: string): boolean {
    return ["pending", "suspended", "expired"].includes(status);
}

function canSuspend(status: string): boolean {
    return status === "active";
}

function canRestore(status: string): boolean {
    return ["suspended", "expired"].includes(status);
}

function canRenew(status: string): boolean {
    return ["active", "grace", "expired"].includes(status);
}

function canExpire(status: string): boolean {
    return ["active", "grace"].includes(status);
}

function canCancel(status: string): boolean {
    return ["draft", "pending", "active", "grace", "suspended"].includes(
        status,
    );
}

export function SubscriptionsPage() {
    const [subscriptions, setSubscriptions] = useState<
        Subscription[]
    >([]);

    const [page, setPage] = useState(1);

    const [pagination, setPagination] =
        useState<SubscriptionListResponse["meta"] | null>(null);

    const [loading, setLoading] = useState(true);
    const [error, setError] = useState("");

    const [showForm, setShowForm] = useState(false);
    const [editingSubscription, setEditingSubscription] =
        useState<Subscription | null>(null);

    const [viewingSubscription, setViewingSubscription] =
        useState<Subscription | null>(null);

    const [form, setForm] =
        useState<SubscriptionForm>(emptyForm);

    const [formErrors, setFormErrors] =
        useState<FormErrors>({});

    const [formError, setFormError] = useState("");
    const [saving, setSaving] = useState(false);

    const [deletingSubscription, setDeletingSubscription] =
        useState<Subscription | null>(null);

    const [deleting, setDeleting] = useState(false);

    const [actionId, setActionId] =
        useState<number | null>(null);

    async function loadSubscriptions() {
        setLoading(true);
        setError("");

        try {
            const response =
                await apiRequest<SubscriptionListResponse>(
                    `/subscriptions?page=${page}`,
                );

            setSubscriptions(response.data);
            setPagination(response.meta);
        } catch (exception) {
            setError(
                exception instanceof Error
                    ? exception.message
                    : "تعذر تحميل الاشتراكات.",
            );
        } finally {
            setLoading(false);
        }
    }

    useEffect(() => {
        void loadSubscriptions();
    }, [page]);

    function openCreate() {
        setEditingSubscription(null);
        setForm(emptyForm);
        setFormErrors({});
        setFormError("");
        setShowForm(true);
    }

    function openEdit(subscription: Subscription) {
        setEditingSubscription(subscription);
        setForm(subscriptionToForm(subscription));
        setFormErrors({});
        setFormError("");
        setShowForm(true);
    }

    function closeForm() {
        if (saving) {
            return;
        }

        setShowForm(false);
        setEditingSubscription(null);
        setForm(emptyForm);
        setFormErrors({});
        setFormError("");
    }

    function updateField<K extends keyof SubscriptionForm>(
        field: K,
        value: SubscriptionForm[K],
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
            start_date: form.start_date,
            end_date: form.end_date || null,
            monthly_price: Number(form.monthly_price),
            ...(editingSubscription
                ? {}
                : {
                      status: form.status,
                  }),
            notes: form.notes || null,
            pppoe_username: form.pppoe_username || null,
            pppoe_password: form.pppoe_password || null,
            mikrotik_profile: form.mikrotik_profile || null,
        };

        try {
            if (editingSubscription) {
                await apiRequest<SubscriptionResponse>(
                    `/subscriptions/${editingSubscription.id}`,
                    {
                        method: "PUT",
                        body: JSON.stringify(payload),
                    },
                );
            } else {
                await apiRequest<SubscriptionResponse>(
                    "/subscriptions",
                    {
                        method: "POST",
                        body: JSON.stringify(payload),
                    },
                );
            }

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
                        : "تعذر حفظ الاشتراك.",
                );
            }
        } finally {
            setSaving(false);
        }
    }

    async function handleView(
        subscription: Subscription,
    ) {
        setError("");

        try {
            const response =
                await apiRequest<SubscriptionResponse>(
                    `/subscriptions/${subscription.id}`,
                );

            setViewingSubscription(response.data);
        } catch (exception) {
            setError(
                exception instanceof Error
                    ? exception.message
                    : "تعذر تحميل تفاصيل الاشتراك.",
            );
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
                `/subscriptions/${deletingSubscription.id}`,
                {
                    method: "DELETE",
                },
            );

            setDeletingSubscription(null);

            if (
                subscriptions.length === 1 &&
                page > 1
            ) {
                setPage((current) => current - 1);
            } else {
                await loadSubscriptions();
            }

            if (
                viewingSubscription?.id ===
                deletingSubscription.id
            ) {
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

    async function runLifecycleAction(
        subscription: Subscription,
        action:
            | "activate"
            | "cancel"
            | "expire"
            | "restore"
            | "suspend",
        confirmation: string,
    ) {
        if (!window.confirm(confirmation)) {
            return;
        }

        setActionId(subscription.id);
        setError("");

        try {
            const response =
                await apiRequest<SubscriptionResponse>(
                    `/subscriptions/${subscription.id}/${action}`,
                    {
                        method: "POST",
                    },
                );

            setViewingSubscription(response.data);
            await loadSubscriptions();
        } catch (exception) {
            setError(
                exception instanceof Error
                    ? exception.message
                    : "تعذر تنفيذ الإجراء.",
            );
        } finally {
            setActionId(null);
        }
    }

    async function handleRenew(
        subscription: Subscription,
    ) {
        const value = window.prompt(
            "عدد أيام التجديد:",
            "30",
        );

        if (value === null) {
            return;
        }

        const days = Number(value);

        if (!Number.isInteger(days) || days <= 0) {
            setError("عدد أيام التجديد يجب أن يكون رقمًا صحيحًا أكبر من صفر.");
            return;
        }

        setActionId(subscription.id);
        setError("");

        try {
            const response =
                await apiRequest<SubscriptionResponse>(
                    `/subscriptions/${subscription.id}/renew`,
                    {
                        method: "POST",
                        body: JSON.stringify({ days }),
                    },
                );

            setViewingSubscription(response.data);
            await loadSubscriptions();
        } catch (exception) {
            setError(
                exception instanceof Error
                    ? exception.message
                    : "تعذر تجديد الاشتراك.",
            );
        } finally {
            setActionId(null);
        }
    }

    function renderFieldError(
        field: keyof SubscriptionForm,
    ) {
        const message = fieldError(formErrors, field);

        if (!message) {
            return null;
        }

        return (
            <p className="mt-1 text-xs text-red-600">
                {message}
            </p>
        );
    }

    function renderLifecycleActions(
        subscription: Subscription,
    ) {
        const busy = actionId === subscription.id;

        return (
            <div className="flex flex-wrap items-center gap-2">
                {canActivate(subscription.status) && (
                    <button
                        type="button"
                        disabled={busy}
                        onClick={() =>
                            void runLifecycleAction(
                                subscription,
                                "activate",
                                "هل تريد تفعيل هذا الاشتراك؟",
                            )
                        }
                        className="rounded-lg border border-emerald-200 px-3 py-1.5 text-xs font-medium text-emerald-700 transition hover:bg-emerald-50 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        تفعيل
                    </button>
                )}

                {canSuspend(subscription.status) && (
                    <button
                        type="button"
                        disabled={busy}
                        onClick={() =>
                            void runLifecycleAction(
                                subscription,
                                "suspend",
                                "هل تريد إيقاف هذا الاشتراك؟",
                            )
                        }
                        className="rounded-lg border border-amber-200 px-3 py-1.5 text-xs font-medium text-amber-700 transition hover:bg-amber-50 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        إيقاف
                    </button>
                )}

                {canRestore(subscription.status) && (
                    <button
                        type="button"
                        disabled={busy}
                        onClick={() =>
                            void runLifecycleAction(
                                subscription,
                                "restore",
                                "هل تريد استعادة هذا الاشتراك؟",
                            )
                        }
                        className="rounded-lg border border-blue-200 px-3 py-1.5 text-xs font-medium text-blue-700 transition hover:bg-blue-50 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        استعادة
                    </button>
                )}

                {canRenew(subscription.status) && (
                    <button
                        type="button"
                        disabled={busy}
                        onClick={() =>
                            void handleRenew(subscription)
                        }
                        className="rounded-lg border border-indigo-200 px-3 py-1.5 text-xs font-medium text-indigo-700 transition hover:bg-indigo-50 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        تجديد
                    </button>
                )}

                {canExpire(subscription.status) && (
                    <button
                        type="button"
                        disabled={busy}
                        onClick={() =>
                            void runLifecycleAction(
                                subscription,
                                "expire",
                                "هل تريد إنهاء صلاحية هذا الاشتراك؟",
                            )
                        }
                        className="rounded-lg border border-orange-200 px-3 py-1.5 text-xs font-medium text-orange-700 transition hover:bg-orange-50 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        إنهاء الصلاحية
                    </button>
                )}

                {canCancel(subscription.status) && (
                    <button
                        type="button"
                        disabled={busy}
                        onClick={() =>
                            void runLifecycleAction(
                                subscription,
                                "cancel",
                                "هل تريد إلغاء هذا الاشتراك؟",
                            )
                        }
                        className="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-700 transition hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        إلغاء
                    </button>
                )}

                {busy && (
                    <span className="text-xs text-slate-500">
                        جارٍ التنفيذ...
                    </span>
                )}
            </div>
        );
    }

    return (
        <main
            dir="rtl"
            className="mx-auto max-w-7xl px-4 py-6 sm:px-6 sm:py-8"
        >
            <PageHeader
                title="الاشتراكات"
                description="إدارة اشتراكات العملاء ومتابعة دورة حياتها."
            />

            <div className="mb-6 flex justify-start">
                <button
                    type="button"
                    onClick={openCreate}
                    className="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800"
                >
                    إضافة اشتراك
                </button>
            </div>

            {error && (
                <div className="mb-5">
                    <Alert variant="error">
                        {error}
                    </Alert>
                </div>
            )}

            {loading && <LoadingState />}

            {!loading && (
                <SectionCard
                    title="قائمة الاشتراكات"
                    description={
                        pagination
                            ? `إجمالي الاشتراكات: ${pagination.total.toLocaleString(
                                  "ar-EG",
                              )}`
                            : undefined
                    }
                >
                    {subscriptions.length === 0 ? (
                        <div className="rounded-xl border border-dashed border-slate-300 px-6 py-12 text-center">
                            <p className="font-medium text-slate-700">
                                لا توجد اشتراكات لعرضها.
                            </p>

                            <p className="mt-2 text-sm text-slate-500">
                                أضف أول اشتراك لبدء إدارة اشتراكات العملاء.
                            </p>
                        </div>
                    ) : (
                        <div className="overflow-x-auto">
                            <table className="min-w-[1500px] w-full">
                                <thead>
                                    <tr className="border-b border-slate-200">
                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            #
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            العميل
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            الباقة
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            البداية
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            النهاية
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            السعر الشهري
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            الحالة
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            PPPoE
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            MikroTik
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            الإجراءات
                                        </th>
                                    </tr>
                                </thead>

                                <tbody className="divide-y divide-slate-100">
                                    {subscriptions.map(
                                        (subscription) => (
                                            <tr
                                                key={
                                                    subscription.id
                                                }
                                                className="transition hover:bg-slate-50"
                                            >
                                                <td className="whitespace-nowrap px-4 py-4 text-sm text-slate-500">
                                                    {
                                                        subscription.id
                                                    }
                                                </td>

                                                <td className="whitespace-nowrap px-4 py-4">
                                                    <p className="text-sm font-semibold text-slate-900">
                                                        {subscription.customer
                                                            ?.name ??
                                                            "-"}
                                                    </p>

                                                    {subscription
                                                        .customer
                                                        ?.phone && (
                                                        <p className="mt-1 text-xs text-slate-500">
                                                            {
                                                                subscription
                                                                    .customer
                                                                    .phone
                                                            }
                                                        </p>
                                                    )}
                                                </td>

                                                <td className="whitespace-nowrap px-4 py-4 text-sm text-slate-700">
                                                    {subscription.package
                                                        ?.name ??
                                                        "-"}
                                                </td>

                                                <td className="whitespace-nowrap px-4 py-4 text-sm text-slate-600">
                                                    {formatDate(
                                                        subscription.start_date,
                                                    )}
                                                </td>

                                                <td className="whitespace-nowrap px-4 py-4 text-sm text-slate-600">
                                                    {formatDate(
                                                        subscription.end_date,
                                                    )}
                                                </td>

                                                <td className="whitespace-nowrap px-4 py-4 text-sm font-semibold text-slate-900">
                                                    {formatPrice(
                                                        subscription.monthly_price,
                                                    )}
                                                </td>

                                                <td className="whitespace-nowrap px-4 py-4">
                                                    <StatusBadge
                                                        label={getStatusLabel(
                                                            subscription.status,
                                                        )}
                                                        tone={getStatusTone(
                                                            subscription.status,
                                                        )}
                                                    />
                                                </td>

                                                <td className="whitespace-nowrap px-4 py-4 text-sm text-slate-700">
                                                    {subscription.pppoe_username ??
                                                        "-"}
                                                </td>

                                                <td className="whitespace-nowrap px-4 py-4 text-sm text-slate-700">
                                                    {subscription.mikrotik_profile ??
                                                        "-"}
                                                </td>

                                                <td className="px-4 py-4">
                                                    <div className="flex min-w-[430px] flex-wrap items-center gap-2">
                                                        <button
                                                            type="button"
                                                            onClick={() =>
                                                                void handleView(
                                                                    subscription,
                                                                )
                                                            }
                                                            className="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 transition hover:bg-slate-50"
                                                        >
                                                            عرض
                                                        </button>

                                                        <button
                                                            type="button"
                                                            onClick={() =>
                                                                openEdit(
                                                                    subscription,
                                                                )
                                                            }
                                                            className="rounded-lg border border-blue-200 px-3 py-1.5 text-xs font-medium text-blue-700 transition hover:bg-blue-50"
                                                        >
                                                            تعديل
                                                        </button>

                                                        <button
                                                            type="button"
                                                            onClick={() =>
                                                                setDeletingSubscription(
                                                                    subscription,
                                                                )
                                                            }
                                                            className="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-700 transition hover:bg-red-50"
                                                        >
                                                            حذف
                                                        </button>

                                                        {renderLifecycleActions(
                                                            subscription,
                                                        )}
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
                            <div className="mt-5 flex flex-col gap-4 border-t border-slate-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                                <p className="text-sm text-slate-500">
                                    عرض{" "}
                                    {(
                                        pagination.from ??
                                        0
                                    ).toLocaleString(
                                        "ar-EG",
                                    )}{" "}
                                    -{" "}
                                    {(
                                        pagination.to ??
                                        0
                                    ).toLocaleString(
                                        "ar-EG",
                                    )}{" "}
                                    من{" "}
                                    {pagination.total.toLocaleString(
                                        "ar-EG",
                                    )}
                                </p>

                                <div className="flex items-center gap-2">
                                    <button
                                        type="button"
                                        disabled={
                                            pagination.current_page <=
                                            1
                                        }
                                        onClick={() =>
                                            setPage(
                                                (current) =>
                                                    Math.max(
                                                        1,
                                                        current -
                                                            1,
                                                    ),
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
                                            setPage(
                                                (current) =>
                                                    Math.min(
                                                        pagination.last_page,
                                                        current +
                                                            1,
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
                    <div className="mx-auto max-w-3xl rounded-2xl bg-white p-6 shadow-xl">
                        <div className="mb-6 flex items-start justify-between">
                            <div>
                                <h2 className="text-xl font-bold text-slate-900">
                                    {editingSubscription
                                        ? "تعديل الاشتراك"
                                        : "إضافة اشتراك"}
                                </h2>

                                <p className="mt-1 text-sm text-slate-500">
                                    {editingSubscription
                                        ? "تعديل بيانات الاشتراك دون تغيير حالته."
                                        : "أدخل بيانات الاشتراك المطلوبة."}
                                </p>
                            </div>

                            <button
                                type="button"
                                disabled={saving}
                                onClick={closeForm}
                                className="rounded-lg px-3 py-1 text-slate-500 hover:bg-slate-100 disabled:opacity-50"
                            >
                                إغلاق
                            </button>
                        </div>

                        {formError && (
                            <div className="mb-5">
                                <Alert variant="error">
                                    {formError}
                                </Alert>
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
                                        fieldError(
                                            formErrors,
                                            "tenant_id",
                                        ) ??
                                            undefined,
                                    )}
                                    inputMode="numeric"
                                    disabled={
                                        Boolean(
                                            editingSubscription,
                                        )
                                    }
                                />

                                {renderFieldError(
                                    "tenant_id",
                                )}
                            </div>

                            <div>
                                <label className="mb-1 block text-sm font-medium text-slate-700">
                                    Customer ID
                                </label>

                                <input
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
                                        ) ??
                                            undefined,
                                    )}
                                    inputMode="numeric"
                                />

                                {renderFieldError(
                                    "customer_id",
                                )}
                            </div>

                            <div>
                                <label className="mb-1 block text-sm font-medium text-slate-700">
                                    Package ID
                                </label>

                                <input
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
                                        ) ??
                                            undefined,
                                    )}
                                    inputMode="numeric"
                                />

                                {renderFieldError(
                                    "package_id",
                                )}
                            </div>

                            <div>
                                <label className="mb-1 block text-sm font-medium text-slate-700">
                                    السعر الشهري
                                </label>

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
                                        ) ??
                                            undefined,
                                    )}
                                />

                                {renderFieldError(
                                    "monthly_price",
                                )}
                            </div>

                            <div>
                                <label className="mb-1 block text-sm font-medium text-slate-700">
                                    تاريخ البداية
                                </label>

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
                                        ) ??
                                            undefined,
                                    )}
                                />

                                {renderFieldError(
                                    "start_date",
                                )}
                            </div>

                            <div>
                                <label className="mb-1 block text-sm font-medium text-slate-700">
                                    تاريخ النهاية
                                </label>

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
                                        ) ??
                                            undefined,
                                    )}
                                />

                                {renderFieldError(
                                    "end_date",
                                )}
                            </div>

                            {!editingSubscription && (
                                <div>
                                    <label className="mb-1 block text-sm font-medium text-slate-700">
                                        الحالة الابتدائية
                                    </label>

                                    <select
                                        value={form.status}
                                        onChange={(event) =>
                                            updateField(
                                                "status",
                                                event.target
                                                    .value as SubscriptionForm["status"],
                                            )
                                        }
                                        className={inputClass(
                                            fieldError(
                                                formErrors,
                                                "status",
                                            ) ??
                                                undefined,
                                        )}
                                    >
                                        <option value="draft">
                                            مسودة
                                        </option>
                                        <option value="pending">
                                            معلقة
                                        </option>
                                        <option value="active">
                                            نشطة
                                        </option>
                                    </select>

                                    {renderFieldError(
                                        "status",
                                    )}
                                </div>
                            )}

                            <div>
                                <label className="mb-1 block text-sm font-medium text-slate-700">
                                    PPPoE Username
                                </label>

                                <input
                                    value={
                                        form.pppoe_username
                                    }
                                    onChange={(event) =>
                                        updateField(
                                            "pppoe_username",
                                            event.target.value,
                                        )
                                    }
                                    className={inputClass(
                                        fieldError(
                                            formErrors,
                                            "pppoe_username",
                                        ) ??
                                            undefined,
                                    )}
                                />

                                {renderFieldError(
                                    "pppoe_username",
                                )}
                            </div>

                            <div>
                                <label className="mb-1 block text-sm font-medium text-slate-700">
                                    PPPoE Password
                                </label>

                                <input
                                    type="password"
                                    value={
                                        form.pppoe_password
                                    }
                                    onChange={(event) =>
                                        updateField(
                                            "pppoe_password",
                                            event.target.value,
                                        )
                                    }
                                    className={inputClass(
                                        fieldError(
                                            formErrors,
                                            "pppoe_password",
                                        ) ??
                                            undefined,
                                    )}
                                    placeholder={
                                        editingSubscription
                                            ? "اتركه فارغًا إذا لم ترد تغييره"
                                            : undefined
                                    }
                                />

                                {renderFieldError(
                                    "pppoe_password",
                                )}
                            </div>

                            <div>
                                <label className="mb-1 block text-sm font-medium text-slate-700">
                                    MikroTik Profile
                                </label>

                                <input
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
                                        ) ??
                                            undefined,
                                    )}
                                />

                                {renderFieldError(
                                    "mikrotik_profile",
                                )}
                            </div>

                            <div className="sm:col-span-2">
                                <label className="mb-1 block text-sm font-medium text-slate-700">
                                    ملاحظات
                                </label>

                                <textarea
                                    value={form.notes}
                                    onChange={(event) =>
                                        updateField(
                                            "notes",
                                            event.target.value,
                                        )
                                    }
                                    rows={4}
                                    className={inputClass(
                                        fieldError(
                                            formErrors,
                                            "notes",
                                        ) ??
                                            undefined,
                                    )}
                                />

                                {renderFieldError(
                                    "notes",
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
                                        : editingSubscription
                                          ? "حفظ التعديلات"
                                          : "إضافة الاشتراك"}
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

            {viewingSubscription && (
                <div className="fixed inset-0 z-50 overflow-y-auto bg-slate-950/40 px-4 py-8">
                    <div className="mx-auto max-w-4xl rounded-2xl bg-white p-6 shadow-xl">
                        <div className="mb-6 flex items-start justify-between">
                            <div>
                                <h2 className="text-xl font-bold text-slate-900">
                                    تفاصيل الاشتراك
                                </h2>

                                <p className="mt-1 text-sm text-slate-500">
                                    الاشتراك #
                                    {
                                        viewingSubscription.id
                                    }
                                </p>
                            </div>

                            <button
                                type="button"
                                onClick={() =>
                                    setViewingSubscription(
                                        null,
                                    )
                                }
                                className="rounded-lg px-3 py-1 text-slate-500 hover:bg-slate-100"
                            >
                                إغلاق
                            </button>
                        </div>

                        <div className="grid gap-4 sm:grid-cols-2">
                            {[
                                [
                                    "العميل",
                                    viewingSubscription.customer
                                        ?.name ?? "-",
                                ],
                                [
                                    "رقم العميل",
                                    viewingSubscription.customer_id,
                                ],
                                [
                                    "الباقة",
                                    viewingSubscription.package
                                        ?.name ?? "-",
                                ],
                                [
                                    "رقم الباقة",
                                    viewingSubscription.package_id,
                                ],
                                [
                                    "Tenant ID",
                                    viewingSubscription.tenant_id,
                                ],
                                [
                                    "تاريخ البداية",
                                    formatDate(
                                        viewingSubscription.start_date,
                                    ),
                                ],
                                [
                                    "تاريخ النهاية",
                                    formatDate(
                                        viewingSubscription.end_date,
                                    ),
                                ],
                                [
                                    "السعر الشهري",
                                    formatPrice(
                                        viewingSubscription.monthly_price,
                                    ),
                                ],
                                [
                                    "PPPoE Username",
                                    viewingSubscription.pppoe_username ??
                                        "-",
                                ],
                                [
                                    "MikroTik Profile",
                                    viewingSubscription.mikrotik_profile ??
                                        "-",
                                ],
                                [
                                    "تاريخ الإنشاء",
                                    formatDate(
                                        viewingSubscription.created_at,
                                    ),
                                ],
                                [
                                    "آخر تحديث",
                                    formatDate(
                                        viewingSubscription.updated_at,
                                    ),
                                ],
                            ].map(([label, value]) => (
                                <div
                                    key={String(label)}
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

                            <div className="rounded-xl bg-slate-50 p-4">
                                <p className="text-xs font-medium text-slate-500">
                                    الحالة
                                </p>

                                <div className="mt-2">
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

                            <div className="rounded-xl bg-slate-50 p-4">
                                <p className="text-xs font-medium text-slate-500">
                                    دورة الحياة
                                </p>

                                <div className="mt-2">
                                    {renderLifecycleActions(
                                        viewingSubscription,
                                    )}
                                </div>
                            </div>

                            <div className="sm:col-span-2 rounded-xl bg-slate-50 p-4">
                                <p className="text-xs font-medium text-slate-500">
                                    ملاحظات
                                </p>

                                <p className="mt-1 whitespace-pre-wrap text-sm text-slate-700">
                                    {viewingSubscription.notes ??
                                        "-"}
                                </p>
                            </div>
                        </div>

                        <div className="mt-6 flex flex-wrap gap-3 border-t border-slate-100 pt-5">
                            <button
                                type="button"
                                onClick={() => {
                                    const subscription =
                                        viewingSubscription;

                                    setViewingSubscription(
                                        null,
                                    );

                                    openEdit(subscription);
                                }}
                                className="rounded-xl border border-blue-200 px-5 py-2.5 text-sm font-medium text-blue-700 transition hover:bg-blue-50"
                            >
                                تعديل الاشتراك
                            </button>

                            <button
                                type="button"
                                onClick={() => {
                                    setDeletingSubscription(
                                        viewingSubscription,
                                    );
                                    setViewingSubscription(
                                        null,
                                    );
                                }}
                                className="rounded-xl border border-red-200 px-5 py-2.5 text-sm font-medium text-red-700 transition hover:bg-red-50"
                            >
                                حذف الاشتراك
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {deletingSubscription && (
                <div className="fixed inset-0 z-[60] flex items-center justify-center bg-slate-950/40 px-4">
                    <div className="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">
                        <h2 className="text-xl font-bold text-slate-900">
                            حذف الاشتراك
                        </h2>

                        <p className="mt-3 text-sm leading-6 text-slate-600">
                            هل تريد حذف الاشتراك #
                            <strong className="mx-1">
                                {deletingSubscription.id}
                            </strong>
                            ؟ لا يمكن التراجع عن هذا الإجراء.
                        </p>

                        <div className="mt-6 flex justify-start gap-3">
                            <button
                                type="button"
                                onClick={() =>
                                    void confirmDelete()
                                }
                                disabled={deleting}
                                className="rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                {deleting
                                    ? "جاري الحذف..."
                                    : "تأكيد الحذف"}
                            </button>

                            <button
                                type="button"
                                onClick={() =>
                                    setDeletingSubscription(
                                        null,
                                    )
                                }
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
