const API_BASE_URL = "/api";

const TOKEN_KEY = "egyptnet.access_token";

export function getAccessToken(): string | null {
    return localStorage.getItem(TOKEN_KEY);
}

export function setAccessToken(token: string): void {
    localStorage.setItem(TOKEN_KEY, token);
}

export function clearAccessToken(): void {
    localStorage.removeItem(TOKEN_KEY);
}

type ApiRequestOptions = RequestInit & {
    auth?: boolean;
};

export async function apiRequest<T>(
    path: string,
    options: ApiRequestOptions = {},
): Promise<T> {
    const { auth = true, headers, ...requestOptions } = options;

    const requestHeaders = new Headers(headers);

    requestHeaders.set("Accept", "application/json");

    if (
        requestOptions.body !== undefined &&
        !(requestOptions.body instanceof FormData)
    ) {
        requestHeaders.set("Content-Type", "application/json");
    }

    if (auth) {
        const token = getAccessToken();

        if (token) {
            requestHeaders.set("Authorization", `Bearer ${token}`);
        }
    }

    const response = await fetch(`${API_BASE_URL}${path}`, {
        ...requestOptions,
        headers: requestHeaders,
    });

    if (response.status === 401) {
        clearAccessToken();
    }

    const contentType = response.headers.get("content-type") ?? "";

    const payload = contentType.includes("application/json")
        ? await response.json()
        : await response.text();

    if (!response.ok) {
        const message =
            typeof payload === "object" &&
            payload !== null &&
            "message" in payload &&
            typeof payload.message === "string"
                ? payload.message
                : `API request failed with status ${response.status}`;

        throw new Error(message);
    }

    return payload as T;
}
