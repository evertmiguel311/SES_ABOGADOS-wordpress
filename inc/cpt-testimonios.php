<?php
/**
 * CPT `ses_testimonio` — Testimonio de cliente (sección "Testimonios" del
 * Home).
 *
 * Propuesta validada primero en el prototipo estático
 * (SES_ABOGADOS-sitio/prototipo) y aprobada por el cliente el 2026-07-28.
 * Testimonios curados y cargados por el propio equipo desde este panel —
 * nunca un formulario público en el sitio: evita que un comentario se lea
 * como garantía de resultado de un caso (Código Disciplinario del
 * Abogado) y protege el dato personal del cliente (Ley 1581 de 2012),
 * que requiere su consentimiento explícito antes de publicarse.
 *
 * `área de práctica` y `calificación` se guardan como post meta nativo
 * (no como campos ACF): ACF Pro todavía no está instalado en este
 * entorno (costo pendiente de confirmar con el cliente), y el campo debe
 * poder editarse desde ya sin depender de esa compra.
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

function ses_register_testimonio_cpt() {
	$labels = array(
		'name'          => __( 'Testimonios', 'ses-abogados' ),
		'singular_name' => __( 'Testimonio', 'ses-abogados' ),
		'add_new'       => __( 'Agregar', 'ses-abogados' ),
		'add_new_item'  => __( 'Agregar testimonio', 'ses-abogados' ),
		'edit_item'     => __( 'Editar testimonio', 'ses-abogados' ),
		'new_item'      => __( 'Nuevo testimonio', 'ses-abogados' ),
		'view_item'     => __( 'Ver testimonio', 'ses-abogados' ),
		'all_items'     => __( 'Testimonios', 'ses-abogados' ),
		'search_items'  => __( 'Buscar testimonios', 'ses-abogados' ),
		'not_found'     => __( 'No se encontraron testimonios.', 'ses-abogados' ),
		'menu_name'     => __( 'Testimonios', 'ses-abogados' ),
	);

	register_post_type(
		'ses_testimonio',
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
			'menu_icon'           => 'dashicons-testimonial',
			'supports'            => array( 'title', 'editor', 'thumbnail' ),
			'capability_type'     => 'post',
		)
	);

	register_post_meta(
		'ses_testimonio',
		'ses_area_practica',
		array(
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback'     => function () {
				return current_user_can( 'edit_posts' );
			},
		)
	);

	register_post_meta(
		'ses_testimonio',
		'ses_calificacion',
		array(
			'type'              => 'integer',
			'single'            => true,
			'default'           => 5,
			'show_in_rest'      => true,
			'sanitize_callback' => 'ses_sanitize_calificacion',
			'auth_callback'     => function () {
				return current_user_can( 'edit_posts' );
			},
		)
	);
}
add_action( 'init', 'ses_register_testimonio_cpt' );

/**
 * Calificación siempre entre 1 y 5 — nunca se confía en el valor crudo de
 * un campo numérico editable por el usuario.
 */
function ses_sanitize_calificacion( $value ) {
	return max( 1, min( 5, absint( $value ) ) );
}

/**
 * Metabox nativo (sin ACF): área de práctica y calificación. Un
 * `add_meta_box()` es más simple que registrar un bloque de Gutenberg
 * propio solo para 2 campos.
 */
function ses_testimonio_metabox() {
	add_meta_box(
		'ses_testimonio_datos',
		__( 'Datos del testimonio', 'ses-abogados' ),
		'ses_testimonio_metabox_render',
		'ses_testimonio',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'ses_testimonio_metabox' );

function ses_testimonio_metabox_render( $post ) {
	wp_nonce_field( 'ses_testimonio_guardar', 'ses_testimonio_nonce' );

	$area         = get_post_meta( $post->ID, 'ses_area_practica', true );
	$calificacion = get_post_meta( $post->ID, 'ses_calificacion', true );
	$calificacion = $calificacion ? (int) $calificacion : 5;
	?>
	<p>
		<label for="ses_area_practica"><strong><?php esc_html_e( 'Área de práctica', 'ses-abogados' ); ?></strong></label><br>
		<input
			type="text"
			id="ses_area_practica"
			name="ses_area_practica"
			class="widefat"
			value="<?php echo esc_attr( $area ); ?>"
			placeholder="<?php esc_attr_e( 'Ej. Derecho de Familia', 'ses-abogados' ); ?>"
		>
	</p>
	<p>
		<label for="ses_calificacion"><strong><?php esc_html_e( 'Calificación (1 a 5)', 'ses-abogados' ); ?></strong></label><br>
		<input type="number" id="ses_calificacion" name="ses_calificacion" min="1" max="5" step="1" value="<?php echo esc_attr( $calificacion ); ?>">
	</p>
	<p class="description">
		<?php esc_html_e( 'El nombre del cliente va en el título de la entrada; la cita, en el contenido. Verifique que exista autorización explícita para publicar ambos antes de guardar como "Publicado".', 'ses-abogados' ); ?>
	</p>
	<?php
}

function ses_testimonio_guardar( $post_id ) {
	if ( ! isset( $_POST['ses_testimonio_nonce'] ) || ! wp_verify_nonce( $_POST['ses_testimonio_nonce'], 'ses_testimonio_guardar' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( 'ses_testimonio' !== get_post_type( $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['ses_area_practica'] ) ) {
		update_post_meta( $post_id, 'ses_area_practica', sanitize_text_field( wp_unslash( $_POST['ses_area_practica'] ) ) );
	}
	if ( isset( $_POST['ses_calificacion'] ) ) {
		update_post_meta( $post_id, 'ses_calificacion', ses_sanitize_calificacion( wp_unslash( $_POST['ses_calificacion'] ) ) );
	}
}
add_action( 'save_post', 'ses_testimonio_guardar' );
