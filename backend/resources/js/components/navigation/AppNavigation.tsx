import { NavLink } from "react-router-dom";

const navigationItems = [
    {
        label: "\u0644\u0648\u062d\u0629 \u0627\u0644\u062a\u062d\u0643\u0645",
        to: "/dashboard",
    },
    {
        label: "\u0627\u0644\u0639\u0645\u0644\u0627\u0621",
        to: "/customers",
    },
];

export function AppNavigation() {
    return (
        <nav
            aria-label="\u0627\u0644\u062a\u0646\u0642\u0644 \u0627\u0644\u0631\u0626\u064a\u0633\u064a"
            className="space-y-1"
        >
            {navigationItems.map((item) => (
                <NavLink
                    key={item.to}
                    to={item.to}
                    className={({ isActive }) =>
                        [
                            "block rounded-lg px-4 py-3 text-sm font-medium transition",
                            isActive
                                ? "bg-slate-900 text-white"
                                : "text-slate-600 hover:bg-slate-100 hover:text-slate-900",
                        ].join(" ")
                    }
                >
                    {item.label}
                </NavLink>
            ))}
        </nav>
    );
}