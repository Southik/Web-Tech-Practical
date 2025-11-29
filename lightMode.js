document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('mode-toggle');
  const KEY = 'mode';
  const html = document.documentElement;
  const body = document.body;

  function applyMode(light) {
    html.classList.toggle('light-mode', light);
    body.classList.toggle('light-mode', light);

    if (btn) {
        if (light) {
          btn.textContent = 'Toggle Dark Mode';
        } else {
          btn.textContent = 'Toggle Light Mode';
        }
      btn.setAttribute('aria-pressed', light);
      btn.setAttribute('aria-pressed', light);
    }

    //save option
    try {
      localStorage.setItem(KEY, light ? 'light' : 'dark');
    } catch (error) {
      console.error('Could not save mode to localStorage:', error);
    }
  }

  //check initial mode
  let saved;
  try {
    saved = localStorage.getItem(KEY);
  } catch (error) {
    console.warn('Could not read mode from localStorage:', error);
    saved = null;
  }

  let initial;

  if (saved === 'light') {
    initial = true;
  } else if (saved === 'dark') {
    initial = false;
  } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches) {
    initial = true;
  } else {
    initial = false;
  }


  applyMode(initial);

  if (btn) {
    btn.addEventListener('click', () => {
      const light = html.classList.contains('light-mode');
      applyMode(!light);
    });
  }
});
