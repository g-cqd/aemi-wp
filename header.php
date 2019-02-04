<!DOCTYPE html>

<html <?php language_attributes(); ?> <?php aemi_html_tag_schema(); ?>>

	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<?php do_action( 'aemi_header_before' ); ?>
		<header <?php if ( get_header_image() ) { ?> style="background-image:url( '<?php echo esc_url( get_header_image() ); ?>' );"<?php } ?> role="banner" >
			<?php do_action( 'aemi_header' ); ?>
		</header>
		<main>
			<div id="content">
