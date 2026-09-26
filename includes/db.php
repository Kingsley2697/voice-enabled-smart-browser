<?php
declare(strict_types=1);

function database(): ?PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;

    $host = getenv('DB_HOST') ?: 'db';
    $port = getenv('DB_PORT') ?: '3306';
    $name = getenv('DB_NAME') ?: 'voice_browser';
    $user = getenv('DB_USER') ?: 'root';
    $password = getenv('DB_PASSWORD') ?: '';

    try {
        $pdo = new PDO("mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4", $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (PDOException $exception) {
        error_log('Database connection failed: ' . $exception->getMessage());
        return null;
    }
    return $pdo;
}

function saveSearch(string $query, string $method, array $result = []): void
{
    $pdo = database();
    if (!$pdo) return;
    $statement = $pdo->prepare(
        'INSERT INTO search_history (query, search_method, result_title, result_text, result_url, ip_address, device_name)
         VALUES (:query, :method, :title, :text, :url, :ip, :device)'
    );
    $statement->execute([
        'query' => $query,
        'method' => $method,
        'title' => $result['title'] ?? null,
        'text' => $result['text'] ?? null,
        'url' => $result['url'] ?? null,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? null,
        // Browsers do not expose a visitor's computer name; the user agent is stored instead.
        'device' => substr($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown device', 0, 255),
    ]);
}
