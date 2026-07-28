# SES Abogados — Tema WordPress

Repositorio público de código del tema WordPress a medida para **SIERRA ELLES & SALGADO ABOGADOS S.A.S.** (SES Abogados), firma jurídica full-service con sede en Cartagena y cobertura nacional.

Este repositorio contiene únicamente los archivos del tema (equivalente al contenido de `wp-content/themes/ses-abogados/` en una instalación WordPress). La documentación de producto, diseño, contenido del cliente y decisiones internas del proyecto viven en un repositorio privado aparte.

Es un producto separado del [prototipo estático](https://github.com/evertmiguel311/SES_ABOGADOS-sitio) usado para revisión de diseño con el cliente — no lo reemplaza ni se publica sobre él.

## Stack

- WordPress tradicional (no headless) + Gutenberg, con `theme.json` para paleta/tipografía/espaciado
- PHP 8.x
- CSS/JS propios (sin frameworks de build)
- ACF Pro (Options Pages + campos, vía `acf-json/`)

## Instalación

Copiar el contenido de este repositorio en `wp-content/themes/ses-abogados/` de una instalación WordPress (mínimo WP 6.4, PHP 8.0), y activar el tema desde Apariencia → Temas.

## Estructura

```
assets/                     CSS, JS, fuentes e imágenes
inc/                         Lógica organizada por responsabilidad (setup, enqueue, CPT, taxonomías, widgets, ACF, seguridad)
template-parts/components/  Partials reutilizables (navbar, footer, mega menú, etc.)
acf-json/                    Grupos de campos de ACF versionados como JSON
theme.json                   Paleta, tipografía, espaciado y ajustes del editor de bloques
```

## Estado

En construcción por sprints — ver documentación interna del proyecto para el roadmap completo.
