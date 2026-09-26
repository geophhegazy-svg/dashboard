interface MetricCardProps {
    label: string;
    value: number | string;
    description?: string;
    tone?: "neutral" | "info" | "success";
}

const toneClasses = {
    neutral: "bg-slate-50 text-slate-900",
    info: "bg-blue-50 text-blue-700",
    success: "bg-emerald-50 text-emerald-700",
};

export function MetricCard({
    label,
    value,
    description,
    tone = "neutral",
}: MetricCardProps) {
    return (
        <article className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div className="flex items-start justify-between gap-4">
                <p className="text-sm font-medium text-slate-500">
                    {label}
                </p>

                <span
                    className={[
                        "rounded-lg px-2.5 py-1 text-xs font-medium",
                        toneClasses[tone],
                    ].join(" ")}
                >
                    مؤشر
                </span>
            </div>

            <p className="mt-4 text-3xl font-bold tracking-tight text-slate-900">
                {value.toLocaleString("ar-EG")}
            </p>

            {description && (
                <p className="mt-2 text-xs leading-5 text-slate-500">
                    {description}
                </p>
            )}
        </article>
    );
}
