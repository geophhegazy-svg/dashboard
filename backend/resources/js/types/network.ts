export interface NetworkDevice {
    id: number;
    name: string;
    type: string;
    status: string;
    is_online: boolean;
}

export interface PppoeUser {
    id?: string | number;
    name?: string;
    username?: string;
    profile?: string;
    service?: string;
    disabled?: boolean | string;
    comment?: string;
    local_address?: string;
    remote_address?: string;
    uptime?: string;
    "last-logged-out"?: string;
}

export interface HotspotUser {
    id?: string | number;
    name?: string;
    username?: string;
    profile?: string;
    disabled?: boolean | string;
    comment?: string;
    uptime?: string;
    "limit-uptime"?: string;
    "limit-bytes-total"?: string;
}

export type NetworkResourceTab = "pppoe" | "hotspot";
