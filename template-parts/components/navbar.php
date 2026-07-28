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
 * El logo (isotipo + "SES ABOGADOS") y la estructura del menú son fijos
 * por diseño — cuando el cliente confirme un logo propio vía
 * Personalizar, se resuelve con `has_custom_logo()` sin tocar este
 * archivo (ver header.php).
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

$ses_actualidad_url = home_url( '/actualidad-juridica/' );
$ses_contacto_url   = home_url( '/contacto/' );
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

			<a href="<?php echo esc_url( $ses_actualidad_url ); ?>"><?php esc_html_e( 'Actualidad Jurídica', 'ses-abogados' ); ?></a>
		</nav>

		<a href="<?php echo esc_url( $ses_contacto_url ); ?>" class="btn btn-outline nav-cta"><?php esc_html_e( 'Contáctenos', 'ses-abogados' ); ?></a>

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
		<a href="<?php echo esc_url( home_url( '/quienes-somos/' ) ); ?>"><?php esc_html_e( 'Quiénes Somos', 'ses-abogados' ); ?></a>
		<a href="<?php echo esc_url( home_url( '/areas-de-practica/' ) ); ?>"><?php esc_html_e( 'Áreas de Práctica', 'ses-abogados' ); ?></a>
		<a href="<?php echo esc_url( $ses_actualidad_url ); ?>"><?php esc_html_e( 'Actualidad Jurídica', 'ses-abogados' ); ?></a>
		<a href="<?php echo esc_url( $ses_contacto_url ); ?>"><?php esc_html_e( 'Contáctenos', 'ses-abogados' ); ?></a>
	</nav>
</div>
