<?php
if ( !function_exists( 'aemi_sidebar_widgets' ) ) {
	function aemi_sidebar_widgets()
	{
		if ( is_active_sidebar( 'sidebar-widget-area' ) ) {
			?><aside id="sidebar"><?php
				dynamic_sidebar( 'sidebar-widget-area' );
			?></aside><?php
		}
	}
}


if ( !function_exists( 'aemi_footer_widgets' ) ) {
	function aemi_footer_widgets()
	{
		if ( is_active_sidebar( 'footer-widget-area' ) ) {
			?><div id="footer-widgets"><?php
				dynamic_sidebar( 'footer-widget-area' );
			?></div><?php
		}
	}
}


if ( !function_exists( 'aemi_footer_site_description' ) ) {
	function aemi_footer_site_description()
	{
		if ( get_bloginfo( 'description' ) ) {
			printf(
				'<h5 id="site-description" class="site-description">%s</h5>',
				esc_html( get_bloginfo( 'description' ) )
			);
		}
	}
}


if ( !function_exists( 'aemi_footer_menu' ) ) {
	function aemi_footer_menu()
	{
		if ( has_nav_menu( 'footer-menu' ) ) {
			?><nav id="footer-menu"><?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-menu',
						'depth' => '1'
					)
				);
			?></nav><?php
		}
	}
}


if ( !function_exists( 'aemi_footer_credit' ) ) {
	function aemi_footer_credit()
	{
		?><p id="copyright"><?php
			printf(
				__( '%1$s %2$s %3$s. All Rights Reserved.', 'aemi' ),
				'&copy;',
				date( 'Y' ),
				esc_html( get_bloginfo( 'name' ) )
			);
		?></p><?php
	}
}


if ( !function_exists( 'aemi_footer_wp_footer' ) ) {
	function aemi_footer_wp_footer()
	{
		if ( wp_footer() ) {
			wp_footer();
		}
	}
}
