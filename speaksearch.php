<?php $pageTitle = 'Voice Search | VoiceBrowser'; require __DIR__ . '/includes/header.php'; ?>
<main class="page-content centered">
  <p class="eyebrow">VOICE SEARCH</p><h1>Say what you want to find.</h1>
  <p class="lead">Press the microphone, then speak clearly. Your search will begin automatically.</p>
  <button id="start-listening" class="mic-button" type="button" aria-label="Start voice search">🎙</button>
  <p id="recognition-status" class="status" aria-live="polite">Ready to listen.</p>
  <p id="transcript" class="transcript" aria-live="polite"></p>
  <a class="text-link" href="typesearch.php">Prefer to type instead?</a>
</main>
<script src="assets/js/speech.js"></script>
<?php require __DIR__ . '/includes/footer.php'; ?>
