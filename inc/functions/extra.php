<?php


if (!function_exists('aemi_body_classes'))
{
	function aemi_body_classes($classes)
	{

		// Color Scheme Preferences
		$scheme = get_theme_mod('aemi_color_scheme', 'auto');
		$user_pref_scheme = get_theme_mod('aemi_color_scheme_user', 0) == 0;
		$scheme_class = 'color-scheme';
		if ($user_pref_scheme && $scheme != 'auto') {
			$classes[] = $scheme_class . '-' . $scheme;
			$classes[] = 'force-color-scheme';
		}
		else if ($scheme == 'auto')
		{
			$classes[] = 'auto-color-scheme';
		}

		$classes[] = is_singular() ? 'singular' : 'not-singular';

		if (has_post_thumbnail())
		{
			$classes[] = 'has-post-thumbnail';
		}
		if (is_active_sidebar('sidebar-widget-area'))
		{
			$classes[] = 'sidebar';
		}
		if (current_user_can('edit_posts'))
		{
			$classes[] = 'editable';
		}
		if (get_theme_mod('aemi_header_autohiding', 1) == 1)
		{
			$classes[] = 'auto-hide';
		}
		return $classes;
	}
}

if (!function_exists('aemi_remove_jquery_migrate'))
{
	function aemi_remove_jquery_migrate($scripts)
	{
		if (!is_admin() && isset($scripts->registered['jquery']))
		{
			$script = $scripts->registered['jquery'];
			if ($script->deps)
			{
				$script->deps = array_diff($script->deps, array('jquery-migrate'));
			}
		}
	}
}


/*'function aemi_html_tag_schema()
{
	$schema 	= 'http://schema.org/';
	$type 		= 'WebPage';
	if ( is_singular( 'post' ) )
	{
		$type 	= 'Article';
	}
	else if ( is_author() )
	{
		$type 	= 'ProfilePage';
	}
	else if ( is_search() )
	{
		$type 	= 'SearchResultsPage';
	}
	echo 'itemscope="itemscope" itemtype="' . esc_attr( $schema ) . esc_attr( $type ) . '"';
}*/


if (!function_exists('aemi_category_transient_flusher'))
{
	function aemi_category_transient_flusher()
	{
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		{
			return;
		}
		delete_transient('aemi_categories');
	}
}


if (!function_exists('aemi_remove_script_version'))
{
	function aemi_remove_script_version($src)
	{
		$parts = explode('?', $src);
		return $parts[0];
	}
}


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


if (!function_exists('aemi_custom_archive_title')) {
	function aemi_custom_archive_title($title)
	{
		switch (true) {
			case is_category(): {
				$title = sprintf(
					'<h1 class="post-title">%1$s</h1><div class="archive-type cat">%2$s</div>',
					single_cat_title('', false),
					__('Category', 'aemi')
				);
				break;
			}
			case is_tag(): {
				$title = sprintf(
					'<h1 class="post-title">%1$s</h1><div class="archive-type tag">%2$s</div>',
					single_tag_title('', false),
					__('Tag', 'aemi')
				);
				break;
			}
			case is_author(): {
				$title = sprintf(
					'<h1 class="post-title">%1$s</h1><div class="archive-type author">%2$s</div>',
					get_the_author(),
					__('Author', 'aemi')
				);
				break;
			}
			case is_year(): {
				$title = sprintf(
					'<h1 class="post-title">%1$s</h1><div class="archive-type year">%2$s</div>',
					get_the_date('Y'),
					__('Year', 'aemi')
				);
				break;
			}
			case is_month(): {
				$title = sprintf(
					'<h1 class="post-title">%1$s</h1><div class="archive-type month">%2$s</div>',
					get_the_date('F Y'),
					__('Month', 'aemi')
				);
				break;
			}
			case is_day(): {
				$title = sprintf(
					'<h1 class="post-title">%1$s</h1><div class="archive-type day">%2$s</div>',
					get_the_date('j F Y'),
					__('Day', 'aemi')
				);
				break;
			}
			case is_tax('post_format', 'post-format-aside'): {
				$title = sprintf(
					'<h1 class="post-title">%1$s</h1>',
					__('Asides', 'aemi')
				);
				break;
			}
			case is_tax('post_format', 'post-format-gallery'): {
				$title = sprintf(
					'<h1 class="post-title">%1$s</h1>',
					__('Galleries', 'aemi')
				);
				break;
			}
			case is_tax('post_format', 'post-format-image'): {
				$title = sprintf(
					'<h1 class="post-title">%1$s</h1>',
					__('Images', 'aemi')
				);
				break;
			}
			case is_tax('post_format', 'post-format-video'): {
				$title = sprintf(
					'<h1 class="post-title">%1$s</h1>',
					__('Videos', 'aemi')
				);
				break;
			}
			case is_tax('post_format', 'post-format-quote'): {
				$title = sprintf(
					'<h1 class="post-title">%1$s</h1>',
					__('Quotes', 'aemi')
				);
				break;
			}
			case is_tax('post_format', 'post-format-link'): {
				$title = sprintf(
					'<h1 class="post-title">%1$s</h1>',
					__('Links', 'aemi')
				);
				break;
			}
			case is_tax('post_format', 'post-format-status'): {
				$title = sprintf(
					'<h1 class="post-title">%1$s</h1>',
					__('Statuses', 'aemi')
				);
				break;
			}
			case is_tax('post_format', 'post-format-audio'): {
				$title = sprintf(
					'<h1 class="post-title">%1$s</h1>',
					__('Audios', 'aemi')
				);
				break;
			}
			case is_tax('post_format', 'post-format-chat'): {
				$title = sprintf(
					'<h1 class="post-title">%1$s</h1>',
					__('Chats', 'aemi')
				);
				break;
			}
			case is_post_type_archive(): {
				$title = sprintf(
					'<h1 class="post-title">%1$s</h1>',
					post_type_archive_title('', false)
				);
				break;
			}
			case is_tax(): {
				$tax = get_taxonomy(get_queried_object()->taxonomy);
				$title = sprintf(
					'<h1 class="post-title">%1$s</h1><div class="archive-type %2$s">%3$s</div>',
					single_term_title('', false),
					$tax->labels->singular_name,
					$tax->labels->singular_name
				);
				break;
			}
			default: {
				$title = sprintf(
					'<h1 class="post-title">%s</h1>',
					__('Archives', 'aemi')
				);
				break;
			}
		}
		return $title;
	}
}


if (!function_exists('aemi_filter_comment_text'))
{
	function aemi_filter_comment_text($comment)
	{
		$allowed_html = [
        	'a' => [
        		'href'	=>	[],
        		'title'	=>	[]
        	],
      		'br'	=>		[],
      		'em'	=>		[],
      		'i'		=>		[],
      		'strong'	=>	[],
      		'b'		=>		[],
      		'del'	=>		[],
      		's'		=>		[],
      		'u'		=>		[],
      		'pre'	=>		[],
      		'code'	=>		[],
      		'kbd'	=>		[],
      		'big'	=>		[],
      		'small'	=>		[],
      		'acronym'	=>	[],
      		'abbr'	=>		[],
      		'ins'	=>		[],
      		'sup'	=>		[],
      		'sub'	=>		[],
      		'ol'	=>		[],
      		'ul'	=>		[],
      		'li'	=>		[]
    	];
    	return wp_kses($comment, $allowed_html);
	}
}

if (!function_exists('aemi_add_svg_support'))
{
	function aemi_add_svg_support($mimes = array())
	{
		if (current_user_can('administrator'))
		{
			$mimes['svg'] = 'image/svg+xml';
			$mimes['svgz'] = 'image/svg+xml';
		}
		return $mimes;
	}	
}

if (!function_exists('aemi_svg_upload_check'))
{
	function aemi_svg_upload_check($checked, $file, $filename, $mimes)
	{
		if (!$checked['type'])
		{
			$check_filetype		= wp_check_filetype($filename, $mimes);
			$ext				= $check_filetype['ext'];
			$type				= $check_filetype['type'];
			$proper_filename	= $filename;
			if ($type && 0 === strpos($type, 'image/') && $ext !== 'svg')
			{
				$ext = $type = false;
			}
			$checked = compact('ext','type','proper_filename');
		}
		return $checked;
	}
}


if (!function_exists('aemi_svg_allow_svg_upload'))
{
	function aemi_svg_allow_svg_upload($data, $file, $filename, $mimes)
	{
		global $wp_version;
		if ($wp_version !== '4.7.1' || $wp_version !== '4.7.2')
		{
			return $data;
		}
		$filetype = wp_check_filetype($filename, $mimes);
		return [
			'ext'				=> $filetype['ext'],
			'type'				=> $filetype['type'],
			'proper_filename'	=> $data['proper_filename']
		];
	}
}

if (!function_exists('aemi_disable_tinymce_emojis'))
{
	function aemi_disable_tinymce_emojis($plugins) {
		if (is_array($plugins))
		{
			return array_diff($plugins, array('wpemoji'));
		}
		else
		{
			return array();
		}
	}
}

if (!function_exists('aemi_remove_emojis'))
{
	function aemi_remove_emojis() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );	
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	
		add_filter( 'tiny_mce_plugins', 'aemi_disable_tinymce_emojis' );
	}
}