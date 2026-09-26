document.addEventListener('DOMContentLoaded', () => {
  document.documentElement.classList.add('js-ready');

  const toggle = document.querySelector('.menu-toggle');
  const navigation = document.querySelector('.site-navigation');
  if (!toggle || !navigation) return;

  toggle.addEventListener('click', () => {
    const isOpen = toggle.getAttribute('aria-expanded') === 'true';
    toggle.setAttribute('aria-expanded', String(!isOpen));
    navigation.classList.toggle('is-open', !isOpen);
  });

  navigation.querySelectorAll('a').forEach(link => link.addEventListener('click', () => {
    toggle.setAttribute('aria-expanded', 'false');
    navigation.classList.remove('is-open');
  }));
});
