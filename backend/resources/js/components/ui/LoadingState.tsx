interface LoadingStateProps {
    message?: string;
}

export function LoadingState({
    message = "جاري تحميل البيانات...",
}: LoadingStateProps) {
    return (
        <div className="rounded-xl border border-slate-200 bg-white p-8 text-center text-sm text-slate-500 shadow-sm">
            {message}
        </div>
    );
}