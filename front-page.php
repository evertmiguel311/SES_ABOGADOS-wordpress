<?php
/**
 * Home (`/`).
 *
 * Máxima prioridad en la jerarquía de plantillas de WordPress
 * (docs/wordpress.md §10) — siempre se resuelve aquí antes que en
 * index.php.
 *
 * Esta fase es solo la estructura base del tema (Sprint 3,
 * docs/roadmap.md — "WordPress instalado, tema base creado"). El
 * contenido real de Inicio (Hero, Value/Differentiator Item, Áreas de
 * práctica destacadas, bloque de Actualidad Jurídica, CTA —
 * docs/estructura_web.md §Inicio) se construye en Sprint 4 con los
 * partials ya reservados en template-parts/components/, sin cambiar el
 * diseño aprobado del prototipo.
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

	<main id="main" class="site-main site-main--front">
		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;

		// Testimonios: propuesta aprobada por el cliente el 2026-07-28 (ver
		// SES_ABOGADOS-sitio/prototipo). No imprime nada si el CPT
		// ses_testimonio todavía no tiene entradas publicadas.
		get_template_part( 'template-parts/components/testimonios-section' );
		?>
	</main>

<?php
get_footer();
