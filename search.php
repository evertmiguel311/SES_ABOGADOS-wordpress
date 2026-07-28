<?php
/**
 * Resultados de búsqueda.
 *
 * Cubre desde ya el criterio de aceptación de Sprint 7 "el buscador
 * muestra un mensaje claro si no hay coincidencias" (docs/roadmap.md),
 * porque es comportamiento genérico de WordPress, no ligado al diseño de
 * página que todavía no se construye en esta fase.
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

	<main id="main" class="site-main site-main--search">
		<header class="archive-header">
			<h1 class="archive-title">
				<?php
				printf(
					/* translators: %s: término buscado. */
					esc_html__( 'Resultados de búsqueda para: %s', 'ses-abogados' ),
					'<span>' . get_search_query() . '</span>'
				);
				?>
			</h1>
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
			<p><?php esc_html_e( 'No se encontraron resultados para su búsqueda. Intente con otros términos.', 'ses-abogados' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</main>

<?php
get_footer();
