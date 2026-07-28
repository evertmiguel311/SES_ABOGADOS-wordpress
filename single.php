<?php
/**
 * Artículo individual de Actualidad Jurídica (`/actualidad-juridica/{slug}`).
 *
 * Resuelve la ruta de entrada individual en la jerarquía de plantillas
 * (docs/wordpress.md §10). Estructura base: título, metaética simple e
 * imagen destacada. El Article Meta block completo, el Sidebar de
 * relacionados y el tratamiento editorial del diseño aprobado
 * (docs/articulos.md, docs/biblioteca_componentes.md) se agregan al
 * construir el blog (Sprint 7, docs/roadmap.md).
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

	<main id="main" class="site-main site-main--single">
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<div class="entry-meta">
						<span class="entry-date"><?php echo esc_html( get_the_date() ); ?></span>
						<span class="entry-categories"><?php the_category( ', ' ); ?></span>
					</div>
				</header>

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="entry-thumbnail">
						<?php the_post_thumbnail( 'ses-article-hero' ); ?>
					</div>
				<?php endif; ?>

				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; ?>
	</main>

<?php
get_footer();
