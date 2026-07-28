<?php
/**
 * Plantilla de respaldo genérica.
 *
 * WordPress exige index.php para considerar un tema válido. En la
 * práctica casi nunca se llega aquí: front-page.php, page.php,
 * single.php, archive.php y search.php cubren cada ruta real del sitio
 * (docs/wordpress.md §10, Template Hierarchy) — index.php solo entra en
 * juego si WordPress no encuentra ninguna plantilla más específica.
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

	<main id="main" class="site-main">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<p><?php esc_html_e( 'No se encontró contenido.', 'ses-abogados' ); ?></p>
		<?php endif; ?>
	</main>

<?php
get_footer();
