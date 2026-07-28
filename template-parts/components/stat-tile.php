<?php
/**
 * Stat Tile — docs/biblioteca_componentes.md §3.
 *
 * Responsabilidad: destacar una cifra institucional confirmada por el
 * cliente. `value` es texto, no número puro (permite "35+" tal cual);
 * nunca se publica una cifra no confirmada como dato definitivo
 * (CLAUDE.md §15).
 *
 * Pendiente de implementación (Sprint 4, docs/roadmap.md — Inicio). Los
 * valores se leen de la Options Page "Cifras institucionales"
 * (docs/wordpress.md §3/§6), no se hardcodean en la plantilla.
 *
 * @package SES_Abogados
 */

defined( 'ABSPATH' ) || exit;
