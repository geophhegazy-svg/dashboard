import type { ReactNode } from "react";

interface SectionCardProps {
    title: string;
    description?: string;
    children: ReactNode;
}

export function SectionCard({
    title,
    description,
    children,
}: SectionCardProps) {
    return (
        <section className="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div className="border-b border-slate-100 px-5 py-4">
                <h3 className="font-semibold text-slate-900">
                    {title}
                </h3>

                {description && (
                    <p className="mt-1 text-sm text-slate-500">
                        {description}
                    </p>
                )}
            </div>

            <div className="p-5">
                {children}
            </div>
        </section>
    );
}
