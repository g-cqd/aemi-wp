<?php

if (!function_exists('aemi_remove_jquery'))
{
	function aemi_remove_jquery() { 
 		if ( !is_admin() ) {
 			wp_deregister_script('jquery');
 		}
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

if (!function_exists('aemi_remove_script_version'))
{
	function aemi_remove_script_version($src)
	{
		$parts = explode('?', $src);
		return $parts[0];
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
		if (is_enabled('aemi_remove_emojis',0))
		{
			remove_action( 'wp_head',				'print_emoji_detection_script', 7 );
			remove_action( 'admin_print_scripts',	'print_emoji_detection_script' );
			remove_action( 'wp_print_styles',		'print_emoji_styles' );
			remove_action( 'admin_print_styles',	'print_emoji_styles' );	
			remove_filter( 'the_content_feed',		'wp_staticize_emoji' );
			remove_filter( 'comment_text_rss',		'wp_staticize_emoji' );	
			remove_filter( 'wp_mail',				'wp_staticize_emoji_for_email' );
			add_filter( 'tiny_mce_plugins',			'aemi_disable_tinymce_emojis' );
			add_filter( 'emoji_svg_url', '__return_false' );
		}
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
		remove_action( 'rest_api_init', 'wp_oembed_register_route' );
		add_filter( 'embed_oembed_discover', '__return_false' );
		remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		remove_action( 'wp_head', 'wp_oembed_add_host_js' );
		add_filter( 'tiny_mce_plugins', 'aemi_disable_tinymce_plugin_embeds' );
		add_filter( 'rewrite_rules_array', 'aemi_disable_embeds_rewrites' );
		remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );
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

if (!function_exists('aemi_rules__expire_headers'))
{
	function aemi_rules__expire_headers()
	{
		$expire_headers = <<<EOD
\n<Ifmodule mod_expires.c>
  ExpiresActive on
  # Images
  ExpiresByType image/jpeg "access plus 1 year"
  ExpiresByType image/gif "access plus 1 year"
  ExpiresByType image/png "access plus 1 year"
  ExpiresByType image/webp "access plus 1 year"
  ExpiresByType image/svg+xml "access plus 1 year"
  ExpiresByType image/x-icon "access plus 1 year"

  # Video
  ExpiresByType video/webm "access plus 1 year"
  ExpiresByType video/mp4 "access plus 1 year"
  ExpiresByType video/mpeg "access plus 1 year"

  # Fonts
  ExpiresByType font/ttf "access plus 1 year"
  ExpiresByType font/otf "access plus 1 year"
  ExpiresByType font/woff "access plus 1 year"
  ExpiresByType font/woff2 "access plus 1 year"
  ExpiresByType application/font-woff "access plus 1 year"

  # CSS, JavaScript
  ExpiresByType text/css "access plus 1 month"
  ExpiresByType text/javascript "access plus 1 month"
  ExpiresByType application/javascript "access plus 1 month"

  # Others
  ExpiresByType application/pdf "access plus 1 month"
  ExpiresByType image/vnd.microsoft.icon "access plus 1 year"
</ifmodule>\n
EOD;
		aemi_rules__add(
			get_theme_mod('aemi_add_expire_headers',0)==1,
			'expire_headers',
			$expire_headers
		);
	}
}

if (!function_exists('aemi_rules__compression'))
{
	function aemi_rules__compression()
	{
		$compression = get_theme_mod('aemi_add_compression','none');
		$compression__str = '';

		$compression_gzip = <<<EOD
\n<IfModule mod_deflate.c>
  AddOutputFilterByType DEFLATE application/javascript
  AddOutputFilterByType DEFLATE application/rss+xml
  AddOutputFilterByType DEFLATE application/vnd.ms-fontobject
  AddOutputFilterByType DEFLATE application/x-font
  AddOutputFilterByType DEFLATE application/x-font-opentype
  AddOutputFilterByType DEFLATE application/x-font-otf
  AddOutputFilterByType DEFLATE application/x-font-truetype
  AddOutputFilterByType DEFLATE application/x-font-ttf
  AddOutputFilterByType DEFLATE application/x-font-woff
  AddOutputFilterByType DEFLATE application/x-font-woff2
  AddOutputFilterByType DEFLATE application/x-javascript
  AddOutputFilterByType DEFLATE application/xhtml+xml
  AddOutputFilterByType DEFLATE application/xml
  AddOutputFilterByType DEFLATE font/opentype
  AddOutputFilterByType DEFLATE font/otf
  AddOutputFilterByType DEFLATE font/ttf
  AddOutputFilterByType DEFLATE font/woff
  AddOutputFilterByType DEFLATE font/woff2
  AddOutputFilterByType DEFLATE image/svg+xml
  AddOutputFilterByType DEFLATE image/x-icon
  AddOutputFilterByType DEFLATE text/css
  AddOutputFilterByType DEFLATE text/html
  AddOutputFilterByType DEFLATE text/svg
  AddOutputFilterByType DEFLATE text/javascript
  AddOutputFilterByType DEFLATE text/plain
  AddOutputFilterByType DEFLATE text/xml

  SetOutputFilter DEFLATE

  BrowserMatch ^Mozilla/4 gzip-only-text/html
  BrowserMatch ^Mozilla/4\.0[678] no-gzip
  BrowserMatch \bMSIE !no-gzip !gzip-only-text/html
  Header append Vary User-Agent
</IfModule>\n
EOD;
		$compression_brotli = <<<EOD
\n<IfModule mod_brotli.c>
  AddOutputFilterByType BROTLI_COMPRESS application/javascript
  AddOutputFilterByType BROTLI_COMPRESS application/rss+xml
  AddOutputFilterByType BROTLI_COMPRESS application/vnd.ms-fontobject
  AddOutputFilterByType BROTLI_COMPRESS application/x-font
  AddOutputFilterByType BROTLI_COMPRESS application/x-font-opentype
  AddOutputFilterByType BROTLI_COMPRESS application/x-font-otf
  AddOutputFilterByType BROTLI_COMPRESS application/x-font-truetype
  AddOutputFilterByType BROTLI_COMPRESS application/x-font-ttf
  AddOutputFilterByType BROTLI_COMPRESS application/x-font-woff
  AddOutputFilterByType BROTLI_COMPRESS application/x-font-woff2
  AddOutputFilterByType BROTLI_COMPRESS application/x-javascript
  AddOutputFilterByType BROTLI_COMPRESS application/xhtml+xml
  AddOutputFilterByType BROTLI_COMPRESS application/xml
  AddOutputFilterByType BROTLI_COMPRESS font/opentype
  AddOutputFilterByType BROTLI_COMPRESS font/otf
  AddOutputFilterByType BROTLI_COMPRESS font/ttf
  AddOutputFilterByType BROTLI_COMPRESS font/woff
  AddOutputFilterByType BROTLI_COMPRESS font/woff2
  AddOutputFilterByType BROTLI_COMPRESS image/svg+xml
  AddOutputFilterByType BROTLI_COMPRESS image/x-icon
  AddOutputFilterByType BROTLI_COMPRESS text/css
  AddOutputFilterByType BROTLI_COMPRESS text/html
  AddOutputFilterByType BROTLI_COMPRESS text/svg
  AddOutputFilterByType BROTLI_COMPRESS text/javascript
  AddOutputFilterByType BROTLI_COMPRESS text/plain
  AddOutputFilterByType BROTLI_COMPRESS text/xml
  
  SetOutputFilter BROTLI_COMPRESS
  Header append Vary User-Agent
  Header append Vary Accept-Encoding
</IfModule>\n
EOD;

		if ($compression != 'none')
		{
			switch ($compression)
			{
				case 'gzip':
					$compression__str = $compression_gzip;
					break;
				case 'brotli':
					$compression__str = $compression_brotli;
					break;
				case 'all':
					$compression__str = <<<EOD
$compression_gzip
$compression_brotli
EOD;
				default:
					break;
			}
		}
		aemi_rules__add(
			$compression != 'none',
			'compression',
			$compression__str
		);
	}
}

if (!function_exists('aemi_rules__keep_alive'))
{
	function aemi_rules__keep_alive()
	{
		$keep_alive = <<<EOD
\n<ifModule mod_headers.c>
Header always set Connection keep-alive
</ifModule>\n
EOD;
		aemi_rules__add(
			get_theme_mod('aemi_add_keep_alive',0)==1,
			'keep_alive',
			$keep_alive
		);
	}
}