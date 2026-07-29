<?php
/**
 * Team Card — docs/biblioteca_componentes.md §4.
 *
 * Dos variantes reales del prototipo aprobado (mismo dato, distinta
 * densidad):
 *   - compact (default): foto + nombre + cargo + especialidad, sin bio
 *     (prototipo/index.html .equipo-card).
 *   - full: foto + nombre + cargo + biografía completa
 *     (prototipo/quienes-somos.html .equipo-card-full).
 *
 * Ninguna variante es interactiva en el diseño aprobado: no hay link ni
 * botón de "ver perfil" en ninguna de las dos ubicaciones — la
 * navegación a la ficha completa ocurre a nivel de sección ("Ver equipo
 * completo"), no por tarjeta. Por eso el wrapper es <div>, no <a> ni
 * <button>; esto resuelve en la práctica la decisión abierta "Modal vs.
 * página individual" (docs/roadmap.md) sin necesitar ninguno de los dos.
 *
 * @param array $args {
 *     @type string $name           Obligatorio.
 *     @type string $role           Cargo. Obligatorio.
 *     @type string $specialization Solo variant=compact.
 *     @type string $bio            Solo variant=full.
 *     @type string $photo_url      Opcional. Sin ella, placeholder "Foto pendiente"
 *                                  (mismo patrón ya aprobado en el prototipo).
 *     @type string $photo_alt      Opcional; default "Retrato de {name}, {role}".
 *     @type string $variant        'compact' (default) | 'full'.
 *     @type int    $reveal_delay   0-7, para escalonar el grid (.reveal-delay-N).
 * }
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

$ses_name = isset( $args['name'] ) ? trim( (string) $args['name'] ) : '';
$ses_role = isset( $args['role'] ) ? trim( (string) $args['role'] ) : '';
if ( '' === $ses_name || '' === $ses_role ) {
	return;
}

$ses_variant   = isset( $args['variant'] ) && 'full' === $args['variant'] ? 'full' : 'compact';
$ses_photo_url = isset( $args['photo_url'] ) ? (string) $args['photo_url'] : '';
$ses_photo_alt = ( isset( $args['photo_alt'] ) && '' !== $args['photo_alt'] )
	? (string) $args['photo_alt']
	/* translators: 1: nombre del socio/a, 2: cargo. */
	: sprintf( __( 'Retrato de %1$s, %2$s', 'ses-abogados' ), $ses_name, $ses_role );

$ses_reveal_delay = isset( $args['reveal_delay'] ) ? max( 0, min( 7, (int) $args['reveal_delay'] ) ) : 0;
$ses_reveal_class = 'reveal' . ( $ses_reveal_delay > 0 ? ' reveal-delay-' . $ses_reveal_delay : '' );

if ( 'full' === $ses_variant ) :
	$ses_bio = isset( $args['bio'] ) ? trim( (string) $args['bio'] ) : '';
	?>
	<div class="equipo-card-full <?php echo esc_attr( $ses_reveal_class ); ?>">
		<?php if ( $ses_photo_url ) : ?>
			<div class="stock-photo-wrap"><img src="<?php echo esc_url( $ses_photo_url ); ?>" alt="<?php echo esc_attr( $ses_photo_alt ); ?>" class="stock-photo"></div>
		<?php else : ?>
			<div class="pending-photo" style="aspect-ratio: 3/4;"><span><?php esc_html_e( 'Foto pendiente', 'ses-abogados' ); ?></span></div>
		<?php endif; ?>
		<div>
			<div class="equipo-nombre"><?php echo esc_html( $ses_name ); ?></div>
			<div class="equipo-cargo"><?php echo esc_html( $ses_role ); ?></div>
			<?php if ( $ses_bio ) : ?>
				<p class="equipo-bio"><?php echo esc_html( $ses_bio ); ?></p>
			<?php endif; ?>
		</div>
	</div>
	<?php
	return;
endif;

$ses_specialization = isset( $args['specialization'] ) ? trim( (string) $args['specialization'] ) : '';
?>
<div class="equipo-card <?php echo esc_attr( $ses_reveal_class ); ?>">
	<?php if ( $ses_photo_url ) : ?>
		<div class="equipo-photo stock-photo-wrap"><img src="<?php echo esc_url( $ses_photo_url ); ?>" alt="<?php echo esc_attr( $ses_photo_alt ); ?>" class="stock-photo"></div>
	<?php else : ?>
		<div class="equipo-photo pending-photo"><span><?php esc_html_e( 'Foto pendiente', 'ses-abogados' ); ?></span></div>
	<?php endif; ?>
	<div class="equipo-nombre"><?php echo esc_html( $ses_name ); ?></div>
	<div class="equipo-cargo"><?php echo esc_html( $ses_role ); ?></div>
	<?php if ( $ses_specialization ) : ?>
		<div class="equipo-especialidad"><?php echo esc_html( $ses_specialization ); ?></div>
	<?php endif; ?>
</div>
