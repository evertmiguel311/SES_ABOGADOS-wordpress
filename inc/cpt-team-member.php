<?php
/**
 * CPT `ses_team_member` — Ficha de socio (Team Card).
 *
 * Es el único Custom Post Type del proyecto: todo lo demás es `page` o
 * `post` nativo (docs/wordpress.md §1). Colección pequeña con campos
 * estructurados (foto, cargo, bio) que no encajan en el contenido libre
 * de una página.
 *
 * No es público como archivo propio: el listado de "Nuestro Equipo" se
 * arma con WP_Query desde la página, no desde una plantilla de archivo
 * (docs/wordpress.md §1.1). `show_in_rest` queda en `true` porque lo
 * necesita el editor de bloques para el campo "bio extendida"; no
 * implica URL pública — eso lo controlan `public`/`publicly_queryable`.
 * Si en el futuro se decide dar página propia por socio, es cambio de
 * configuración (`publicly_queryable` => true, `has_archive` => true),
 * no de arquitectura.
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

function ses_register_team_member_cpt() {
	$labels = array(
		'name'          => __( 'Equipo', 'ses-abogados' ),
		'singular_name' => __( 'Miembro del equipo', 'ses-abogados' ),
		'add_new'       => __( 'Agregar', 'ses-abogados' ),
		'add_new_item'  => __( 'Agregar miembro del equipo', 'ses-abogados' ),
		'edit_item'     => __( 'Editar miembro del equipo', 'ses-abogados' ),
		'new_item'      => __( 'Nuevo miembro del equipo', 'ses-abogados' ),
		'view_item'     => __( 'Ver miembro del equipo', 'ses-abogados' ),
		'all_items'     => __( 'Equipo', 'ses-abogados' ),
		'search_items'  => __( 'Buscar en el equipo', 'ses-abogados' ),
		'not_found'     => __( 'No se encontraron miembros del equipo.', 'ses-abogados' ),
		'menu_name'     => __( 'Equipo', 'ses-abogados' ),
	);

	register_post_type(
		'ses_team_member',
		array(
			'labels'              => $labels,
			'public'              => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'rewrite'             => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => true,
			'menu_icon'           => 'dashicons-groups',
			'supports'            => array( 'title', 'editor', 'thumbnail' ),
			'capability_type'     => 'post',
		)
	);
}
add_action( 'init', 'ses_register_team_member_cpt' );
