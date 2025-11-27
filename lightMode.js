// lightMode toggle - robust and persistent
document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('mode-toggle');
  const KEY = 'mode';

  function applyMode(enabled) {
    if (enabled) {
      document.documentElement.classList.add('light-mode');
      document.body.classList.add('light-mode');
      if (btn) {
        btn.textContent = 'Toggle Dark Mode';
        btn.setAttribute('aria-pressed', 'true');
      }
      try { localStorage.setItem(KEY, 'light'); } catch (e) {}
    } else {
      document.documentElement.classList.remove('light-mode');
      document.body.classList.remove('light-mode');
      if (btn) {
        btn.textContent = 'Toggle Light Mode';
        btn.setAttribute('aria-pressed', 'false');
      }
      try { localStorage.setItem(KEY, 'dark'); } catch (e) {}
    }
  }

  // initialize from storage or prefers-color-scheme
  let saved = null;
  try { saved = localStorage.getItem(KEY); } catch (e) { saved = null; }
  if (saved === 'light') {
    applyMode(true);
  } else if (saved === 'dark') {
    applyMode(false);
  } else {
    const prefersLight = window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches;
    applyMode(prefersLight);
  }

  if (!btn) return;
  btn.addEventListener('click', () => {
    const enabled = document.documentElement.classList.contains('light-mode') || document.body.classList.contains('light-mode');
    applyMode(!enabled);
  });
});
