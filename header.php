<!DOCTYPE html>

<html <?php language_attributes(); ?> <?php /* aemi_html_tag_schema(); */ ?>>

	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<?php do_action( 'aemi_header_before' ); ?>
		<header id="site-header">
			<?php
			printf(
				'<a class="skip-link screen-reader-text" href="#main-content">%s</a>',
				esc_html__( 'Skip to content', 'aemi' )
			);
			?>
			<?php do_action( 'aemi_header' ); ?>
		</header>
		<main id="site-content">
			<div id="main-content">
