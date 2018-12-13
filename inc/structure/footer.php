<?php


if ( ! function_exists( 'aemi_sidebar_widgets' ) )
{
	function aemi_sidebar_widgets()
	{
		if ( is_active_sidebar( 'sidebar-widget-area' ) ) { ?>

			<div id="sidebar">

				<?php dynamic_sidebar( 'sidebar-widget-area' ); ?>

			</div>

			<?php
		}
	}
}


if ( ! function_exists( 'aemi_footer_widgets' ) )
{
	function aemi_footer_widgets()
	{
		if ( is_active_sidebar( 'footer-widget-area' ) ) { ?>

			<div id="footer-widgets">

				<?php dynamic_sidebar( 'footer-widget-area' ); ?>

			</div>

		<?php }
	}
}


if ( ! function_exists( 'aemi_footer_site_description' ) )
{
	function aemi_footer_site_description()
	{
		if ( get_bloginfo( 'description' ) ) { ?>

			<h5 id="site-description" class="site-description">

				&#x2039; <?php echo esc_html( get_bloginfo( 'description' ) ); ?> &#x203A;

			</h5>

		<?php }
	}
}


if ( ! function_exists( 'aemi_footer_menu' ) )
{
	function aemi_footer_menu()
	{
		if ( has_nav_menu( 'footer-menu' ) ) { ?>

			<nav id="footer-menu">

				<?php wp_nav_menu( array(
					'theme_location' => 'footer-menu',
					'depth' => '1'
				) ); ?>

			</nav>

		<?php }
	}
}


if ( ! function_exists( 'aemi_footer_credit' ) )
{
	function aemi_footer_credit()
	{ ?>

		<div id="copyright">

			<?php echo sprintf( _x( '%1$s %2$s %3$s. All Rights Reserved.', 'copyright', 'aemi' ), '&copy;', date( 'Y' ), esc_html( get_bloginfo( 'name' ) ) ); ?>

		</div>

		<?php
	}
}


if ( ! function_exists( 'aemi_footer_wp_footer' ) )
{
	function aemi_footer_wp_footer()
	{
		if ( wp_footer() ) { ?>

			<?php wp_footer(); ?>

		<?php }
	}
}
