<?php
/**
 * Listado de Actualidad Jurídica (`/actualidad-juridica`) — Sprint 5
 * (estructura visual) + Sprint 6 (docs/roadmap.md, capa dinámica).
 *
 * Resuelve el archivo de `post` en la jerarquía de plantillas
 * (docs/wordpress.md §10). Ahora usa la query principal real
 * (`have_posts()`/`the_post()`) sobre `post` + `category` (relabeada
 * "Categoría Jurídica", inc/taxonomies.php) — ya no es un array
 * hardcodeado. Mientras no exista ningún artículo publicado (sitio recién
 * desplegado), se muestra el mismo contenido de ejemplo ya aprobado en el
 * prototipo como respaldo, para que la página nunca se vea vacía o rota
 * antes de que el Editor publique el primer artículo real (CLAUDE.md
 * §14, mismo criterio que ses_get_equipo_socios()).
 *
 * El filtro de categorías y la paginación siguen siendo Sprint 7
 * (docs/roadmap.md — "Blog: categorías, SEO, buscador"): aquí el filtro ya
 * lista las categorías reales, pero no filtra todavía (no hay JS/query var
 * conectado), y la paginación usa `the_posts_pagination()` solo cuando hay
 * posts reales.
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

get_header();

$ses_categorias_reales = get_categories( array( 'hide_empty' => false ) );

// Respaldo (Sprint 5): mismo contenido de ejemplo del prototipo aprobado.
$ses_articulos_demo = array(
	array(
		'title'        => __( 'Reforma al régimen societario: qué deben revisar las empresas en 2026', 'ses-abogados' ),
		'url'          => home_url( '/actualidad-juridica/reforma-regimen-societario-2026/' ),
		'category'     => __( 'Derecho Corporativo', 'ses-abogados' ),
		'image_url'    => 'https://picsum.photos/seed/ses-articulo-1/700/525',
		'date_display' => '12 jun 2026',
		'date_iso'     => '2026-06-12',
		'reading_time' => __( '5 min de lectura', 'ses-abogados' ),
	),
	array(
		'title'        => __( 'Titulación rural: rutas legales para regularizar predios', 'ses-abogados' ),
		'url'          => home_url( '/actualidad-juridica/titulacion-rural-regularizar-predios/' ),
		'category'     => __( 'Derecho Inmobiliario', 'ses-abogados' ),
		'image_url'    => 'https://picsum.photos/seed/ses-articulo-2/700/525',
		'date_display' => '28 may 2026',
		'date_iso'     => '2026-05-28',
		'reading_time' => __( '4 min de lectura', 'ses-abogados' ),
	),
	array(
		'title'        => __( 'Nuevas reglas de teletrabajo: implicaciones para el empleador', 'ses-abogados' ),
		'url'          => home_url( '/actualidad-juridica/nuevas-reglas-teletrabajo/' ),
		'category'     => __( 'Derecho Laboral', 'ses-abogados' ),
		'image_url'    => 'https://picsum.photos/seed/ses-articulo-3/700/525',
		'date_display' => '14 may 2026',
		'date_iso'     => '2026-05-14',
		'reading_time' => __( '6 min de lectura', 'ses-abogados' ),
	),
);
?>

	<main id="main" class="site-main site-main--archive">
		<?php
		get_template_part(
			'template-parts/components/breadcrumb',
			null,
			array(
				'trail' => array(
					array( 'label' => __( 'Inicio', 'ses-abogados' ), 'url' => home_url( '/' ) ),
					array( 'label' => __( 'Actualidad Jurídica', 'ses-abogados' ) ),
				),
			)
		);

		get_template_part(
			'template-parts/components/hero',
			null,
			array(
				'variant'  => 'interior',
				'eyebrow'  => __( 'Actualidad Jurídica', 'ses-abogados' ),
				'title'    => __( 'Análisis y perspectivas de nuestro equipo', 'ses-abogados' ),
				'subtitle' => __( 'Comentarios técnicos sobre reformas, jurisprudencia y tendencias regulatorias relevantes para empresas y personas naturales.', 'ses-abogados' ),
			)
		);
		?>

		<?php if ( $ses_categorias_reales ) : ?>
			<div class="filter-row reveal">
				<span class="filter-pill is-active"><?php esc_html_e( 'Todos', 'ses-abogados' ); ?></span>
				<?php foreach ( $ses_categorias_reales as $ses_categoria ) : ?>
					<span class="filter-pill"><?php echo esc_html( $ses_categoria->name ); ?></span>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<section class="<?php echo esc_attr( ses_section_class( 'white' ) ); ?>">
			<?php if ( have_posts() ) : ?>
				<?php
				$ses_articulos_items = array();
				$ses_index           = 0;
				while ( have_posts() ) :
					the_post();
					$ses_post_categories = get_the_category();
					$ses_articulos_items[] = array(
						'title'        => get_the_title(),
						'url'          => get_permalink(),
						'category'     => ! empty( $ses_post_categories ) ? $ses_post_categories[0]->name : __( 'Actualidad Jurídica', 'ses-abogados' ),
						'image_url'    => get_the_post_thumbnail_url( get_the_ID(), 'ses-article-card' ),
						'date_display' => get_the_date(),
						'date_iso'     => get_the_date( 'c' ),
						'reading_time' => ses_get_reading_time( get_the_ID() ),
						'reveal_delay' => $ses_index % 3,
					);
					++$ses_index;
				endwhile;
				get_template_part(
					'template-parts/components/card-grid',
					null,
					array(
						'items'      => $ses_articulos_items,
						'card_type'  => 'article',
						'grid_class' => 'blog-grid',
					)
				);
				the_posts_pagination();
				wp_reset_postdata();
				?>
			<?php else : ?>
				<?php
				/*
				 * Sin artículos publicados todavía: contenido de ejemplo del
				 * prototipo aprobado (Sprint 5), con paginación estática — no una
				 * página vacía mientras el Editor carga el primer artículo real.
				 */
				$ses_demo_items = array();
				foreach ( $ses_articulos_demo as $ses_index => $ses_articulo ) {
					$ses_demo_items[] = array_merge( $ses_articulo, array( 'reveal_delay' => $ses_index ) );
				}
				get_template_part(
					'template-parts/components/card-grid',
					null,
					array(
						'items'      => $ses_demo_items,
						'card_type'  => 'article',
						'grid_class' => 'blog-grid',
					)
				);
				?>
				<div class="pagination-row" aria-label="<?php esc_attr_e( 'Paginación de artículos', 'ses-abogados' ); ?>">
					<span class="page-btn is-active">1</span>
				</div>
			<?php endif; ?>
		</section>
	</main>

<?php
get_footer();
