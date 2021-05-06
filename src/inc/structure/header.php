<?php

if (!function_exists('aemi_theme_switcher'))
{
	function aemi_theme_switcher()
	{
		$scheme = get_theme_mod('aemi_color_scheme', 'auto');
		$s = ' checked';
		?><div id="header-settings" class="header-block">
			<form class="settings-set" id="color-scheme-selector">
				<div class="color-scheme-option">
					<input type="radio" id="light-scheme-option" class="color-scheme-input" name="color-scheme-option"<?php echo $scheme == 'light' ? $s : '' ?>>
					<label for="light-scheme-option" class="color-scheme-label"><?php echo esc_html__('Light', 'aemi'); ?></label>
				</div>
				<div class="color-scheme-option">
					<input type="radio" id="dark-scheme-option" class="color-scheme-input" name="color-scheme-option"<?php echo $scheme == 'dark' ? $s : '' ?>>
					<label for="dark-scheme-option" class="color-scheme-label"><?php echo esc_html__('Dark', 'aemi'); ?></label>
				</div>
				<div class="color-scheme-option">
					<input type="radio" id="auto-scheme-option" class="color-scheme-input" name="color-scheme-option"<?php echo $scheme == 'auto' ? $s : '' ?>>
					<label for="auto-scheme-option" class="color-scheme-label"><?php echo esc_html__('Auto', 'aemi'); ?></label>
				</div>
			</form>
		</div><?php
	}
}


if (!function_exists('aemi_overlay_menu'))
{
	function aemi_overlay_menu()
	{
		
		$scheme_selector = is_enabled('aemi_color_scheme_user', 0);
		$has_overlay_menu = has_nav_menu('overlay-menu');
		$sidebar_id = 'overlay-widget-area';
		$total_widgets = wp_get_sidebars_widgets();
		$overlay_widgets = count($total_widgets[$sidebar_id]) > 0;

		$just_mobile = !($scheme_selector || $has_overlay_menu || $overlay_widgets);

		?><button id="navigation-toggle" title="<?php echo esc_attr__('Menu', 'aemi') ?>" data-target="navigation-wrapper" class="no-style toggle <?php echo esc_attr( $just_mobile ? 'just-mobile' : '') ?>">
			<span class="top-bar" ></span>
			<span class="middle-bar" ></span>
			<span class="bottom-bar" ></span>
		</button><?php
	}
}


if (!function_exists('aemi_header_menu'))
{
	function aemi_header_menu()
	{
		if (has_nav_menu('header-menu'))
		{
			wp_nav_menu([
				'theme_location'=>	'header-menu',
				'container'		=>	'',
				'menu_id'		=>	'header-menu',
				'menu_class'	=>	'header-menu',
				'depth'			=>	'2'
			]);
		}
	}
}


if (!function_exists('aemi_header_branding'))
{
	function aemi_header_branding()
	{

		global $has_custom_logo, $has_jetpack_logo, $has_aemi_logo, $has_logo;



		
		$light_scheme_logo = wp_get_attachment_url( get_theme_mod('aemi_light_scheme_logo') );
		$dark_scheme_logo = wp_get_attachment_url( get_theme_mod('aemi_dark_scheme_logo') );
		$has_light_scheme_logo = isset($light_scheme_logo) && $light_scheme_logo != '';
		$has_dark_scheme_logo = isset($dark_scheme_logo) && $dark_scheme_logo != '';
		
		$color_scheme = get_theme_mod('aemi_color_scheme','auto');
		$scheme_user_pref = is_enabled('aemi_color_scheme_user',0);

		$lazy_load = $scheme_user_pref || $color_scheme == 'auto';

		$has_aemi_logo = $has_light_scheme_logo || $has_dark_scheme_logo;
		$has_custom_logo = function_exists('the_custom_logo') ? has_custom_logo() : false;
		$has_jetpack_logo = function_exists('jetpack_has_site_logo') ? jetpack_has_site_logo() : false;
		
		$has_logo = $has_custom_logo || $has_jetpack_logo || $has_aemi_logo;

		printf(
			'<div id="site-branding">%1$s',
			$has_logo ? '' : sprintf(
				'<a href="%1$s" title="%2$s - %3$s" rel="home">',
				esc_url(home_url()),
				esc_attr(get_bloginfo('name')),
				esc_attr__('Home', 'aemi')
			)
		);

		$home = is_home();
		$front_page = is_front_page();

		$custom_title = get_theme_mod('aemi_homepage_header_custom_title','') != '';

		printf(
			'<%1$s id="site-title" class="site-title%2$s %3$s">%4$s</%1$s>',
			$home && !$custom_title ? 'h1' : 'strong',
			$has_logo ? ' screen-reader-text' : '',
			$home ? '' : 'h1',
			esc_html(get_bloginfo('name'))
		);

		if ($has_logo)
		{
			if ($has_custom_logo || $has_jetpack_logo || $has_aemi_logo)
			{
				?><div id="site-logo"><?php
				if ($has_light_scheme_logo && ($color_scheme != 'dark' || $scheme_user_pref))
				{

					?><div class="light-scheme-logo"><?php

					printf(
						'<a href="%1$s" class="custom-logo-link" title="%2$s • %3$s" rel="home"><img src="%4$s" alt="%2$s Logo for Light Scheme" height="40"%5$s></a>',
						esc_url(home_url()),
						esc_attr(get_bloginfo('name')),
						esc_attr__('Home', 'aemi'),
						esc_url(aemi_ensure_https($light_scheme_logo)),
						$lazy_load ? ' loading="lazy"' : ''
					);

					?></div><?php

				}
				else if ($has_custom_logo || $has_jetpack_logo)
				{
					$scheme_class = '';
					if ($has_aemi_logo)
					{
						$scheme_class = ' class="' . ($has_light_scheme_logo ? 'dark' : 'light') . '"';
					}

					$logo_src = '';
					if ($has_custom_logo)
					{
						$logo_src = $has_custom_logo ? wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'aemi-logo' ) : jetpack_get_site_logo();
					}

					?><div<?php echo $scheme_class ?>><?php echo sprintf(
						'<a href="%1$s" class="custom-logo-link" title="%2$s • %3$s" rel="home"><img src="%4$s" alt="%2$s Logo for Dark Scheme" height="40"></a>',
						esc_url(home_url()),
						esc_attr(get_bloginfo('name')),
						esc_attr__('Home', 'aemi'),
						esc_url(aemi_ensure_https($logo_src))

					) ?></div><?php
				}
				if ($has_dark_scheme_logo)
				{
					?><div class="dark-scheme-logo"><?php

					printf(
						'<a href="%1$s" class="custom-logo-link" title="%2$s • %3$s" rel="home"><img src="%4$s" alt="%2$s Logo for Dark Scheme" height="40"%5$s></a>',
						esc_url(home_url()),
						esc_attr(get_bloginfo('name')),
						esc_attr__('Home', 'aemi'),
						esc_url(aemi_ensure_https($dark_scheme_logo)),
						$lazy_load ? ' loading="lazy"' : ''
					);

					?></div><?php
				}
				?></div><?php
			}
		}

		$home = is_home();

		printf( '%s', $has_logo ? '' : '</a>' );

		?></div><?php
	}
}


if (!function_exists('aemi_header_search'))
{
	function aemi_header_search()
	{
		if (is_enabled('aemi_search_button_display', 1))
		{
			?><button id="search-toggle" title="<?php echo esc_attr__('Search', 'aemi') ?>" class="no-style toggle" data-target="search-wrapper">
				<span class="search-icon"></span>
			</button><?php
		}
	}
}