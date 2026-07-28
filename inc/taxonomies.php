<?php
/**
 * Relabeling de las taxonomías nativas `category`/`post_tag` como
 * "Categoría Jurídica"/"Etiqueta Jurídica" para Actualidad Jurídica.
 *
 * Se reutilizan las taxonomías nativas en vez de crear unas nuevas:
 * mantiene compatibilidad con Yoast y cualquier plugin que espere
 * `category`/`post_tag` por defecto (docs/wordpress.md §2). La lista de
 * términos (Derecho Administrativo, Contratación Estatal, etc. — ver
 * docs/articulos.md) se crea al construir el blog (Sprint 7), no aquí.
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

function ses_relabel_native_taxonomies() {
	global $wp_taxonomies;

	if ( isset( $wp_taxonomies['category'] ) ) {
		$wp_taxonomies['category']->label                = __( 'Categorías Jurídicas', 'ses-abogados' );
		$wp_taxonomies['category']->labels->name          = __( 'Categorías Jurídicas', 'ses-abogados' );
		$wp_taxonomies['category']->labels->singular_name = __( 'Categoría Jurídica', 'ses-abogados' );
		$wp_taxonomies['category']->labels->menu_name     = __( 'Categorías Jurídicas', 'ses-abogados' );
	}

	if ( isset( $wp_taxonomies['post_tag'] ) ) {
		$wp_taxonomies['post_tag']->label                = __( 'Etiquetas Jurídicas', 'ses-abogados' );
		$wp_taxonomies['post_tag']->labels->name          = __( 'Etiquetas Jurídicas', 'ses-abogados' );
		$wp_taxonomies['post_tag']->labels->singular_name = __( 'Etiqueta Jurídica', 'ses-abogados' );
		$wp_taxonomies['post_tag']->labels->menu_name     = __( 'Etiquetas Jurídicas', 'ses-abogados' );
	}
}
add_action( 'init', 'ses_relabel_native_taxonomies', 20 );
