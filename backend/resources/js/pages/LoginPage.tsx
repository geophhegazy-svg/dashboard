import { FormEvent, useState } from "react";
import { Navigate, useLocation, useNavigate } from "react-router-dom";

import { useAuth } from "../auth/AuthContext";

export function LoginPage() {
    const { isAuthenticated, login } = useAuth();

    const navigate = useNavigate();
    const location = useLocation();

    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [error, setError] = useState("");
    const [submitting, setSubmitting] = useState(false);

    if (isAuthenticated) {
        return <Navigate to="/dashboard" replace />;
    }

    async function handleSubmit(event: FormEvent<HTMLFormElement>) {
        event.preventDefault();

        setError("");
        setSubmitting(true);

        try {
            await login(email, password);

            const state = location.state as
                | { from?: { pathname?: string } }
                | null;

            const destination = state?.from?.pathname ?? "/dashboard";

            navigate(destination, { replace: true });
        } catch (exception) {
            setError(
                exception instanceof Error
                    ? exception.message
                    : "Unable to sign in.",
            );
        } finally {
            setSubmitting(false);
        }
    }

    return (
        <main
            dir="rtl"
            className="flex min-h-screen items-center justify-center bg-slate-950 px-4"
        >
            <section className="w-full max-w-md rounded-2xl bg-white p-8 shadow-2xl">
                <div className="mb-8 text-center">
                    <div className="mb-3 text-3xl font-bold text-slate-900">
                        EgyptNet
                    </div>

                    <p className="text-sm text-slate-500">
                        تسجيل الدخول إلى لوحة الإدارة
                    </p>
                </div>

                <form onSubmit={handleSubmit} className="space-y-5">
                    <div>
                        <label
                            htmlFor="email"
                            className="mb-2 block text-sm font-medium text-slate-700"
                        >
                            البريد الإلكتروني
                        </label>

                        <input
                            id="email"
                            type="email"
                            autoComplete="email"
                            required
                            value={email}
                            onChange={(event) => setEmail(event.target.value)}
                            className="w-full rounded-lg border border-slate-300 px-4 py-3 text-left outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                        />
                    </div>

                    <div>
                        <label
                            htmlFor="password"
                            className="mb-2 block text-sm font-medium text-slate-700"
                        >
                            كلمة المرور
                        </label>

                        <input
                            id="password"
                            type="password"
                            autoComplete="current-password"
                            required
                            value={password}
                            onChange={(event) =>
                                setPassword(event.target.value)
                            }
                            className="w-full rounded-lg border border-slate-300 px-4 py-3 text-left outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                        />
                    </div>

                    {error && (
                        <div className="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            {error}
                        </div>
                    )}

                    <button
                        type="submit"
                        disabled={submitting}
                        className="w-full rounded-lg bg-slate-900 px-4 py-3 font-medium text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        {submitting ? "جاري تسجيل الدخول..." : "تسجيل الدخول"}
                    </button>
                </form>
            </section>
        </main>
    );
}
