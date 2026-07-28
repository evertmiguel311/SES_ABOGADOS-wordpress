<?php
/**
 * Hardening ligero de WordPress a nivel de tema.
 *
 * Complementa (no reemplaza) el plugin de seguridad (Wordfence/Sucuri) y
 * la configuración de servidor de docs/seguridad.md — ver también
 * docs/wordpress.md §13 (REST API) y §15 (seguridad).
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;

/**
 * XML-RPC: vector de fuerza bruta conocido sin uso real en este
 * proyecto (no hay apps externas que lo consuman) — docs/wordpress.md §13.
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Enumeración de usuarios vía /wp-json/wp/v2/users: fuga común de
 * nombres de usuario, relevante porque hay pocos administradores y son
 * objetivo de fuerza bruta — docs/wordpress.md §13.
 *
 * Se compara por prefijo (`strpos(...) === 0`) en vez de una clave
 * literal exacta: el patrón de regex que WordPress core usa para la ruta
 * con `{id}` puede variar de una versión a otra (nombre del grupo de
 * captura, espacios), y una comparación exacta que deja de coincidir
 * falla en silencio — sin romper nada, pero sin proteger tampoco.
 */
add_filter(
	'rest_endpoints',
	function ( $endpoints ) {
		foreach ( array_keys( $endpoints ) as $ses_route ) {
			if ( 0 === strpos( $ses_route, '/wp/v2/users' ) ) {
				unset( $endpoints[ $ses_route ] );
			}
		}
		return $endpoints;
	}
);

// No anunciar la versión exacta de WordPress en el HTML público.
remove_action( 'wp_head', 'wp_generator' );

/**
 * Emojis nativos de WordPress: no aportan al contenido jurídico del
 * sitio y agregan una petición/script extra en cada carga — performance
 * por defecto (CLAUDE.md §14).
 */
add_action(
	'init',
	function () {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
	}
);
