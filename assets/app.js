import 'bootstrap';
import './styles/app.scss';

// small smooth scroll + active link helper
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('a.nav-link').forEach(a => {
    if (a.href === window.location.href) a.classList.add('active');
  });
});
