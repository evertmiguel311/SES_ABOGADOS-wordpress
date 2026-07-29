<?php
/**
 * Stat Tile — docs/biblioteca_componentes.md §3.
 *
 * Dos variantes reales del prototipo aprobado (mismo dato, distinto
 * tratamiento visual):
 *   - oscura (default): franja de cifras del Hero de Home
 *     (prototipo/index.html .stats-wrap .stat) — admite conteo animado y
 *     la etiqueta "Sugerido — a confirmar" para cifras aún no confirmadas
 *     por el cliente (CLAUDE.md §15, no publicar cifras no confirmadas
 *     como dato definitivo).
 *   - light (`$args['light'] = true`): franja ligera reutilizada en
 *     Quiénes Somos (prototipo/quienes-somos.html .stats-grid-light),
 *     sin conteo animado ni etiqueta de sugerido — son datos ya
 *     estructurales (4 grupos, 12 sub-especialidades), no cifras a
 *     confirmar.
 *
 * `value` es texto, no número puro (permite "Nacional" o "35+" tal cual).
 *
 * @param array $args {
 *     @type string $value         Obligatorio.
 *     @type string $label         Obligatorio.
 *     @type bool   $animate_count Solo variante oscura. Default false.
 *     @type bool   $suggested     Solo variante oscura. Muestra la
 *                                 etiqueta "Sugerido — a confirmar".
 *     @type bool   $light         Default false.
 *     @type int    $reveal_delay  0-7, para escalonar el grid.
 * }
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

$ses_value = isset( $args['value'] ) ? trim( (string) $args['value'] ) : '';
$ses_label = isset( $args['label'] ) ? trim( (string) $args['label'] ) : '';
if ( '' === $ses_value || '' === $ses_label ) {
	return;
}

$ses_light = ! empty( $args['light'] );

if ( $ses_light ) :
	?>
	<div>
		<div class="stat-number-light"><?php echo esc_html( $ses_value ); ?></div>
		<div class="stat-label-light"><?php echo esc_html( $ses_label ); ?></div>
	</div>
	<?php
	return;
endif;

$ses_animate_count = ! empty( $args['animate_count'] );
$ses_suggested     = ! empty( $args['suggested'] );
$ses_reveal_delay  = isset( $args['reveal_delay'] ) ? max( 0, min( 7, (int) $args['reveal_delay'] ) ) : 0;
$ses_reveal_class  = 'reveal' . ( $ses_reveal_delay > 0 ? ' reveal-delay-' . $ses_reveal_delay : '' );

// data-count-to solo si $value es puramente numérico (ej. "35" en "35+" vía
// $args aparte) — un valor de texto ("Nacional") nunca anima, coherente con
// design_system.md §11.2 (Stat Tile no fuerza conteo donde no hay número.
$ses_count_to = isset( $args['count_to'] ) ? (string) $args['count_to'] : '';
$ses_suffix   = isset( $args['suffix'] ) ? (string) $args['suffix'] : '';
?>
<div class="stat <?php echo esc_attr( $ses_reveal_class ); ?>">
	<div
		class="stat-number<?php echo ( '' === $ses_count_to ) ? ' is-text' : ''; ?>"
		<?php if ( $ses_animate_count && '' !== $ses_count_to ) : ?>
			data-count-to="<?php echo esc_attr( $ses_count_to ); ?>"
			<?php if ( '' !== $ses_suffix ) : ?>data-suffix="<?php echo esc_attr( $ses_suffix ); ?>"<?php endif; ?>
		<?php endif; ?>
	><?php echo esc_html( $ses_value ); ?></div>
	<div class="stat-accent" aria-hidden="true"></div>
	<div class="stat-label"><?php echo esc_html( $ses_label ); ?></div>
	<?php if ( $ses_suggested ) : ?>
		<div class="stat-suggested-tag"><?php esc_html_e( 'Sugerido — a confirmar', 'ses-abogados' ); ?></div>
	<?php else : ?>
		<div class="stat-suggested-tag" aria-hidden="true"></div>
	<?php endif; ?>
</div>
