<?php
/**
 * Testimonios — sección del Home (propuesta aprobada por el cliente el
 * 2026-07-28, validada primero en SES_ABOGADOS-sitio/prototipo). Consulta
 * los testimonios publicados (CPT `ses_testimonio`, inc/cpt-testimonios.php)
 * y los presenta en el carrusel de assets/css/style.css + assets/js/main.js.
 *
 * No se inventan testimonios de ejemplo aquí: si el cliente todavía no ha
 * cargado ninguno, la sección simplemente no se imprime — nunca un
 * placeholder falso en un sitio en producción.
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

$ses_testimonios_query = new WP_Query(
	array(
		'post_type'      => 'ses_testimonio',
		'post_status'    => 'publish',
		'posts_per_page' => 6,
		'orderby'        => 'menu_order date',
		'order'          => 'ASC',
	)
);

if ( ! $ses_testimonios_query->have_posts() ) {
	return;
}
?>
<section class="section-alt testimonios">
	<div class="testimonios-head reveal">
		<div class="eyebrow"><?php esc_html_e( 'Testimonios', 'ses-abogados' ); ?></div>
		<h2><?php esc_html_e( 'La confianza de nuestros clientes, nuestro mayor respaldo', 'ses-abogados' ); ?></h2>
		<p class="testimonios-intro"><?php esc_html_e( 'Más que resultados, construimos relaciones basadas en la confianza, el compromiso y la excelencia legal.', 'ses-abogados' ); ?></p>
	</div>

	<div class="testimonios-carousel reveal">
		<button type="button" class="testimonio-nav testimonio-prev" aria-label="<?php esc_attr_e( 'Testimonio anterior', 'ses-abogados' ); ?>">
			<svg width="8" height="14" viewBox="0 0 8 14" fill="none" aria-hidden="true"><path d="M7 1L1 7L7 13" stroke="currentColor" stroke-width="1.4"/></svg>
		</button>

		<div class="testimonios-track" role="list">
			<?php
			while ( $ses_testimonios_query->have_posts() ) :
				$ses_testimonios_query->the_post();
				get_template_part(
					'template-parts/components/testimonio-card',
					null,
					array( 'testimonio_id' => get_the_ID() )
				);
			endwhile;
			wp_reset_postdata();
			?>
		</div>

		<button type="button" class="testimonio-nav testimonio-next" aria-label="<?php esc_attr_e( 'Siguiente testimonio', 'ses-abogados' ); ?>">
			<svg width="8" height="14" viewBox="0 0 8 14" fill="none" aria-hidden="true"><path d="M1 1L7 7L1 13" stroke="currentColor" stroke-width="1.4"/></svg>
		</button>
	</div>

	<div class="testimonios-dots" role="tablist" aria-label="<?php esc_attr_e( 'Seleccionar testimonio', 'ses-abogados' ); ?>"></div>
</section>
