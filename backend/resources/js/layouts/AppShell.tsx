import { useState } from "react";
import { Outlet } from "react-router-dom";

import { useAuth } from "../auth/AuthContext";
import { AppNavigation } from "../components/navigation/AppNavigation";

export function AppShell() {
    const { user, logout } = useAuth();
    const [mobileNavigationOpen, setMobileNavigationOpen] =
        useState(false);

    function closeMobileNavigation() {
        setMobileNavigationOpen(false);
    }

    return (
        <div
            dir="rtl"
            className="min-h-screen bg-slate-100 text-slate-900 lg:flex"
        >
            {mobileNavigationOpen && (
                <button
                    type="button"
                    aria-label="إغلاق القائمة الجانبية"
                    className="fixed inset-0 z-40 bg-slate-950/40 lg:hidden"
                    onClick={closeMobileNavigation}
                />
            )}

            <aside
                className={[
                    "fixed inset-y-0 right-0 z-50 flex w-72 flex-col border-l border-slate-200 bg-white shadow-xl transition-transform duration-200 lg:static lg:z-auto lg:w-64 lg:translate-x-0 lg:shadow-none",
                    mobileNavigationOpen
                        ? "translate-x-0"
                        : "translate-x-full",
                ].join(" ")}
            >
                <div className="flex items-center justify-between border-b border-slate-200 px-5 py-5">
                    <div>
                        <h1 className="text-xl font-bold tracking-tight text-slate-900">
                            EgyptNet
                        </h1>

                        <p className="mt-1 text-xs text-slate-500">
                            Enterprise ISP Platform
                        </p>
                    </div>

                    <button
                        type="button"
                        aria-label="إغلاق القائمة"
                        className="rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-900 lg:hidden"
                        onClick={closeMobileNavigation}
                    >
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div className="flex-1 overflow-y-auto p-4">
                    <AppNavigation
                        onNavigate={closeMobileNavigation}
                    />
                </div>

                <div className="border-t border-slate-200 p-4">
                    <p className="truncate text-sm font-medium text-slate-900">
                        {user?.name ?? user?.email}
                    </p>

                    {user?.name && (
                        <p className="mt-1 truncate text-xs text-slate-500">
                            {user.email}
                        </p>
                    )}
                </div>
            </aside>

            <div className="flex min-h-screen min-w-0 flex-col lg:mr-0">
                <header className="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur">
                    <div className="flex min-h-16 items-center justify-between gap-4 px-4 sm:px-6">
                        <div className="flex min-w-0 items-center gap-3">
                            <button
                                type="button"
                                aria-label="فتح القائمة الرئيسية"
                                aria-expanded={mobileNavigationOpen}
                                className="rounded-xl border border-slate-200 p-2.5 text-slate-600 hover:bg-slate-50 hover:text-slate-900 lg:hidden"
                                onClick={() =>
                                    setMobileNavigationOpen(true)
                                }
                            >
                                <span
                                    aria-hidden="true"
                                    className="text-lg leading-none"
                                >
                                    ☰
                                </span>
                            </button>

                            <div className="min-w-0">
                                <p className="text-xs text-slate-500">
                                    الحساب الحالي
                                </p>

                                <p className="truncate text-sm font-semibold text-slate-900 sm:text-base">
                                    {user?.name ?? user?.email}
                                </p>
                            </div>
                        </div>

                        <button
                            type="button"
                            onClick={() => void logout()}
                            className="shrink-0 rounded-xl border border-slate-300 px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-50 sm:px-4 sm:text-sm"
                        >
                            تسجيل الخروج
                        </button>
                    </div>
                </header>

                <main className="min-w-0 flex-1">
                    <Outlet />
                </main>
            </div>
        </div>
    );
}
