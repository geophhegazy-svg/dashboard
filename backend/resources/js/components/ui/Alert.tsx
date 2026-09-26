import type { HTMLAttributes } from "react";

interface AlertProps extends HTMLAttributes<HTMLDivElement> {
    variant?: "error" | "info" | "success";
}

const variantClasses = {
    error: "border-red-200 bg-red-50 text-red-700",
    info: "border-blue-200 bg-blue-50 text-blue-700",
    success: "border-green-200 bg-green-50 text-green-700",
};

export function Alert({
    variant = "info",
    className = "",
    ...props
}: AlertProps) {
    return (
        <div
            {...props}
            role="alert"
            className={[
                "rounded-xl border p-5 text-sm",
                variantClasses[variant],
                className,
            ].join(" ")}
        />
    );
}