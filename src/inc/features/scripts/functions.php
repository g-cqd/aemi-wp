<?php

if ( ! function_exists( 'aemi_async_script' ) ) {
	/**
	 * Register script on which add async attribute.
	 *
	 * @param string $script_tag Script tag on which add an async attribute.
	 */
	function aemi_async_script( $script_tag ) {
		global $async_scripts;
		if ( ! isset( $async_scripts ) ) {
			$async_scripts = array();
		}
		$async_scripts[] = $script_tag;
	}
}

if ( ! function_exists( 'aemi_async_scripts' ) ) {
	/**
	 * Register scripts on which add async attribute.
	 *
	 * @param scripts_tag $scripts_tag Script tags on which add an async attribute.
	 */
	function aemi_async_scripts( $scripts_tag ) {
		global $async_scripts;

		if ( ! isset( $async_scripts ) ) {
			$async_scripts = array();
		}

		foreach ( $scripts_tag as $script ) {
			$async_scripts[] = $script;
		}
	}
}

if ( ! function_exists( 'aemi_async_scripts_filter' ) ) {
	/**
	 * Add an async attribute to an enqueued script.
	 *
	 * @param tag    $tag    Enqueued script tag.
	 * @param handle $handle Script to test.
	 * @return mixed
	 */
	function aemi_async_scripts_filter( $tag, $handle ) {
		global $async_scripts;

		if ( ! isset( $async_scripts ) ) {
			$async_scripts = array();
		}

		foreach ( $async_scripts as $script ) {
			if ( $script === $handle ) {
				return strtr( $tag, array( ' src' => ' async src' ) );
			}
		}
		return $tag;
	}
}

if ( ! function_exists( 'aemi_defer_script' ) ) {
	/**
	 * Register script on which add defer attribute.
	 *
	 * @param string $script_tag Script tag on which add an defer attribute.
	 */
	function aemi_defer_script( $script_tag ) {
		global $defer_scripts;
		if ( ! isset( $defer_scripts ) ) {
			$defer_scripts = array();
		}
		$defer_scripts[] = $script_tag;
	}
}

if ( ! function_exists( 'aemi_defer_scripts' ) ) {
	/**
	 * Register scripts on which add defer attribute.
	 *
	 * @param scripts_tag $scripts_tag Script tags on which add an defer attribute.
	 */
	function aemi_defer_scripts( $scripts_tag ) {
		global $defer_scripts;
		if ( ! isset( $defer_scripts ) ) {
			$defer_scripts = array();
		}
		foreach ( $scripts_tag as $script ) {
			$defer_scripts[] = $script;
		}
	}
}

if ( ! function_exists( 'aemi_defer_scripts_filter' ) ) {
	/**
	 * Add a defer attribute to an enqueued script.
	 *
	 * @param tag    $tag    Enqueued script tag.
	 * @param handle $handle Script to test.
	 * @return mixed
	 */
	function aemi_defer_scripts_filter( $tag, $handle ) {
		global $defer_scripts;
		if ( ! isset( $defer_scripts ) ) {
			$defer_scripts = array();
		}
		foreach ( $defer_scripts as $script ) {
			if ( $script === $handle ) {
				return strtr( $tag, array( ' src' => ' defer src' ) );
			}
		}
		return $tag;
	}
}

if ( ! function_exists( 'aemi_module_script' ) ) {
	/**
	 * Register script on which add module type.
	 *
	 * @param string $script_tag Script tag on which add module type.
	 */
	function aemi_module_script( $script_tag ) {
		global $module_scripts;
		if ( ! isset( $module_scripts ) ) {
			$module_scripts = array();
		}
		$module_scripts[] = $script_tag;
	}
}

if ( ! function_exists( 'aemi_module_scripts' ) ) {
	/**
	 * Register scripts on which add module type.
	 *
	 * @param scripts_tag $scripts_tag Script tags on which add module type.
	 */
	function aemi_module_scripts( $scripts_tag ) {
		global $module_scripts;
		if ( ! isset( $module_scripts ) ) {
			$module_scripts = array();
		}
		foreach ( $scripts_tag as $script ) {
			$module_scripts[] = $script;
		}
	}
}

if ( ! function_exists( 'aemi_module_scripts_filter' ) ) {
	/**
	 * Add a module type attribute to an enqueued script.
	 *
	 * @param tag    $tag    Enqueued script tag.
	 * @param handle $handle Script to test.
	 * @return mixed
	 */
	function aemi_module_scripts_filter( $tag, $handle ) {
		global $module_scripts;
		if ( ! isset( $module_scripts ) ) {
			$module_scripts = array();
		}
		foreach ( $module_scripts as $script ) {
			if ( $script === $handle ) {
				return strtr( $tag, array( 'script ' => 'script type="module"' ) );
			}
		}
		return $tag;
	}
}

if ( ! function_exists( 'aemi_register_script' ) ) {
	function aemi_register_script( $handle, $src = '', $deps = array(), $in_footer = false ) {
		wp_register_script( $handle, $src, $deps, wp_get_theme( 'aemi' )['Version'], $in_footer );
	}
}

if ( ! function_exists( 'aemi_enqueue_script' ) ) {
	function aemi_enqueue_script( $handle, $modes = array() ) {
		wp_enqueue_script( $handle );
		if ( in_array( 'defer', $modes, true ) ) {
			aemi_defer_script( $handle );
		}
		if ( in_array( 'async', $modes, true ) ) {
			aemi_async_script( $handle );
		}
		if ( in_array( 'module', $modes, true ) ) {
			aemi_module_script( $handle );
		}
	}
}

if ( ! function_exists( 'aemi_register_style' ) ) {
	function aemi_register_style( $handle, $src, $deps = array(), $media = 'all' ) {
		wp_register_style( $handle, $src, $deps, wp_get_theme( 'aemi' )['Version'], $media );
	}
}
if ( ! function_exists( 'aemi_preprocess_resources' ) ) {
	function aemi_preprocess_resources() {

		$wp_scripts = wp_scripts();
		$wp_styles  = wp_styles();

		global $module_scripts;

		$script_handles = apply_filters( 'aemi_preload_script', array() );
		$style_handles  = apply_filters( 'aemi_preload_style', array() );
		$domains        = apply_filters( 'aemi_preload_domain', array() );
		$fonts          = apply_filters( 'aemi_preload_font', array() );

		foreach ( $script_handles as $handle ) {
			$script = $wp_scripts->registered[ $handle ];
			$source = $script->src . ( $script->ver ? "?ver={$script->ver}" : '' );
			if ( in_array( $handle, $module_scripts, true ) ) {
				echo '<link rel="modulepreload" href="' . esc_url( $source ) . '" as="script"/>';
			} else {
				echo '<link rel="preload" href="' . esc_url( $source ) . '" as="script"/>';
			}
		}

		foreach ( $style_handles as $handle ) {
			$style  = $wp_styles->registered[ $handle ];
			$source = $style->src . ( $script->ver ? "?ver={$style->ver}" : '' );
			echo '<link rel="preload" href="' . esc_url( $source ) . '" as="style"/>';
		}

		foreach ( $domains as $domain ) {
			echo '<link rel="dns-prefetch" href="' . esc_url( $domain ) . '"/>';
		}

		foreach ( $fonts as $font ) {
			$source = $font['src'];
			$type   = $font['type'];
			$cors   = $font['cors'];
			echo '<link rel="preload" href="' . esc_url( $source ) . '" as="font" type="font/' . esc_attr( $type ) . '" ' . ( $cors ? 'crossorigin' : '' ) . '/>';
		}

	}
}

if ( ! function_exists( 'aemi_default_preload_script' ) ) {
	function aemi_default_preload_script( $handles ) {
		if ( WP_DEBUG ) {
			$handles[] = 'aemi-script-debug';
		} else {
			$handles[] = 'aemi-script';
		}
		return $handles;
	}
}

if ( ! function_exists( 'aemi_default_preload_style' ) ) {
	function aemi_default_preload_style( $handles ) {
		if ( WP_DEBUG ) {
			$handles[] = 'aemi-standard-debug';
			$handles[] = 'aemi-theme-debug';
			$handles[] = 'aemi-fonts-debug';
			$handles[] = 'aemi-wordpress-debug';
		} else {
			$handles[] = 'aemi-standard';
			$handles[] = 'aemi-theme';
			$handles[] = 'aemi-fonts';
			$handles[] = 'aemi-wordpress';
		}
		return $handles;
	}
}

if ( ! function_exists( 'aemi_default_preload_domain' ) ) {
	function aemi_default_preload_domain( $domains ) {
		if ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
			$agent = $_SERVER['HTTP_USER_AGENT'];
			if ( ! preg_match( '/(Mac|iPad|iPhone|iPod)/i', $agent ) ) {
				$domains[] = 'https://rsms.me/';
			}
		}
		return $fonts;
	}
}

if ( ! function_exists( 'aemi_default_preload_font' ) ) {
	function aemi_default_preload_font( $fonts ) {
		if ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
			$agent = $_SERVER['HTTP_USER_AGENT'];
			if ( ! preg_match( '/(Mac|iPad|iPhone|iPod)/i', $agent ) ) {
				$fonts[] = array(
					'src'  => 'https://rsms.me/inter/font-files/Inter-roman.var.woff2',
					'type' => 'woff2',
					'cors' => true,
				);
			}
		}
		return $fonts;
	}
}

if ( ! function_exists( 'aemi_scripts' ) ) {
	function aemi_scripts() {
		/**
		 * Register Styles
		 */
		aemi_register_style(
			'aemi-style-debug',
			get_stylesheet_uri()
		);

		aemi_register_style(
			'aemi-theme-debug',
			get_template_directory_uri() . '/assets/css/public/aemi.css'
		);

		aemi_register_style(
			'aemi-standard-debug',
			get_template_directory_uri() . '/assets/css/public/standard.css'
		);

		aemi_register_style(
			'aemi-fonts-debug',
			get_template_directory_uri() . '/assets/css/public/fonts.css'
		);

		aemi_register_style(
			'aemi-wordpress-debug',
			get_template_directory_uri() . '/assets/css/public/wordpress.css'
		);

		aemi_register_style(
			'aemi-theme',
			get_template_directory_uri() . '/assets/css/min/aemi.css'
		);

		aemi_register_style(
			'aemi-standard',
			get_template_directory_uri() . '/assets/css/min/standard.css'
		);

		aemi_register_style(
			'aemi-fonts',
			get_template_directory_uri() . '/assets/css/min/fonts.css'
		);

		aemi_register_style(
			'aemi-wordpress',
			get_template_directory_uri() . '/assets/css/min/wordpress.css'
		);

		aemi_register_style(
			'aemi-gutenberg-style',
			get_template_directory_uri() . '/assets/css/admin/gutenberg.style.css'
		);
		/**
		 * Override default Scripts
		 */
		wp_deregister_script( 'comment-reply' );
		aemi_register_script( 'comment-reply', '/wp-includes/js/comment-reply.min.js' );

		wp_deregister_script( 'wp-embed' );
		aemi_register_script( 'wp-embed', '/wp-includes/js/wp-embed.min.js' );

		/**
		 * Register Aemi Script
		 */
		aemi_register_script(
			'aemi-script-debug',
			get_template_directory_uri() . '/assets/js/aemi.js'
		);

		aemi_register_script(
			'aemi-script',
			get_template_directory_uri() . '/assets/js/aemi.min.js'
		);

		/**
		 * Dequeue Default Style
		 */
		wp_dequeue_style( 'wp-block-library' );

		/**
		 * Enqueue Styles and Scripts depending on debug mode
		 */
		if ( WP_DEBUG ) {
			/**
			 * Enqueue Styles
			 */
			wp_enqueue_style( 'aemi-style-debug' );
			wp_enqueue_style( 'aemi-fonts-debug' );
			wp_enqueue_style( 'aemi-standard-debug' );
			wp_enqueue_style( 'aemi-theme-debug' );
			wp_enqueue_style( 'aemi-wordpress-debug' );
			/**
			 * Enqueue Scripts
			 */
			aemi_enqueue_script( 'aemi-script-debug', array( 'defer', 'module' ) );
		} else {
			/**
			 * Enqueue Styles
			 */
			wp_enqueue_style( 'aemi-fonts' );
			wp_enqueue_style( 'aemi-standard' );
			wp_enqueue_style( 'aemi-theme' );
			wp_enqueue_style( 'aemi-wordpress' );
			/**
			 * Enqueue Scripts
			 */
			aemi_enqueue_script( 'aemi-script', array( 'defer', 'module' ) );
		}
		/**
		 * Add Comment Script if necessary
		 */
		if (
			is_enabled( 'aemi_display_comments', 1 ) &&
			is_singular() && comments_open() &&
			get_option( 'thread_comments' )
		) {
			aemi_enqueue_script( 'comment-reply', array( 'defer' ) );
		}

		aemi_enqueue_script( 'wp-embed', array( 'defer' ) );
	}
}

if ( ! function_exists( 'aemi_gutenberg_editor_style' ) ) {
	function aemi_gutenberg_editor_style() {
		wp_enqueue_style( 'aemi-gutenberg-style' );
	}
}

if ( ! function_exists( 'aemi_header_script' ) ) {
	function aemi_header_script() {
		$header_script = get_theme_mod( 'aemi_header_js_code', '' );
		if ( ! empty( $header_script ) ) {
			aemi_register_script( 'aemi-custom-header-script' );
			aemi_enqueue_script( 'aemi-custom-header-script' );
			wp_add_inline_script( 'aemi-custom-header-script', $header_script );
		}
	}
}

if ( ! function_exists( 'aemi_footer_script' ) ) {
	function aemi_footer_script() {
		$footer_script = get_theme_mod( 'aemi_footer_js_code', '' );
		if ( ! empty( $footer_script ) ) {
			aemi_register_script( 'aemi-custom-footer-script' );
			aemi_enqueue_script( 'aemi-custom-footer-script' );
			wp_add_inline_script( 'aemi-custom-footer-script', $footer_script );
		}
	}
}
