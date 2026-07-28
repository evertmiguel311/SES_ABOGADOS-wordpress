<?php
/**
 * Container — docs/biblioteca_componentes.md §1.
 *
 * Responsabilidad: aplicar el ancho máximo y el padding lateral
 * consistente del sistema a cualquier bloque de contenido. No tiene
 * opinión sobre lo que envuelve.
 *
 * Implementado como helper de clase, `ses_container_class()`
 * (inc/template-tags.php), no como archivo con markup: Container envuelve
 * contenido arbitrario y get_template_part no tiene forma de recibir ese
 * contenido como "hijo" en PHP clásico. El llamador escribe su propio
 * `<div>`/`<section>` y pide aquí solo el nombre de clase:
 *
 *   <div class="<?php echo esc_attr( ses_container_class() ); ?>">…</div>
 *
 * CSS ya existente y sin cambios: .container / .container-wide
 * (assets/css/design-system.css).
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;
