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

    return date.toLocaleString("en-US");
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
        <div className="flex flex-col gap-4 rounded-2xl border border-slate-100 bg-slate-50 p-4 sm:flex-row sm:items-center sm:justify-between">
            <div className="min-w-0">
                <p className="font-medium text-slate-900">{label}</p>

                <p className="mt-1 text-sm leading-6 text-slate-500">
                    {value}
                </p>
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
        <main
            dir="rtl"
            className="mx-auto max-w-7xl px-4 py-6 sm:px-6 sm:py-8"
        >
            <div className="space-y-8">
                <div className="flex flex-col gap-4 rounded-3xl border border-slate-200 bg-white px-5 py-6 shadow-sm sm:px-7">
                    <div className="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <PageHeader
                            title="لوحة التحكم"
                            description="نظرة تشغيلية على العملاء والأجهزة وبيانات المزامنة الأخيرة"
                        />

                        <StatusBadge
                            label="ملخص تشغيلي"
                            tone="info"
                        />
                    </div>
                </div>

                {loading && <LoadingState />}

                {error && (
                    <Alert variant="error">
                        {error}
                    </Alert>
                )}

                {!loading && !error && stats && (
                    <>
                        <section>
                            <div className="mb-4">
                                <h2 className="text-lg font-bold text-slate-900">
                                    المؤشرات الرئيسية
                                </h2>

                                <p className="mt-1 text-sm text-slate-500">
                                    ملخص للأرقام المتاحة من عقد Dashboard الحالي
                                </p>
                            </div>

                            <div className="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                                <MetricCard
                                    label="إجمالي المستخدمين"
                                    value={stats.totalUsers}
                                    eyebrow="قاعدة المستخدمين"
                                />

                                <MetricCard
                                    label="المستخدمون المتصلون"
                                    value={stats.onlineUsers}
                                    description={`آخر مزامنة: ${formatSyncTime(
                                        stats.onlineUsersLastSyncAt,
                                    )}`}
                                    tone="info"
                                    eyebrow="بيانات الشبكة المزامنة"
                                />

                                <MetricCard
                                    label="المستخدمون النشطون"
                                    value={stats.activeUsers}
                                    description="حالة الحسابات والاشتراكات النشطة"
                                    tone="success"
                                    eyebrow="حالة الحسابات"
                                />

                                <MetricCard
                                    label="إجمالي الأجهزة"
                                    value={stats.totalDevices}
                                    eyebrow="البنية الشبكية"
                                />
                            </div>
                        </section>

                        <section className="grid gap-6 lg:grid-cols-2">
                            <SectionCard
                                title="مزامنة المستخدمين"
                                description="آخر نقطة زمنية تتوفر منها بيانات المستخدمين"
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
                                title="مزامنة الأجهزة"
                                description="آخر نقطة زمنية تتوفر منها بيانات الأجهزة"
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
                            description="تفاصيل إضافية من عقد Dashboard الحالي"
                        >
                            <div className="grid gap-4 sm:grid-cols-2">
                                <div className="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                                    <p className="text-sm font-medium text-slate-500">
                                        الأجهزة المتصلة حسب آخر مزامنة
                                    </p>

                                    <p className="mt-3 text-3xl font-bold tracking-tight text-slate-950">
                                        {stats.onlineDevices.toLocaleString(
                                            "en-US",
                                        )}
                                    </p>

                                    <p className="mt-2 text-xs leading-5 text-slate-500">
                                        القيمة تعكس آخر بيانات مزامنة متاحة، وليست
                                        اتصالًا لحظيًا.
                                    </p>
                                </div>

                                <div className="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                                    <p className="text-sm font-medium text-slate-500">
                                        المستخدمون النشطون
                                    </p>

                                    <p className="mt-3 text-3xl font-bold tracking-tight text-slate-950">
                                        {stats.activeUsers.toLocaleString(
                                            "en-US",
                                        )}
                                    </p>

                                    <p className="mt-2 text-xs leading-5 text-slate-500">
                                        حالة الحسابات والاشتراكات، وليست مؤشرًا
                                        مباشرًا للاتصال الشبكي.
                                    </p>
                                </div>
                            </div>
                        </SectionCard>
                    </>
                )}
            </div>
        </main>
    );
}
