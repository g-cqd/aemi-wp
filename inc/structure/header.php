<?php
if ( ! function_exists( 'aemi_header_menu' ) )
{
	function aemi_header_menu()
	{
		?><a class="skip-link screen-reader-text" href="#content"><?php
			esc_html_e( 'Skip to content', 'aemi' );
		?></a>
		<nav id="header-menu" role="navigation">
			<div id="toggle-header-menu" class="toggle">
				<a id="toggle-element" href="javascript:void(0);">
					<span></span>
					<span></span>
					<span></span>
				</a>
			</div>
			<div id="header-menu-wrap" class="wrap"><?php
			if ( has_nav_menu( 'header-menu' ) )
			{
				wp_nav_menu( array(
					'theme_location' => 'header-menu',
					'container' => '',
					'menu_id' => 'header-menu',
					'menu_class' => 'header-section menu'
				) );
			}
			if ( has_nav_menu( 'social-menu' ) )
			{
				wp_nav_menu( array(
					'theme_location' => 'social-menu',
					'container' => '',
					'depth' => '1',
					'menu_id' => 'header-social',
					'menu_class' => 'header-section'
				) );
			}
			if ( get_theme_mod( 'aemi_darkmode_display', 1 ) == 1 )
			{
				?><div id="header-settings" class="header-section">
					<div>
						<a id="darkmode" href="javascript:void(0);"><span class="off"><?php echo esc_html_x( 'Light','light mode text','aemi' ); ?></span><span class="on"><?php echo esc_html_x( 'Dark','dark mode text','aemi' ); ?></span></a>
					</div>
				</div><?php
			}
			if ( is_active_sidebar( 'header-widget-area' ) )
			{
				?><div class="toggle">
					<div id="toggle-widget"></div>
				</div>
				<div id="header-widgets"><?php
				dynamic_sidebar( 'header-widget-area' );
				?></div><?php
			}
			?></div>
		</nav><?php
	}
}


if ( ! function_exists( 'aemi_header_branding' ) )
{
	function aemi_header_branding()
	{
		?><div id="branding"><?php
		if ( has_custom_logo() )
		{
			?><div id="logo"><?php
			if ( function_exists( 'the_custom_logo' ) )
			{
				the_custom_logo();
			}
			?></div><?php
		}
		else if ( function_exists( 'jetpack_has_site_logo' ) && jetpack_has_site_logo() )
		{
			jetpack_the_site_logo();
		}
		else
		{
			?><h1 id="site-title" class="site-title">
				<a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home"><?php
					echo esc_html( get_bloginfo( 'name' ) );
				?></a>
			</h1><?php
		}
		?></div><?php
	}
}


if ( ! function_exists( 'aemi_header_search' ) )
{
	function aemi_header_search()
	{
		if ( get_theme_mod( 'aemi_search_button_display' ) == 1 )
		{
			?><div id="aemi-search">
				<a id="search-toggle" href="javascript:void(0);" class="toggle"><span class="icon"></span></a>
				<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
					<div id="search-container">
						<label>
							<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'aemi' ) ?></span>
							<input type="search" id="searchOverlay" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'aemi' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'aemi' ) ?>" />
					</label>
					<input type="submit" class="search-submit" value="<?php esc_html_e( '&#x23CE;', 'aemi' ); ?>" />
				</div>
				</form>
			</div><?php
		}
	}
}

if ( ! function_exists( 'aemi_progress_bar' ) )
{
	function aemi_progress_bar()
	{
		if ( get_theme_mod( 'aemi_type_'.get_post_type().'_progress_bar' ) == 1 && is_singular() )
		{
			?><div id="aemi-progress-bar"></div><?php
		}
	}
}
