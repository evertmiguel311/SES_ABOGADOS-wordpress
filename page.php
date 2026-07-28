<?php
/**
 * Plantilla genérica de página.
 *
 * `page-{slug}.php` o una plantilla asignada por `Template Name` tiene
 * prioridad sobre esta cuando exista (docs/wordpress.md §10) — por
 * ejemplo `page-contacto.php` o `page-grupo-practica.php`, que se crean
 * junto con cada página real en su propio sprint. Esta plantilla cubre
 * cualquier página que todavía no tenga una propia.
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

	<main id="main" class="site-main">
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; ?>
	</main>

<?php
get_footer();
