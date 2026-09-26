import { useEffect, useState } from "react";

import { apiRequest } from "../api/client";
import { Alert } from "../components/ui/Alert";
import { Card } from "../components/ui/Card";
import { LoadingState } from "../components/ui/LoadingState";
import { PageHeader } from "../components/ui/PageHeader";

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

    const cards = stats
        ? [
              {
                  label: "إجمالي المستخدمين",
                  value: stats.totalUsers,
              },
              {
                  label: "المستخدمون المتصلون حسب آخر مزامنة",
                  value: stats.onlineUsers,
                  description: `آخر مزامنة: ${formatSyncTime(
                      stats.onlineUsersLastSyncAt,
                  )}`,
              },
              {
                  label: "المستخدمون النشطون",
                  value: stats.activeUsers,
                  description:
                      "حالة الحسابات/الاشتراكات النشطة",
              },
              {
                  label: "إجمالي الأجهزة",
                  value: stats.totalDevices,
              },
              {
                  label: "الأجهزة المتصلة حسب آخر مزامنة",
                  value: stats.onlineDevices,
                  description: `آخر مزامنة: ${formatSyncTime(
                      stats.onlineDevicesLastSyncAt,
                  )}`,
              },
          ]
        : [];

    return (
        <main dir="rtl" className="mx-auto max-w-7xl px-6 py-8">
            <PageHeader
                title="نظرة عامة"
                description="ملخص تشغيلي مبني على آخر بيانات المزامنة المتاحة"
            />

            {loading && <LoadingState />}

            {error && <Alert variant="error">{error}</Alert>}

            {!loading && !error && stats && (
                <div className="grid gap-5 sm:grid-cols-2 lg:grid-cols-5">
                    {cards.map((card) => (
                        <Card key={card.label} className="p-6">
                            <p className="text-sm text-slate-500">
                                {card.label}
                            </p>

                            <p className="mt-3 text-3xl font-bold text-slate-900">
                                {card.value}
                            </p>

                            {card.description && (
                                <p className="mt-2 text-xs text-slate-500">
                                    {card.description}
                                </p>
                            )}
                        </Card>
                    ))}
                </div>
            )}
        </main>
    );
}