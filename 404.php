<?php
/**
 * Página 404 (docs/biblioteca_componentes.md §9 — Página 404).
 *
 * Estructura base funcional y accesible: siempre ofrece un enlace de
 * vuelta a Inicio. El tratamiento visual final se alinea con el resto
 * del sitio cuando se construyan las páginas; el comportamiento no
 * cambia.
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

	<main id="main" class="site-main site-main--404">
		<h1><?php esc_html_e( 'Página no encontrada', 'ses-abogados' ); ?></h1>
		<p><?php esc_html_e( 'La página que busca no existe o fue movida.', 'ses-abogados' ); ?></p>
		<p>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php esc_html_e( 'Volver a Inicio', 'ses-abogados' ); ?>
			</a>
		</p>
	</main>

<?php
get_footer();
