<?php

if ( ! function_exists( 'aemi_aside_search' ) ) {
	function aemi_aside_search() {
		if ( get_theme_mod( 'aemi_search_button_display', 1 ) === 1 ) {
			?>
<div id="search-wrapper" class="wrapper">
			<?php get_search_form(); ?>
</div>
			<?php
		}
	}
}

if ( ! function_exists( 'aemi_aside_wrapper_menu' ) ) {
	function aemi_aside_wrapper_menu() {
		$is_header_menu_used  = is_menu_filled( 'header-menu' );
		$is_overlay_menu_used = is_menu_filled( 'overlay-menu' );
		$is_social_menu_used  = is_menu_filled( 'social-menu' );

		$is_any_menu_used = $is_header_menu_used || $is_overlay_menu_used || $is_social_menu_used;

		$sidebar_id              = 'overlay-widget-area';
		$every_widgets           = wp_get_sidebars_widgets();
		$has_overlay_widgets     = count( $every_widgets[ $sidebar_id ] ) > 0;
		$is_overlay_widgets_used = is_active_sidebar( $sidebar_id ) && $has_overlay_widgets;

		$is_scheme_selector_used = is_enabled( 'aemi_color_scheme_user', 0 );

		if ( $is_any_menu_used || $is_overlay_widgets_used || $is_scheme_selector_used ) {

			?>
<nav id="navigation-wrapper" class="wrapper">
			<?php
			if ( $is_header_menu_used ) {
				?>
	<div class="header-block<?php echo esc_attr( $is_overlay_menu_used ? '' : ' no-overlay-menu' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'header-menu',
						'container'      => '',
						'menu_id'        => 'overlay-header-menu',
						'menu_class'     => 'overlay-header-menu menu',
						'depth'          => '2',
					)
				);
			}
			if ( $is_overlay_menu_used ) {
				wp_nav_menu(
					array(
						'theme_location' => 'overlay-menu',
						'container'      => '',
						'menu_id'        => 'overlay-menu',
						'menu_class'     => 'overlay-menu menu',
						'depth'          => '4',
					)
				);
			}
			?>
	</div>
			<?php
			if ( $is_social_menu_used ) {
				wp_nav_menu(
					array(
						'theme_location' => 'social-menu',
						'container'      => '',
						'menu_id'        => 'header-social',
						'menu_class'     => 'header-block',
						'depth'          => '1',
					)
				);
			}

			if ( $is_scheme_selector_used ) {
				aemi_theme_switcher();
			}

			if ( $is_overlay_widgets_used ) {
				$width   = preg_replace( '/_/', '-', get_theme_mod( 'aemi_widget_overlay_width', 'default_width' ) );
				$columns = preg_replace( '/_/', '-', get_theme_mod( 'aemi_widget_overlay_column_layout', 'one_column' ) );
				?>
	<div id="overlay-widgets">
		<div class="widget-area <?php echo esc_attr( "$width $columns" ); ?>">
				<?php dynamic_sidebar( 'overlay-widget-area' ); ?>
		</div>
	</div>
				<?php
			}
			?>
</nav>
			<?php
		}
	}
}

if ( ! function_exists( 'aemi_aside_progress_bar' ) ) {
	function aemi_aside_progress_bar() {
		if (
			get_theme_mod( aemi_setting( get_post_type(), 'progress_bar' ), 1 ) === 1 &&
			is_singular()
		) {
			?>
<div id="site-progress-bar"<?php echo has_post_thumbnail() ? ' class="color-scheme-dark"' : ''; ?>></div>
			<?php
		}
	}
}
