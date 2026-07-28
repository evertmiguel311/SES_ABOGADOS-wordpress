<?php
/**
 * Skip link — primer elemento del <body> (CLAUDE.md §9, accesibilidad;
 * docs/biblioteca_componentes.md §2 Skip link).
 *
 * Permite a un usuario de teclado saltar directo al contenido principal
 * (#main) sin tabular por todo el header. Estilo visual en
 * assets/css/style.css (.skip-link).
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;
?>
<a class="skip-link" href="#main"><?php esc_html_e( 'Saltar al contenido', 'ses-abogados' ); ?></a>
