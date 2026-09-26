import {
    createContext,
    useCallback,
    useContext,
    useEffect,
    useMemo,
    useState,
    type ReactNode,
} from "react";

import {
    apiRequest,
    clearAccessToken,
    getAccessToken,
    setAccessToken,
} from "../api/client";

import type { LoginResponse, User } from "./types";

interface AuthContextValue {
    user: User | null;
    loading: boolean;
    isAuthenticated: boolean;
    login: (email: string, password: string) => Promise<void>;
    logout: () => Promise<void>;
}

const AuthContext = createContext<AuthContextValue | undefined>(undefined);

interface AuthProviderProps {
    children: ReactNode;
}

export function AuthProvider({ children }: AuthProviderProps) {
    const [user, setUser] = useState<User | null>(null);
    const [loading, setLoading] = useState(true);

    const loadCurrentUser = useCallback(async () => {
        const token = getAccessToken();

        if (!token) {
            setUser(null);
            setLoading(false);
            return;
        }

        try {
            const currentUser = await apiRequest<User>("/me");
            setUser(currentUser);
        } catch {
            clearAccessToken();
            setUser(null);
        } finally {
            setLoading(false);
        }
    }, []);

    useEffect(() => {
        void loadCurrentUser();
    }, [loadCurrentUser]);

    const login = useCallback(async (email: string, password: string) => {
        const response = await apiRequest<LoginResponse>("/login", {
            method: "POST",
            auth: false,
            body: JSON.stringify({
                email,
                password,
            }),
        });

        setAccessToken(response.token);
        setUser(response.user);
    }, []);

    const logout = useCallback(async () => {
        try {
            await apiRequest("/logout", {
                method: "POST",
            });
        } finally {
            clearAccessToken();
            setUser(null);
        }
    }, []);

    const value = useMemo<AuthContextValue>(
        () => ({
            user,
            loading,
            isAuthenticated: user !== null,
            login,
            logout,
        }),
        [user, loading, login, logout],
    );

    return (
        <AuthContext.Provider value={value}>
            {children}
        </AuthContext.Provider>
    );
}

export function useAuth(): AuthContextValue {
    const context = useContext(AuthContext);

    if (!context) {
        throw new Error("useAuth must be used inside AuthProvider");
    }

    return context;
}
