export interface User {
    id: number;
    name: string;
    email: string;
    [key: string]: unknown;
}

export interface LoginResponse {
    token: string;
    user: User;
}
