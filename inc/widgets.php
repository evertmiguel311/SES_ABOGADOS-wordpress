<?php
/**
 * Áreas de widget mínimas a propósito (docs/wordpress.md §5): casi todo
 * el contenido dinámico del sitio se resuelve con template-parts + ACF,
 * no con widgets arrastrables. `sidebar-articulo` es la única excepción
 * documentada, como fallback/extensión del Sidebar de relacionados en
 * la página de Artículo.
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

function ses_register_widget_areas() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar — Artículo', 'ses-abogados' ),
			'id'            => 'sidebar-articulo',
			'description'   => __( 'Extensión opcional del sidebar de artículos relacionados en Actualidad Jurídica.', 'ses-abogados' ),
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'ses_register_widget_areas' );
