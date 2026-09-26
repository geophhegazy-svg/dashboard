interface StatusBadgeProps {
    label: string;
    tone?: "success" | "info" | "neutral";
}

const toneClasses = {
    success: "bg-emerald-50 text-emerald-700 ring-emerald-600/20",
    info: "bg-blue-50 text-blue-700 ring-blue-600/20",
    neutral: "bg-slate-100 text-slate-600 ring-slate-500/20",
};

export function StatusBadge({
    label,
    tone = "neutral",
}: StatusBadgeProps) {
    return (
        <span
            className={[
                "inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset",
                toneClasses[tone],
            ].join(" ")}
        >
            {label}
        </span>
    );
}
