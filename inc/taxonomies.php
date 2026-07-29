<?php
/**
 * Relabeling de las taxonomías nativas `category`/`post_tag` como
 * "Categoría Jurídica"/"Etiqueta Jurídica" para Actualidad Jurídica.
 *
 * Se reutilizan las taxonomías nativas en vez de crear unas nuevas:
 * mantiene compatibilidad con Yoast y cualquier plugin que espere
 * `category`/`post_tag` por defecto (docs/wordpress.md §2).
 *
 * La lista de categorías (docs/articulos.md §Taxonomía) se siembra una
 * sola vez al activar el tema (Sprint 6, "preparación del blog") —
 * idempotente: si el término ya existe (porque un Editor ya lo creó a
 * mano, o porque el tema se reactivó), no se duplica. La "nota de
 * desfase" de docs/articulos.md (estas 10 categorías no cubren todavía
 * las 12 sub-especialidades ampliadas) sigue sin resolverse aquí — es una
 * decisión abierta de Sprint 7, no se amplía unilateralmente.
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

/**
 * Siembra la lista inicial de Categorías Jurídicas (docs/articulos.md
 * §Taxonomía) una sola vez, para que el blog no arranque con la
 * taxonomía vacía. `after_switch_theme` en vez de `init` — no tiene
 * sentido comprobar `term_exists()` en cada carga de página.
 */
function ses_sembrar_categorias_juridicas() {
	$ses_categorias = array(
		__( 'Derecho Administrativo', 'ses-abogados' ),
		__( 'Contratación Estatal', 'ses-abogados' ),
		__( 'Regulación y Control Urbano', 'ses-abogados' ),
		__( 'Derecho Inmobiliario', 'ses-abogados' ),
		__( 'Saneamiento Predial', 'ses-abogados' ),
		__( 'Jurisprudencia', 'ses-abogados' ),
		__( 'Conceptos Jurídicos', 'ses-abogados' ),
		__( 'Análisis Normativo', 'ses-abogados' ),
		__( 'Boletines', 'ses-abogados' ),
		__( 'Noticias de la Firma', 'ses-abogados' ),
	);

	foreach ( $ses_categorias as $ses_categoria ) {
		if ( ! term_exists( $ses_categoria, 'category' ) ) {
			wp_insert_term( $ses_categoria, 'category' );
		}
	}
}
add_action( 'after_switch_theme', 'ses_sembrar_categorias_juridicas' );
