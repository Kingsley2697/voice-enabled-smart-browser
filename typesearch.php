<?php
declare(strict_types=1);
require __DIR__ . '/config/config.php';
require __DIR__ . '/includes/db.php';
session_start();

function fetchSearchResult(string $query): array
{
    $parameters = http_build_query([
        'action' => 'query',
        'format' => 'json',
        'list' => 'search',
        'srsearch' => $query,
        'srlimit' => 1,
        'utf8' => 1,
        'origin' => '*',
    ]);
    $curl = curl_init(WIKIPEDIA_API_URL . '?' . $parameters);
    curl_setopt_array($curl, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 8, CURLOPT_USERAGENT => 'VoiceBrowser/1.0']);
    $response = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);

    if ($response === false || $error) {
        return ['title' => 'Search service unavailable', 'text' => 'We could not fetch a result right now. Please check your connection and try again.', 'url' => ''];
    }
    $data = json_decode($response, true);
    $item = $data['query']['search'][0] ?? null;
    if (!$item) {
        return ['title' => 'No result found', 'text' => "No encyclopedia result was found for {$query}.", 'url' => ''];
    }
    $title = (string)$item['title'];
    return [
        'title' => $title,
        'text' => trim(html_entity_decode(strip_tags((string)$item['snippet']), ENT_QUOTES | ENT_HTML5, 'UTF-8')),
        'url' => 'https://en.wikipedia.org/wiki/' . rawurlencode(str_replace(' ', '_', $title)),
    ];
}

$query = trim((string)($_GET['q'] ?? ''));
if ($query !== '') {
    $query = substr($query, 0, 500);
    $result = fetchSearchResult($query);
    $_SESSION['searchTerm'] = $query;
    $_SESSION['searchResult'] = $result;
    saveSearch($query, (string)($_GET['method'] ?? 'typed'), $result);
    $pageTitle = 'Search Result | VoiceBrowser';
    require __DIR__ . '/includes/header.php';
    ?>
    <main class="page-content"><p class="eyebrow">SEARCH RESULT</p><p class="search-term">Results for “<?= htmlspecialchars($query, ENT_QUOTES, 'UTF-8') ?>”</p>
      <article class="result-card"><h1><?= htmlspecialchars($result['title'], ENT_QUOTES, 'UTF-8') ?></h1><p class="lead"><?= htmlspecialchars($result['text'], ENT_QUOTES, 'UTF-8') ?></p>
      <?php if ($result['url']): ?><a class="text-link" href="<?= htmlspecialchars($result['url'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener">Read more on Wikipedia ↗</a><?php endif; ?></article>
      <div class="result-actions"><a class="button" href="hearsearchresult.php">Hear this result</a><a class="button secondary" href="typesearch.php">New search</a></div>
    </main>
    <?php require __DIR__ . '/includes/footer.php';
    exit;
}
$pageTitle = 'Type Search | VoiceBrowser';
require __DIR__ . '/includes/header.php';
?>
<main class="page-content centered"><p class="eyebrow">TEXT SEARCH</p><h1>What are you looking for?</h1><form class="search-form" method="get" action="typesearch.php"><label for="q">Search term</label><div><input id="q" name="q" type="search" placeholder="Try: weather today" autocomplete="off" required autofocus><button class="button" type="submit">Search</button></div></form><a class="text-link" href="speaksearch.php">Use voice search instead</a></main>
<?php require __DIR__ . '/includes/footer.php'; ?>
