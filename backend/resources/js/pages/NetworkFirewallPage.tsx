import { useEffect, useMemo, useState } from "react";

import { ApiError, apiRequest } from "../api/client";
import type { NetworkDevice } from "../types/network";

interface FirewallRule {
    ".id"?: string;
    chain?: string;
    action?: string;
    src_address?: string;
    dst_address?: string;
    protocol?: string;
    dst_port?: string;
    comment?: string;
    disabled?: boolean | string;
    [key: string]: unknown;
}

interface FirewallStatistics {
    filter_rules?: number;
    nat_rules?: number;
    [key: string]: unknown;
}

interface NatRule {
    ".id"?: string;
    comment?: string;
    disabled?: boolean | string;
    [key: string]: unknown;
}

interface FilterForm {
    chain: string;
    action: string;
    src_address: string;
    dst_address: string;
    protocol: string;
    dst_port: string;
    comment: string;
}

interface NatForm {
    comment: string;
    attributes: string;
}

type Tab = "filter" | "nat";

const emptyFilterForm: FilterForm = {
    chain: "forward",
    action: "accept",
    src_address: "",
    dst_address: "",
    protocol: "",
    dst_port: "",
    comment: "",
};

const emptyNatForm: NatForm = {
    comment: "",
    attributes: "{}",
};

function errorMessage(error: unknown): string {
    if (error instanceof ApiError) {
        return error.message;
    }

    return error instanceof Error
        ? error.message
        : "حدث خطأ غير متوقع.";
}

function asBoolean(value: boolean | string | undefined): boolean {
    return value === true || value === "yes" || value === "true";
}

function unwrapArray<T>(payload: unknown): T[] {
    if (Array.isArray(payload)) {
        return payload as T[];
    }

    if (
        typeof payload === "object" &&
        payload !== null &&
        "data" in payload &&
        Array.isArray(payload.data)
    ) {
        return payload.data as T[];
    }

    return [];
}

function unwrapObject<T extends Record<string, unknown>>(
    payload: unknown,
): T {
    if (
        typeof payload === "object" &&
        payload !== null &&
        "data" in payload &&
        typeof payload.data === "object" &&
        payload.data !== null
    ) {
        return payload.data as T;
    }

    return (payload ?? {}) as T;
}

export function NetworkFirewallPage() {
    const [devices, setDevices] = useState<NetworkDevice[]>([]);
    const [deviceId, setDeviceId] = useState("");
    const [tab, setTab] = useState<Tab>("filter");

    const [filterRules, setFilterRules] = useState<FirewallRule[]>([]);
    const [natRules, setNatRules] = useState<NatRule[]>([]);
    const [statistics, setStatistics] = useState<FirewallStatistics>({});

    const [loading, setLoading] = useState(false);
    const [saving, setSaving] = useState(false);
    const [message, setMessage] = useState("");
    const [error, setError] = useState("");

    const [filterModal, setFilterModal] = useState(false);
    const [natModal, setNatModal] = useState(false);

    const [editingFilterId, setEditingFilterId] = useState<string | null>(
        null,
    );
    const [editingNatId, setEditingNatId] = useState<string | null>(null);

    const [filterForm, setFilterForm] =
        useState<FilterForm>(emptyFilterForm);
    const [natForm, setNatForm] = useState<NatForm>(emptyNatForm);

    const selectedDevice = useMemo(
        () => devices.find((device) => String(device.id) === deviceId),
        [devices, deviceId],
    );

    async function loadDevices() {
        try {
            const payload = await apiRequest<unknown>("/network-devices");
            const nextDevices = unwrapArray<NetworkDevice>(payload);

            setDevices(nextDevices);

            if (nextDevices.length > 0 && !deviceId) {
                setDeviceId(String(nextDevices[0].id));
            }
        } catch (requestError) {
            setError(errorMessage(requestError));
        }
    }

    async function loadFirewall() {
        if (!deviceId) {
            setFilterRules([]);
            setNatRules([]);
            setStatistics({});
            return;
        }

        setLoading(true);
        setError("");

        try {
            const [filterPayload, natPayload, statisticsPayload] =
                await Promise.all([
                    apiRequest<unknown>(
                        `/network/firewall?device_id=${encodeURIComponent(deviceId)}`,
                    ),
                    apiRequest<unknown>(
                        `/network/firewall/nat?device_id=${encodeURIComponent(deviceId)}`,
                    ),
                    apiRequest<unknown>(
                        `/network/firewall/statistics?device_id=${encodeURIComponent(
                            deviceId,
                        )}`,
                    ),
                ]);

            setFilterRules(unwrapArray<FirewallRule>(filterPayload));
            setNatRules(unwrapArray<NatRule>(natPayload));
            setStatistics(
                unwrapObject<FirewallStatistics>(statisticsPayload),
            );
        } catch (requestError) {
            setError(errorMessage(requestError));
        } finally {
            setLoading(false);
        }
    }

    useEffect(() => {
        void loadDevices();
    }, []);

    useEffect(() => {
        void loadFirewall();
    }, [deviceId]);

    function openCreateFilter() {
        setEditingFilterId(null);
        setFilterForm(emptyFilterForm);
        setMessage("");
        setError("");
        setFilterModal(true);
    }

    function openEditFilter(rule: FirewallRule) {
        setEditingFilterId(rule[".id"] ?? null);
        setFilterForm({
            chain: String(rule.chain ?? ""),
            action: String(rule.action ?? ""),
            src_address: String(rule.src_address ?? ""),
            dst_address: String(rule.dst_address ?? ""),
            protocol: String(rule.protocol ?? ""),
            dst_port: String(rule.dst_port ?? ""),
            comment: String(rule.comment ?? ""),
        });
        setMessage("");
        setError("");
        setFilterModal(true);
    }

    function openCreateNat() {
        setEditingNatId(null);
        setNatForm(emptyNatForm);
        setMessage("");
        setError("");
        setNatModal(true);
    }

    function openEditNat(rule: NatRule) {
        const attributes = Object.fromEntries(
            Object.entries(rule).filter(
                ([key]) => key !== ".id" && key !== "comment",
            ),
        );

        setEditingNatId(rule[".id"] ?? null);
        setNatForm({
            comment: String(rule.comment ?? ""),
            attributes: JSON.stringify(attributes, null, 2),
        });
        setMessage("");
        setError("");
        setNatModal(true);
    }

    function closeModals() {
        if (saving) {
            return;
        }

        setFilterModal(false);
        setNatModal(false);
    }

    async function saveFilter(event: React.FormEvent<HTMLFormElement>) {
        event.preventDefault();

        if (!deviceId) {
            setError("اختر جهاز الشبكة أولًا.");
            return;
        }

        setSaving(true);
        setMessage("");
        setError("");

        const attributes: Record<string, string> = {
            chain: filterForm.chain,
            action: filterForm.action,
        };

        if (filterForm.src_address) {
            attributes.src_address = filterForm.src_address;
        }

        if (filterForm.dst_address) {
            attributes.dst_address = filterForm.dst_address;
        }

        if (filterForm.protocol) {
            attributes.protocol = filterForm.protocol;
        }

        if (filterForm.dst_port) {
            attributes.dst_port = filterForm.dst_port;
        }

        if (filterForm.comment) {
            attributes.comment = filterForm.comment;
        }

        try {
            if (editingFilterId) {
                await apiRequest(
                    `/network/firewall/${encodeURIComponent(editingFilterId)}`,
                    {
                        method: "PUT",
                        body: JSON.stringify({
                            device_id: Number(deviceId),
                            attributes,
                        }),
                    },
                );

                setMessage("تم تحديث قاعدة Firewall.");
            } else {
                await apiRequest("/network/firewall", {
                    method: "POST",
                    body: JSON.stringify({
                        device_id: Number(deviceId),
                        attributes,
                    }),
                });

                setMessage("تم إنشاء قاعدة Firewall.");
            }

            setFilterModal(false);
            await loadFirewall();
        } catch (requestError) {
            setError(errorMessage(requestError));
        } finally {
            setSaving(false);
        }
    }

    async function toggleFilter(rule: FirewallRule) {
        if (!deviceId || !rule[".id"]) {
            return;
        }

        setError("");
        setMessage("");

        try {
            await apiRequest(
                `/network/firewall/${encodeURIComponent(rule[".id"])}/toggle`,
                {
                    method: "PATCH",
                    body: JSON.stringify({
                        device_id: Number(deviceId),
                        action: asBoolean(rule.disabled)
                            ? "enable"
                            : "disable",
                    }),
                },
            );

            setMessage("تم تحديث حالة قاعدة Firewall.");
            await loadFirewall();
        } catch (requestError) {
            setError(errorMessage(requestError));
        }
    }

    async function deleteFilter(rule: FirewallRule) {
        if (!deviceId || !rule[".id"]) {
            return;
        }

        if (!window.confirm("هل تريد حذف قاعدة Firewall؟")) {
            return;
        }

        setError("");
        setMessage("");

        try {
            await apiRequest(
                `/network/firewall/${encodeURIComponent(rule[".id"])}`,
                {
                    method: "DELETE",
                    body: JSON.stringify({
                        device_id: Number(deviceId),
                    }),
                },
            );

            setMessage("تم حذف قاعدة Firewall.");
            await loadFirewall();
        } catch (requestError) {
            setError(errorMessage(requestError));
        }
    }

    async function saveNat(event: React.FormEvent<HTMLFormElement>) {
        event.preventDefault();

        if (!deviceId) {
            setError("اختر جهاز الشبكة أولًا.");
            return;
        }

        let parsedAttributes: Record<string, unknown>;

        try {
            parsedAttributes = JSON.parse(natForm.attributes);
        } catch {
            setError("خصائص NAT يجب أن تكون JSON صحيحة.");
            return;
        }

        setSaving(true);
        setMessage("");
        setError("");

        if (natForm.comment) {
            parsedAttributes.comment = natForm.comment;
        }

        try {
            if (editingNatId) {
                await apiRequest(
                    `/network/firewall/nat/${encodeURIComponent(editingNatId)}`,
                    {
                        method: "PUT",
                        body: JSON.stringify({
                            device_id: Number(deviceId),
                            attributes: parsedAttributes,
                        }),
                    },
                );

                setMessage("تم تحديث قاعدة NAT.");
            } else {
                await apiRequest("/network/firewall/nat", {
                    method: "POST",
                    body: JSON.stringify({
                        device_id: Number(deviceId),
                        attributes: parsedAttributes,
                    }),
                });

                setMessage("تم إنشاء قاعدة NAT.");
            }

            setNatModal(false);
            await loadFirewall();
        } catch (requestError) {
            setError(errorMessage(requestError));
        } finally {
            setSaving(false);
        }
    }

    async function deleteNat(rule: NatRule) {
        if (!deviceId || !rule[".id"]) {
            return;
        }

        if (!window.confirm("هل تريد حذف قاعدة NAT؟")) {
            return;
        }

        setError("");
        setMessage("");

        try {
            await apiRequest(
                `/network/firewall/nat/${encodeURIComponent(rule[".id"])}`,
                {
                    method: "DELETE",
                    body: JSON.stringify({
                        device_id: Number(deviceId),
                    }),
                },
            );

            setMessage("تم حذف قاعدة NAT.");
            await loadFirewall();
        } catch (requestError) {
            setError(errorMessage(requestError));
        }
    }

    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-2xl font-semibold text-slate-900">
                    Firewall
                </h1>
                <p className="mt-1 text-sm text-slate-500">
                    إدارة قواعد Firewall وNAT على أجهزة الشبكة.
                </p>
            </div>

            <div className="rounded-xl border border-slate-200 bg-white p-4">
                <div className="grid gap-4 md:grid-cols-3">
                    <label className="space-y-2">
                        <span className="text-sm font-medium text-slate-700">
                            جهاز الشبكة
                        </span>
                        <select
                            value={deviceId}
                            onChange={(event) =>
                                setDeviceId(event.target.value)
                            }
                            className="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"
                        >
                            <option value="">اختر الجهاز</option>
                            {devices.map((device) => (
                                <option key={device.id} value={device.id}>
                                    {device.name}
                                </option>
                            ))}
                        </select>
                    </label>

                    <div className="rounded-lg bg-slate-50 p-3">
                        <div className="text-xs text-slate-500">
                            الجهاز الحالي
                        </div>
                        <div className="mt-1 font-medium text-slate-900">
                            {selectedDevice?.name ?? "—"}
                        </div>
                    </div>

                    <div className="rounded-lg bg-slate-50 p-3">
                        <div className="text-xs text-slate-500">
                            Statistics
                        </div>
                        <div className="mt-1 text-sm text-slate-900">
                            Filter: {statistics.filter_rules ?? filterRules.length}
                            {" · "}
                            NAT: {statistics.nat_rules ?? natRules.length}
                        </div>
                    </div>
                </div>
            </div>

            {message && (
                <div className="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {message}
                </div>
            )}

            {error && (
                <div className="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    {error}
                </div>
            )}

            <div className="rounded-xl border border-slate-200 bg-white">
                <div className="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 p-4">
                    <div className="flex gap-2">
                        <button
                            type="button"
                            onClick={() => setTab("filter")}
                            className={`rounded-lg px-4 py-2 text-sm font-medium ${
                                tab === "filter"
                                    ? "bg-slate-900 text-white"
                                    : "bg-slate-100 text-slate-700"
                            }`}
                        >
                            Filter Rules
                        </button>

                        <button
                            type="button"
                            onClick={() => setTab("nat")}
                            className={`rounded-lg px-4 py-2 text-sm font-medium ${
                                tab === "nat"
                                    ? "bg-slate-900 text-white"
                                    : "bg-slate-100 text-slate-700"
                            }`}
                        >
                            NAT Rules
                        </button>
                    </div>

                    <button
                        type="button"
                        onClick={
                            tab === "filter"
                                ? openCreateFilter
                                : openCreateNat
                        }
                        disabled={!deviceId}
                        className="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white disabled:opacity-50"
                    >
                        + إضافة قاعدة
                    </button>
                </div>

                {loading ? (
                    <div className="p-8 text-center text-sm text-slate-500">
                        جاري تحميل قواعد Firewall...
                    </div>
                ) : tab === "filter" ? (
                    <div className="overflow-x-auto">
                        <table className="min-w-full text-sm">
                            <thead className="bg-slate-50 text-left text-slate-600">
                                <tr>
                                    <th className="px-4 py-3">ID</th>
                                    <th className="px-4 py-3">Chain</th>
                                    <th className="px-4 py-3">Action</th>
                                    <th className="px-4 py-3">Source</th>
                                    <th className="px-4 py-3">Destination</th>
                                    <th className="px-4 py-3">Protocol</th>
                                    <th className="px-4 py-3">Port</th>
                                    <th className="px-4 py-3">Comment</th>
                                    <th className="px-4 py-3">الحالة</th>
                                    <th className="px-4 py-3">إجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                {filterRules.map((rule) => (
                                    <tr
                                        key={rule[".id"]}
                                        className="border-t border-slate-100"
                                    >
                                        <td className="px-4 py-3 font-mono text-xs">
                                            {rule[".id"] ?? "—"}
                                        </td>
                                        <td className="px-4 py-3">
                                            {String(rule.chain ?? "—")}
                                        </td>
                                        <td className="px-4 py-3">
                                            {String(rule.action ?? "—")}
                                        </td>
                                        <td className="px-4 py-3">
                                            {String(rule.src_address ?? "—")}
                                        </td>
                                        <td className="px-4 py-3">
                                            {String(rule.dst_address ?? "—")}
                                        </td>
                                        <td className="px-4 py-3">
                                            {String(rule.protocol ?? "—")}
                                        </td>
                                        <td className="px-4 py-3">
                                            {String(rule.dst_port ?? "—")}
                                        </td>
                                        <td className="px-4 py-3">
                                            {String(rule.comment ?? "—")}
                                        </td>
                                        <td className="px-4 py-3">
                                            {asBoolean(rule.disabled)
                                                ? "Disabled"
                                                : "Enabled"}
                                        </td>
                                        <td className="px-4 py-3">
                                            <div className="flex flex-wrap gap-2">
                                                <button
                                                    type="button"
                                                    onClick={() =>
                                                        openEditFilter(rule)
                                                    }
                                                    className="rounded border border-slate-300 px-2 py-1 text-xs"
                                                >
                                                    تعديل
                                                </button>

                                                <button
                                                    type="button"
                                                    onClick={() =>
                                                        void toggleFilter(rule)
                                                    }
                                                    className="rounded border border-slate-300 px-2 py-1 text-xs"
                                                >
                                                    {asBoolean(rule.disabled)
                                                        ? "Enable"
                                                        : "Disable"}
                                                </button>

                                                <button
                                                    type="button"
                                                    onClick={() =>
                                                        void deleteFilter(rule)
                                                    }
                                                    className="rounded border border-red-300 px-2 py-1 text-xs text-red-700"
                                                >
                                                    حذف
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))}

                                {filterRules.length === 0 && (
                                    <tr>
                                        <td
                                            colSpan={10}
                                            className="px-4 py-8 text-center text-slate-500"
                                        >
                                            لا توجد Filter Rules.
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                ) : (
                    <div className="overflow-x-auto">
                        <table className="min-w-full text-sm">
                            <thead className="bg-slate-50 text-left text-slate-600">
                                <tr>
                                    <th className="px-4 py-3">ID</th>
                                    <th className="px-4 py-3">Comment</th>
                                    <th className="px-4 py-3">الحالة</th>
                                    <th className="px-4 py-3">Attributes</th>
                                    <th className="px-4 py-3">إجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                {natRules.map((rule) => {
                                    const attributes = Object.entries(rule)
                                        .filter(
                                            ([key]) =>
                                                key !== ".id" &&
                                                key !== "comment" &&
                                                key !== "disabled",
                                        )
                                        .map(([key, value]) => `${key}: ${String(value)}`)
                                        .join(" · ");

                                    return (
                                        <tr
                                            key={rule[".id"]}
                                            className="border-t border-slate-100"
                                        >
                                            <td className="px-4 py-3 font-mono text-xs">
                                                {rule[".id"] ?? "—"}
                                            </td>
                                            <td className="px-4 py-3">
                                                {String(rule.comment ?? "—")}
                                            </td>
                                            <td className="px-4 py-3">
                                                {asBoolean(rule.disabled)
                                                    ? "Disabled"
                                                    : "Enabled"}
                                            </td>
                                            <td className="max-w-md px-4 py-3 text-xs text-slate-600">
                                                {attributes || "—"}
                                            </td>
                                            <td className="px-4 py-3">
                                                <div className="flex gap-2">
                                                    <button
                                                        type="button"
                                                        onClick={() =>
                                                            openEditNat(rule)
                                                        }
                                                        className="rounded border border-slate-300 px-2 py-1 text-xs"
                                                    >
                                                        تعديل
                                                    </button>

                                                    <button
                                                        type="button"
                                                        onClick={() =>
                                                            void deleteNat(rule)
                                                        }
                                                        className="rounded border border-red-300 px-2 py-1 text-xs text-red-700"
                                                    >
                                                        حذف
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    );
                                })}

                                {natRules.length === 0 && (
                                    <tr>
                                        <td
                                            colSpan={5}
                                            className="px-4 py-8 text-center text-slate-500"
                                        >
                                            لا توجد NAT Rules.
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                )}
            </div>

            {filterModal && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
                    <div className="w-full max-w-2xl rounded-xl bg-white p-6 shadow-xl">
                        <div className="mb-5 flex items-center justify-between">
                            <h2 className="text-lg font-semibold text-slate-900">
                                {editingFilterId
                                    ? "تعديل Firewall Rule"
                                    : "إضافة Firewall Rule"}
                            </h2>

                            <button
                                type="button"
                                onClick={closeModals}
                                disabled={saving}
                                className="text-slate-500"
                            >
                                ✕
                            </button>
                        </div>

                        <form
                            onSubmit={saveFilter}
                            className="grid gap-4 md:grid-cols-2"
                        >
                            {(
                                [
                                    ["chain", "Chain"],
                                    ["action", "Action"],
                                    ["src_address", "Source Address"],
                                    ["dst_address", "Destination Address"],
                                    ["protocol", "Protocol"],
                                    ["dst_port", "Destination Port"],
                                    ["comment", "Comment"],
                                ] as const
                            ).map(([field, label]) => (
                                <label
                                    key={field}
                                    className="space-y-1"
                                    >
                                    <span className="text-sm font-medium text-slate-700">
                                        {label}
                                    </span>
                                    <input
                                        value={filterForm[field]}
                                        onChange={(event) =>
                                            setFilterForm((current) => ({
                                                ...current,
                                                [field]: event.target.value,
                                            }))
                                        }
                                        required={
                                            field === "chain" ||
                                            field === "action"
                                        }
                                        className="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"
                                    />
                                </label>
                            ))}

                            <div className="flex justify-end gap-2 md:col-span-2">
                                <button
                                    type="button"
                                    onClick={closeModals}
                                    disabled={saving}
                                    className="rounded-lg border border-slate-300 px-4 py-2 text-sm"
                                >
                                    إلغاء
                                </button>

                                <button
                                    type="submit"
                                    disabled={saving}
                                    className="rounded-lg bg-slate-900 px-4 py-2 text-sm text-white disabled:opacity-50"
                                >
                                    {saving ? "جاري الحفظ..." : "حفظ"}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}

            {natModal && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
                    <div className="w-full max-w-2xl rounded-xl bg-white p-6 shadow-xl">
                        <div className="mb-5 flex items-center justify-between">
                            <h2 className="text-lg font-semibold text-slate-900">
                                {editingNatId
                                    ? "تعديل NAT Rule"
                                    : "إضافة NAT Rule"}
                            </h2>

                            <button
                                type="button"
                                onClick={closeModals}
                                disabled={saving}
                                className="text-slate-500"
                            >
                                ✕
                            </button>
                        </div>

                        <form onSubmit={saveNat} className="space-y-4">
                            <label className="block space-y-1">
                                <span className="text-sm font-medium text-slate-700">
                                    Comment
                                </span>
                                <input
                                    value={natForm.comment}
                                    onChange={(event) =>
                                        setNatForm((current) => ({
                                            ...current,
                                            comment: event.target.value,
                                        }))
                                    }
                                    className="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"
                                />
                            </label>

                            <label className="block space-y-1">
                                <span className="text-sm font-medium text-slate-700">
                                    NAT Attributes JSON
                                </span>
                                <textarea
                                    value={natForm.attributes}
                                    onChange={(event) =>
                                        setNatForm((current) => ({
                                            ...current,
                                            attributes: event.target.value,
                                        }))
                                    }
                                    rows={12}
                                    className="w-full rounded-lg border border-slate-300 px-3 py-2 font-mono text-sm"
                                    placeholder='{"chain":"srcnat","action":"masquerade"}'
                                />
                            </label>

                            <div className="flex justify-end gap-2">
                                <button
                                    type="button"
                                    onClick={closeModals}
                                    disabled={saving}
                                    className="rounded-lg border border-slate-300 px-4 py-2 text-sm"
                                >
                                    إلغاء
                                </button>

                                <button
                                    type="submit"
                                    disabled={saving}
                                    className="rounded-lg bg-slate-900 px-4 py-2 text-sm text-white disabled:opacity-50"
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
