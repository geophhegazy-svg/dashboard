import { Outlet } from "react-router-dom";

import { useAuth } from "../auth/AuthContext";
import { AppNavigation } from "../components/navigation/AppNavigation";

export function AppShell() {
    const { user, logout } = useAuth();

    return (
        <div dir="rtl" className="min-h-screen bg-slate-100">
            <div className="flex min-h-screen">
                <aside className="w-64 shrink-0 border-l border-slate-200 bg-white">
                    <div className="border-b border-slate-200 px-6 py-5">
                        <h1 className="text-xl font-bold text-slate-900">
                            EgyptNet
                        </h1>

                        <p className="mt-1 text-xs text-slate-500">
                            Enterprise ISP Platform
                        </p>
                    </div>

                    <div className="p-4">
                        <AppNavigation />
                    </div>
                </aside>

                <div className="flex min-w-0 flex-1 flex-col">
                    <header className="border-b border-slate-200 bg-white">
                        <div className="flex items-center justify-between px-6 py-4">
                            <div>
                                <p className="text-sm text-slate-500">
                                    المستخدم
                                </p>

                                <p className="font-medium text-slate-900">
                                    {user?.name ?? user?.email}
                                </p>
                            </div>

                            <button
                                type="button"
                                onClick={() => void logout()}
                                className="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                            >
                                تسجيل الخروج
                            </button>
                        </div>
                    </header>

                    <main className="flex-1">
                        <Outlet />
                    </main>
                </div>
            </div>
        </div>
    );
}