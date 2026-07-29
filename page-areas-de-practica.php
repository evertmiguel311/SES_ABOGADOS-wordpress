<?php
/**
 * Landing de Áreas de Práctica (`/areas-de-practica`) — Sprint 5,
 * docs/roadmap.md.
 *
 * `page-{slug}.php` (docs/wordpress.md §10). Presenta los 4 grupos con la
 * variante `landing` de Practice Area Card — mismo dato que el Mega Menú
 * de escritorio (ses_get_grupos_practica()), sin segunda fuente.
 *
 * Las 4 páginas de grupo (`/areas-de-practica/{grupo}`) enlazadas desde
 * aquí y desde el Mega Menú todavía no existen: se construyen en Sprint 6
 * junto con el campo ACF `sub_especialidades` y la plantilla
 * `page-grupo-practica.php` (docs/wordpress.md §4, docs/roadmap.md).
 * Sprint 5 no adelanta esa capa (fuera de su alcance explícito).
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

	<main id="main" class="site-main">
		<?php
		get_template_part(
			'template-parts/components/hero',
			null,
			array(
				'variant'  => 'interior',
				'eyebrow'  => __( 'Áreas de Práctica', 'ses-abogados' ),
				'title'    => __( 'Cuatro grupos de práctica, doce sub-especialidades, una sola estrategia', 'ses-abogados' ),
				'subtitle' => __( 'Coordinamos nuestra práctica jurídica para que cada asunto reciba una mirada integral, sin importar cuántas ramas del derecho intervengan.', 'ses-abogados' ),
			)
		);

		$ses_grupos_items = array();
		foreach ( ses_get_grupos_practica() as $ses_index => $ses_grupo ) {
			$ses_grupos_items[] = array(
				'title'        => $ses_grupo['title'],
				'url'          => $ses_grupo['url'],
				'icon'         => $ses_grupo['icon'],
				'excerpt'      => $ses_grupo['excerpt'],
				'variant'      => 'landing',
				'cta_label'    => __( 'Ver grupo', 'ses-abogados' ),
				'reveal_delay' => $ses_index,
			);
		}
		?>

		<section class="<?php echo esc_attr( ses_section_class( 'white' ) ); ?>">
			<?php
			get_template_part(
				'template-parts/components/card-grid',
				null,
				array(
					'items'      => $ses_grupos_items,
					'card_type'  => 'practice-area',
					'grid_class' => 'grupos-landing-grid',
				)
			);
			?>
		</section>

		<?php
		get_template_part(
			'template-parts/components/cta-section',
			null,
			array(
				'title'       => __( '¿No está seguro de qué área necesita?', 'ses-abogados' ),
				'description' => __( 'Cuéntenos su caso y lo dirigimos al grupo de práctica adecuado.', 'ses-abogados' ),
				'cta_primary' => array(
					'label' => __( 'Contáctenos', 'ses-abogados' ),
					'url'   => home_url( '/contacto/' ),
				),
			)
		);
		?>
	</main>

<?php
get_footer();
