<?php

if (!function_exists('aemi_log'))
{
	function aemi_log(...$params)
	{
		?><script>console.log(<?php echo json_encode( $params ) ?>);</script><?php
	}
}

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

if (!function_exists('aemi_format_title'))
{
	function aemi_format_title($title,$desc_class = '',$desc_content = '')
	{
		$markup_title = '';
		$markup_desc = '';

		if (is_string($title) && $title != '')
		{
			$markup_title = '<h1 class="post-title">' . esc_html($title) . '</h1>';
		}
		if (is_string($desc_class) && is_string($desc_content) && $desc_class != '' && $desc_content != '')
		{
			$markup_desc = '<div class="archive-type ' . esc_attr($desc_class) . '">' . esc_html($desc_content) . '</div>';
		}
		else if (is_string($desc_content) && $desc_content != '')
		{
			$markup_desc = '<span class="screen-reader-text"> • ' . esc_html($desc_content) . '</span>';
		}

		return $markup_title . $markup_desc;
	}
}

if (!function_exists('aemi_archive_title'))
{
	function aemi_archive_title($bool = true)
	{
		$raw_title = '';
		$desc_class = '';
		$desc_content = '';

		if (is_category())
		{
			$raw_title = single_cat_title('', false);
			$desc_class = 'cat';
			$desc_content = __('Category', 'aemi');
		}
		else if (is_tag())
		{
			$raw_title = single_tag_title('', false);
			$desc_class = 'tag';
			$desc_content = __('Tag', 'aemi');
		}
		else if (is_author())
		{
			$raw_title = get_the_author();
			$desc_class = 'author';
			$desc_content = __('Author', 'aemi');
		}
		else if (is_year())
		{
			$raw_title = get_the_date('Y');
			$desc_class = 'year';
			$desc_content = __('Year', 'aemi');
		}
		else if (is_month())
		{
			$raw_title = get_the_date('F Y');
			$desc_class = 'month';
			$desc_content = __('Month', 'aemi');
		}
		else if (is_day())
		{
			$raw_title = get_the_date('j F Y');
			$desc_class = 'day';
			$desc_content = __('Day', 'aemi');
		}
		else if (is_tax('post_format', 'post-format-aside'))
		{
			$raw_title = __('Asides','aemi');
		}
		else if (is_tax('post_format', 'post-format-gallery'))
		{
			$raw_title = __('Galleries','aemi');
		}
		else if (is_tax('post_format', 'post-format-image'))
		{
			$raw_title = __('Images','aemi');
		}
		else if (is_tax('post_format', 'post-format-video'))
		{
			$raw_title = __('Videos','aemi');
		}
		else if (is_tax('post_format', 'post-format-quote'))
		{
			$raw_title = __('Quotes','aemi');
		}
		else if (is_tax('post_format', 'post-format-link'))
		{
			$raw_title = __('Links','aemi');
		}
		else if (is_tax('post_format', 'post-format-status'))
		{
			$raw_title = __('Statuses','aemi');
		}
		else if (is_tax('post_format', 'post-format-audio'))
		{
			$raw_title = __('Audios','aemi');
		}
		else if (is_tax('post_format', 'post-format-chat'))
		{
			$raw_title = __('Chats','aemi');
		}
		else if (is_post_type_archive())
		{
			$raw_title = post_type_archive_title('', false);
		}
		else if (is_tax())
		{
			$tax = get_taxonomy(get_queried_object()->taxonomy);
			$raw_title = single_term_title('', false);
			$desc_class = $tax->labels->singular_name;
			$desc_content = $tax->labels->singular_name;
		}
		else
		{
			$raw_title = __('Archives', 'aemi');
		}
		if ($bool)
		{
			return aemi_format_title( $raw_title, $desc_class, $desc_content );
		}
		return wp_strip_all_tags( aemi_format_title( $raw_title, null, $desc_content ) );
	}
}

if (!function_exists('aemi_get_the_archive_title'))
{
	function aemi_get_the_archive_title($title)
	{
		return aemi_archive_title();
	}
}

if (!function_exists('aemi_get_title'))
{
	function aemi_get_title($post = null)
	{
		$title = '';

		switch (true)
		{
			case is_search():
				$query = get_search_query();
				if ($query == '')
				{
					$title = __('What are you looking for?', 'aemi');
				}
				else
				{
					if (have_posts())
					{
						$title = esc_html( $query ) . ' • ' . __('Search Results','aemi');
					}
					else {
						$title = __('Nothing Found','aemi');
					}
				}
				break;
			case is_archive():
				$title = aemi_archive_title(false);
				break;
			case is_404():
				$title = __('Code 404','aemi') . ' • ' . __('Page not Found','aemi');
				break;
			case is_home() && is_front_page():
			case is_front_page():
				$title = get_bloginfo('name');
				break;
			case is_home():
				$title = __('Latest Posts', 'aemi');
				break;
			default:
				$title = single_post_title('',false);
			break;
		}
		return $title;
	}
}

if (!function_exists('aemi_get_the_content'))
{
	function aemi_get_the_content($wp_post)
	{
		if (!isset($wp_post))
		{
			global $post;
			$wp_post = $post;
		}
		$content = $wp_post->post_content;
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		return $content;
	}
}

if (!function_exists('aemi_get_meta_desc'))
{
	function aemi_get_meta_desc($wp_post)
	{
		if (!isset($wp_post))
		{
			global $post;
			$wp_post = $post;
		}

		$meta_desc = '';

		switch (true) {
			case is_archive():
			$meta_desc = get_the_archive_description();
			case is_search():
			$query = get_search_query();
			if ($query == '')
			{
				$meta_desc = __('The search is not precise enough to display a relevant result.', 'aemi');
			}
			else
			{
				if (have_posts())
				{
					$meta_desc = __('Here are the search results for','aemi') . ': "' . esc_html( $query ) . '".';
				}
				else {
					$meta_desc = __('Nothing Found','aemi');
				}
			}
			break;
			case is_404():
			$meta_desc = __('The page you are looking for is no longer available or never existed.','aemi');
			break;
			case is_home() && is_front_page():
			case is_front_page():
			case is_home():
				$meta_desc = get_theme_mod('aemi_site_description','');
				if ($meta_desc == '')
				{
					$meta_desc = get_bloginfo('description');
				}
				break;
			default:
				if (is_enabled('aemi_add_meta_tags',0))
				{
					$meta_desc = wp_trim_words( get_post_meta( $wp_post->ID, 'aemi_meta_desc', true ), 25, '...' );
				}
			break;
		}
		if ( $meta_desc == '' )
		{
			$meta_desc = wp_trim_words( aemi_get_the_content($wp_post), 25, '...' );
		}

		return wp_strip_all_tags( $meta_desc );
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

if (!function_exists('aemi_ensure_https'))
{
	function aemi_ensure_https($string) {
		if (is_ssl())
		{
			return preg_replace('/http\:/', '', $string);
		}
		return $string;
	}
}

if (!function_exists('aemi_title_parts'))
{
	function aemi_title_parts($parts)
	{
		$parts['title'] = aemi_get_title();
		return $parts;
	}
}

if (!function_exists('aemi_title_separator'))
{
	function aemi_title_separator($sep)
	{
		$mod = get_theme_mod('aemi_title_separator','•');
		if ($mod == '')
		{
			return '•';
		}
		return $mod;
	}
}