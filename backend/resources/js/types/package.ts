export interface Package {
    id: number;
    tenant_id: number;
    name: string;
    description: string | null;
    price: string | number;
    speed_download: number | null;
    speed_upload: number | null;
    billing_cycle: string | null;
    billing_interval: number | null;
    grace_days: number | null;
    auto_suspend: boolean | number;
    auto_expire: boolean | number;
    created_at: string | null;
    updated_at: string | null;
}

export interface PackagePaginationMetaLink {
    url: string | null;
    label: string;
    page: number | null;
    active: boolean;
}

export interface PackagePaginationMeta {
    current_page: number;
    from: number | null;
    last_page: number;
    links: PackagePaginationMetaLink[];
    path: string;
    per_page: number;
    to: number | null;
    total: number;
}

export interface PackagePaginationLinks {
    first: string | null;
    last: string | null;
    prev: string | null;
    next: string | null;
}

export interface PackageListResponse {
    data: Package[];
    links: PackagePaginationLinks;
    meta: PackagePaginationMeta;
}