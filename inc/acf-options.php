<?php
/**
 * Options Pages de ACF (docs/wordpress.md §6): datos que se editan una
 * sola vez y se leen desde todo el sitio (footer, header, contacto) —
 * nunca hardcodeados por duplicado (CLAUDE.md §14, "un solo lugar para
 * cada dato").
 *
 * Se registran solo si ACF está activo: el tema no debe romperse si el
 * plugin todavía no está instalado en el entorno (docs/wordpress.md §8).
 * Los grupos de campos de cada página (teléfono, cifras, etc.) se
 * definen al construir la sección que los consume, no en esta fase de
 * estructura.
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

/**
 * Guarda/lee los grupos de campos de ACF como JSON en /acf-json en vez de
 * solo en la base de datos: viajan versionados con Git junto al tema (se
 * ven en el diff de un PR) y se sincronizan solos entre local/staging/
 * producción. Configurarlo ahora, vacío, es una línea; hacerlo después de
 * que existan grupos de campos reales exige exportarlos a mano uno por
 * uno — docs/wordpress.md §6/§8.
 */
add_filter(
	'acf/settings/save_json',
	function () {
		return SES_THEME_DIR . '/acf-json';
	}
);
add_filter(
	'acf/settings/load_json',
	function ( $paths ) {
		$paths[] = SES_THEME_DIR . '/acf-json';
		return $paths;
	}
);

function ses_register_acf_options_pages() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page(
		array(
			'page_title' => __( 'Datos de contacto', 'ses-abogados' ),
			'menu_title' => __( 'Datos de contacto', 'ses-abogados' ),
			'menu_slug'  => 'ses-opciones-contacto',
			'capability' => 'manage_options',
			'icon_url'   => 'dashicons-phone',
		)
	);

	acf_add_options_page(
		array(
			'page_title' => __( 'Identidad y redes', 'ses-abogados' ),
			'menu_title' => __( 'Identidad y redes', 'ses-abogados' ),
			'menu_slug'  => 'ses-opciones-identidad',
			'capability' => 'manage_options',
			'icon_url'   => 'dashicons-admin-customizer',
		)
	);

	acf_add_options_page(
		array(
			'page_title' => __( 'Cifras institucionales', 'ses-abogados' ),
			'menu_title' => __( 'Cifras institucionales', 'ses-abogados' ),
			'menu_slug'  => 'ses-opciones-cifras',
			'capability' => 'manage_options',
			'icon_url'   => 'dashicons-chart-bar',
		)
	);

	acf_add_options_page(
		array(
			'page_title' => __( 'Integraciones', 'ses-abogados' ),
			'menu_title' => __( 'Integraciones', 'ses-abogados' ),
			'menu_slug'  => 'ses-opciones-integraciones',
			'capability' => 'manage_options',
			'icon_url'   => 'dashicons-admin-plugins',
		)
	);
}
add_action( 'acf/init', 'ses_register_acf_options_pages' );
