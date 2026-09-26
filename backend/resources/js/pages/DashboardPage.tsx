import { useEffect, useState } from "react";

import { apiRequest } from "../api/client";
import { Alert } from "../components/ui/Alert";
import { LoadingState } from "../components/ui/LoadingState";
import { PageHeader } from "../components/ui/PageHeader";
import { MetricCard } from "../components/dashboard/MetricCard";
import { SectionCard } from "../components/dashboard/SectionCard";
import { StatusBadge } from "../components/dashboard/StatusBadge";

interface DashboardStats {
    totalUsers: number;
    onlineUsers: number;
    activeUsers: number;
    totalDevices: number;
    onlineDevices: number;
    onlineUsersLastSyncAt: string | null;
    onlineDevicesLastSyncAt: string | null;
}

function formatSyncTime(value: string | null): string {
    if (!value) {
        return "لا توجد مزامنة مسجلة";
    }

    const date = new Date(value);

    if (Number.isNaN(date.getTime())) {
        return value;
    }

    return date.toLocaleString("ar-EG");
}

function SyncRow({
    label,
    value,
    tone,
}: {
    label: string;
    value: string;
    tone: "success" | "info";
}) {
    return (
        <div className="flex flex-col gap-3 rounded-xl border border-slate-100 bg-slate-50 p-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p className="font-medium text-slate-900">{label}</p>
                <p className="mt-1 text-sm text-slate-500">{value}</p>
            </div>

            <StatusBadge
                label="بيانات مزامنة"
                tone={tone}
            />
        </div>
    );
}

export function DashboardPage() {
    const [stats, setStats] = useState<DashboardStats | null>(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState("");

    useEffect(() => {
        async function loadDashboard() {
            try {
                const response =
                    await apiRequest<DashboardStats>("/dashboard");

                setStats(response);
            } catch (exception) {
                setError(
                    exception instanceof Error
                        ? exception.message
                        : "Unable to load dashboard.",
                );
            } finally {
                setLoading(false);
            }
        }

        void loadDashboard();
    }, []);

    return (
        <main dir="rtl" className="mx-auto max-w-7xl px-4 py-6 sm:px-6 sm:py-8">
            <PageHeader
                title="نظرة عامة"
                description="ملخص تشغيلي مبني على آخر بيانات المزامنة المتاحة"
            />

            {loading && <LoadingState />}

            {error && <Alert variant="error">{error}</Alert>}

            {!loading && !error && stats && (
                <div className="space-y-6">
                    <section className="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                        <MetricCard
                            label="إجمالي المستخدمين"
                            value={stats.totalUsers}
                        />

                        <MetricCard
                            label="المستخدمون المتصلون"
                            value={stats.onlineUsers}
                            description={`حسب آخر مزامنة: ${formatSyncTime(
                                stats.onlineUsersLastSyncAt,
                            )}`}
                            tone="info"
                        />

                        <MetricCard
                            label="المستخدمون النشطون"
                            value={stats.activeUsers}
                            description="حالة الحسابات والاشتراكات النشطة"
                            tone="success"
                        />

                        <MetricCard
                            label="إجمالي الأجهزة"
                            value={stats.totalDevices}
                        />
                    </section>

                    <section className="grid gap-6 lg:grid-cols-2">
                        <SectionCard
                            title="حالة مزامنة المستخدمين"
                            description="وقت آخر بيانات متاحة من مصدر المزامنة"
                        >
                            <SyncRow
                                label="المستخدمون المتصلون"
                                value={formatSyncTime(
                                    stats.onlineUsersLastSyncAt,
                                )}
                                tone="info"
                            />
                        </SectionCard>

                        <SectionCard
                            title="حالة مزامنة الأجهزة"
                            description="وقت آخر بيانات متاحة من مصدر المزامنة"
                        >
                            <SyncRow
                                label="الأجهزة المتصلة"
                                value={formatSyncTime(
                                    stats.onlineDevicesLastSyncAt,
                                )}
                                tone="success"
                            />
                        </SectionCard>
                    </section>

                    <SectionCard
                        title="مؤشرات التشغيل"
                        description="القيم الحالية التي يوفرها عقد Dashboard"
                    >
                        <div className="grid gap-4 sm:grid-cols-2">
                            <div className="rounded-xl border border-slate-100 p-4">
                                <p className="text-sm text-slate-500">
                                    الأجهزة المتصلة حسب آخر مزامنة
                                </p>

                                <p className="mt-2 text-2xl font-bold text-slate-900">
                                    {stats.onlineDevices.toLocaleString(
                                        "ar-EG",
                                    )}
                                </p>
                            </div>

                            <div className="rounded-xl border border-slate-100 p-4">
                                <p className="text-sm text-slate-500">
                                    المستخدمون النشطون
                                </p>

                                <p className="mt-2 text-2xl font-bold text-slate-900">
                                    {stats.activeUsers.toLocaleString(
                                        "ar-EG",
                                    )}
                                </p>

                                <p className="mt-1 text-xs text-slate-500">
                                    حالة الحسابات والاشتراكات، وليست مؤشرًا
                                    مباشرًا للاتصال الشبكي.
                                </p>
                            </div>
                        </div>
                    </SectionCard>
                </div>
            )}
        </main>
    );
}
