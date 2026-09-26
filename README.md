# Voice Enabled Smart Browser

A lightweight PHP web app that supports keyboard search, voice recognition, text-to-speech, and optional MySQL search-history storage. Search terms and result data are stored temporarily in the visitor's PHP session.

## Requirements

- Docker Desktop (recommended), or PHP 8.3 with the PDO MySQL extension
- A current Chromium browser for the best Web Speech API support

## Run locally with Docker

```bash
docker compose up --build
```

Open `http://localhost:8080`. The MySQL database starts automatically and initializes the `search_history` table from `database/schema.sql`.

## Environment variables

Copy `.env.example` to `.env` and set values appropriate for your environment:

- `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASSWORD` configure MySQL.
- `SEARCH_ENGINE_URL` selects the search provider URL prefix.

## Deploy to Render

1. Push this project to a Git repository.
2. Create a new **Web Service** in Render and select **Docker** as the runtime.
3. Add the database environment variables in the Render dashboard.
4. Point `DB_HOST` at your managed MySQL-compatible database host.

Voice recognition requires HTTPS in production and the visitor must allow microphone access. Search summaries are fetched from Wikipedia's public search API; an active internet connection is required.
