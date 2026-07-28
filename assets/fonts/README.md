# assets/fonts

Carpeta reservada para auto-hospedar Cormorant Garamond e Inter (en vez de cargarlas desde Google Fonts) como optimización de Core Web Vitals — ver `docs/roadmap.md` Sprint 9 y `CLAUDE.md` §7 (SEO/rendimiento).

Mientras esa optimización no se haga, las fuentes se cargan vía Google Fonts CDN (`inc/enqueue.php`), igual que en el prototipo aprobado. Cuando se auto-hospeden: agregar los archivos `.woff2` aquí y declarar los `@font-face` correspondientes en `assets/css/style.css`.
