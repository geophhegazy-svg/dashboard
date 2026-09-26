export interface Customer {
    id: number;
    tenant_id: number;
    name: string;
    phone: string;
    email: string | null;
    address: string | null;
    national_id: string | null;
    status: string;
    notes: string | null;
    created_at: string | null;
}

export interface CustomerPaginationMetaLink {
    url: string | null;
    label: string;
    page: number | null;
    active: boolean;
}

export interface CustomerPaginationMeta {
    current_page: number;
    from: number | null;
    last_page: number;
    links: CustomerPaginationMetaLink[];
    path: string;
    per_page: number;
    to: number | null;
    total: number;
}

export interface CustomerPaginationLinks {
    first: string | null;
    last: string | null;
    prev: string | null;
    next: string | null;
}

export interface CustomerListResponse {
    data: Customer[];
    links: CustomerPaginationLinks;
    meta: CustomerPaginationMeta;
}