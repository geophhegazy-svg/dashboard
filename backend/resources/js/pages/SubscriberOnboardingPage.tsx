import { formatDigits } from "../utils/formatDigits";
import { useEffect, useMemo, useState } from "react";

import { ApiError, apiRequest } from "../api/client";
import { useAuth } from "../auth/AuthContext";
import { Alert } from "../components/ui/Alert";
import { LoadingState } from "../components/ui/LoadingState";
import { PageHeader } from "../components/ui/PageHeader";
import { SectionCard } from "../components/dashboard/SectionCard";

interface Tenant {
    id: number;
    name: string;
    status: string;
}

interface Package {
    id: number;
    tenant_id: number;
    name: string;
    price: string | number;
    download_speed: number | null;
    upload_speed: number | null;
    status: string;
}

interface NetworkDevice {
    id: number;
    name: string;
    type: string;
    status: string;
    is_online: boolean;
}

interface PaginatedResponse<T> {
    data: T[];
    meta?: {
        current_page: number;
        last_page: number;
        total: number;
    };
}

interface Customer {
    id: number;
    tenant_id: number;
    name: string;
    phone: string;
    email: string | null;
    status: string;
}

interface Subscription {
    id: number;
    tenant_id: number;
    customer_id: number;
    package_id: number;
    start_date: string;
    end_date: string | null;
    monthly_price: string | number;
    status: string;
}

interface NetworkService {
    id: number;
    tenant_id?: number;
    customer_id?: number;
    package_id?: number;
    network_device_id?: number;
    connection_type?: string;
    username?: string;
    status?: string;
    provisioning_status?: string;
    last_error?: string | null;
    [key: string]: unknown;
}

interface OnboardingResponse {
    message: string;
    data: {
        customer: Customer;
        subscription: Subscription;
        network_service: NetworkService;
    };
}

interface ProvisionResponse {
    message: string;
    data: NetworkService;
}

interface FormData {
    tenant_id: string;

    customer_name: string;
    customer_phone: string;
    customer_email: string;
    customer_address: string;
    customer_national_id: string;
    customer_status: "active" | "inactive" | "suspended";
    customer_notes: string;

    package_id: string;
    start_date: string;
    end_date: string;
    monthly_price: string;
    subscription_status: "draft" | "pending" | "active";
    subscription_notes: string;

    network_device_id: string;
    connection_type: "pppoe" | "hotspot";
    username: string;
    password: string;
    mac_address: string;
    ip_address: string;
    ip_mode: "dynamic" | "static";
    starts_at: string;
    ends_at: string;
}

const emptyForm: FormData = {
    tenant_id: "",

    customer_name: "",
    customer_phone: "",
    customer_email: "",
    customer_address: "",
    customer_national_id: "",
    customer_status: "active",
    customer_notes: "",

    package_id: "",
    start_date: "",
    end_date: "",
    monthly_price: "",
    subscription_status: "active",
    subscription_notes: "",

    network_device_id: "",
    connection_type: "pppoe",
    username: "",
    password: "",
    mac_address: "",
    ip_address: "",
    ip_mode: "dynamic",
    starts_at: "",
    ends_at: "",
};

const steps = [
    "بيانات العميل",
    "الاشتراك",
    "إعداد الشبكة",
    "المراجعة",
];

function inputClass(error = false): string {
    return `w-full rounded-xl border px-3 py-2 text-sm outline-none transition focus:ring-2 ${
        error
            ? "border-red-300 focus:border-red-400 focus:ring-red-100"
            : "border-slate-300 focus:border-slate-400 focus:ring-slate-100"
    }`;
}

function today(): string {
    return new Date().toISOString().slice(0, 10);
}

function nowLocalDateTime(): string {
    const date = new Date();
    const offset = date.getTimezoneOffset();
    const local = new Date(date.getTime() - offset * 60_000);

    return local.toISOString().slice(0, 16);
}

function formatPrice(value: string | number): string {
    const amount = Number(value);

    if (Number.isNaN(amount)) {
        return String(value);
    }

    return amount.toLocaleString("en-US", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });
}

export function SubscriberOnboardingPage() {
    const { user } = useAuth();

    const [step, setStep] = useState(0);
    const [form, setForm] = useState<FormData>(() => ({
        ...emptyForm,
        start_date: today(),
        starts_at: nowLocalDateTime(),
    }));

    const [tenants, setTenants] = useState<Tenant[]>([]);
    const [packages, setPackages] = useState<Package[]>([]);
    const [networkDevices, setNetworkDevices] = useState<NetworkDevice[]>([]);

    const [loading, setLoading] = useState(true);
    const [loadingError, setLoadingError] = useState("");

    const [submitting, setSubmitting] = useState(false);
    const [provisioning, setProvisioning] = useState(false);

    const [formErrors, setFormErrors] = useState<Record<string, string[]>>({});
    const [submitError, setSubmitError] = useState("");
    const [success, setSuccess] = useState("");
    const [provisioningError, setProvisioningError] = useState("");

    const [createdData, setCreatedData] =
        useState<OnboardingResponse["data"] | null>(null);

    const isGlobal = useMemo(() => {
        const roles = user?.roles;

        if (Array.isArray(roles)) {
            return roles.some(
                (role) =>
                    (typeof role === "string" && role === "Super Admin") ||
                    (typeof role === "object" &&
                        role !== null &&
                        "name" in role &&
                        role.name === "Super Admin"),
            );
        }

        return user?.tenant_id == null;
    }, [user]);

    useEffect(() => {
        if (!user) {
            return;
        }

        setForm((current) => ({
            ...current,
            tenant_id:
                typeof user.tenant_id === "number"
                    ? String(user.tenant_id)
                    : current.tenant_id,
        }));
    }, [user]);

    useEffect(() => {
        async function loadData() {
            setLoading(true);
            setLoadingError("");

            try {
                const requests: [
                    Promise<PaginatedResponse<Package>>,
                    Promise<NetworkDevice[] | PaginatedResponse<NetworkDevice>>,
                    Promise<PaginatedResponse<Tenant> | null>,
                ] = [
                    apiRequest<PaginatedResponse<Package>>("/packages"),
                    apiRequest<
                        NetworkDevice[] | PaginatedResponse<NetworkDevice>
                    >("/network-devices"),
                    isGlobal
                        ? apiRequest<PaginatedResponse<Tenant>>("/tenants")
                        : Promise.resolve(null),
                ];

                const [packageResponse, deviceResponse, tenantResponse] =
                    await Promise.all(requests);

                setPackages(packageResponse.data);

                setNetworkDevices(
                    Array.isArray(deviceResponse)
                        ? deviceResponse
                        : deviceResponse.data,
                );

                if (tenantResponse) {
                    setTenants(tenantResponse.data);
                }
            } catch (exception) {
                setLoadingError(
                    exception instanceof Error
                        ? exception.message
                        : "تعذر تحميل بيانات النموذج.",
                );
            } finally {
                setLoading(false);
            }
        }

        void loadData();
    }, [isGlobal]);

    const selectedPackage = packages.find(
        (item) => String(item.id) === form.package_id,
    );

    const selectedDevice = networkDevices.find(
        (item) => String(item.id) === form.network_device_id,
    );

    function updateField<K extends keyof FormData>(
        field: K,
        value: FormData[K],
    ) {
        setForm((current) => ({
            ...current,
            [field]: value,
        }));

        setFormErrors((current) => {
            const next = { ...current };
            delete next[field];
            return next;
        });

        setSubmitError("");
    }

    function validateStep(): boolean {
        const errors: Record<string, string[]> = {};

        if (step === 0) {
            if (!form.tenant_id) {
                errors.tenant_id = ["اختيار الشركة مطلوب."];
            }

            if (!form.customer_name.trim()) {
                errors["customer.name"] = ["اسم العميل مطلوب."];
            }

            if (!form.customer_phone.trim()) {
                errors["customer.phone"] = ["رقم الهاتف مطلوب."];
            }
        }

        if (step === 1) {
            if (!form.package_id) {
                errors["subscription.package_id"] = ["اختيار الباقة مطلوب."];
            }

            if (!form.start_date) {
                errors["subscription.start_date"] = [
                    "تاريخ بداية الاشتراك مطلوب.",
                ];
            }

            if (!form.monthly_price) {
                errors["subscription.monthly_price"] = [
                    "السعر الشهري مطلوب.",
                ];
            } else if (Number(form.monthly_price) < 0) {
                errors["subscription.monthly_price"] = [
                    "السعر لا يمكن أن يكون سالبًا.",
                ];
            }
        }

        if (step === 2) {
            if (!form.network_device_id) {
                errors["network_service.network_device_id"] = [
                    "اختيار جهاز الشبكة مطلوب.",
                ];
            }

            if (!form.username.trim()) {
                errors["network_service.username"] = [
                    "اسم المستخدم مطلوب.",
                ];
            }

            if (!form.password.trim()) {
                errors["network_service.password"] = [
                    "كلمة المرور مطلوبة.",
                ];
            }

            if (!form.starts_at) {
                errors["network_service.starts_at"] = [
                    "بداية الخدمة مطلوبة.",
                ];
            }
        }

        setFormErrors(errors);

        return Object.keys(errors).length === 0;
    }

    function nextStep() {
        if (!validateStep()) {
            return;
        }

        setStep((current) => Math.min(current + 1, steps.length - 1));
    }

    function previousStep() {
        setStep((current) => Math.max(current - 1, 0));
    }

    async function submitOnboarding() {
        if (!validateStep()) {
            return;
        }

        setSubmitting(true);
        setSubmitError("");
        setProvisioningError("");
        setSuccess("");
        setFormErrors({});

        try {
            const response = await apiRequest<OnboardingResponse>(
                "/subscriber-onboarding",
                {
                    method: "POST",
                    body: JSON.stringify({
                        tenant_id: Number(form.tenant_id),

                        customer: {
                            name: form.customer_name,
                            phone: form.customer_phone,
                            email: form.customer_email || null,
                            address: form.customer_address || null,
                            national_id: form.customer_national_id || null,
                            status: form.customer_status,
                            notes: form.customer_notes || null,
                        },

                        subscription: {
                            package_id: Number(form.package_id),
                            start_date: form.start_date,
                            end_date: form.end_date || null,
                            monthly_price: Number(form.monthly_price),
                            status: form.subscription_status,
                            notes: form.subscription_notes || null,
                        },

                        network_service: {
                            network_device_id: Number(
                                form.network_device_id,
                            ),
                            connection_type: form.connection_type,
                            username: form.username,
                            password: form.password,
                            mac_address: form.mac_address || null,
                            ip_address: form.ip_address || null,
                            ip_mode: form.ip_mode,
                            starts_at: form.starts_at,
                            ends_at: form.ends_at || null,
                        },
                    }),
                },
            );

            setCreatedData(response.data);
            setSuccess("تم إنشاء بيانات المشترك بنجاح.");

            await provisionNetworkService(
                response.data.network_service.id,
            );
        } catch (exception) {
            if (exception instanceof ApiError) {
                setFormErrors(exception.errors);

                setSubmitError(
                    exception.status === 422
                        ? "راجع البيانات المدخلة."
                        : exception.message,
                );
            } else {
                setSubmitError(
                    exception instanceof Error
                        ? exception.message
                        : "حدث خطأ أثناء إنشاء المشترك.",
                );
            }
        } finally {
            setSubmitting(false);
        }
    }

    async function provisionNetworkService(networkServiceId: number) {
        setProvisioning(true);
        setProvisioningError("");

        try {
            const response = await apiRequest<ProvisionResponse>(
                `/network-services/${networkServiceId}/provision`,
                {
                    method: "POST",
                },
            );

            setCreatedData((current) =>
                current
                    ? {
                          ...current,
                          network_service: response.data,
                      }
                    : current,
            );

            setSuccess(
                "تم إنشاء المشترك وإعداد خدمة الشبكة بنجاح.",
            );
        } catch (exception) {
            if (exception instanceof ApiError) {
                setProvisioningError(
                    exception.message ||
                        "تم إنشاء المشترك، لكن إعداد خدمة الشبكة فشل.",
                );
            } else {
                setProvisioningError(
                    "تم إنشاء المشترك، لكن حدث خطأ أثناء إعداد خدمة الشبكة.",
                );
            }
        } finally {
            setProvisioning(false);
        }
    }

    function resetWizard() {
        setStep(0);
        setCreatedData(null);
        setSubmitError("");
        setSuccess("");
        setProvisioningError("");
        setFormErrors({});

        setForm({
            ...emptyForm,
            tenant_id:
                typeof user?.tenant_id === "number"
                    ? String(user.tenant_id)
                    : "",
            start_date: today(),
            starts_at: nowLocalDateTime(),
        });
    }

    if (loading) {
        return <LoadingState />;
    }

    if (loadingError) {
        return (
            <div className="space-y-6">
                <PageHeader
                    title="إضافة مشترك"
                    description="إنشاء عميل واشتراك وخدمة شبكة من شاشة واحدة."
                />
                <Alert variant="error">{loadingError}</Alert>
            </div>
        );
    }

    if (createdData) {
        const networkService = createdData.network_service;

        return (
            <div className="space-y-6">
                <PageHeader
                    title="تم إنشاء المشترك"
                    description="تم إنشاء بيانات العميل والاشتراك وخدمة الشبكة."
                />

                {success && <Alert variant="success">{success}</Alert>}

                {provisioning && (
                    <Alert variant="info">
                        جاري إعداد خدمة الشبكة...
                    </Alert>
                )}

                {provisioningError && (
                    <Alert variant="error">
                        {provisioningError}
                        <div className="mt-1 text-sm">
                            بيانات المشترك تم إنشاؤها بالفعل، ويمكن إعادة
                            محاولة إعداد الشبكة.
                        </div>
                    </Alert>
                )}

                <SectionCard title="ملخص المشترك">
                    <div className="grid gap-4 md:grid-cols-3">
                        <div>
                            <div className="text-xs text-slate-500">
                                العميل
                            </div>
                            <div className="mt-1 font-semibold">
                                {createdData.customer.name}
                            </div>
                        </div>

                        <div>
                            <div className="text-xs text-slate-500">
                                الاشتراك
                            </div>
                            <div className="mt-1 font-semibold">
                                #{formatDigits(createdData.subscription.id)}
                            </div>
                        </div>

                        <div>
                            <div className="text-xs text-slate-500">
                                خدمة الشبكة
                            </div>
                            <div className="mt-1 font-semibold">
                                #{formatDigits(networkService.id)}
                            </div>
                        </div>
                    </div>
                </SectionCard>

                <div className="flex flex-wrap gap-3">
                    {provisioningError && (
                        <button
                            type="button"
                            onClick={() =>
                                void provisionNetworkService(
                                    networkService.id,
                                )
                            }
                            disabled={provisioning}
                            className="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-medium text-white disabled:opacity-50"
                        >
                            إعادة محاولة إعداد الشبكة
                        </button>
                    )}

                    <button
                        type="button"
                        onClick={resetWizard}
                        disabled={provisioning}
                        className="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 disabled:opacity-50"
                    >
                        إضافة مشترك آخر
                    </button>
                </div>
            </div>
        );
    }

    return (
        <div className="space-y-6">
            <PageHeader
                title="إضافة مشترك"
                description="إنشاء العميل والاشتراك وخدمة الشبكة ثم إعدادها."
            />

            <div className="grid gap-2 md:grid-cols-4">
                {steps.map((label, index) => (
                    <div
                        key={label}
                        className={`rounded-xl px-4 py-3 text-sm ${
                            index === step
                                ? "bg-slate-900 font-semibold text-white"
                                : index < step
                                  ? "bg-slate-200 text-slate-800"
                                  : "bg-slate-100 text-slate-500"
                        }`}
                    >
                        <div className="text-xs opacity-70">
                            الخطوة {index + 1}
                        </div>
                        <div className="mt-1">{label}</div>
                    </div>
                ))}
            </div>

            {submitError && (
                <Alert variant="error">
                    {submitError}
                </Alert>
            )}

            <SectionCard title={steps[step]}>
                {step === 0 && (
                    <div className="grid gap-5 md:grid-cols-2">
                        {isGlobal && (
                            <label className="md:col-span-2">
                                <span className="mb-1 block text-sm font-medium text-slate-700">
                                    الشركة
                                </span>
                                <select
                                    value={form.tenant_id}
                                    onChange={(event) =>
                                        updateField(
                                            "tenant_id",
                                            event.target.value,
                                        )
                                    }
                                    className={inputClass(
                                        Boolean(formErrors.tenant_id),
                                    )}
                                >
                                    <option value="">
                                        اختر الشركة
                                    </option>
                                    {tenants.map((tenant) => (
                                        <option
                                            key={tenant.id}
                                            value={tenant.id}
                                        >
                                            {tenant.name}
                                        </option>
                                    ))}
                                </select>
                                {formErrors.tenant_id && (
                                    <p className="mt-1 text-xs text-red-600">
                                        {formErrors.tenant_id[0]}
                                    </p>
                                )}
                            </label>
                        )}

                        <label>
                            <span className="mb-1 block text-sm font-medium text-slate-700">
                                اسم العميل *
                            </span>
                            <input
                                value={form.customer_name}
                                onChange={(event) =>
                                    updateField(
                                        "customer_name",
                                        event.target.value,
                                    )
                                }
                                className={inputClass(
                                    Boolean(formErrors["customer.name"]),
                                )}
                            />
                        </label>

                        <label>
                            <span className="mb-1 block text-sm font-medium text-slate-700">
                                الهاتف *
                            </span>
                            <input
                                value={form.customer_phone}
                                onChange={(event) =>
                                    updateField(
                                        "customer_phone",
                                        event.target.value,
                                    )
                                }
                                className={inputClass(
                                    Boolean(formErrors["customer.phone"]),
                                )}
                            />
                        </label>

                        <label>
                            <span className="mb-1 block text-sm font-medium text-slate-700">
                                البريد الإلكتروني
                            </span>
                            <input
                                type="email"
                                value={form.customer_email}
                                onChange={(event) =>
                                    updateField(
                                        "customer_email",
                                        event.target.value,
                                    )
                                }
                                className={inputClass()}
                            />
                        </label>

                        <label>
                            <span className="mb-1 block text-sm font-medium text-slate-700">
                                الرقم القومي
                            </span>
                            <input
                                value={form.customer_national_id}
                                onChange={(event) =>
                                    updateField(
                                        "customer_national_id",
                                        event.target.value,
                                    )
                                }
                                className={inputClass()}
                                maxLength={14}
                            />
                        </label>

                        <label className="md:col-span-2">
                            <span className="mb-1 block text-sm font-medium text-slate-700">
                                العنوان
                            </span>
                            <textarea
                                value={form.customer_address}
                                onChange={(event) =>
                                    updateField(
                                        "customer_address",
                                        event.target.value,
                                    )
                                }
                                className={inputClass()}
                                rows={2}
                            />
                        </label>

                        <label className="md:col-span-2">
                            <span className="mb-1 block text-sm font-medium text-slate-700">
                                ملاحظات
                            </span>
                            <textarea
                                value={form.customer_notes}
                                onChange={(event) =>
                                    updateField(
                                        "customer_notes",
                                        event.target.value,
                                    )
                                }
                                className={inputClass()}
                                rows={2}
                            />
                        </label>
                    </div>
                )}

                {step === 1 && (
                    <div className="grid gap-5 md:grid-cols-2">
                        <label className="md:col-span-2">
                            <span className="mb-1 block text-sm font-medium text-slate-700">
                                الباقة *
                            </span>
                            <select
                                value={form.package_id}
                                onChange={(event) => {
                                    const packageId = event.target.value;

                                    updateField("package_id", packageId);

                                    const packageItem = packages.find(
                                        (item) =>
                                            String(item.id) === packageId,
                                    );

                                    if (
                                        packageItem &&
                                        !form.monthly_price
                                    ) {
                                        updateField(
                                            "monthly_price",
                                            String(packageItem.price),
                                        );
                                    }
                                }}
                                className={inputClass(
                                    Boolean(
                                        formErrors["subscription.package_id"],
                                    ),
                                )}
                            >
                                <option value="">اختر الباقة</option>
                                {packages
                                    .filter(
                                        (item) =>
                                            item.status === "active" &&
                                            (!form.tenant_id ||
                                                item.tenant_id ===
                                                    Number(form.tenant_id)),
                                    )
                                    .map((item) => (
                                        <option
                                            key={item.id}
                                            value={item.id}
                                        >
                                            {item.name} —{" "}
                                            {formatPrice(item.price)} ج.م
                                        </option>
                                    ))}
                            </select>
                        </label>

                        {selectedPackage && (
                            <div className="rounded-xl bg-slate-50 p-4 md:col-span-2">
                                <div className="text-sm font-semibold text-slate-800">
                                    {selectedPackage.name}
                                </div>
                                <div className="mt-2 text-sm text-slate-500">
                                    سرعة التحميل:{" "}
                                    {selectedPackage.download_speed ?? "-"}{" "}
                                    Mbps
                                    {" — "}
                                    سرعة الرفع:{" "}
                                    {selectedPackage.upload_speed ?? "-"} Mbps
                                </div>
                            </div>
                        )}

                        <label>
                            <span className="mb-1 block text-sm font-medium text-slate-700">
                                بداية الاشتراك *
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
                                    Boolean(
                                        formErrors["subscription.start_date"],
                                    ),
                                )}
                            />
                        </label>

                        <label>
                            <span className="mb-1 block text-sm font-medium text-slate-700">
                                نهاية الاشتراك
                            </span>
                            <input
                                type="date"
                                value={form.end_date}
                                min={form.start_date || undefined}
                                onChange={(event) =>
                                    updateField(
                                        "end_date",
                                        event.target.value,
                                    )
                                }
                                className={inputClass()}
                            />
                        </label>

                        <label>
                            <span className="mb-1 block text-sm font-medium text-slate-700">
                                السعر الشهري *
                            </span>
                            <input
                                type="number"
                                min="0"
                                step="0.01"
                                value={form.monthly_price}
                                onChange={(event) =>
                                    updateField(
                                        "monthly_price",
                                        event.target.value,
                                    )
                                }
                                className={inputClass(
                                    Boolean(
                                        formErrors[
                                            "subscription.monthly_price"
                                        ],
                                    ),
                                )}
                            />
                        </label>

                        <label>
                            <span className="mb-1 block text-sm font-medium text-slate-700">
                                حالة الاشتراك
                            </span>
                            <select
                                value={form.subscription_status}
                                onChange={(event) =>
                                    updateField(
                                        "subscription_status",
                                        event.target.value as FormData["subscription_status"],
                                    )
                                }
                                className={inputClass()}
                            >
                                <option value="draft">مسودة</option>
                                <option value="pending">معلق</option>
                                <option value="active">نشط</option>
                            </select>
                        </label>

                        <label className="md:col-span-2">
                            <span className="mb-1 block text-sm font-medium text-slate-700">
                                ملاحظات الاشتراك
                            </span>
                            <textarea
                                value={form.subscription_notes}
                                onChange={(event) =>
                                    updateField(
                                        "subscription_notes",
                                        event.target.value,
                                    )
                                }
                                className={inputClass()}
                                rows={2}
                            />
                        </label>
                    </div>
                )}

                {step === 2 && (
                    <div className="grid gap-5 md:grid-cols-2">
                        <label className="md:col-span-2">
                            <span className="mb-1 block text-sm font-medium text-slate-700">
                                جهاز الشبكة *
                            </span>
                            <select
                                value={form.network_device_id}
                                onChange={(event) =>
                                    updateField(
                                        "network_device_id",
                                        event.target.value,
                                    )
                                }
                                className={inputClass(
                                    Boolean(
                                        formErrors[
                                            "network_service.network_device_id"
                                        ],
                                    ),
                                )}
                            >
                                <option value="">
                                    اختر جهاز الشبكة
                                </option>
                                {networkDevices.map((device) => (
                                    <option
                                        key={device.id}
                                        value={device.id}
                                    >
                                        {device.name} — {device.type}
                                        {device.is_online
                                            ? " — متصل"
                                            : " — غير متصل"}
                                    </option>
                                ))}
                            </select>
                        </label>

                        {selectedDevice && (
                            <div className="rounded-xl bg-slate-50 p-4 md:col-span-2">
                                <div className="text-sm font-semibold">
                                    {selectedDevice.name}
                                </div>
                                <div className="mt-1 text-sm text-slate-500">
                                    الحالة:{" "}
                                    {selectedDevice.is_online
                                        ? "متصل"
                                        : "غير متصل"}
                                </div>
                            </div>
                        )}

                        <label>
                            <span className="mb-1 block text-sm font-medium text-slate-700">
                                نوع الاتصال *
                            </span>
                            <select
                                value={form.connection_type}
                                onChange={(event) =>
                                    updateField(
                                        "connection_type",
                                        event.target.value as FormData["connection_type"],
                                    )
                                }
                                className={inputClass()}
                            >
                                <option value="pppoe">PPPoE</option>
                                <option value="hotspot">Hotspot</option>
                            </select>
                        </label>

                        <label>
                            <span className="mb-1 block text-sm font-medium text-slate-700">
                                نمط IP *
                            </span>
                            <select
                                value={form.ip_mode}
                                onChange={(event) =>
                                    updateField(
                                        "ip_mode",
                                        event.target.value as FormData["ip_mode"],
                                    )
                                }
                                className={inputClass()}
                            >
                                <option value="dynamic">Dynamic</option>
                                <option value="static">Static</option>
                            </select>
                        </label>

                        <label>
                            <span className="mb-1 block text-sm font-medium text-slate-700">
                                اسم المستخدم *
                            </span>
                            <input
                                value={form.username}
                                onChange={(event) =>
                                    updateField(
                                        "username",
                                        event.target.value,
                                    )
                                }
                                className={inputClass(
                                    Boolean(
                                        formErrors[
                                            "network_service.username"
                                        ],
                                    ),
                                )}
                            />
                        </label>

                        <label>
                            <span className="mb-1 block text-sm font-medium text-slate-700">
                                كلمة المرور *
                            </span>
                            <input
                                type="password"
                                value={form.password}
                                onChange={(event) =>
                                    updateField(
                                        "password",
                                        event.target.value,
                                    )
                                }
                                className={inputClass(
                                    Boolean(
                                        formErrors[
                                            "network_service.password"
                                        ],
                                    ),
                                )}
                            />
                        </label>

                        <label>
                            <span className="mb-1 block text-sm font-medium text-slate-700">
                                MAC Address
                            </span>
                            <input
                                value={form.mac_address}
                                onChange={(event) =>
                                    updateField(
                                        "mac_address",
                                        event.target.value,
                                    )
                                }
                                className={inputClass()}
                                placeholder="AA:BB:CC:DD:EE:FF"
                            />
                        </label>

                        <label>
                            <span className="mb-1 block text-sm font-medium text-slate-700">
                                IP Address
                            </span>
                            <input
                                value={form.ip_address}
                                onChange={(event) =>
                                    updateField(
                                        "ip_address",
                                        event.target.value,
                                    )
                                }
                                className={inputClass()}
                            />
                        </label>

                        <label>
                            <span className="mb-1 block text-sm font-medium text-slate-700">
                                بداية الخدمة *
                            </span>
                            <input
                                type="datetime-local"
                                value={form.starts_at}
                                onChange={(event) =>
                                    updateField(
                                        "starts_at",
                                        event.target.value,
                                    )
                                }
                                className={inputClass(
                                    Boolean(
                                        formErrors[
                                            "network_service.starts_at"
                                        ],
                                    ),
                                )}
                            />
                        </label>

                        <label>
                            <span className="mb-1 block text-sm font-medium text-slate-700">
                                نهاية الخدمة
                            </span>
                            <input
                                type="datetime-local"
                                value={form.ends_at}
                                min={form.starts_at || undefined}
                                onChange={(event) =>
                                    updateField(
                                        "ends_at",
                                        event.target.value,
                                    )
                                }
                                className={inputClass()}
                            />
                        </label>
                    </div>
                )}

                {step === 3 && (
                    <div className="space-y-6">
                        <div className="grid gap-4 md:grid-cols-2">
                            <div>
                                <div className="text-xs text-slate-500">
                                    العميل
                                </div>
                                <div className="mt-1 font-semibold">
                                    {form.customer_name}
                                </div>
                                <div className="text-sm text-slate-500">
                                    {form.customer_phone}
                                </div>
                            </div>

                            <div>
                                <div className="text-xs text-slate-500">
                                    الباقة
                                </div>
                                <div className="mt-1 font-semibold">
                                    {selectedPackage?.name ?? "-"}
                                </div>
                            </div>

                            <div>
                                <div className="text-xs text-slate-500">
                                    السعر الشهري
                                </div>
                                <div className="mt-1 font-semibold">
                                    {form.monthly_price
                                        ? `${formatPrice(
                                              form.monthly_price,
                                          )} ج.م`
                                        : "-"}
                                </div>
                            </div>

                            <div>
                                <div className="text-xs text-slate-500">
                                    جهاز الشبكة
                                </div>
                                <div className="mt-1 font-semibold">
                                    {selectedDevice?.name ?? "-"}
                                </div>
                            </div>

                            <div>
                                <div className="text-xs text-slate-500">
                                    نوع الاتصال
                                </div>
                                <div className="mt-1 font-semibold">
                                    {form.connection_type === "pppoe"
                                        ? "PPPoE"
                                        : "Hotspot"}
                                </div>
                            </div>

                            <div>
                                <div className="text-xs text-slate-500">
                                    اسم المستخدم
                                </div>
                                <div className="mt-1 font-semibold">
                                    {form.username}
                                </div>
                            </div>
                        </div>

                        <div className="rounded-xl bg-amber-50 p-4 text-sm text-amber-800">
                            عند الضغط على «إنشاء المشترك»، سيتم أولًا إنشاء
                            بيانات العميل والاشتراك وخدمة الشبكة، ثم تنفيذ
                            إعداد الشبكة في طلب منفصل.
                        </div>
                    </div>
                )}
            </SectionCard>

            <div className="flex items-center justify-between gap-3">
                <button
                    type="button"
                    onClick={previousStep}
                    disabled={step === 0 || submitting}
                    className="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 disabled:opacity-40"
                >
                    السابق
                </button>

                {step < steps.length - 1 ? (
                    <button
                        type="button"
                        onClick={nextStep}
                        className="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-medium text-white"
                    >
                        التالي
                    </button>
                ) : (
                    <button
                        type="button"
                        onClick={() => void submitOnboarding()}
                        disabled={submitting}
                        className="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-medium text-white disabled:opacity-50"
                    >
                        {submitting
                            ? "جاري إنشاء المشترك..."
                            : "إنشاء المشترك"}
                    </button>
                )}
            </div>
        </div>
    );
}
