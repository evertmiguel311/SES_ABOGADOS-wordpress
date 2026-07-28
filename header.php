<?php
/**
 * Apertura del documento y header completo.
 *
 * Implementa 1:1 el diseño aprobado por el cliente en el prototipo
 * estático (SES_ABOGADOS-sitio/prototipo/index.html): franja de aviso,
 * Navbar con logo, Dropdown "Quiénes Somos", Mega Menu "Áreas de
 * Práctica", CTA de contacto y menú off-canvas mobile
 * (template-parts/components/navbar.php, dropdown-quienes-somos.php,
 * mega-menu.php) — docs/roadmap.md Sprint 4.
 *
 * La franja de aviso (ciudad/correo) se hardcodea con el dato ya
 * confirmado por el cliente (CLAUDE.md §1); pasa a leerse de la Options
 * Page "Datos de contacto" (docs/wordpress.md §6) cuando se construya
 * Contacto (Sprint 8) — un solo lugar para ese dato, no duplicado.
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
	/*
	 * Favicon fijo del tema mientras no se suba un ícono de sitio desde
	 * Personalizar (Site Icon nativo de WordPress, que si se configura
	 * tiene prioridad automática sobre esto vía wp_head()).
	 */
	if ( ! has_site_icon() ) :
		?>
		<link rel="icon" type="image/png" href="<?php echo esc_url( SES_THEME_URI . '/assets/images/favicon.png' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php get_template_part( 'template-parts/components/skip-link' ); ?>

<div class="announcement-bar">
	<span><?php esc_html_e( 'Cartagena, Colombia', 'ses-abogados' ); ?></span>
	<span class="announcement-extra">
		<span><?php echo esc_html( 'sierraellesabogados@gmail.com' ); ?></span>
	</span>
</div>

<?php get_template_part( 'template-parts/components/navbar' ); ?>
