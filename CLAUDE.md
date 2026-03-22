# Playtime

Tracker de sessions de jeu vidéo avec synchronisation Steam automatique.

> Projet d'apprentissage — l'objectif est de monter en compétence sur Laravel 13, Inertia.js et Vue 3. Privilégier la lisibilité et les bonnes pratiques plutôt que l'optimisation prématurée.

## Stack technique

- **Backend** : Laravel 13
- **Frontend** : Vue 3 + Vite
- **Bridge** : Inertia.js
- **Base de données** : SQLite (dev), PostgreSQL (prod)
- **Auth** : Laravel Breeze (Inertia + Vue)

## Architecture

### Base de données

- `users` — compte utilisateur, contient `steam_id` et `steam_avatar_url`
- `games` — jeux (Steam ou saisie manuelle), contient `steam_appid`, `source` (steam/manual)
- `sessions` — sessions de jeu, contient `duration_min`, `source`, `mood` (1–5), `notes`, `played_at`
- `steam_snapshots` — snapshot quotidien du temps de jeu Steam par jeu (`total_minutes`, `snapped_at`)

### Mécanique Steam

L'API Steam ne fournit pas d'historique journalier. La stratégie :

1. Un job Laravel schedulé tourne chaque nuit
2. Il récupère le `total_minutes` de chaque jeu via l'API Steam
3. Il le stocke dans `steam_snapshots`
4. La différence entre deux snapshots consécutifs = durée de session du jour
5. Une `session` est générée automatiquement avec `source = steam`

### API Steam

- Endpoint bibliothèque : `api.steampowered.com/IPlayerService/GetOwnedGames`
- Endpoint infos jeu : `store.steampowered.com/api/appdetails?appids={steam_appid}`
- Clé API à stocker dans `.env` sous `STEAM_API_KEY`
- Login OAuth Steam via `laravel/socialite`

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

## Variables d'environnement

```
STEAM_API_KEY=
STEAM_REDIRECT_URI=http://playtime.test/auth/steam/callback
```

## Conventions

- Modèles en anglais, singular (`Game`, `Session`, `SteamSnapshot`)
- Pas d'API REST — tout passe par Inertia (props Laravel → composants Vue)
- Jobs dans `app/Jobs/`, Services dans `app/Services/`
- `SteamService` pour encapsuler tous les appels à l'API Steam
