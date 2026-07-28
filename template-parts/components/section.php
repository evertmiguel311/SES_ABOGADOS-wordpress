<?php
/**
 * Section — docs/biblioteca_componentes.md §1.
 *
 * Responsabilidad: dar el espaciado vertical y el color de fondo alterno
 * entre bloques consecutivos de una página (blanco / crema / niebla
 * azulada — docs/manual_marca.md §3, ritmo de secciones).
 *
 * Implementado como helper de clase, `ses_section_class( $background )`
 * (inc/template-tags.php) — mismo motivo que Container: envuelve contenido
 * arbitrario, no cabe como archivo de markup.
 *
 *   <section class="<?php echo esc_attr( ses_section_class( 'niebla' ) ); ?>">…</section>
 *
 * CSS: .section (blanco, ya existente) / .section-alt (crema, ya
 * existente) / .section-niebla (nuevo, mismo patrón que .section-alt con
 * --color-niebla-azul — assets/css/style.css).
 *
 * NOTA — fondo "azul oscuro" (grafito) sin implementar: hoy todo fondo
 * oscuro del sitio es Hero o Footer, componentes bespoke con su propio
 * forzado de color de texto; no hay todavía un uso real de una Section
 * oscura genérica. Se agrega cuando ese caso de uso exista (CLAUDE.md §5).
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;
