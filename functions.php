<?php
/**
 * SES Abogados — bootstrap del tema.
 *
 * Este archivo se mantiene deliberadamente como un simple cargador: toda
 * la lógica vive organizada por responsabilidad en /inc (CLAUDE.md §12),
 * para que cada pieza (setup, enqueue, CPT, taxonomías, widgets, ACF,
 * seguridad) se pueda ubicar y mantener sin buscar dentro de un único
 * archivo gigante.
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

define( 'SES_THEME_VERSION', '0.1.0' );
define( 'SES_THEME_DIR', get_template_directory() );
define( 'SES_THEME_URI', get_template_directory_uri() );

/**
 * Orden de carga de /inc — no es alfabético, sigue dependencias lógicas
 * (setup antes que enqueue, CPT antes que cualquier consulta que lo use).
 */
$ses_inc_files = array(
	'inc/setup.php',            // Soporte de tema, menús, tamaños de imagen, textdomain.
	'inc/enqueue.php',          // Carga de CSS/JS del tema.
	'inc/cpt-team-member.php',  // CPT ses_team_member — docs/wordpress.md §1.1.
	'inc/taxonomies.php',       // Relabeling de category/post_tag — docs/wordpress.md §2.
	'inc/widgets.php',          // Área de widget sidebar-articulo — docs/wordpress.md §5.
	'inc/acf-options.php',      // Options Pages de ACF — docs/wordpress.md §6.
	'inc/security.php',         // Hardening básico — docs/wordpress.md §9, §13, §15.
	'inc/template-tags.php',    // Helpers compartidos entre plantillas.
);

foreach ( $ses_inc_files as $ses_inc_file ) {
	$ses_inc_path = SES_THEME_DIR . '/' . $ses_inc_file;
	if ( file_exists( $ses_inc_path ) ) {
		require_once $ses_inc_path;
	}
}
unset( $ses_inc_files, $ses_inc_file, $ses_inc_path );
