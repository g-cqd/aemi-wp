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

		$stickyness = get_theme_mod('aemi_header_stickyness', 'adaptative');

		if (in_array($stickyness,['top','adaptative']))
		{
			$classes[] = 'header-'.$stickyness;
			$auto_hide = get_theme_mod('aemi_header_autohiding', 1) == 1;
			if ($auto_hide)
			{
				$classes[] = 'header-auto-hide';
			}
		}
		else {
			$classes[] = 'header-absolute';
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


if (!function_exists('aemi_remove_jquery'))
{
	function aemi_remove_jquery() { 
 		if ( !is_admin() ) {
 			wp_deregister_script('jquery');
 		}
	}	
}

function deregister_qjuery() { 
 if ( !is_admin() ) {
 wp_deregister_script('jquery');
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

if (!function_exists('aemi_disable_tinymce_plugin_embeds'))
{
	function aemi_disable_tinymce_plugin_embeds($plugins)
	{
    	return array_diff($plugins, array('wpembed'));
	}
}

if (!function_exists('aemi_disable_embeds_rewrites'))
{
	function aemi_disable_embeds_rewrites($rules) {
    	foreach($rules as $rule => $rewrite) {
    	    if(false !== strpos($rewrite, 'embed=true')) {
    	        unset($rules[$rule]);
    	    }
    	}
    	return $rules;
	}
}


if (!function_exists('aemi_remove_wpembeds'))
{
	function aemi_remove_wpembeds()
	{
		// Remove the REST API endpoint.
		remove_action( 'rest_api_init', 'wp_oembed_register_route' );
		// Turn off oEmbed auto discovery.
		add_filter( 'embed_oembed_discover', '__return_false' );
		// Don't filter oEmbed results.
		remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
		// Remove oEmbed discovery links.
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		// Remove oEmbed-specific JavaScript from the front-end and back-end.
		remove_action( 'wp_head', 'wp_oembed_add_host_js' );
		add_filter( 'tiny_mce_plugins', 'aemi_disable_tinymce_plugin_embeds' );
		// Remove all embeds rewrite rules.
		add_filter( 'rewrite_rules_array', 'aemi_disable_embeds_rewrites' );
		// Remove filter of the oEmbed result before any HTTP requests are made.
		remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );
	}
}

if (!function_exists('aemi_disable_comment_post_types_support'))
{
	function aemi_disable_comment_post_types_support() {
    	$post_types = get_post_types();
   		foreach ($post_types as $post_type)
   		{
      		if(post_type_supports($post_type, 'comments'))
      		{
        		remove_post_type_support($post_type, 'comments');
        		remove_post_type_support($post_type, 'trackbacks');
      		}
   		}
	}
}

if (!function_exists('aemi_remove_comments'))
{
	function aemi_remove_comments()
	{
		global $pagenow, $wp_widget_factory;
    
    	if ($pagenow === 'edit-comments.php')
    	{
    	    wp_redirect(admin_url());
    	    exit;
    	}
    	add_action('init', function ()
			{
    			if (is_admin_bar_showing())
    			{
    			    remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    			}
			}
		);
		add_action('admin_init', 'aemi_disable_comment_post_types_support');
		add_filter('comments_open', '__return_false', 20, 2);
		add_filter('pings_open', '__return_false', 20, 2);
		add_filter('comments_array', '__return_empty_array', 10, 2);
		add_action('admin_menu', function ()
			{
    			remove_menu_page('edit-comments.php');
			}
		);
		add_action('wp_before_admin_bar_render', function()
			{
    			global $wp_admin_bar;
    			$wp_admin_bar->remove_menu('comments');
			}
		);
		add_action('widgets_init',function ()
    		{
    			remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
			}
		);
	}
}

if (!function_exists('aemi_deregister_wpembed'))
{
	function aemi_deregister_wpembed()
	{
		wp_dequeue_script( 'wp-embed' );
	}
}

if (!function_exists('aemi_remove_apiworg'))
{
	function aemi_remove_apiworg()
	{
		remove_action('wp_head', 'rest_output_link_wp_head', 10);
		remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
		remove_action('template_redirect', 'rest_output_link_header', 11, 0);
	}
}

if (!function_exists('aemi_ga_script'))
{
	function aemi_ga_script()
	{
		$ga_id = get_theme_mod('aemi_ga_id','');
		$type = get_theme_mod('aemi_ga_type','none');
		if ($ga_id != '' && $type != 'none')
		{
			switch ($type) {
				case 'gtag':
					?><script async src="https://www.googletagmanager.com/gtag/js?id=<?= $ga_id ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '<?= esc_js($ga_id) ?>');
</script><?php
					break;
				case 'analytics':
					?><script>
window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
ga('create', '<?= esc_js($ga_id) ?>', 'auto');
ga('send', 'pageview');
</script>
<script async src='https://www.google-analytics.com/analytics.js'></script><?php
					break;
				default:
					break;
			}
		}
	}
}

if (!function_exists('aemi_bing_meta_tag'))
{
	function aemi_bing_meta_tag()
	{
		$bing_content = get_theme_mod('aemi_bing_meta_tag_content','');
		if ($bing_content != '')
		{
			?><meta name="msvalidate.01" content="<?= esc_attr($bing_content) ?>" /><?php
		}
	}
}

if (!function_exists('aemi_ensure_https'))
{
	function aemi_ensure_https($string) {
		if (is_ssl())
		{
			return preg_replace('/http\:/', 'https:', $string);
		}
		return $string;
	}
}

if (!function_exists('aemi_get_htaccess_path'))
{
	function aemi_get_htaccess_path()
	{
		require_once ABSPATH . 'wp-admin/includes/file.php';
		$home_path = get_home_path();
		return $home_path . ".htaccess";
	}
}

if (!function_exists('aemi_insert_htaccess'))
{
	function aemi_insert_htaccess($marker,$string)
	{
		require_once ABSPATH . 'wp-admin/includes/file.php';
		$home_path = get_home_path();
		$htaccess_file = $home_path . ".htaccess";
		if ($htaccess_file != '')
		{
			if (!file_exists($htaccess_file) && is_writable($home_path) || is_writable($htaccess_file))
			{
				if (got_mod_rewrite())
				{
	            	$rules = explode( "\n", $string );
	            	return insert_with_markers($htaccess_file, sprintf('%1$s %2$s', __('Aemi Theme', 'aemi'), $marker), $rules);
	        	}
	    	}
		}
	}
}

if (!function_exists('aemi_add_expire_headers'))
{
	function aemi_add_expire_headers($bool)
	{
		$aemi_rules = '';
		if ($bool) {
			$aemi_rules = <<<EOD
\n<Ifmodule mod_expires.c>
<filesmatch "\.(jpg|jpeg|gif|png|css|js|mov|svg|pdf|webp|webm|woff|woff2)$">
ExpiresActive on
ExpiresDefault "access plus 1 year"
</filesmatch>
</ifmodule>\n
EOD;
		}
    	return $aemi_rules;
	}
}


if (!function_exists('aemi_add_expire_headers_true'))
{
	function aemi_add_expire_headers_true() {
		aemi_insert_htaccess(__('Expire Headers', 'aemi'),aemi_add_expire_headers(true));
	}
}
if (!function_exists('aemi_add_expire_headers_false'))
{
	function aemi_add_expire_headers_false() {
		aemi_insert_htaccess(__('Expire Headers', 'aemi'),aemi_add_expire_headers(false));
	}
}

if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && ( ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== false ) || ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Trident/7.0' ) !== false ) ) )
{
	add_action( 'wp_enqueue_scripts', 'aemi_ie_scripts', 20 );
}