export interface Invoice {
    id: number;
    invoice_number: string;
    customer: string | null;
    amount: string | number;
    status: string;
    paid_at: string | null;
    due_date: string | null;
}

export interface InvoicePaginationMetaLink {
    url: string | null;
    label: string;
    page: number | null;
    active: boolean;
}

export interface InvoicePaginationMeta {
    current_page: number;
    from: number | null;
    last_page: number;
    links: InvoicePaginationMetaLink[];
    path: string;
    per_page: number;
    to: number | null;
    total: number;
}

export interface InvoicePaginationLinks {
    first: string | null;
    last: string | null;
    prev: string | null;
    next: string | null;
}

export interface InvoiceListResponse {
    data: Invoice[];
    links: InvoicePaginationLinks;
    meta: InvoicePaginationMeta;
}
