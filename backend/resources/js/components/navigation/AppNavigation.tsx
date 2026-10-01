import { NavLink } from "react-router-dom";

interface AppNavigationProps {
    onNavigate?: () => void;
}

interface NavigationItem {
    label: string;
    to: string;
}

interface NavigationGroup {
    label: string;
    items: NavigationItem[];
}

const navigationGroups: NavigationGroup[] = [
    {
        label: "الرئيسية",
        items: [
            {
                label: "لوحة التحكم",
                to: "/dashboard",
            },
        ],
    },
    {
        label: "إدارة العملاء",
        items: [
            {
                label: "العملاء",
                to: "/customers",
            },
            {
                label: "الباقات",
                to: "/packages",
            },
            {
                label: "الاشتراكات",
                to: "/subscriptions",
            },
            {
                label: "اشتراكات Hotspot",
                to: "/hotspot-subscriptions",
            },
        ],
    },
    {
        label: "الفوترة",
        items: [
            {
                label: "الفواتير",
                to: "/invoices",
            },
        ],
    },
];

export function AppNavigation({
    onNavigate,
}: AppNavigationProps) {
    return (
        <nav
            aria-label="التنقل الرئيسي"
            className="space-y-6"
        >
            {navigationGroups.map((group) => (
                <section key={group.label}>
                    <h2 className="mb-2 px-3 text-xs font-semibold uppercase tracking-wide text-slate-400">
                        {group.label}
                    </h2>

                    <div className="space-y-1">
                        {group.items.map((item) => (
                            <NavLink
                                key={item.to}
                                to={item.to}
                                onClick={onNavigate}
                                className={({ isActive }) =>
                                    [
                                        "flex items-center rounded-xl px-4 py-3 text-sm font-medium transition",
                                        isActive
                                            ? "bg-slate-900 text-white shadow-sm"
                                            : "text-slate-600 hover:bg-slate-100 hover:text-slate-900",
                                    ].join(" ")
                                }
                            >
                                {item.label}
                            </NavLink>
                        ))}
                    </div>
                </section>
            ))}
        </nav>
    );
}
