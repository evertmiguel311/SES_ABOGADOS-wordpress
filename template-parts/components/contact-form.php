<?php
/**
 * Form (Formulario de Contacto) — docs/biblioteca_componentes.md §7.
 *
 * Responsabilidad: capturar Nombre, Correo, Teléfono, Área de interés
 * (los 4 grupos de práctica, no las 12 sub-especialidades) y Mensaje;
 * validar en cliente y reenviar a validación/sanitización de servidor
 * (nonces + `sanitize_*` nativas — docs/wordpress.md §15). Template-part
 * fijo en `page-contacto.php`, no un shortcode insertable en cualquier
 * página (docs/wordpress.md §12).
 *
 * Pendiente de implementación (Sprint 8, docs/roadmap.md).
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;
