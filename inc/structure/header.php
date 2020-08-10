<?php

if (!function_exists('aemi_theme_switcher'))
{
	function aemi_theme_switcher()
	{
		$scheme = get_theme_mod('aemi_color_scheme', 'auto');
		$s = ' checked';
		?><div id="header-settings" class="header-section">
			<form class="settings-set" id="color-scheme-selector">
				<div class="color-scheme-option">
					<input type="radio" id="light-scheme-option" class="color-scheme-input" name="color-scheme-option"<?= $scheme == 'light' ? $s : '' ?>>
					<label for="light-scheme-option" class="color-scheme-label"><?= esc_html__('Light', 'aemi'); ?></label>
				</div>
				<div class="color-scheme-option">
					<input type="radio" id="dark-scheme-option" class="color-scheme-input" name="color-scheme-option"<?= $scheme == 'dark' ? $s : '' ?>>
					<label for="dark-scheme-option" class="color-scheme-label"><?= esc_html__('Dark', 'aemi'); ?></label>
				</div>
				<div class="color-scheme-option">
					<input type="radio" id="auto-scheme-option" class="color-scheme-input" name="color-scheme-option"<?= $scheme == 'auto' ? $s : '' ?>>
					<label for="auto-scheme-option" class="color-scheme-label"><?= esc_html__('Auto', 'aemi'); ?></label>
				</div>
			</form>
		</div><?php
	}
}


if (!function_exists('aemi_overlay_menu'))
{
	function aemi_overlay_menu()
	{
		?><button id="navigation-toggle" title="<?= esc_attr__('Menu', 'aemi') ?>" data-target="navigation-wrapper" class="no-style toggle">
			<span class="top-bar" ></span>
			<span class="middle-bar" ></span>
			<span class="bottom-bar" ></span>
		</button><?php
	}
}

if (!function_exists('aemi_header_branding'))
{
	function aemi_header_branding()
	{

		global $has_custom_logo;
		global $has_jetpack_custom_logo;
		global $has_logo;

		$has_custom_logo = function_exists('the_custom_logo') && has_custom_logo();
		$has_jetpack_custom_logo = function_exists('jetpack_has_site_logo') && jetpack_has_site_logo();
		$light_scheme_logo = get_theme_mod('aemi_light_scheme_logo');
		$dark_scheme_logo = get_theme_mod('aemi_dark_scheme_logo');
		$has_light_scheme_logo = $light_scheme_logo != '';
		$has_dark_scheme_logo = $dark_scheme_logo != '';
		$has_aemi_custom_logo = $has_light_scheme_logo || $has_dark_scheme_logo;
		$has_logo = $has_custom_logo || $has_jetpack_custom_logo || $has_dark_scheme_logo || $has_light_scheme_logo;

		printf(
			'<div id="site-branding">%1$s',
			$has_logo ? '' : sprintf(
				'<a href="%1$s" title="%2$s - %3$s" rel="home">',
				esc_url(home_url()),
				esc_attr(get_bloginfo('name')),
				esc_attr__('Home', 'aemi')
			)
		);

		printf(
			'<%1$s id="site-title" class="site-title%2$s %3$s">%4$s</%1$s>',
			$home ? 'h1' : 'strong',
			$has_logo ? ' screen-reader-text' : '',
			$home ? '' : 'h1',
			esc_html(get_bloginfo('name'))
		);

		if ($has_logo)
		{
			if ($has_custom_logo || $has_aemi_custom_logo)
			{
				?><div id="site-logo"><?php
				if ($has_light_scheme_logo) {

					?><div class="light-scheme-logo"><?php

					printf(
						'<a href="%1$s" class="custom-logo-link" title="%2$s - %3$s" rel="home"><img src="%4$s" alt="%2$s Logo for Light Scheme"></a>',
						esc_url(home_url()),
						esc_attr(get_bloginfo('name')),
						esc_attr__('Home', 'aemi'),
						$light_scheme_logo
					);

					?></div><?php

				}
				else if ($has_custom_logo)
				{
					?><div class="light-scheme-logo"><?php the_custom_logo(); ?></div><?php
				}
				if ($has_dark_scheme_logo)
				{
					?><div class="dark-scheme-logo"><?php

					printf(
						'<a href="%1$s" class="custom-logo-link" title="%2$s - %3$s" rel="home"><img src="%4$s" alt="%2$s Logo for Dark Scheme"></a>',
						esc_url(home_url()),
						esc_attr(get_bloginfo('name')),
						esc_attr__('Home', 'aemi'),
						$dark_scheme_logo
					);

					?></div><?php
				}
				?></div><?php
			}
			else if ($has_jetpack_custom_logo)
			{
				jetpack_the_site_logo();
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
		if (get_theme_mod('aemi_search_button_display', 1) == 1)
		{
			?><button id="search-toggle" title="<?= esc_attr__('Search', 'aemi') ?>" class="no-style toggle" data-target="search-wrapper">
				<span class="search-icon"></span>
			</button><?php
		}
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
