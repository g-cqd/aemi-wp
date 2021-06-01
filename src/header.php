<?php
/**
 * Aemi WordPress Theme
 * Header Template
 *
 * @package  aemi.page
 * @author   Guillaume COQUARD <contact@aemi.dev>
 * @license  http://www.gnu.org/licenses/gpl-3.0.txt GNU Public License 3
 * @link     https://github.com/aemi-dev/aemi-wp/tree/main/src/header.php
 */

?><!DOCTYPE html>

<html <?php language_attributes(); ?> <?php echo aemi_meta_og_namespace(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php do_action( 'aemi_head_before' ); ?>
		<?php do_action( 'aemi_head' ); ?>
		<?php do_action( 'aemi_head_after' ); ?>
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?> <?php aemi_body_background_color(); ?>>
		<?php wp_body_open(); ?>
		<?php do_action( 'aemi_body_afterbegin' ); ?>
		<?php do_action( 'aemi_header_beforebegin' ); ?>
		<header id="site-header"<?php aemi_get_site_header_classes(); ?>>
			<?php do_action( 'aemi_header_afterbegin' ); ?>
			<?php do_action( 'aemi_header' ); ?>
			<?php do_action( 'aemi_header_beforeend' ); ?>
		</header>
		<?php do_action( 'aemi_header_afterend' ); ?>
		<?php do_action( 'aemi_main_beforebegin' ); ?>
		<main id="site-content">
			<?php do_action( 'aemi_main_afterbegin' ); ?>
			<?php do_action( 'aemi_content_beforebegin' ); ?>
			<div id="main-content">
				<?php do_action( 'aemi_content_afterbegin' ); ?>
