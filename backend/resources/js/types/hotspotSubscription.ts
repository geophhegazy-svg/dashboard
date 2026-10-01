export interface HotspotSubscriptionCustomer {
    id: number;
    name: string;
    phone?: string | null;
}

export interface HotspotSubscriptionPackage {
    id: number;
    name: string;
}

export interface HotspotSubscription {
    id: number;
    tenant_id: number;
    customer_id: number;
    package_id: number;
    customer: HotspotSubscriptionCustomer | null;
    package: HotspotSubscriptionPackage | null;
    hotspot_username: string;
    hotspot_password?: string | null;
    mikrotik_profile: string;
    start_date: string | null;
    end_date: string | null;
    monthly_price: number | string;
    status: "active" | "expired" | "suspended" | string;
    created_at: string | null;
    updated_at: string | null;
}

export interface HotspotSubscriptionPaginationMetaLink {
    url: string | null;
    label: string;
    page: number | null;
    active: boolean;
}

export interface HotspotSubscriptionPaginationMeta {
    current_page: number;
    from: number | null;
    last_page: number;
    links: HotspotSubscriptionPaginationMetaLink[];
    path: string;
    per_page: number;
    to: number | null;
    total: number;
}

export interface HotspotSubscriptionPaginationLinks {
    first: string | null;
    last: string | null;
    prev: string | null;
    next: string | null;
}

export interface HotspotSubscriptionListResponse {
    data: HotspotSubscription[];
    links: HotspotSubscriptionPaginationLinks;
    meta: HotspotSubscriptionPaginationMeta;
}
