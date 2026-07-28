# Traducciones

Carpeta de destino de `load_theme_textdomain( 'ses-abogados', ... )` (ver `inc/setup.php`). Vacía a propósito: el proyecto es 100% español por ahora (CLAUDE.md §3), así que no hay un idioma alternativo que empaquetar todavía.

Cuando exista contenido en un segundo idioma, generar aquí:

- `ses-abogados.pot` — plantilla de traducción, con `wp i18n make-pot . languages/ses-abogados.pot` (WP-CLI) una vez el contenido esté cerrado.
- `ses-abogados-{locale}.po` / `.mo` — traducción compilada por idioma (p. ej. `ses-abogados-en_US.po`).

Todas las cadenas del tema ya usan el textdomain `ses-abogados` de forma consistente (verificado en la auditoría de cierre de Sprint 1), así que generar el `.pot` en ese momento es un solo comando, no una revisión de código.
