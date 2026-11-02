import { useEffect, useMemo, useState } from "react";

import { apiRequest, ApiError } from "../api/client";
import type {
    HotspotUser,
    NetworkDevice,
    NetworkResourceTab,
    PppoeUser,
} from "../types/network";

type PaginatedResponse<T> = {
    data: T[];
    current_page?: number;
    last_page?: number;
    total?: number;
};

type FormMode = "create" | "edit";

type UserFormState = {
    username: string;
    password: string;
    profile: string;
    comment: string;
};

function extractItems<T>(payload: T[] | PaginatedResponse<T>): T[] {
    if (Array.isArray(payload)) {
        return payload;
    }

    if (
        payload &&
        typeof payload === "object" &&
        Array.isArray((payload as PaginatedResponse<T>).data)
    ) {
        return (payload as PaginatedResponse<T>).data;
    }

    return [];
}

function userName(
    user: PppoeUser | HotspotUser,
): string {
    return user.name ?? user.username ?? "—";
}

function isDisabled(
    user: PppoeUser | HotspotUser,
): boolean {
    return (
        user.disabled === true ||
        user.disabled === "yes" ||
        user.disabled === "true"
    );
}

const emptyForm: UserFormState = {
    username: "",
    password: "",
    profile: "",
    comment: "",
};

export function NetworkControlPage() {
    const [devices, setDevices] = useState<NetworkDevice[]>([]);
    const [deviceId, setDeviceId] = useState("");
    const [tab, setTab] =
        useState<NetworkResourceTab>("pppoe");

    const [pppoeUsers, setPppoeUsers] = useState<PppoeUser[]>([]);
    const [hotspotUsers, setHotspotUsers] =
        useState<HotspotUser[]>([]);

    const [loadingDevices, setLoadingDevices] =
        useState(true);
    const [loadingUsers, setLoadingUsers] =
        useState(false);
    const [workingUser, setWorkingUser] =
        useState<string | null>(null);

    const [error, setError] = useState("");
    const [success, setSuccess] = useState("");

    const [formOpen, setFormOpen] = useState(false);
    const [formMode, setFormMode] =
        useState<FormMode>("create");
    const [form, setForm] =
        useState<UserFormState>(emptyForm);

    const selectedDevice = useMemo(
        () =>
            devices.find(
                (device) =>
                    String(device.id) === deviceId,
            ),
        [devices, deviceId],
    );

    const users =
        tab === "pppoe"
            ? pppoeUsers
            : hotspotUsers;

    async function loadUsers(
        selectedDeviceId = deviceId,
    ): Promise<void> {
        if (!selectedDeviceId) {
            setPppoeUsers([]);
            setHotspotUsers([]);
            return;
        }

        setLoadingUsers(true);
        setError("");

        try {
            const [
                pppoePayload,
                hotspotPayload,
            ] = await Promise.all([
                apiRequest<PppoeUser[]>(
                    `/network/pppoe?device_id=${selectedDeviceId}`,
                ),
                apiRequest<HotspotUser[]>(
                    `/network/hotspot?device_id=${selectedDeviceId}`,
                ),
            ]);

            setPppoeUsers(
                extractItems(pppoePayload),
            );
            setHotspotUsers(
                extractItems(hotspotPayload),
            );
        } catch (err) {
            setError(
                err instanceof ApiError
                    ? err.message
                    : "تعذر تحميل بيانات MikroTik.",
            );
        } finally {
            setLoadingUsers(false);
        }
    }

    useEffect(() => {
        let cancelled = false;

        async function loadDevices() {
            setLoadingDevices(true);
            setError("");

            try {
                const payload =
                    await apiRequest<
                        NetworkDevice[] |
                        PaginatedResponse<NetworkDevice>
                    >("/network-devices");

                if (cancelled) {
                    return;
                }

                const items = extractItems(payload);

                setDevices(items);

                if (items.length > 0) {
                    setDeviceId(
                        String(items[0].id),
                    );
                }
            } catch (err) {
                if (cancelled) {
                    return;
                }

                setError(
                    err instanceof ApiError
                        ? err.message
                        : "تعذر تحميل أجهزة الشبكة.",
                );
            } finally {
                if (!cancelled) {
                    setLoadingDevices(false);
                }
            }
        }

        void loadDevices();

        return () => {
            cancelled = true;
        };
    }, []);

    useEffect(() => {
        void loadUsers();
    }, [deviceId]);

    function clearMessages() {
        setError("");
        setSuccess("");
    }

    function openCreate() {
        clearMessages();
        setFormMode("create");
        setForm(emptyForm);
        setFormOpen(true);
    }

    function openEdit(
        user: PppoeUser | HotspotUser,
    ) {
        clearMessages();

        setFormMode("edit");

        setForm({
            username: userName(user),
            password: "",
            profile: user.profile ?? "",
            comment: user.comment ?? "",
        });

        setFormOpen(true);
    }

    async function submitForm(
        event: React.FormEvent<HTMLFormElement>,
    ) {
        event.preventDefault();

        if (!deviceId) {
            setError("يجب اختيار جهاز شبكة أولًا.");
            return;
        }

        clearMessages();

        const basePath =
            tab === "pppoe"
                ? "/network/pppoe"
                : "/network/hotspot";

        setWorkingUser(
            formMode === "edit"
                ? form.username
                : "__create__",
        );

        try {
            if (formMode === "create") {
                const payload = {
                    device_id: Number(deviceId),
                    username: form.username,
                    password: form.password,
                    profile: form.profile,
                    options: {
                        comment: form.comment,
                    },
                };

                await apiRequest(basePath, {
                    method: "POST",
                    body: JSON.stringify(payload),
                });

                setSuccess(
                    `${tab === "pppoe" ? "PPPoE" : "HotSpot"} user تم إنشاؤه بنجاح.`,
                );
            } else {
                const payload: {
                    device_id: number;
                    data: Record<string, string>;
                } = {
                    device_id: Number(deviceId),
                    data: {
                        profile: form.profile,
                        comment: form.comment,
                    },
                };

                if (form.password) {
                    payload.data.password =
                        form.password;
                }

                await apiRequest(
                    `${basePath}/${encodeURIComponent(form.username)}`,
                    {
                        method: "PUT",
                        body: JSON.stringify(payload),
                    },
                );

                setSuccess("تم تحديث المستخدم بنجاح.");
            }

            setFormOpen(false);
            setForm(emptyForm);
            await loadUsers();
        } catch (err) {
            setError(
                err instanceof ApiError
                    ? err.message
                    : "تعذر تنفيذ العملية.",
            );
        } finally {
            setWorkingUser(null);
        }
    }

    async function toggleUser(
        user: PppoeUser | HotspotUser,
    ) {
        if (!deviceId) {
            return;
        }

        const username = userName(user);
        const action = isDisabled(user)
            ? "enable"
            : "disable";

        clearMessages();
        setWorkingUser(username);

        try {
            const basePath =
                tab === "pppoe"
                    ? "/network/pppoe"
                    : "/network/hotspot";

            await apiRequest(
                `${basePath}/${encodeURIComponent(username)}/toggle`,
                {
                    method: "PATCH",
                    body: JSON.stringify({
                        device_id: Number(deviceId),
                        action,
                    }),
                },
            );

            setSuccess(
                isDisabled(user)
                    ? "تم تفعيل المستخدم."
                    : "تم تعطيل المستخدم.",
            );

            await loadUsers();
        } catch (err) {
            setError(
                err instanceof ApiError
                    ? err.message
                    : "تعذر تغيير حالة المستخدم.",
            );
        } finally {
            setWorkingUser(null);
        }
    }

    async function disconnectUser(
        user: PppoeUser | HotspotUser,
    ) {
        if (!deviceId) {
            return;
        }

        const username = userName(user);

        clearMessages();
        setWorkingUser(username);

        try {
            const basePath =
                tab === "pppoe"
                    ? "/network/pppoe"
                    : "/network/hotspot";

            await apiRequest(
                `${basePath}/${encodeURIComponent(username)}/disconnect`,
                {
                    method: "POST",
                    body: JSON.stringify({
                        device_id: Number(deviceId),
                    }),
                },
            );

            setSuccess(
                "تم إرسال أمر فصل الاتصال.",
            );

            await loadUsers();
        } catch (err) {
            setError(
                err instanceof ApiError
                    ? err.message
                    : "تعذر فصل اتصال المستخدم.",
            );
        } finally {
            setWorkingUser(null);
        }
    }

    async function deleteUser(
        user: PppoeUser | HotspotUser,
    ) {
        if (!deviceId) {
            return;
        }

        const username = userName(user);

        if (
            !window.confirm(
                `هل تريد حذف المستخدم "${username}" من MikroTik؟`,
            )
        ) {
            return;
        }

        clearMessages();
        setWorkingUser(username);

        try {
            const basePath =
                tab === "pppoe"
                    ? "/network/pppoe"
                    : "/network/hotspot";

            await apiRequest(
                `${basePath}/${encodeURIComponent(username)}`,
                {
                    method: "DELETE",
                    body: JSON.stringify({
                        device_id: Number(deviceId),
                    }),
                },
            );

            setSuccess(
                "تم حذف المستخدم بنجاح.",
            );

            await loadUsers();
        } catch (err) {
            setError(
                err instanceof ApiError
                    ? err.message
                    : "تعذر حذف المستخدم.",
            );
        } finally {
            setWorkingUser(null);
        }
    }

    return (
        <div className="space-y-6">
            <header className="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p className="text-sm font-medium text-slate-500">
                        إدارة الشبكة
                    </p>

                    <h1 className="mt-1 text-2xl font-bold text-slate-900">
                        Network Control
                    </h1>

                    <p className="mt-2 text-sm text-slate-500">
                        التحكم في موارد MikroTik من داخل EgyptNet.
                    </p>
                </div>

                <div className="min-w-64">
                    <label
                        htmlFor="network-device"
                        className="mb-2 block text-sm font-medium text-slate-700"
                    >
                        جهاز الشبكة
                    </label>

                    <select
                        id="network-device"
                        value={deviceId}
                        onChange={(event) =>
                            setDeviceId(
                                event.target.value,
                            )
                        }
                        disabled={
                            loadingDevices ||
                            devices.length === 0
                        }
                        className="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-slate-500"
                    >
                        {devices.length === 0 && (
                            <option value="">
                                لا توجد أجهزة متاحة
                            </option>
                        )}

                        {devices.map((device) => (
                            <option
                                key={device.id}
                                value={device.id}
                            >
                                {device.name}
                                {device.is_online
                                    ? " — Online"
                                    : " — Offline"}
                            </option>
                        ))}
                    </select>
                </div>
            </header>

            {error && (
                <div
                    role="alert"
                    className="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                >
                    {error}
                </div>
            )}

            {success && (
                <div
                    role="status"
                    className="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700"
                >
                    {success}
                </div>
            )}

            {selectedDevice && (
                <section className="grid gap-4 sm:grid-cols-3">
                    <div className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p className="text-xs font-medium uppercase tracking-wide text-slate-400">
                            الجهاز
                        </p>

                        <p className="mt-2 text-lg font-semibold text-slate-900">
                            {selectedDevice.name}
                        </p>
                    </div>

                    <div className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p className="text-xs font-medium uppercase tracking-wide text-slate-400">
                            الحالة
                        </p>

                        <p className="mt-2 text-lg font-semibold text-slate-900">
                            {selectedDevice.is_online
                                ? "Online"
                                : "Offline"}
                        </p>
                    </div>

                    <div className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p className="text-xs font-medium uppercase tracking-wide text-slate-400">
                            المستخدمون
                        </p>

                        <p className="mt-2 text-lg font-semibold text-slate-900">
                            {loadingUsers
                                ? "..."
                                : users.length}
                        </p>
                    </div>
                </section>
            )}

            <section className="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div className="flex flex-col gap-3 border-b border-slate-200 p-4 sm:flex-row sm:items-center sm:justify-between">
                    <div className="flex flex-wrap gap-2">
                        <button
                            type="button"
                            onClick={() =>
                                setTab("pppoe")
                            }
                            className={[
                                "rounded-xl px-4 py-2 text-sm font-medium transition",
                                tab === "pppoe"
                                    ? "bg-slate-900 text-white"
                                    : "text-slate-600 hover:bg-slate-100",
                            ].join(" ")}
                        >
                            PPPoE
                        </button>

                        <button
                            type="button"
                            onClick={() =>
                                setTab("hotspot")
                            }
                            className={[
                                "rounded-xl px-4 py-2 text-sm font-medium transition",
                                tab === "hotspot"
                                    ? "bg-slate-900 text-white"
                                    : "text-slate-600 hover:bg-slate-100",
                            ].join(" ")}
                        >
                            HotSpot
                        </button>
                    </div>

                    <button
                        type="button"
                        onClick={openCreate}
                        disabled={!deviceId}
                        className="rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        + إضافة مستخدم
                    </button>
                </div>

                {loadingUsers ? (
                    <div className="p-8 text-center text-sm text-slate-500">
                        جاري تحميل بيانات MikroTik...
                    </div>
                ) : users.length === 0 ? (
                    <div className="p-8 text-center text-sm text-slate-500">
                        لا توجد بيانات متاحة لهذا المورد.
                    </div>
                ) : (
                    <div className="overflow-x-auto">
                        <table className="min-w-full text-right text-sm">
                            <thead className="bg-slate-50 text-xs text-slate-500">
                                <tr>
                                    <th className="px-5 py-3 font-medium">
                                        المستخدم
                                    </th>

                                    <th className="px-5 py-3 font-medium">
                                        Profile
                                    </th>

                                    <th className="px-5 py-3 font-medium">
                                        Comment
                                    </th>

                                    <th className="px-5 py-3 font-medium">
                                        الحالة
                                    </th>

                                    <th className="px-5 py-3 font-medium">
                                        الإجراءات
                                    </th>
                                </tr>
                            </thead>

                            <tbody className="divide-y divide-slate-100">
                                {users.map(
                                    (
                                        user,
                                        index,
                                    ) => {
                                        const username =
                                            userName(
                                                user,
                                            );

                                        const busy =
                                            workingUser ===
                                            username;

                                        return (
                                            <tr
                                                key={
                                                    user.id ??
                                                    `${username}-${index}`
                                                }
                                                className="hover:bg-slate-50"
                                            >
                                                <td className="whitespace-nowrap px-5 py-4 font-medium text-slate-900">
                                                    {username}
                                                </td>

                                                <td className="whitespace-nowrap px-5 py-4 text-slate-600">
                                                    {user.profile ??
                                                        "—"}
                                                </td>

                                                <td className="max-w-xs truncate px-5 py-4 text-slate-600">
                                                    {user.comment ??
                                                        "—"}
                                                </td>

                                                <td className="whitespace-nowrap px-5 py-4">
                                                    <span
                                                        className={[
                                                            "inline-flex rounded-full px-2.5 py-1 text-xs font-medium",
                                                            isDisabled(
                                                                user,
                                                            )
                                                                ? "bg-red-50 text-red-700"
                                                                : "bg-emerald-50 text-emerald-700",
                                                        ].join(
                                                            " ",
                                                        )}
                                                    >
                                                        {isDisabled(
                                                            user,
                                                        )
                                                            ? "Disabled"
                                                            : "Enabled"}
                                                    </span>
                                                </td>

                                                <td className="px-5 py-4">
                                                    <div className="flex flex-wrap gap-2">
                                                        <button
                                                            type="button"
                                                            disabled={
                                                                busy
                                                            }
                                                            onClick={() =>
                                                                openEdit(
                                                                    user,
                                                                )
                                                            }
                                                            className="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-100 disabled:opacity-50"
                                                        >
                                                            تعديل
                                                        </button>

                                                        <button
                                                            type="button"
                                                            disabled={
                                                                busy
                                                            }
                                                            onClick={() =>
                                                                void toggleUser(
                                                                    user,
                                                                )
                                                            }
                                                            className="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-100 disabled:opacity-50"
                                                        >
                                                            {isDisabled(
                                                                user,
                                                            )
                                                                ? "تفعيل"
                                                                : "تعطيل"}
                                                        </button>

                                                        <button
                                                            type="button"
                                                            disabled={
                                                                busy
                                                            }
                                                            onClick={() =>
                                                                void disconnectUser(
                                                                    user,
                                                                )
                                                            }
                                                            className="rounded-lg border border-amber-300 px-3 py-1.5 text-xs font-medium text-amber-700 hover:bg-amber-50 disabled:opacity-50"
                                                        >
                                                            فصل
                                                        </button>

                                                        <button
                                                            type="button"
                                                            disabled={
                                                                busy
                                                            }
                                                            onClick={() =>
                                                                void deleteUser(
                                                                    user,
                                                                )
                                                            }
                                                            className="rounded-lg border border-red-300 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-50 disabled:opacity-50"
                                                        >
                                                            حذف
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        );
                                    },
                                )}
                            </tbody>
                        </table>
                    </div>
                )}
            </section>

            {formOpen && (
                <div
                    className="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 p-4"
                    role="presentation"
                    onMouseDown={(event) => {
                        if (
                            event.target ===
                            event.currentTarget
                        ) {
                            setFormOpen(false);
                        }
                    }}
                >
                    <div
                        role="dialog"
                        aria-modal="true"
                        aria-labelledby="network-user-form-title"
                        className="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl"
                    >
                        <div className="mb-5">
                            <h2
                                id="network-user-form-title"
                                className="text-lg font-semibold text-slate-900"
                            >
                                {formMode ===
                                "create"
                                    ? `إضافة ${tab === "pppoe" ? "PPPoE" : "HotSpot"} user`
                                    : "تعديل المستخدم"}
                            </h2>

                            <p className="mt-1 text-sm text-slate-500">
                                الجهاز:{" "}
                                {selectedDevice?.name ??
                                    "—"}
                            </p>
                        </div>

                        <form
                            onSubmit={submitForm}
                            className="space-y-4"
                        >
                            <div>
                                <label
                                    htmlFor="network-username"
                                    className="mb-1.5 block text-sm font-medium text-slate-700"
                                >
                                    Username
                                </label>

                                <input
                                    id="network-username"
                                    value={
                                        form.username
                                    }
                                    onChange={(
                                        event,
                                    ) =>
                                        setForm(
                                            (
                                                current,
                                            ) => ({
                                                ...current,
                                                username:
                                                    event
                                                        .target
                                                        .value,
                                            }),
                                        )
                                    }
                                    disabled={
                                        formMode ===
                                        "edit"
                                    }
                                    required
                                    className="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-slate-500 disabled:bg-slate-100"
                                />
                            </div>

                            <div>
                                <label
                                    htmlFor="network-password"
                                    className="mb-1.5 block text-sm font-medium text-slate-700"
                                >
                                    Password
                                </label>

                                <input
                                    id="network-password"
                                    type="password"
                                    value={
                                        form.password
                                    }
                                    onChange={(
                                        event,
                                    ) =>
                                        setForm(
                                            (
                                                current,
                                            ) => ({
                                                ...current,
                                                password:
                                                    event
                                                        .target
                                                        .value,
                                            }),
                                        )
                                    }
                                    required={
                                        formMode ===
                                        "create"
                                    }
                                    placeholder={
                                        formMode ===
                                        "edit"
                                            ? "اتركه فارغًا بدون تغيير"
                                            : ""
                                    }
                                    className="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-slate-500"
                                />
                            </div>

                            <div>
                                <label
                                    htmlFor="network-profile"
                                    className="mb-1.5 block text-sm font-medium text-slate-700"
                                >
                                    Profile
                                </label>

                                <input
                                    id="network-profile"
                                    value={
                                        form.profile
                                    }
                                    onChange={(
                                        event,
                                    ) =>
                                        setForm(
                                            (
                                                current,
                                            ) => ({
                                                ...current,
                                                profile:
                                                    event
                                                        .target
                                                        .value,
                                            }),
                                        )
                                    }
                                    required
                                    className="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-slate-500"
                                />
                            </div>

                            <div>
                                <label
                                    htmlFor="network-comment"
                                    className="mb-1.5 block text-sm font-medium text-slate-700"
                                >
                                    Comment
                                </label>

                                <input
                                    id="network-comment"
                                    value={
                                        form.comment
                                    }
                                    onChange={(
                                        event,
                                    ) =>
                                        setForm(
                                            (
                                                current,
                                            ) => ({
                                                ...current,
                                                comment:
                                                    event
                                                        .target
                                                        .value,
                                            }),
                                        )
                                    }
                                    className="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-slate-500"
                                />
                            </div>

                            <div className="flex justify-end gap-3 pt-3">
                                <button
                                    type="button"
                                    onClick={() =>
                                        setFormOpen(
                                            false,
                                        )
                                    }
                                    className="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50"
                                >
                                    إلغاء
                                </button>

                                <button
                                    type="submit"
                                    disabled={
                                        workingUser !==
                                        null
                                    }
                                    className="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-slate-800 disabled:opacity-50"
                                >
                                    {workingUser !==
                                    null
                                        ? "جاري التنفيذ..."
                                        : formMode ===
                                            "create"
                                          ? "إنشاء"
                                          : "حفظ التعديلات"}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </div>
    );
}
