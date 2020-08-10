<?php

if (!function_exists('aemi_aside_search'))
{
    function aemi_aside_search()
    {
        if (get_theme_mod('aemi_search_button_display', 1) == 1)
        {
            ?><div id="search-wrapper" class="wrapper">
		    	<form role="search" method="get" class="search-form" action="<?= home_url('/') ?>">
		    		<div id="search-container">
						<label class="screen-reader-text"><?= esc_html__('Search for &hellip;', 'aemi') ?></label>
	    				<input type="search" id="search-input" class="search-input" placeholder="<?= esc_attr__('Search for &hellip;', 'aemi') ?>" value="<?= get_search_query() ?>" name="s" title="<?= esc_attr__('Search for &hellip;', 'aemi') ?>" />
	    				<button type="submit" class="search-submit no-style" title="<?= esc_attr__('Search','aemi') ?>">
	    					<span class="search-icon"></span>
	    				</button>
	    			</div>
                </form>
            </div><?php
        }
    }
}

if (!function_exists('aemi_aside_wrapper_menu'))
{
    function aemi_aside_wrapper_menu()
    {
        ?><nav id="navigation-wrapper" class="wrapper"><?php
            if (has_nav_menu('header-menu'))
            {
                wp_nav_menu([
                    'theme_location'	=>	'header-menu',
                    'container'	=>	'',
                    'menu_id'	=>	'overlay-header-menu',
                    'menu_class'	=>	'header-section overlay-header-menu menu',
                    'depth'		=>	'2'
                ]);
            }
			if (has_nav_menu('overlay-menu'))
			{
				wp_nav_menu([
					'theme_location'	=>	'overlay-menu',
					'container'	=>	'',
					'menu_id'	=>	'overlay-menu',
					'menu_class'	=>	'header-section menu',
					'depth'	=>	'4'
				]);
			}
			if (has_nav_menu('social-menu'))
			{
				wp_nav_menu([
					'theme_location'	=>	'social-menu',
					'container'	=>	'',
					'menu_id'	=>	'header-social',
                    'menu_class'	=>	'header-section',
                    'depth'	=>	'1'
				]);
			}

			if (get_theme_mod('aemi_color_scheme_user', 0) == 1)
			{
				aemi_theme_switcher();
			}

			if (is_active_sidebar('header-widget-area'))
			{
				?><div class="toggle" data-target="header-widgets"></div>
				<div id="header-widgets"><?php
					dynamic_sidebar('header-widget-area');
				?></div><?php
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
			get_theme_mod('aemi_type_'.get_post_type().'_progress_bar', 1) == 1 &&
			is_singular())
		{
			?><div id="site-progress-bar"<?= has_post_thumbnail() ? ' class="color-scheme-dark"' : '' ?>></div><?php
		}
	}
}