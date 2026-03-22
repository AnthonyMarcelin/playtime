# Playtime — Plan de projet

## Schéma de base de données

### users

| Champ            | Type              |
| ---------------- | ----------------- |
| id               | PK                |
| name             | string            |
| email            | string            |
| steam_id         | string (nullable) |
| steam_avatar_url | string (nullable) |
| timestamps       | —                 |

### games

| Champ       | Type                 |
| ----------- | -------------------- |
| id          | PK                   |
| steam_appid | int (nullable)       |
| title       | string               |
| cover_url   | string (nullable)    |
| platform    | string               |
| genre       | string (nullable)    |
| source      | enum: steam / manual |
| timestamps  | —                    |

### sessions

| Champ        | Type                    |
| ------------ | ----------------------- |
| id           | PK                      |
| user_id      | FK → users              |
| game_id      | FK → games              |
| duration_min | int                     |
| source       | enum: steam / manual    |
| mood         | tinyint (1–5, nullable) |
| notes        | text (nullable)         |
| played_at    | datetime                |
| timestamps   | —                       |

### steam_snapshots

| Champ         | Type       |
| ------------- | ---------- |
| id            | PK         |
| user_id       | FK → users |
| steam_appid   | int        |
| total_minutes | int        |
| snapped_at    | datetime   |

---

## Stack technique

| Couche      | Techno         |
| ----------- | -------------- |
| Backend     | Laravel 13     |
| Bridge      | Inertia.js     |
| Frontend    | Vue 3 + Vite   |
| Auth        | Laravel Breeze |
| BDD dev     | SQLite         |
| BDD prod    | PostgreSQL     |
| API externe | Steam Web API  |

---

## Mécanique Steam (snapshots)

L'API Steam ne fournit pas d'historique journalier — seulement le temps de jeu total.

**Stratégie :**

1. Job schedulé chaque nuit (`SteamSyncJob`)
2. Récupération du `total_minutes` par jeu via l'API Steam
3. Stockage dans `steam_snapshots`
4. Diff entre J et J-1 = durée jouée dans la journée
5. Création automatique d'une `session` avec `source = steam`

---

## Sprints

### Sprint 1 — Base

- Auth (register / login)
- CRUD jeux en saisie manuelle
- Log de session rapide
- Liste des sessions
- Dashboard basique

### Sprint 2 — Steam

- Login OAuth Steam (Socialite)
- Import de la bibliothèque Steam
- Job schedulé quotidien (snapshot)
- Génération automatique des sessions
- Stats par jeu

### Sprint 3 — Fun

- Heatmap d'activité (type GitHub contributions)
- Mood tracker avec graphique
- Tops / palmarès
- Saisie manuelle pour jeux console
- Profil public

---

## API Steam

- Bibliothèque : `api.steampowered.com/IPlayerService/GetOwnedGames`
- Infos jeu : `store.steampowered.com/api/appdetails?appids={steam_appid}`
- Auth OAuth via `laravel/socialite`
- Clé API dans `.env` → `STEAM_API_KEY`
