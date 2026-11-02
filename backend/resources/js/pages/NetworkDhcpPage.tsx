import { useEffect, useMemo, useState } from "react";

import { ApiError, apiRequest } from "../api/client";
import type { NetworkDevice } from "../types/network";

interface DhcpLease {
    ".id"?: string;
    address?: string;
    "mac-address"?: string;
    "client-id"?: string;
    hostname?: string;
    display_name?: string | null;
    server?: string;
    status?: string;
    dynamic?: boolean | string;
    blocked?: boolean | string;
    "active-address"?: string;
    "active-mac-address"?: string;
    "active-client-id"?: string;
    "active-server"?: string;
    "last-seen"?: string;
    comment?: string;
}

interface DhcpStatistics {
    [key: string]: unknown;
}

interface LeaseForm {
    address: string;
    mac_address: string;
    hostname: string;
    comment: string;
}

function errorMessage(error: unknown): string {
    if (error instanceof ApiError) {
        return error.message;
    }

    if (error instanceof Error) {
        return error.message;
    }

    return "حدث خطأ غير متوقع.";
}

function asBoolean(value: boolean | string | undefined): boolean {
    return value === true || value === "true" || value === "yes";
}

function unwrapArray(payload: unknown): DhcpLease[] {
    if (Array.isArray(payload)) {
        return payload as DhcpLease[];
    }

    if (
        typeof payload === "object" &&
        payload !== null &&
        "data" in payload &&
        Array.isArray(payload.data)
    ) {
        return payload.data as DhcpLease[];
    }

    return [];
}

function unwrapObject(payload: unknown): DhcpStatistics {
    if (
        typeof payload === "object" &&
        payload !== null &&
        "data" in payload &&
        typeof payload.data === "object" &&
        payload.data !== null
    ) {
        return payload.data as DhcpStatistics;
    }

    if (typeof payload === "object" && payload !== null) {
        return payload as DhcpStatistics;
    }

    return {};
}

const emptyForm: LeaseForm = {
    address: "",
    mac_address: "",
    hostname: "",
    comment: "",
};

export function NetworkDhcpPage() {
    const [devices, setDevices] = useState<NetworkDevice[]>([]);
    const [deviceId, setDeviceId] = useState("");
    const [leases, setLeases] = useState<DhcpLease[]>([]);
    const [statistics, setStatistics] = useState<DhcpStatistics>({});
    const [loadingDevices, setLoadingDevices] = useState(true);
    const [loading, setLoading] = useState(false);
    const [saving, setSaving] = useState(false);
    const [error, setError] = useState("");
    const [success, setSuccess] = useState("");
    const [showForm, setShowForm] = useState(false);
    const [editingId, setEditingId] = useState<string | null>(null);
    const [form, setForm] = useState<LeaseForm>(emptyForm);

    const selectedDevice = useMemo(
        () => devices.find((device) => String(device.id) === deviceId),
        [devices, deviceId],
    );

    async function loadDevices() {
        setLoadingDevices(true);
        setError("");

        try {
            const payload = await apiRequest<unknown>("/network-devices");

            const rows =
                typeof payload === "object" &&
                payload !== null &&
                "data" in payload &&
                Array.isArray(payload.data)
                    ? (payload.data as NetworkDevice[])
                    : Array.isArray(payload)
                      ? (payload as NetworkDevice[])
                      : [];

            const activeDevices = rows.filter(
                (device) => device.status === "active",
            );

            setDevices(activeDevices);

            if (activeDevices.length > 0) {
                setDeviceId((current) =>
                    current &&
                    activeDevices.some(
                        (device) => String(device.id) === current,
                    )
                        ? current
                        : String(activeDevices[0].id),
                );
            } else {
                setDeviceId("");
            }
        } catch (loadError) {
            setError(errorMessage(loadError));
        } finally {
            setLoadingDevices(false);
        }
    }

    async function loadDhcp() {
        if (!deviceId) {
            setLeases([]);
            setStatistics({});
            return;
        }

        setLoading(true);
        setError("");

        try {
            const [leasePayload, statisticsPayload] = await Promise.all([
                apiRequest<unknown>(
                    `/network/dhcp?device_id=${encodeURIComponent(deviceId)}`,
                ),
                apiRequest<unknown>(
                    `/network/dhcp/statistics?device_id=${encodeURIComponent(
                        deviceId,
                    )}`,
                ),
            ]);

            setLeases(unwrapArray(leasePayload));
            setStatistics(unwrapObject(statisticsPayload));
        } catch (loadError) {
            setError(errorMessage(loadError));
            setLeases([]);
            setStatistics({});
        } finally {
            setLoading(false);
        }
    }

    useEffect(() => {
        void loadDevices();
    }, []);

    useEffect(() => {
        void loadDhcp();
    }, [deviceId]);

    function openCreate() {
        setEditingId(null);
        setForm(emptyForm);
        setError("");
        setSuccess("");
        setShowForm(true);
    }

    function openEdit(lease: DhcpLease) {
        if (!lease[".id"]) {
            setError("هذا الـ DHCP lease لا يحتوي على ID صالح للتعديل.");
            return;
        }

        setEditingId(lease[".id"]);
        setForm({
            address: lease.address ?? "",
            mac_address: lease["mac-address"] ?? "",
            hostname: lease.hostname ?? "",
            comment: lease.comment ?? "",
        });
        setError("");
        setSuccess("");
        setShowForm(true);
    }

    function closeForm() {
        if (saving) {
            return;
        }

        setShowForm(false);
        setEditingId(null);
        setForm(emptyForm);
    }

    async function saveLease(event: React.FormEvent<HTMLFormElement>) {
        event.preventDefault();

        if (!deviceId) {
            setError("اختر MikroTik device أولاً.");
            return;
        }

        setSaving(true);
        setError("");
        setSuccess("");

        try {
            if (editingId) {
                await apiRequest(
                    `/network/dhcp/${encodeURIComponent(editingId)}`,
                    {
                        method: "PUT",
                        body: JSON.stringify({
                            device_id: Number(deviceId),
                            data: {
                                address: form.address,
                                mac_address: form.mac_address,
                                hostname: form.hostname || null,
                                comment: form.comment || null,
                            },
                        }),
                    },
                );

                setSuccess("تم تحديث DHCP lease بنجاح.");
            } else {
                await apiRequest("/network/dhcp", {
                    method: "POST",
                    body: JSON.stringify({
                        device_id: Number(deviceId),
                        address: form.address,
                        mac_address: form.mac_address,
                        hostname: form.hostname || null,
                        options: {
                            comment: form.comment || null,
                        },
                    }),
                });

                setSuccess("تمت إضافة DHCP lease بنجاح.");
            }

            closeForm();
            await loadDhcp();
        } catch (saveError) {
            setError(errorMessage(saveError));
        } finally {
            setSaving(false);
        }
    }

    async function deleteLease(lease: DhcpLease) {
        if (!deviceId || !lease[".id"]) {
            return;
        }

        if (!window.confirm(`حذف DHCP lease للعنوان ${lease.address ?? ""}؟`)) {
            return;
        }

        setError("");
        setSuccess("");

        try {
            await apiRequest(
                `/network/dhcp/${encodeURIComponent(lease[".id"])}`,
                {
                    method: "DELETE",
                    body: JSON.stringify({
                        device_id: Number(deviceId),
                    }),
                },
            );

            setSuccess("تم حذف DHCP lease بنجاح.");
            await loadDhcp();
        } catch (deleteError) {
            setError(errorMessage(deleteError));
        }
    }

    async function changeStaticState(
        lease: DhcpLease,
        action: "make-static" | "remove-static",
    ) {
        if (!deviceId || !lease[".id"]) {
            return;
        }

        setError("");
        setSuccess("");

        try {
            await apiRequest(
                `/network/dhcp/${encodeURIComponent(lease[".id"])}/${action}`,
                {
                    method: "PATCH",
                    body: JSON.stringify({
                        device_id: Number(deviceId),
                    }),
                },
            );

            setSuccess(
                action === "make-static"
                    ? "تم تحويل DHCP lease إلى Static."
                    : "تم تحويل DHCP lease إلى Dynamic.",
            );

            await loadDhcp();
        } catch (stateError) {
            setError(errorMessage(stateError));
        }
    }

    const statisticEntries = Object.entries(statistics).filter(
        ([, value]) =>
            typeof value === "string" ||
            typeof value === "number" ||
            typeof value === "boolean",
    );

    return (
        <div className="space-y-6">
            <div className="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <h1 className="text-2xl font-semibold text-slate-900">
                        DHCP Leases
                    </h1>
                    <p className="mt-1 text-sm text-slate-500">
                        إدارة DHCP leases مباشرة على MikroTik.
                    </p>
                </div>

                <div className="flex flex-col gap-2 md:flex-row md:items-center">
                    <select
                        value={deviceId}
                        onChange={(event) => setDeviceId(event.target.value)}
                        disabled={loadingDevices || devices.length === 0}
                        className="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"
                    >
                        <option value="">
                            {loadingDevices
                                ? "جاري تحميل الأجهزة..."
                                : "اختر الجهاز"}
                        </option>

                        {devices.map((device) => (
                            <option key={device.id} value={device.id}>
                                {device.name} ({device.type})
                            </option>
                        ))}
                    </select>

                    <button
                        type="button"
                        onClick={openCreate}
                        disabled={!deviceId}
                        className="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white disabled:opacity-50"
                    >
                        + إضافة DHCP Lease
                    </button>
                </div>
            </div>

            {selectedDevice && (
                <div className="rounded-xl border border-slate-200 bg-white p-4">
                    <div className="flex flex-wrap items-center gap-3 text-sm">
                        <span className="font-medium text-slate-900">
                            {selectedDevice.name}
                        </span>

                        <span
                            className={`rounded-full px-2.5 py-1 ${
                                selectedDevice.is_online
                                    ? "bg-emerald-100 text-emerald-700"
                                    : "bg-slate-100 text-slate-600"
                            }`}
                        >
                            {selectedDevice.is_online
                                ? "Online"
                                : "Offline"}
                        </span>

                        <span className="text-slate-500">
                            {leases.length} leases
                        </span>
                    </div>
                </div>
            )}

            {statisticEntries.length > 0 && (
                <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    {statisticEntries.map(([key, value]) => (
                        <div
                            key={key}
                            className="rounded-xl border border-slate-200 bg-white p-4"
                        >
                            <div className="text-xs font-medium uppercase tracking-wide text-slate-400">
                                {key.replaceAll("_", " ")}
                            </div>
                            <div className="mt-2 text-xl font-semibold text-slate-900">
                                {String(value)}
                            </div>
                        </div>
                    ))}
                </div>
            )}

            {error && (
                <div className="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {error}
                </div>
            )}

            {success && (
                <div className="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {success}
                </div>
            )}

            <div className="overflow-hidden rounded-xl border border-slate-200 bg-white">
                <div className="border-b border-slate-200 px-5 py-4">
                    <h2 className="font-semibold text-slate-900">
                        DHCP Leases
                    </h2>
                </div>

                {loading ? (
                    <div className="p-8 text-center text-sm text-slate-500">
                        جاري تحميل DHCP leases...
                    </div>
                ) : leases.length === 0 ? (
                    <div className="p-8 text-center text-sm text-slate-500">
                        لا توجد DHCP leases.
                    </div>
                ) : (
                    <div className="overflow-x-auto">
                        <table className="min-w-full text-sm">
                            <thead className="bg-slate-50 text-right text-xs font-semibold uppercase text-slate-500">
                                <tr>
                                    <th className="px-4 py-3">Address</th>
                                    <th className="px-4 py-3">MAC</th>
                                    <th className="px-4 py-3">Name / Hostname</th>
                                    <th className="px-4 py-3">Server</th>
                                    <th className="px-4 py-3">Status</th>
                                    <th className="px-4 py-3">Type</th>
                                    <th className="px-4 py-3">Actions</th>
                                </tr>
                            </thead>

                            <tbody className="divide-y divide-slate-100">
                                {leases.map((lease) => {
                                    const isStatic = !asBoolean(lease.dynamic);

                                    return (
                                        <tr
                                            key={
                                                lease[".id"] ??
                                                `${lease.address}-${lease["mac-address"]}`
                                            }
                                            className="hover:bg-slate-50"
                                        >
                                            <td className="px-4 py-3 font-medium text-slate-900">
                                                {lease.address ?? "—"}
                                            </td>

                                            <td className="px-4 py-3 font-mono text-xs text-slate-600">
                                                {lease["mac-address"] ?? "—"}
                                            </td>

                                            <td className="px-4 py-3 text-slate-600">
                                                {lease.display_name || lease.hostname || "—"}
                                            </td>

                                            <td className="px-4 py-3 text-slate-600">
                                                {lease.server ?? "—"}
                                            </td>

                                            <td className="px-4 py-3 text-slate-600">
                                                {lease.status ?? "—"}
                                            </td>

                                            <td className="px-4 py-3">
                                                <span
                                                    className={`rounded-full px-2.5 py-1 text-xs font-medium ${
                                                        isStatic
                                                            ? "bg-blue-100 text-blue-700"
                                                            : "bg-slate-100 text-slate-600"
                                                    }`}
                                                >
                                                    {isStatic
                                                        ? "Static"
                                                        : "Dynamic"}
                                                </span>
                                            </td>

                                            <td className="px-4 py-3">
                                                <div className="flex flex-wrap gap-2">
                                                    <button
                                                        type="button"
                                                        onClick={() =>
                                                            openEdit(lease)
                                                        }
                                                        className="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700"
                                                    >
                                                        تعديل
                                                    </button>

                                                    <button
                                                        type="button"
                                                        onClick={() =>
                                                            void changeStaticState(
                                                                lease,
                                                                isStatic
                                                                    ? "remove-static"
                                                                    : "make-static",
                                                            )
                                                        }
                                                        className="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700"
                                                    >
                                                        {isStatic
                                                            ? "Dynamic"
                                                            : "Static"}
                                                    </button>

                                                    <button
                                                        type="button"
                                                        onClick={() =>
                                                            void deleteLease(
                                                                lease,
                                                            )
                                                        }
                                                        className="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-700"
                                                    >
                                                        حذف
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    );
                                })}
                            </tbody>
                        </table>
                    </div>
                )}
            </div>

            {showForm && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 p-4">
                    <div className="w-full max-w-2xl rounded-2xl bg-white shadow-xl">
                        <div className="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                            <div>
                                <h2 className="text-lg font-semibold text-slate-900">
                                    {editingId
                                        ? "تعديل DHCP Lease"
                                        : "إضافة DHCP Lease"}
                                </h2>
                                <p className="mt-1 text-xs text-slate-500">
                                    {selectedDevice?.name ?? "MikroTik"}
                                </p>
                            </div>

                            <button
                                type="button"
                                onClick={closeForm}
                                disabled={saving}
                                className="text-slate-400 hover:text-slate-700"
                            >
                                ✕
                            </button>
                        </div>

                        <form
                            onSubmit={saveLease}
                            className="grid gap-4 p-6 md:grid-cols-2"
                        >
                            <div>
                                <label className="mb-1 block text-sm font-medium text-slate-700">
                                    IP Address
                                </label>

                                <input
                                    value={form.address}
                                    onChange={(event) =>
                                        setForm((current) => ({
                                            ...current,
                                            address: event.target.value,
                                        }))
                                    }
                                    required
                                    placeholder="192.168.1.100"
                                    className="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"
                                />
                            </div>

                            <div>
                                <label className="mb-1 block text-sm font-medium text-slate-700">
                                    MAC Address
                                </label>

                                <input
                                    value={form.mac_address}
                                    onChange={(event) =>
                                        setForm((current) => ({
                                            ...current,
                                            mac_address: event.target.value,
                                        }))
                                    }
                                    required
                                    placeholder="AA:BB:CC:DD:EE:FF"
                                    className="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"
                                />
                            </div>

                            <div>
                                <label className="mb-1 block text-sm font-medium text-slate-700">
                                    Hostname
                                </label>

                                <input
                                    value={form.hostname}
                                    onChange={(event) =>
                                        setForm((current) => ({
                                            ...current,
                                            hostname: event.target.value,
                                        }))
                                    }
                                    className="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"
                                />
                            </div>

                            <div>
                                <label className="mb-1 block text-sm font-medium text-slate-700">
                                    Comment
                                </label>

                                <input
                                    value={form.comment}
                                    onChange={(event) =>
                                        setForm((current) => ({
                                            ...current,
                                            comment: event.target.value,
                                        }))
                                    }
                                    className="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"
                                />
                            </div>

                            <div className="flex justify-end gap-2 md:col-span-2">
                                <button
                                    type="button"
                                    onClick={closeForm}
                                    disabled={saving}
                                    className="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700"
                                >
                                    إلغاء
                                </button>

                                <button
                                    type="submit"
                                    disabled={saving}
                                    className="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white disabled:opacity-50"
                                >
                                    {saving ? "جاري الحفظ..." : "حفظ"}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </div>
    );
}
