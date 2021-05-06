<?php


if (!function_exists('aemi_footer_widgets'))
{
	function aemi_footer_widgets()
	{
		$sidebar_id = 'footer-widget-area';

		$total_widgets = wp_get_sidebars_widgets();
		
		if (is_active_sidebar($sidebar_id) && count($total_widgets[$sidebar_id]) > 0)
		{

			$width = preg_replace( '/_/', '-', get_theme_mod('aemi_widget_footer_width','default_width'));
			$columns = preg_replace( '/_/', '-', get_theme_mod('aemi_widget_footer_column_layout','two_columns'));

			?><div id="footer-widgets">
				<div class="widget-area <?php echo esc_attr( "$width $columns" ) ?>"><?php
					dynamic_sidebar( 'footer-widget-area' );
				?></div>
			</div><?php
		}
	}
}


if (!function_exists('aemi_footer_site_description'))
{
	function aemi_footer_site_description()
	{
		if (get_bloginfo('description'))
		{
			printf(
				'<strong id="site-description" class="site-description h3">%s</strong>',
				esc_html(get_bloginfo('description'))
			);
		}
	}
}


if (!function_exists('aemi_footer_menu'))
{
	function aemi_footer_menu()
	{
		if (has_nav_menu('footer-menu'))
		{
			?><nav id="footer-menu"><?php
				wp_nav_menu([
					'theme_location' => 'footer-menu',
					'depth' => '1'
				]);
			?></nav><?php
		}
	}
}


if (!function_exists('aemi_footer_credit'))
{
	function aemi_footer_credit()
	{
		?><span id="site-credit"><?php
			printf(
				__('%1$s %2$s %3$s. All Rights Reserved.', 'aemi'),
				'&copy;',
				date('Y'),
				esc_html(get_bloginfo('name'))
			);
		?></span><?php
	}
}


if (!function_exists('aemi_footer_wp_footer'))
{
	function aemi_footer_wp_footer()
	{
		if (wp_footer())
		{
			wp_footer();
		}
	}
}
