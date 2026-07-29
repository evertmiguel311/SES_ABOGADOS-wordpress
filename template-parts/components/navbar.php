<?php
/**
 * Navbar — docs/biblioteca_componentes.md §2.
 *
 * Orquesta logo, navegación principal (Dropdown + Mega Menu), CTA de
 * contacto y menú off-canvas mobile; el estado sticky/scrolled del
 * header lo gestiona assets/js/main.js (clase `.is-scrolled` sobre
 * `.header-sticky-wrap`). Markup y clases idénticas al prototipo
 * aprobado (prototipo/index.html) — es la implementación completa de
 * Sprint 4 (docs/roadmap.md — "Navbar funcional: sticky, Mega Menu de
 * Áreas de Práctica, Dropdown de Quiénes Somos, versión mobile").
 *
 * Dentro del off-canvas, "Quiénes Somos" se aplana a sus 2 enlaces reales
 * (Nuestra Firma / Nuestro Equipo) y "Áreas de Práctica" se representa
 * con el componente Accordion (template-parts/components/accordion.php),
 * ambos según DA-004 (docs/componentes.md, docs/roadmap.md Sprint 4).
 *
 * El logo (isotipo + "SES ABOGADOS") y la estructura del menú son fijos
 * por diseño — cuando el cliente confirme un logo propio vía
 * Personalizar, se resuelve con `has_custom_logo()` sin tocar este
 * archivo (ver header.php).
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

$ses_actualidad_url    = home_url( '/actualidad-juridica/' );
$ses_contacto_url      = home_url( '/contacto/' );
$ses_quienes_somos_url = home_url( '/quienes-somos/' );

/**
 * Representación responsive del Mega Menú dentro del off-canvas móvil
 * (DA-004, docs/componentes.md; docs/arquitectura.md §4 — preservar la
 * misma jerarquía que en desktop). Mismo dato que mega-menu.php
 * (ses_get_grupos_practica()), sin segunda fuente; accordion.php no
 * conoce "grupos de práctica", solo recibe `title` + `content` ya
 * armados.
 */
$ses_mobile_areas_items = array();
foreach ( ses_get_grupos_practica() as $ses_mobile_index => $ses_mobile_grupo ) :
	ob_start();
	?>
	<ul class="mega-col-links grid-list-reset">
		<?php foreach ( $ses_mobile_grupo['links'] as $ses_mobile_link ) : ?>
			<li><a href="<?php echo esc_url( $ses_mobile_grupo['url'] . '#' . $ses_mobile_link['anchor'] ); ?>"><?php echo esc_html( $ses_mobile_link['label'] ); ?></a></li>
		<?php endforeach; ?>
	</ul>
	<a href="<?php echo esc_url( $ses_mobile_grupo['url'] ); ?>" class="mega-col-cta"><?php esc_html_e( 'Ver grupo', 'ses-abogados' ); ?></a>
	<?php
	$ses_mobile_areas_items[] = array(
		'id'      => 'mobile-areas-panel-' . $ses_mobile_index,
		'title'   => $ses_mobile_grupo['title'],
		'content' => ob_get_clean(),
	);
endforeach;
?>
<div class="header-sticky-wrap">
	<header class="site-header">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
			<img src="<?php echo esc_url( SES_THEME_URI . '/assets/images/isotipo-azul.png' ); ?>" alt="" class="logo-mark" aria-hidden="true">
			<?php esc_html_e( 'SES', 'ses-abogados' ); ?> <span><?php esc_html_e( 'ABOGADOS', 'ses-abogados' ); ?></span>
		</a>

		<nav class="main-nav" aria-label="<?php esc_attr_e( 'Navegación principal', 'ses-abogados' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"<?php echo is_front_page() ? ' aria-current="page"' : ''; ?>>
				<?php esc_html_e( 'Inicio', 'ses-abogados' ); ?>
			</a>

			<?php get_template_part( 'template-parts/components/dropdown-quienes-somos' ); ?>
			<?php get_template_part( 'template-parts/components/mega-menu' ); ?>

			<a href="<?php echo esc_url( $ses_actualidad_url ); ?>"<?php echo ( is_home() || is_singular( 'post' ) ) ? ' aria-current="page"' : ''; ?>><?php esc_html_e( 'Actualidad Jurídica', 'ses-abogados' ); ?></a>
		</nav>

		<a href="<?php echo esc_url( $ses_contacto_url ); ?>" class="btn btn-outline nav-cta"<?php echo is_page( 'contacto' ) ? ' aria-current="page"' : ''; ?>><?php esc_html_e( 'Contáctenos', 'ses-abogados' ); ?></a>

		<button
			type="button"
			class="mobile-menu-toggle"
			aria-expanded="false"
			aria-controls="mobile-menu"
			aria-label="<?php esc_attr_e( 'Abrir menú de navegación', 'ses-abogados' ); ?>"
			data-label-open="<?php esc_attr_e( 'Abrir menú de navegación', 'ses-abogados' ); ?>"
			data-label-close="<?php esc_attr_e( 'Cerrar menú de navegación', 'ses-abogados' ); ?>"
		>
			<span></span><span></span><span></span>
		</button>
	</header>

	<nav id="mobile-menu" class="mobile-menu" aria-label="<?php esc_attr_e( 'Navegación móvil', 'ses-abogados' ); ?>" hidden>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Inicio', 'ses-abogados' ); ?></a>
		<a href="<?php echo esc_url( $ses_quienes_somos_url . '#firma' ); ?>"><?php esc_html_e( 'Nuestra Firma', 'ses-abogados' ); ?></a>
		<a href="<?php echo esc_url( $ses_quienes_somos_url . '#equipo' ); ?>"><?php esc_html_e( 'Nuestro Equipo', 'ses-abogados' ); ?></a>
		<?php get_template_part( 'template-parts/components/accordion', null, array( 'items' => $ses_mobile_areas_items ) ); ?>
		<a href="<?php echo esc_url( $ses_actualidad_url ); ?>"><?php esc_html_e( 'Actualidad Jurídica', 'ses-abogados' ); ?></a>
		<a href="<?php echo esc_url( $ses_contacto_url ); ?>"><?php esc_html_e( 'Contáctenos', 'ses-abogados' ); ?></a>
	</nav>
</div>
