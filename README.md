# SES Abogados — Tema WordPress

Repositorio público de código del tema WordPress a medida para **SIERRA ELLES & SALGADO ABOGADOS S.A.S.** (SES Abogados), firma jurídica full-service con sede en Cartagena y cobertura nacional.

Este repositorio contiene únicamente los archivos del tema (equivalente al contenido de `wp-content/themes/ses-abogados/` en una instalación WordPress). La documentación de producto, diseño, contenido del cliente y decisiones internas del proyecto viven en un repositorio privado aparte.

Es un producto separado del [prototipo estático](https://github.com/evertmiguel311/SES_ABOGADOS-sitio) usado para revisión de diseño con el cliente — no lo reemplaza ni se publica sobre él.

## Stack

- WordPress tradicional (no headless) + Gutenberg, con `theme.json` para paleta/tipografía/espaciado
- PHP 8.x
- CSS/JS propios (sin frameworks de build)
- ACF Pro (Options Pages + campos, vía `acf-json/`)

## Requisitos

- WordPress 6.4 o superior
- PHP 8.0 como mínimo; código verificado sin construcciones obsoletas en PHP 8.2+
- ACF Pro activo (los Options Pages y los campos vía `acf-json/` no hacen nada sin él; el tema no se rompe si falta — ver `inc/acf-options.php`)

## Instalación

Copiar el contenido de este repositorio en `wp-content/themes/ses-abogados/` de una instalación WordPress, y activar el tema desde Apariencia → Temas.

## Estructura

```
assets/css/design-system.css  Sistema de diseño: espaciado, tipografía, grid, formularios y utilidades reutilizables
assets/css/style.css          Tokens de marca (colores, sombras, radios, animaciones) + estilos por componente
assets/                       CSS, JS, fuentes e imágenes
inc/                          Lógica organizada por responsabilidad (setup, enqueue, CPT, taxonomías, widgets, ACF, seguridad)
template-parts/components/   Partials reutilizables (navbar, footer, mega menú, etc.)
acf-json/                     Grupos de campos de ACF versionados como JSON
languages/                    Traducciones (.pot/.po/.mo) — vacía hasta que exista un segundo idioma
theme.json                    Paleta, tipografía, espaciado y ajustes del editor de bloques
```

## Calidad de código

`phpcs.xml.dist` trae el ruleset de WordPress Coding Standards ya configurado (textdomain `ses-abogados`, `testVersion 8.0-`). Con PHP y Composer instalados:

```
composer require --dev wp-coding-standards/wpcs squizlabs/php_codesniffer
vendor/bin/phpcs
```

## Flujo de trabajo Git

Repositorio de un solo colaborador por ahora: todo el trabajo entra directo a `master`. Si se suma más de una persona escribiendo código a la vez, conviene abrir una rama `develop` como integración (feature branches → `develop` → `master` solo en releases estables) para no exponer `master` a trabajo a medias. No se crea todavía porque no hay flujo colaborativo real que la justifique — es una recomendación para el momento en que sí lo haya.

## Estado

En construcción por sprints — ver documentación interna del proyecto para el roadmap completo.
