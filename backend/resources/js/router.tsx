import { Navigate, Route, Routes } from "react-router-dom";

import { ProtectedRoute } from "./components/ProtectedRoute";
import { AppShell } from "./layouts/AppShell";
import { CustomersPage } from "./pages/CustomersPage";
import { DashboardPage } from "./pages/DashboardPage";
import { InvoicesPage } from "./pages/InvoicesPage";
import { LoginPage } from "./pages/LoginPage";
import { NetworkControlPage } from "./pages/NetworkControlPage";
import { NetworkQueuesPage } from "./pages/NetworkQueuesPage";
import { NetworkDhcpPage } from "./pages/NetworkDhcpPage";
import { NetworkFirewallPage } from "./pages/NetworkFirewallPage";
import { PackagesPage } from "./pages/PackagesPage";
import { SubscriptionsPage } from "./pages/SubscriptionsPage";
import { HotspotSubscriptionsPage } from "./pages/HotspotSubscriptionsPage";
import { SubscriberOnboardingPage } from "./pages/SubscriberOnboardingPage";

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
                        path="/network"
                        element={<NetworkControlPage />}
                    />
                    <Route
                        path="/network/queues"
                        element={<NetworkQueuesPage />}
                    />
                    <Route
                        path="/network/dhcp"
                        element={<NetworkDhcpPage />}
                    />
                    <Route
                        path="/network/firewall"
                        element={<NetworkFirewallPage />}
                    />

                    <Route
                        path="/customers"
                        element={<CustomersPage />}
                    />

                    <Route
                        path="/subscriber-onboarding"
                        element={<SubscriberOnboardingPage />}
                    />

                    <Route
                        path="/packages"
                        element={<PackagesPage />}
                    />

                    <Route
                        path="/invoices"
                        element={<InvoicesPage />}
                    />

                    <Route
                        path="/subscriptions"
                        element={<SubscriptionsPage />}
                    />

                    <Route
                        path="/hotspot-subscriptions"
                        element={<HotspotSubscriptionsPage />}
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
