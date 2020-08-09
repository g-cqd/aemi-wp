<?php


if (!function_exists('aemi_body_classes')) {
	function aemi_body_classes($classes)
	{
		if (is_singular())
		{
			$classes[] = 'singular';
		} else
		{
			$classes[] = 'not-singular';
		}
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
		// if (get_theme_mod('aemi_loop_excerpts', 1) == 1)
		// {
		// 	$classes[] = 'loop-excertps';
		// }
		return $classes;
	}
}

if (!function_exists('aemi_remove_jquery_migrate')) {
	function aemi_remove_jquery_migrate($scripts)
	{
		if (!is_admin() && isset($scripts->registered['jquery'])) {
			$script = $scripts->registered['jquery'];
			if ($script->deps) {
				$script->deps = array_diff($script->deps, array('jquery-migrate'));
			}
		}
	}
}
if (true === false) {
	add_action('wp_default_scripts', 'aemi_remove_jquery_migrate');
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



function aemi_category_transient_flusher()
{
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	delete_transient('aemi_categories');
}
add_action('edit_category', 'aemi_category_transient_flusher');
add_action('save_post', 'aemi_category_transient_flusher');



function aemi_remove_script_version($src)
{
	$parts = explode('?', $src);
	return $parts[0];
}
add_filter('script_loader_src', 'aemi_remove_script_version', 15, 1);
add_filter('style_loader_src', 'aemi_remove_script_version', 15, 1);


if (!function_exists('aemi_async_scripts')) {
	function aemi_async_scripts($scripts_tag)
	{

		global $async_scripts;
		if (!isset($async_scripts)) {
			$async_scripts = array();
		}
		foreach ($scripts_tag as $script) {
			$async_scripts[] = $script;
		}

		if (!function_exists('aemi_async_scripts_filter')) {
			function aemi_async_scripts_filter($tag, $handle)
			{
				global $async_scripts;
				foreach ($async_scripts as $script) {
					if ($script === $handle) {
						return str_replace(' src', ' async src', $tag);
					}
				}
				return $tag;
			}
			add_filter('script_loader_tag', 'aemi_async_scripts_filter', 10, 2);
		}
	}
}


if (!function_exists('aemi_defer_scripts')) {
	function aemi_defer_scripts($scripts_tag)
	{

		global $defer_scripts;
		if (!isset($defer_scripts)) {
			$defer_scripts = array();
		}
		foreach ($scripts_tag as $script) {
			$defer_scripts[] = $script;
		}

		if (!function_exists('aemi_defer_scripts_filter')) {
			function aemi_defer_scripts_filter($tag, $handle)
			{
				global $defer_scripts;
				foreach ($defer_scripts as $script) {
					if ($script === $handle) {
						return str_replace(' src', ' defer src', $tag);
					}
				}
				return $tag;
			}
			add_filter('script_loader_tag', 'aemi_defer_scripts_filter', 10, 2);
		}
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
add_filter('get_the_archive_title', 'aemi_custom_archive_title');



if ( !function_exists('aemi_filter_comment_text') ) {
	function aemi_filter_comment_text( $comment ) {
		$allowed_html = array(
        	'a' => array(
        		'href' => array(),
        		'title' => array()
      		),
      		'br' => array(),
      		'em' => array(),
      		'i' => array(),
      		'strong' => array(),
      		'b' => array(),
      		'del' => array(),
      		's' => array(),
      		'u' => array(),
      		'pre' => array(),
      		'code' => array(),
      		'kbd' => array(),
      		'big' => array(),
      		'small' => array(),
      		'acronym' => array(),
      		'abbr' => array(),
      		'ins' => array(),
      		'sup' => array(),
      		'sub' => array(),
      		'ol' => array(),
      		'ul' => array(),
      		'li' => array()
    	);
    	return wp_kses($comment, $allowed_html);
	}
}

add_filter( 'comment_text', 'aemi_filter_comment_text' );
