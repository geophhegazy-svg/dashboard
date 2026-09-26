interface PageHeaderProps {
    title: string;
    description?: string;
}

export function PageHeader({
    title,
    description,
}: PageHeaderProps) {
    return (
        <div className="mb-8">
            <h2 className="text-2xl font-bold text-slate-900">
                {title}
            </h2>

            {description && (
                <p className="mt-1 text-sm text-slate-500">
                    {description}
                </p>
            )}
        </div>
    );
}