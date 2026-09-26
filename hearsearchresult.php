<?php
session_start();
$pageTitle = 'Hear Search | VoiceBrowser';
$term = $_SESSION['searchTerm'] ?? '';
$savedResult = $_SESSION['searchResult'] ?? null;
require __DIR__ . '/includes/header.php';
?>
<main class="page-content centered"><p class="eyebrow">LISTENING MODE</p><h1>Hear your last search.</h1>
  <?php if ($savedResult): ?>
    <p id="result-text" class="lead">For <?= htmlspecialchars($term, ENT_QUOTES, 'UTF-8') ?>: <?= htmlspecialchars($savedResult['title'], ENT_QUOTES, 'UTF-8') ?>. <?= htmlspecialchars($savedResult['text'], ENT_QUOTES, 'UTF-8') ?></p>
    <button id="speak-result" class="button" type="button">Read aloud</button><button id="stop-speaking" class="button secondary" type="button">Stop</button>
  <?php else: ?>
    <p id="result-text" class="lead">No recent search is available yet. Search for something first.</p><a class="button" href="typesearch.php">Start a search</a>
  <?php endif; ?>
</main>
<script src="assets/js/speech.js"></script>
<?php require __DIR__ . '/includes/footer.php'; ?>
