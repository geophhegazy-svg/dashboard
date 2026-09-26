import type { HTMLAttributes } from "react";

interface CardProps extends HTMLAttributes<HTMLElement> {
    as?: "article" | "div";
}

export function Card({
    as = "article",
    className = "",
    ...props
}: CardProps) {
    const Component = as;

    return (
        <Component
            {...props}
            className={[
                "rounded-xl border border-slate-200 bg-white shadow-sm",
                className,
            ].join(" ")}
        />
    );
}