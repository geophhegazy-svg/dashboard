interface MetricCardProps {
    label: string;
    value: number | string;
    description?: string;
    tone?: "neutral" | "info" | "success";
    eyebrow?: string;
}

const toneClasses = {
    neutral: {
        badge: "bg-slate-100 text-slate-600 ring-slate-500/20",
        accent: "bg-slate-900",
    },
    info: {
        badge: "bg-blue-50 text-blue-700 ring-blue-600/20",
        accent: "bg-blue-600",
    },
    success: {
        badge: "bg-emerald-50 text-emerald-700 ring-emerald-600/20",
        accent: "bg-emerald-600",
    },
};

export function MetricCard({
    label,
    value,
    description,
    tone = "neutral",
    eyebrow = "مؤشر تشغيلي",
}: MetricCardProps) {
    const classes = toneClasses[tone];

    return (
        <article className="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
            <div
                className={[
                    "absolute inset-y-0 right-0 w-1",
                    classes.accent,
                ].join(" ")}
            />

            <div className="flex items-start justify-between gap-4">
                <div>
                    <p className="text-xs font-semibold text-slate-400">
                        {eyebrow}
                    </p>

                    <p className="mt-2 text-sm font-medium text-slate-600">
                        {label}
                    </p>
                </div>

                <span
                    className={[
                        "rounded-lg px-2.5 py-1 text-xs font-medium ring-1 ring-inset",
                        classes.badge,
                    ].join(" ")}
                >
                    {tone === "success"
                        ? "نشط"
                        : tone === "info"
                          ? "مزامنة"
                          : "إجمالي"}
                </span>
            </div>

            <p className="mt-5 text-3xl font-bold tracking-tight text-slate-950">
                {typeof value === "number"
                    ? value.toLocaleString("en-US")
                    : value}
            </p>

            {description && (
                <p className="mt-2 text-xs leading-5 text-slate-500">
                    {description}
                </p>
            )}
        </article>
    );
}
