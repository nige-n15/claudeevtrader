export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
    role: string;
    dealer_id?: number | null;
    current_dealer_id?: number | null;
    is_admin: boolean;
    is_dealer: boolean;
    is_customer: boolean;
    can_access_dealer_dashboard: boolean;
}

export interface Dealer {
    id: number;
    name: string;
    trading_name?: string;
    email?: string;
    phone?: string;
    website?: string;
    city?: string;
    county?: string;
    postcode?: string;
    country?: string;
    status: string;
    vehicles_count?: number;
    leads_count?: number;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User | null;
        active_dealer?: Dealer | null;
    };
};
