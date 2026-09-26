(() => {
  const recognitionConstructor = window.SpeechRecognition || window.webkitSpeechRecognition;
  const transcript = document.getElementById('transcript');
  const status = document.getElementById('recognition-status');
  const listenButton = document.getElementById('start-listening');

  function setLastSearch(value) {
    localStorage.setItem('voiceBrowserLastSearch', value);
  }

  if (listenButton) {
    if (!recognitionConstructor) {
      listenButton.disabled = true;
      status.textContent = 'Speech recognition is not supported in this browser. Please use typed search.';
    } else {
      const recognition = new recognitionConstructor();
      recognition.lang = 'en-US';
      recognition.interimResults = false;
      recognition.maxAlternatives = 1;
      listenButton.addEventListener('click', () => recognition.start());
      recognition.onstart = () => { listenButton.classList.add('is-listening'); status.textContent = 'Listening…'; };
      recognition.onerror = event => { status.textContent = `Voice search error: ${event.error}. Please try again.`; };
      recognition.onend = () => listenButton.classList.remove('is-listening');
      recognition.onresult = event => {
        const query = event.results[0][0].transcript.trim();
        transcript.textContent = `You said: “${query}”`;
        status.textContent = 'Searching…';
        setLastSearch(query);
        window.location.assign(`typesearch.php?q=${encodeURIComponent(query)}&method=voice`);
      };
    }
  }

  const result = document.getElementById('result-text');
  document.getElementById('speak-result')?.addEventListener('click', () => {
    if (!window.speechSynthesis) return;
    window.speechSynthesis.cancel();
    window.speechSynthesis.speak(new SpeechSynthesisUtterance(result.textContent));
  });
  document.getElementById('stop-speaking')?.addEventListener('click', () => window.speechSynthesis?.cancel());
})();
