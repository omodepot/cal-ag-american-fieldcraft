<?php
/**
 * Shared header: the approved <head> and site header (logo, menu, phone),
 * identical to the homepage.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html lang="en">
<head><?php echo cal_ag_fieldcraft_shell_part( 'head' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php echo cal_ag_fieldcraft_shell_part( 'preamble' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<?php echo cal_ag_fieldcraft_shell_part( 'header' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
