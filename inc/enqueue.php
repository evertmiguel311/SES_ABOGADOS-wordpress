<?php
/**
 * Carga de CSS/JS del tema.
 *
 * Un solo stylesheet base por ahora (fundamentos: tokens de marca +
 * reset, docs/manual_marca.md) — los estilos de cada componente/página
 * se agregan en las tareas de construcción de página correspondientes,
 * no en esta fase de estructura (ver docs/roadmap.md).
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

/**
 * Preconnect a los hosts de Google Fonts: sin esto el navegador no abre
 * la conexión TLS hasta que descubre el <link> en el HTML, perdiendo un
 * round-trip completo antes de poder pedir la tipografía.
 */
function ses_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
		$urls[] = 'https://fonts.googleapis.com';
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'ses_resource_hints', 10, 2 );

function ses_enqueue_assets() {
	/*
	 * Tipografía vía Google Fonts, igual que el prototipo aprobado.
	 * Auto-hospedar las fuentes en assets/fonts/ queda como optimización
	 * de Core Web Vitals para Sprint 9 (docs/roadmap.md) — ver
	 * assets/fonts/README.md.
	 */
	wp_enqueue_style(
		'ses-google-fonts',
		'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Inter:wght@300;400;500;600&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'ses-abogados-style',
		SES_THEME_URI . '/assets/css/style.css',
		array( 'ses-google-fonts' ),
		SES_THEME_VERSION
	);

	wp_enqueue_script(
		'ses-abogados-main',
		SES_THEME_URI . '/assets/js/main.js',
		array(),
		SES_THEME_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'ses_enqueue_assets' );
