<?php
/**
 * Hero — docs/biblioteca_componentes.md §3.
 *
 * Dos variantes reales del prototipo aprobado:
 *   - home (default): lema + bandera + 2 CTA + imagen con sello + franja
 *     de cifras (prototipo/index.html .hero/.stats-wrap).
 *   - interior: título + párrafo, más baja, sin animación escalonada, sin
 *     imagen ni CTA (prototipo/quienes-somos.html, areas-de-practica.html,
 *     actualidad-juridica.html, contacto.html .page-hero).
 *
 * La franja de cifras (`stats`) delega cada cifra en Stat Tile
 * (stat-tile.php) — Hero no conoce el detalle visual de una cifra, solo
 * orquesta la lista (arquitectura.md §3.2, regla de composición 1).
 *
 * @param array $args {
 *     @type string $variant       'home' (default) | 'interior'.
 *     @type string $eyebrow       Antetítulo. Obligatorio.
 *     @type string $title         <h1>. Obligatorio.
 *     @type string $subtitle      Párrafo de apoyo. Obligatorio.
 *     @type array  $cta_primary   Solo variant=home. {label, url}.
 *     @type array  $cta_secondary Solo variant=home. {label, url}.
 *     @type string $image_url     Solo variant=home.
 *     @type string $image_alt     Solo variant=home.
 *     @type string $seal_url      Solo variant=home. Opcional, decorativo.
 *     @type array  $stats         Solo variant=home. Array de $args de Stat Tile.
 * }
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

$ses_eyebrow  = isset( $args['eyebrow'] ) ? trim( (string) $args['eyebrow'] ) : '';
$ses_title    = isset( $args['title'] ) ? trim( (string) $args['title'] ) : '';
$ses_subtitle = isset( $args['subtitle'] ) ? trim( (string) $args['subtitle'] ) : '';
if ( '' === $ses_title ) {
	return;
}

$ses_variant = isset( $args['variant'] ) && 'interior' === $args['variant'] ? 'interior' : 'home';

if ( 'interior' === $ses_variant ) :
	?>
	<section class="page-hero">
		<div class="page-hero-inner reveal">
			<?php if ( $ses_eyebrow ) : ?><div class="eyebrow eyebrow-light"><?php echo esc_html( $ses_eyebrow ); ?></div><?php endif; ?>
			<h1><?php echo esc_html( $ses_title ); ?></h1>
			<?php if ( $ses_subtitle ) : ?><p><?php echo esc_html( $ses_subtitle ); ?></p><?php endif; ?>
		</div>
	</section>
	<?php
	return;
endif;

$ses_cta_primary   = isset( $args['cta_primary'] ) && is_array( $args['cta_primary'] ) ? $args['cta_primary'] : array();
$ses_cta_secondary = isset( $args['cta_secondary'] ) && is_array( $args['cta_secondary'] ) ? $args['cta_secondary'] : array();
$ses_image_url     = isset( $args['image_url'] ) ? (string) $args['image_url'] : '';
$ses_image_alt     = isset( $args['image_alt'] ) ? (string) $args['image_alt'] : '';
$ses_seal_url      = isset( $args['seal_url'] ) ? (string) $args['seal_url'] : '';
$ses_stats         = isset( $args['stats'] ) && is_array( $args['stats'] ) ? $args['stats'] : array();
?>
<section class="hero">
	<div class="hero-grid">
		<div class="hero-copy">
			<?php if ( $ses_eyebrow ) : ?><div class="eyebrow eyebrow-light"><?php echo esc_html( $ses_eyebrow ); ?></div><?php endif; ?>
			<h1><?php echo esc_html( $ses_title ); ?></h1>
			<?php if ( $ses_subtitle ) : ?><p class="hero-lead"><?php echo esc_html( $ses_subtitle ); ?></p><?php endif; ?>
			<?php if ( $ses_cta_primary || $ses_cta_secondary ) : ?>
				<div class="hero-btn-row">
					<?php if ( ! empty( $ses_cta_primary['label'] ) && ! empty( $ses_cta_primary['url'] ) ) : ?>
						<?php get_template_part( 'template-parts/components/button', null, array( 'label' => $ses_cta_primary['label'], 'href' => $ses_cta_primary['url'], 'variant' => 'solid-light' ) ); ?>
					<?php endif; ?>
					<?php if ( ! empty( $ses_cta_secondary['label'] ) && ! empty( $ses_cta_secondary['url'] ) ) : ?>
						<?php get_template_part( 'template-parts/components/button', null, array( 'label' => $ses_cta_secondary['label'], 'href' => $ses_cta_secondary['url'], 'variant' => 'outline-dark' ) ); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
		<?php if ( $ses_image_url ) : ?>
			<div class="hero-img-wrap">
				<div class="hero-img stock-photo-wrap">
					<img class="stock-photo" src="<?php echo esc_url( $ses_image_url ); ?>" alt="<?php echo esc_attr( $ses_image_alt ); ?>" loading="eager">
				</div>
				<?php if ( $ses_seal_url ) : ?>
					<img src="<?php echo esc_url( $ses_seal_url ); ?>" alt="<?php esc_attr_e( 'Sello institucional Sierra Elles & Salgado Abogados', 'ses-abogados' ); ?>" class="hero-seal">
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( $ses_stats ) : ?>
		<div class="stats-wrap">
			<div class="stats-grid">
				<?php foreach ( $ses_stats as $ses_stat_index => $ses_stat ) : ?>
					<?php
					if ( ! is_array( $ses_stat ) ) {
						continue;
					}
					get_template_part(
						'template-parts/components/stat-tile',
						null,
						array_merge( $ses_stat, array( 'reveal_delay' => $ses_stat_index ) )
					);
					?>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>
</section>
