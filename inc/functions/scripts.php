<?php

if (!function_exists('aemi_async_scripts'))
{
	function aemi_async_scripts($scripts_tag)
	{
		global $async_scripts;
		if (!isset($async_scripts))
		{
			$async_scripts = [];
		}
		foreach ($scripts_tag as $script)
		{
			$async_scripts[] = $script;
		}
	}
}


if (!function_exists('aemi_async_scripts_filter'))
{
	function aemi_async_scripts_filter($tag, $handle)
	{
		global $async_scripts;

		if (!isset($async_scripts))
		{
			$async_scripts = [];
		}

		foreach ($async_scripts as $script)
		{
			if ($script === $handle)
			{
				return str_replace(' src', ' async src', $tag);
			}
		}
		return $tag;
	}
}

if (!function_exists('aemi_defer_scripts'))
{
	function aemi_defer_scripts($scripts_tag)
	{
		global $defer_scripts;
		if (!isset($defer_scripts))
		{
			$defer_scripts = [];
		}
		foreach ($scripts_tag as $script)
		{
			$defer_scripts[] = $script;
		}
	}
}


if (!function_exists('aemi_defer_scripts_filter'))
{
	function aemi_defer_scripts_filter($tag, $handle)
	{
		global $defer_scripts;
		if (!isset($defer_scripts))
		{
			$defer_scripts = [];
		}
		foreach ($defer_scripts as $script)
		{
			if ($script === $handle)
			{
				return str_replace(' src', ' defer src', $tag);
			}
		}
		return $tag;
	}
}


if (!function_exists('aemi_module_scripts'))
{
	function aemi_module_scripts($scripts_tag)
	{
		global $module_scripts;
		if (!isset($module_scripts))
		{
			$module_scripts = [];
		}
		foreach ($scripts_tag as $script)
		{
			$module_scripts[] = $script;
		}
	}
}


if (!function_exists('aemi_module_scripts_filter'))
{
	function aemi_module_scripts_filter($tag, $handle)
	{
		global $module_scripts;
		if (!isset($module_scripts))
		{
			$module_scripts = [];
		}
		foreach ($module_scripts as $script)
		{
			if ($script === $handle)
			{
				return str_replace('script ', 'script type="module" ', $tag);
			}
		}
		return $tag;
	}
}


if (!function_exists('aemi_scripts'))
{
	function aemi_scripts()
	{
		/**
         * Register Styles
         */
		wp_register_style( 'aemi-fonts', get_template_directory_uri() . '/assets/css/public/fonts.css' );
		wp_register_style( 'aemi-standard', get_template_directory_uri() . '/assets/css/public/standard.css' );
		wp_register_style( 'aemi-styles', get_stylesheet_uri() );
		wp_register_style( 'aemi-wordpress', get_template_directory_uri() . '/assets/css/public/wordpress.css' );
		/**
         * Register Aemi Script
         */
		wp_register_script( 'aemi-script-debug', get_template_directory_uri() . '/assets/js/aemi.js', false, false, false );
		wp_register_script( 'aemi-script', get_template_directory_uri() . '/assets/js/aemi.min.js', false, false, false );
		/**
         * Enqueue Styles
         */
		wp_enqueue_style( 'aemi-fonts' );
		wp_enqueue_style( 'aemi-standard' );
		wp_enqueue_style( 'aemi-styles' );
		wp_enqueue_style( 'aemi-wordpress' );
		/**
         * Dequeue Default Style
         */
		wp_dequeue_style( 'wp-block-library' );
        /**
         * Mark Aemi Scrips as Modules
         */
		if ( WP_DEBUG ) {
            wp_enqueue_script( 'aemi-script-debug' );
            aemi_defer_scripts( ['aemi-script-debug'] );
            aemi_module_scripts( ['aemi-script-debug'] );
        }
        else {
            wp_enqueue_script( 'aemi-script' );
            aemi_defer_scripts( ['aemi-script' ]);
            aemi_module_scripts( ['aemi-script' ]);
        }
		/**
         * Add Comment Script if necessary
         */
		if (
			is_enabled('aemi_display_comments',1) &&
			is_singular() && comments_open() &&
			get_option('thread_comments')
		)
		{
			wp_enqueue_script('comment-reply');
		}
	}
}

if (!function_exists('aemi_gutenberg_editor_style'))
{
	function aemi_gutenberg_editor_style()
	{
		wp_enqueue_style( 'aemi-gutenberg-style', get_template_directory_uri() . '/assets/css/admin/gutenberg.style.css' );
	}
}

if (!function_exists('aemi_header_script'))
{
	function aemi_header_script()
	{
		$header_script = get_theme_mod('aemi_header_js_code');
		
		?><script id="aemi-custom-header-script" type="text/javascript"><?php echo $header_script ?></script><?php
		
	}
}

if (get_theme_mod('aemi_header_js_code','') != '')
{
	add_action('wp_head', 'aemi_header_script');
}


if (!function_exists('aemi_footer_script'))
{
	function aemi_footer_script()
	{
		$footer_script = get_theme_mod('aemi_footer_js_code');

		?><script id="aemi-custom-footer-script" type="text/javascript"><?php echo $footer_script ?></script><?php

	}
}
if (get_theme_mod('aemi_footer_js_code','') != '')
{
	add_action('wp_head', 'aemi_footer_script');
}
