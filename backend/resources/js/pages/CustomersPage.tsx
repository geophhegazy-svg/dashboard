import { FormEvent, useEffect, useState } from "react";

import { ApiError, apiRequest } from "../api/client";
import { Alert } from "../components/ui/Alert";
import { LoadingState } from "../components/ui/LoadingState";
import { PageHeader } from "../components/ui/PageHeader";
import { SectionCard } from "../components/dashboard/SectionCard";
import { StatusBadge } from "../components/dashboard/StatusBadge";
import type {
    Customer,
    CustomerListResponse,
} from "../types/customer";

type CustomerForm = {
    name: string;
    phone: string;
    email: string;
    address: string;
    national_id: string;
    status: string;
    notes: string;
};

type CustomerResponse = {
    data: Customer;
};

type FormErrors = Record<string, string[]>;

const emptyForm: CustomerForm = {
    name: "",
    phone: "",
    email: "",
    address: "",
    national_id: "",
    status: "active",
    notes: "",
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

function statusLabel(status: string): string {
    switch (status) {
        case "active":
            return "نشط";

        case "inactive":
            return "غير نشط";

        case "suspended":
            return "موقوف";

        default:
            return status;
    }
}

function statusTone(
    status: string,
): "success" | "info" | "neutral" {
    switch (status) {
        case "active":
            return "success";

        case "suspended":
            return "info";

        default:
            return "neutral";
    }
}

function customerToForm(customer: Customer): CustomerForm {
    return {
        name: customer.name,
        phone: customer.phone,
        email: customer.email ?? "",
        address: customer.address ?? "",
        national_id: customer.national_id ?? "",
        status: customer.status,
        notes: customer.notes ?? "",
    };
}

function fieldError(
    errors: FormErrors,
    field: keyof CustomerForm,
): string | null {
    return errors[field]?.[0] ?? null;
}

export function CustomersPage() {
    const [customers, setCustomers] = useState<Customer[]>([]);
    const [page, setPage] = useState(1);
    const [pagination, setPagination] =
        useState<CustomerListResponse["meta"] | null>(null);

    const [loading, setLoading] = useState(true);
    const [error, setError] = useState("");

    const [formOpen, setFormOpen] = useState(false);
    const [editingCustomer, setEditingCustomer] =
        useState<Customer | null>(null);
    const [form, setForm] = useState<CustomerForm>(emptyForm);
    const [formErrors, setFormErrors] = useState<FormErrors>({});
    const [saving, setSaving] = useState(false);

    const [selectedCustomer, setSelectedCustomer] =
        useState<Customer | null>(null);
    const [loadingCustomer, setLoadingCustomer] = useState(false);

    const [deletingId, setDeletingId] = useState<number | null>(null);

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

    useEffect(() => {
        void loadCustomers();
    }, [page]);

    function openCreateForm() {
        setEditingCustomer(null);
        setForm(emptyForm);
        setFormErrors({});
        setFormOpen(true);
    }

    function openEditForm(customer: Customer) {
        setEditingCustomer(customer);
        setForm(customerToForm(customer));
        setFormErrors({});
        setFormOpen(true);
    }

    function closeForm() {
        if (saving) {
            return;
        }

        setFormOpen(false);
        setEditingCustomer(null);
        setForm(emptyForm);
        setFormErrors({});
    }

    function updateField(
        field: keyof CustomerForm,
        value: string,
    ) {
        setForm((current) => ({
            ...current,
            [field]: value,
        }));

        if (formErrors[field]) {
            setFormErrors((current) => {
                const next = { ...current };
                delete next[field];
                return next;
            });
        }
    }

    async function handleSubmit(event: FormEvent<HTMLFormElement>) {
        event.preventDefault();

        setSaving(true);
        setFormErrors({});

        const payload = {
            name: form.name,
            phone: form.phone,
            email: form.email || null,
            address: form.address || null,
            national_id: form.national_id || null,
            status: form.status,
            notes: form.notes || null,
        };

        try {
            if (editingCustomer) {
                await apiRequest<CustomerResponse>(
                    `/customers/${editingCustomer.id}`,
                    {
                        method: "PUT",
                        body: JSON.stringify(payload),
                    },
                );
            } else {
                await apiRequest<CustomerResponse>("/customers", {
                    method: "POST",
                    body: JSON.stringify(payload),
                });
            }

            closeForm();

            if (!editingCustomer && page !== 1) {
                setPage(1);
            } else {
                await loadCustomers();
            }
        } catch (exception) {
            if (exception instanceof ApiError && exception.status === 422) {
                setFormErrors(exception.errors);
            } else {
                setError(
                    exception instanceof Error
                        ? exception.message
                        : "تعذر حفظ بيانات العميل.",
                );
            }
        } finally {
            setSaving(false);
        }
    }

    async function handleView(customer: Customer) {
        setSelectedCustomer(customer);
        setLoadingCustomer(true);

        try {
            const response = await apiRequest<CustomerResponse>(
                `/customers/${customer.id}`,
            );

            setSelectedCustomer(response.data);
        } catch (exception) {
            setError(
                exception instanceof Error
                    ? exception.message
                    : "تعذر تحميل بيانات العميل.",
            );
            setSelectedCustomer(null);
        } finally {
            setLoadingCustomer(false);
        }
    }

    async function handleDelete(customer: Customer) {
        if (
            !window.confirm(
                `هل أنت متأكد من حذف العميل "${customer.name}"؟`,
            )
        ) {
            return;
        }

        setDeletingId(customer.id);
        setError("");

        try {
            await apiRequest<{ message: string }>(
                `/customers/${customer.id}`,
                {
                    method: "DELETE",
                },
            );

            if (
                customers.length === 1 &&
                page > 1
            ) {
                setPage((current) => current - 1);
            } else {
                await loadCustomers();
            }

            if (selectedCustomer?.id === customer.id) {
                setSelectedCustomer(null);
            }
        } catch (exception) {
            setError(
                exception instanceof Error
                    ? exception.message
                    : "تعذر حذف العميل.",
            );
        } finally {
            setDeletingId(null);
        }
    }

    function renderFieldError(field: keyof CustomerForm) {
        const message = fieldError(formErrors, field);

        if (!message) {
            return null;
        }

        return (
            <p className="mt-1 text-sm text-red-600">
                {message}
            </p>
        );
    }

    return (
        <main
            dir="rtl"
            className="mx-auto max-w-7xl px-4 py-6 sm:px-6 sm:py-8"
        >
            <PageHeader
                title="العملاء"
                description="إدارة ومراجعة بيانات العملاء"
            />

            <div className="mb-5 flex justify-start">
                <button
                    type="button"
                    onClick={openCreateForm}
                    className="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800"
                >
                    إضافة عميل
                </button>
            </div>

            {error && (
                <div className="mb-5">
                    <Alert variant="error">{error}</Alert>
                </div>
            )}

            {loading && <LoadingState />}

            {!loading && (
                <SectionCard
                    title="قائمة العملاء"
                    description={
                        pagination
                            ? `إجمالي العملاء: ${pagination.total.toLocaleString(
                                  "ar-EG",
                              )}`
                            : undefined
                    }
                >
                    {customers.length === 0 ? (
                        <div className="rounded-xl border border-dashed border-slate-300 px-6 py-12 text-center">
                            <p className="font-medium text-slate-700">
                                لا يوجد عملاء لعرضهم.
                            </p>

                            <p className="mt-2 text-sm text-slate-500">
                                أضف أول عميل لبدء إدارة بيانات العملاء.
                            </p>
                        </div>
                    ) : (
                        <div className="overflow-x-auto">
                            <table className="min-w-[980px] w-full">
                                <thead>
                                    <tr className="border-b border-slate-200">
                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            #
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            الاسم
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            الهاتف
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            البريد الإلكتروني
                                        </th>

                                        <th className="px-4 py-3 text-right text-xs font-semibold text-slate-500">
                                            الحالة
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
                                    {customers.map((customer) => (
                                        <tr
                                            key={customer.id}
                                            className="transition hover:bg-slate-50"
                                        >
                                            <td className="whitespace-nowrap px-4 py-4 text-sm text-slate-500">
                                                {customer.id}
                                            </td>

                                            <td className="whitespace-nowrap px-4 py-4 text-sm font-semibold text-slate-900">
                                                {customer.name}
                                            </td>

                                            <td className="whitespace-nowrap px-4 py-4 text-sm text-slate-600">
                                                {customer.phone}
                                            </td>

                                            <td className="px-4 py-4 text-sm text-slate-600">
                                                {customer.email ?? "-"}
                                            </td>

                                            <td className="whitespace-nowrap px-4 py-4">
                                                <StatusBadge
                                                    label={statusLabel(
                                                        customer.status,
                                                    )}
                                                    tone={statusTone(
                                                        customer.status,
                                                    )}
                                                />
                                            </td>

                                            <td className="whitespace-nowrap px-4 py-4 text-sm text-slate-500">
                                                {formatDate(
                                                    customer.created_at,
                                                )}
                                            </td>

                                            <td className="whitespace-nowrap px-4 py-4">
                                                <div className="flex items-center gap-2">
                                                    <button
                                                        type="button"
                                                        onClick={() =>
                                                            void handleView(
                                                                customer,
                                                            )
                                                        }
                                                        className="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 transition hover:bg-slate-50"
                                                    >
                                                        عرض
                                                    </button>

                                                    <button
                                                        type="button"
                                                        onClick={() =>
                                                            openEditForm(
                                                                customer,
                                                            )
                                                        }
                                                        className="rounded-lg border border-blue-200 px-3 py-1.5 text-xs font-medium text-blue-700 transition hover:bg-blue-50"
                                                    >
                                                        تعديل
                                                    </button>

                                                    <button
                                                        type="button"
                                                        disabled={
                                                            deletingId ===
                                                            customer.id
                                                        }
                                                        onClick={() =>
                                                            void handleDelete(
                                                                customer,
                                                            )
                                                        }
                                                        className="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-700 transition hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-50"
                                                    >
                                                        {deletingId ===
                                                        customer.id
                                                            ? "جارٍ الحذف..."
                                                            : "حذف"}
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
                                {pagination.total.toLocaleString(
                                    "ar-EG",
                                )}
                            </p>

                            <div className="flex items-center gap-2">
                                <button
                                    type="button"
                                    disabled={
                                        pagination.current_page <= 1
                                    }
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

            {formOpen && (
                <div className="fixed inset-0 z-50 overflow-y-auto bg-slate-950/40 p-4 sm:p-8">
                    <div className="mx-auto max-w-3xl rounded-2xl bg-white shadow-xl">
                        <div className="flex items-center justify-between border-b border-slate-200 px-5 py-4 sm:px-6">
                            <div>
                                <h2 className="text-lg font-bold text-slate-900">
                                    {editingCustomer
                                        ? "تعديل العميل"
                                        : "إضافة عميل"}
                                </h2>

                                <p className="mt-1 text-sm text-slate-500">
                                    أدخل بيانات العميل المطلوبة.
                                </p>
                            </div>

                            <button
                                type="button"
                                disabled={saving}
                                onClick={closeForm}
                                className="rounded-lg px-3 py-2 text-sm text-slate-500 hover:bg-slate-100 disabled:opacity-50"
                            >
                                إغلاق
                            </button>
                        </div>

                        <form
                            onSubmit={handleSubmit}
                            className="space-y-5 p-5 sm:p-6"
                        >
                            <div className="grid gap-5 sm:grid-cols-2">
                                <label className="block">
                                    <span className="text-sm font-medium text-slate-700">
                                        الاسم
                                    </span>

                                    <input
                                        value={form.name}
                                        onChange={(event) =>
                                            updateField(
                                                "name",
                                                event.target.value,
                                            )
                                        }
                                        className="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                                    />

                                    {renderFieldError("name")}
                                </label>

                                <label className="block">
                                    <span className="text-sm font-medium text-slate-700">
                                        الهاتف
                                    </span>

                                    <input
                                        value={form.phone}
                                        onChange={(event) =>
                                            updateField(
                                                "phone",
                                                event.target.value,
                                            )
                                        }
                                        className="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                                    />

                                    {renderFieldError("phone")}
                                </label>

                                <label className="block">
                                    <span className="text-sm font-medium text-slate-700">
                                        البريد الإلكتروني
                                    </span>

                                    <input
                                        type="email"
                                        value={form.email}
                                        onChange={(event) =>
                                            updateField(
                                                "email",
                                                event.target.value,
                                            )
                                        }
                                        className="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                                    />

                                    {renderFieldError("email")}
                                </label>

                                <label className="block">
                                    <span className="text-sm font-medium text-slate-700">
                                        الرقم القومي
                                    </span>

                                    <input
                                        value={form.national_id}
                                        onChange={(event) =>
                                            updateField(
                                                "national_id",
                                                event.target.value,
                                            )
                                        }
                                        className="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                                    />

                                    {renderFieldError("national_id")}
                                </label>

                                <label className="block">
                                    <span className="text-sm font-medium text-slate-700">
                                        الحالة
                                    </span>

                                    <select
                                        value={form.status}
                                        onChange={(event) =>
                                            updateField(
                                                "status",
                                                event.target.value,
                                            )
                                        }
                                        className="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                                    >
                                        <option value="active">
                                            نشط
                                        </option>
                                        <option value="inactive">
                                            غير نشط
                                        </option>
                                        <option value="suspended">
                                            موقوف
                                        </option>
                                    </select>

                                    {renderFieldError("status")}
                                </label>

                                <label className="block">
                                    <span className="text-sm font-medium text-slate-700">
                                        العنوان
                                    </span>

                                    <input
                                        value={form.address}
                                        onChange={(event) =>
                                            updateField(
                                                "address",
                                                event.target.value,
                                            )
                                        }
                                        className="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                                    />

                                    {renderFieldError("address")}
                                </label>
                            </div>

                            <label className="block">
                                <span className="text-sm font-medium text-slate-700">
                                    ملاحظات
                                </span>

                                <textarea
                                    value={form.notes}
                                    onChange={(event) =>
                                        updateField(
                                            "notes",
                                            event.target.value,
                                        )
                                    }
                                    rows={4}
                                    className="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                                />

                                {renderFieldError("notes")}
                            </label>

                            <div className="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-start">
                                <button
                                    type="submit"
                                    disabled={saving}
                                    className="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50"
                                >
                                    {saving
                                        ? "جارٍ الحفظ..."
                                        : editingCustomer
                                          ? "حفظ التعديلات"
                                          : "إضافة العميل"}
                                </button>

                                <button
                                    type="button"
                                    disabled={saving}
                                    onClick={closeForm}
                                    className="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 disabled:opacity-50"
                                >
                                    إلغاء
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}

            {selectedCustomer && (
                <div className="fixed inset-0 z-40 overflow-y-auto bg-slate-950/40 p-4 sm:p-8">
                    <div className="mx-auto max-w-2xl rounded-2xl bg-white shadow-xl">
                        <div className="flex items-center justify-between border-b border-slate-200 px-5 py-4 sm:px-6">
                            <div>
                                <h2 className="text-lg font-bold text-slate-900">
                                    بيانات العميل
                                </h2>

                                <p className="mt-1 text-sm text-slate-500">
                                    التفاصيل الحالية من النظام.
                                </p>
                            </div>

                            <button
                                type="button"
                                onClick={() =>
                                    setSelectedCustomer(null)
                                }
                                className="rounded-lg px-3 py-2 text-sm text-slate-500 hover:bg-slate-100"
                            >
                                إغلاق
                            </button>
                        </div>

                        {loadingCustomer ? (
                            <div className="p-6">
                                <LoadingState />
                            </div>
                        ) : (
                            <div className="grid gap-5 p-5 sm:grid-cols-2 sm:p-6">
                                <div>
                                    <p className="text-xs font-medium text-slate-500">
                                        الاسم
                                    </p>
                                    <p className="mt-1 font-semibold text-slate-900">
                                        {selectedCustomer.name}
                                    </p>
                                </div>

                                <div>
                                    <p className="text-xs font-medium text-slate-500">
                                        الهاتف
                                    </p>
                                    <p className="mt-1 text-slate-700">
                                        {selectedCustomer.phone}
                                    </p>
                                </div>

                                <div>
                                    <p className="text-xs font-medium text-slate-500">
                                        البريد الإلكتروني
                                    </p>
                                    <p className="mt-1 text-slate-700">
                                        {selectedCustomer.email ?? "-"}
                                    </p>
                                </div>

                                <div>
                                    <p className="text-xs font-medium text-slate-500">
                                        الرقم القومي
                                    </p>
                                    <p className="mt-1 text-slate-700">
                                        {selectedCustomer.national_id ?? "-"}
                                    </p>
                                </div>

                                <div>
                                    <p className="text-xs font-medium text-slate-500">
                                        الحالة
                                    </p>
                                    <div className="mt-1">
                                        <StatusBadge
                                            label={statusLabel(
                                                selectedCustomer.status,
                                            )}
                                            tone={statusTone(
                                                selectedCustomer.status,
                                            )}
                                        />
                                    </div>
                                </div>

                                <div>
                                    <p className="text-xs font-medium text-slate-500">
                                        تاريخ الإنشاء
                                    </p>
                                    <p className="mt-1 text-slate-700">
                                        {formatDate(
                                            selectedCustomer.created_at,
                                        )}
                                    </p>
                                </div>

                                <div className="sm:col-span-2">
                                    <p className="text-xs font-medium text-slate-500">
                                        العنوان
                                    </p>
                                    <p className="mt-1 whitespace-pre-wrap text-slate-700">
                                        {selectedCustomer.address ?? "-"}
                                    </p>
                                </div>

                                <div className="sm:col-span-2">
                                    <p className="text-xs font-medium text-slate-500">
                                        ملاحظات
                                    </p>
                                    <p className="mt-1 whitespace-pre-wrap text-slate-700">
                                        {selectedCustomer.notes ?? "-"}
                                    </p>
                                </div>

                                <div className="sm:col-span-2 border-t border-slate-100 pt-4">
                                    <button
                                        type="button"
                                        onClick={() => {
                                            const customer =
                                                selectedCustomer;

                                            setSelectedCustomer(null);
                                            openEditForm(customer);
                                        }}
                                        className="rounded-xl border border-blue-200 px-5 py-2.5 text-sm font-medium text-blue-700 transition hover:bg-blue-50"
                                    >
                                        تعديل العميل
                                    </button>
                                </div>
                            </div>
                        )}
                    </div>
                </div>
            )}
        </main>
    );
}
