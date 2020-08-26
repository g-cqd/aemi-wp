<?php

if (!function_exists('aemi_aside_search'))
{
    function aemi_aside_search()
    {
        if (get_theme_mod('aemi_search_button_display', 1) == 1)
        {
            ?><div id="search-wrapper" class="wrapper">
		    	<?php get_search_form(); ?>
            </div><?php
        }
    }
}

if (!function_exists('aemi_aside_wrapper_menu'))
{
    function aemi_aside_wrapper_menu()
    {

		$has_header_menu = has_nav_menu('header-menu');
		$has_overlay_menu = has_nav_menu('overlay-menu');

		?><nav id="navigation-wrapper" class="wrapper"><?php

            if (has_nav_menu('header-menu'))
            {
				?><div class="header-block<?php echo esc_attr( $has_overlay_menu ? '' : ' no-overlay-menu' ) ?>"><?php
                wp_nav_menu([
                    'theme_location'	=>	'header-menu',
                    'container'	=>	'',
                    'menu_id'	=>	'overlay-header-menu',
                    'menu_class'	=>	'overlay-header-menu menu',
                    'depth'		=>	'2'
                ]);
            }
			if (has_nav_menu('overlay-menu'))
			{
				wp_nav_menu([
					'theme_location'	=>	'overlay-menu',
					'container'	=>	'',
					'menu_id'	=>	'overlay-menu',
					'menu_class'	=>	'overlay-menu menu',
					'depth'	=>	'4'
				]);
			}
			?></div><?php
			if (has_nav_menu('social-menu'))
			{
				wp_nav_menu([
					'theme_location'	=>	'social-menu',
					'container'	=>	'',
					'menu_id'	=>	'header-social',
                    'menu_class'	=>	'header-block',
                    'depth'	=>	'1'
				]);
			}

			if (get_theme_mod('aemi_color_scheme_user', 0) == 1)
			{
				aemi_theme_switcher();
			}

			$sidebar_id = 'overlay-widget-area';

			$total_widgets = wp_get_sidebars_widgets();

			$overlay_widgets = count($total_widgets[$sidebar_id]) > 0;
		
			if (is_active_sidebar($sidebar_id) && $overlay_widgets)
			{

				$width = preg_replace( '/_/', '-', get_theme_mod('aemi_widget_overlay_width','default_width'));
				$columns = preg_replace( '/_/', '-', get_theme_mod('aemi_widget_overlay_column_layout','one_column'));

				?><div id="overlay-widgets">
					<div class="widget-area <?php echo esc_attr( "$width $columns" ) ?>"><?php
						dynamic_sidebar( 'overlay-widget-area' );
					?></div>
				</div><?php
			}
		?>
		</nav><?php
    }
}

if (!function_exists('aemi_aside_progress_bar'))
{
	function aemi_aside_progress_bar()
	{
		if (
			get_theme_mod(aemi_setting(get_post_type(), 'progress_bar'), 1) == 1 &&
			is_singular())
		{
			?><div id="site-progress-bar"<?php echo has_post_thumbnail() ? ' class="color-scheme-dark"' : '' ?>></div><?php
		}
	}
}