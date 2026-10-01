export interface SubscriptionCustomer {
    id: number;
    name: string;
    phone?: string | null;
}

export interface SubscriptionPackage {
    id: number;
    name: string;
}

export interface Subscription {
    id: number;
    tenant_id: number;
    customer_id: number;
    package_id: number;
    customer: SubscriptionCustomer | null;
    package: SubscriptionPackage | null;
    start_date: string | null;
    end_date: string | null;
    monthly_price: number;
    status: string;
    notes: string | null;
    pppoe_username: string | null;
    mikrotik_profile: string | null;
    created_at: string | null;
    updated_at: string | null;
}

export interface SubscriptionPaginationMetaLink {
    url: string | null;
    label: string;
    page: number | null;
    active: boolean;
}

export interface SubscriptionPaginationMeta {
    current_page: number;
    from: number | null;
    last_page: number;
    links: SubscriptionPaginationMetaLink[];
    path: string;
    per_page: number;
    to: number | null;
    total: number;
}

export interface SubscriptionPaginationLinks {
    first: string | null;
    last: string | null;
    prev: string | null;
    next: string | null;
}

export interface SubscriptionListResponse {
    data: Subscription[];
    links: SubscriptionPaginationLinks;
    meta: SubscriptionPaginationMeta;
}
