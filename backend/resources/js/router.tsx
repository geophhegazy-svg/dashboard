import { Navigate, Route, Routes } from "react-router-dom";

import { ProtectedRoute } from "./components/ProtectedRoute";
import { AppShell } from "./layouts/AppShell";
import { DashboardPage } from "./pages/DashboardPage";
import { CustomersPage } from "./pages/CustomersPage";
import { LoginPage } from "./pages/LoginPage";
import { PackagesPage } from "./pages/PackagesPage";
import { InvoicesPage } from "./pages/InvoicesPage";

export function AppRouter() {
    return (
        <Routes>
            <Route path="/login" element={<LoginPage />} />

            <Route element={<ProtectedRoute />}>
                <Route element={<AppShell />}>
                    <Route
                        path="/dashboard"
                        element={<DashboardPage />}
                    />

                    <Route
                        path="/customers"
                        element={<CustomersPage />}
                    />

                    <Route
                        path="/packages"
                        element={<PackagesPage />}
                    />

                    <Route
                        path="/invoices"
                        element={<InvoicesPage />}
                    />
                </Route>
            </Route>

            <Route
                path="*"
                element={<Navigate to="/dashboard" replace />}
            />
        </Routes>
    );
}
