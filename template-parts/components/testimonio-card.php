<?php
/**
 * Testimonio Card — tarjeta individual dentro de la sección "Testimonios"
 * del Home (propuesta aprobada por el cliente el 2026-07-28, validada
 * primero en SES_ABOGADOS-sitio/prototipo).
 *
 * @param array $args {
 *     @type int $testimonio_id ID del post `ses_testimonio` a mostrar.
 *                               Si no se pasa, usa el post actual del loop.
 * }
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

$ses_testimonio_id = isset( $args['testimonio_id'] ) ? (int) $args['testimonio_id'] : get_the_ID();

$ses_nombre   = get_the_title( $ses_testimonio_id );
$ses_cita     = get_post_field( 'post_content', $ses_testimonio_id );
$ses_area     = get_post_meta( $ses_testimonio_id, 'ses_area_practica', true );
$ses_rating   = (int) get_post_meta( $ses_testimonio_id, 'ses_calificacion', true );
$ses_rating   = $ses_rating ? max( 1, min( 5, $ses_rating ) ) : 5;

// Iniciales para el avatar por defecto (sin foto): primeras 2 palabras del nombre.
$ses_iniciales = '';
foreach ( array_slice( preg_split( '/\s+/', trim( $ses_nombre ) ), 0, 2 ) as $ses_palabra ) {
	$ses_iniciales .= mb_strtoupper( mb_substr( $ses_palabra, 0, 1 ) );
}
?>
<div class="testimonio-card" role="listitem">
	<div class="testimonio-top">
		<span class="testimonio-quote" aria-hidden="true">&ldquo;</span>
		<span
			class="testimonio-rating"
			aria-label="<?php echo esc_attr( sprintf( /* translators: %d: calificación de 1 a 5. */ __( '%d de 5 estrellas', 'ses-abogados' ), $ses_rating ) ); ?>"
		>
			<?php echo esc_html( str_repeat( '★', $ses_rating ) ); ?>
		</span>
	</div>

	<p class="testimonio-texto"><?php echo esc_html( wp_strip_all_tags( $ses_cita ) ); ?></p>

	<div class="testimonio-autor">
		<?php if ( has_post_thumbnail( $ses_testimonio_id ) ) : ?>
			<div class="testimonio-avatar testimonio-avatar--foto">
				<?php echo get_the_post_thumbnail( $ses_testimonio_id, 'thumbnail', array( 'alt' => '' ) ); ?>
			</div>
		<?php else : ?>
			<div class="testimonio-avatar" aria-hidden="true"><?php echo esc_html( $ses_iniciales ); ?></div>
		<?php endif; ?>
		<div class="testimonio-datos">
			<span class="testimonio-nombre"><?php echo esc_html( $ses_nombre ); ?></span>
			<?php if ( $ses_area ) : ?>
				<span class="testimonio-area"><?php echo esc_html( $ses_area ); ?></span>
			<?php endif; ?>
		</div>
	</div>
</div>
