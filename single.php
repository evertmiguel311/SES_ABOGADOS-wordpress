<?php
/**
 * Artículo individual de Actualidad Jurídica (`/actualidad-juridica/{slug}`).
 *
 * Resuelve la ruta de entrada individual en la jerarquía de plantillas
 * (docs/wordpress.md §10). Estructura base: breadcrumb dinámico, título,
 * metaética simple e imagen destacada. El Article Meta block completo, el
 * Sidebar de relacionados y el tratamiento editorial del diseño aprobado
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
			<?php
			$ses_categorias = get_the_category();
			$ses_trail      = array(
				array( 'label' => __( 'Inicio', 'ses-abogados' ), 'url' => home_url( '/' ) ),
				array( 'label' => __( 'Actualidad Jurídica', 'ses-abogados' ), 'url' => home_url( '/actualidad-juridica/' ) ),
			);
			if ( ! empty( $ses_categorias ) ) {
				$ses_trail[] = array(
					'label' => $ses_categorias[0]->name,
					'url'   => get_category_link( $ses_categorias[0]->term_id ),
				);
			}
			$ses_trail[] = array( 'label' => get_the_title() );

			get_template_part(
				'template-parts/components/breadcrumb',
				null,
				array(
					'trail'         => $ses_trail,
					'wrapper_class' => 'article-breadcrumb',
				)
			);
			?>
			<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<div class="entry-meta">
						<span class="entry-date"><?php echo esc_html( get_the_date() ); ?></span>
						<span class="entry-categories"><?php the_category( ', ' ); ?></span>
						<span class="entry-reading-time"><?php echo esc_html( ses_get_reading_time( get_the_ID() ) ); ?></span>
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
