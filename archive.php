<?php
/**
 * Listado de Actualidad Jurídica (`/actualidad-juridica`).
 *
 * Resuelve el archivo de `post` en la jerarquía de plantillas
 * (docs/wordpress.md §10). Estructura base: título y lista simple. El
 * Article Card, el filtro por categoría/etiqueta y la Pagination con el
 * diseño aprobado se agregan en Sprint 7 (docs/roadmap.md).
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

	<main id="main" class="site-main site-main--archive">
		<header class="archive-header">
			<h1 class="archive-title"><?php esc_html_e( 'Actualidad Jurídica', 'ses-abogados' ); ?></h1>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="archive-list">
				<?php while ( have_posts() ) : the_post(); ?>
					<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
						<h2 class="entry-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<div class="entry-summary"><?php the_excerpt(); ?></div>
					</article>
				<?php endwhile; ?>
			</div>

			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Todavía no hay artículos publicados.', 'ses-abogados' ); ?></p>
		<?php endif; ?>
	</main>

<?php
get_footer();
