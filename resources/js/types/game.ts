export type Game = {
    id: number;
    title: string;
    platform: string | null;
    genre: string | null;
    cover_url: string | null;
    steam_appid: number | null;
    source: 'steam' | 'manual';
    created_at: string;
    updated_at: string;
};
