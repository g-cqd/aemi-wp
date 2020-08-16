<?php

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
	function aemi_insert_htaccess($string)
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
	            	return insert_with_markers($htaccess_file, __('Aemi Theme Custom Rules', 'aemi'), $rules);
	        	}
	    	}
		}
	}
}

if (!function_exists('aemi_rules__add'))
{
	function aemi_rules__add($bool,$slug,$string)
	{
		global $aemi_htaccess_rules;
		if (!isset($aemi_htaccess_rules))
		{
			$aemi_htaccess_rules = array();
		}
		$aemi_rules = '';
		if ($bool) {
			$aemi_htaccess_rules[$slug] = $string;
		}
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

		if ($compression != 'none')
		{
			switch ($compression)
			{
				case 'gzip':
					$compression__str = <<<EOD
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
					break;
				case 'brotli':
					$compression__str = <<<EOD
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
					break;
				case 'all':
					$compression__str = <<<EOD
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
</IfModule>
<IfModule mod_brotli.c>
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

if (!function_exists('aemi_rules__csph'))
{
	function aemi_rules__csph()
	{
		$csph_rule = <<<EOD
\n<IfModule mod_headers.c>
Header always set Content-Security-Policy "base-uri 'self';object-src 'none';"
</IfModule>\n
EOD;

		aemi_rules__add(
			get_theme_mod('aemi_add_csph',0)==1,
			'csp_headers',
			$csph_rule
		);
	}
}

if (!function_exists('aemi_rules__xframe_options'))
{
	function aemi_rules__xframe_options()
	{
		$xframe = get_theme_mod('aemi_add_xframe_options','not-set');
		$xframe_options = '';
		if ($xframe != 'not-set')
		{
			$xframe_options = <<<EOD
\n<IfModule mod_headers.c>
Header always set X-Frame-Options "$xframe"
</IfModule>\n
EOD;
		}
		aemi_rules__add(
			$xframe != 'not-set',
			'xframe_options',
			$xframe_options
		);
	}
}

if (!function_exists('aemi_rules__content_type_nosniff'))
{
	function aemi_rules__content_type_nosniff()
	{
		$content_nosniff = <<<EOD
\n<IfModule mod_headers.c>
Header always set X-Content-Type-Options "nosniff"
</IfModule>\n
EOD;
		aemi_rules__add(
			get_theme_mod('aemi_add_content_nosniff',0)==1,
			'content_nosniff',
			$content_nosniff
		);
	}
}

if (!function_exists('aemi_rules__hsts'))
{
	function aemi_rules__hsts()
	{
		$hsts = <<<EOD
\n<IfModule mod_headers.c>
Header always set Strict-Transport-Security "max-age=31536000;includeSubDomains;preload;"
</IfModule>\n
EOD;
		aemi_rules__add(
			get_theme_mod('aemi_add_hsts',0)==1,
			'hsts',
			$hsts
		);
	}
}

if (!function_exists('aemi_rules__xss'))
{
	function aemi_rules__xss()
	{
		$xss = <<<EOD
\n<IfModule mod_headers.c>
Header always set X-XSS-Protection "1; mode=block"
</IfModule>\n
EOD;
		aemi_rules__add(
			get_theme_mod('aemi_add_xss',0)==1,
			'xss',
			$xss
		);
	}
}

if (!function_exists('aemi_rules__expect_ct'))
{
	function aemi_rules__expect_ct()
	{
		$expect_ct = <<<EOD
\n<IfModule mod_headers.c>
Header always set Expect-CT "enforce, max-age=3600"
</IfModule>\n
EOD;
		aemi_rules__add(
			get_theme_mod('aemi_add_expect_ct',0)==1,
			'expect_ct',
			$expect_ct
		);
	}
}

if (!function_exists('aemi_rules__referer_policy'))
{
	function aemi_rules__referer_policy()
	{
		$referer_param = get_theme_mod('aemi_add_referer','not-set');
		$referer = <<<EOD
\n<IfModule headers_module.c>
Header always set Referrer-Policy "$referer_param"
</IfModule>\n
EOD;
		aemi_rules__add(
			$referer_param!='not-set',
			'referer_policy',
			$referer
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

if (!function_exists('aemi_rules__x_powered_by'))
{
	function aemi_rules__x_powered_by()
	{
		$powered_by = <<<EOD
\n<IfModule mod_headers.c>
Header always unset "X-Powered-By"
Header unset "X-Powered-By"
</IfModule>\n
EOD;
		aemi_rules__add(
			get_theme_mod('aemi_add_powered_by',0) == 1,
			'x_powered_by',
			$powered_by
		);
	}
}

if (!function_exists('aemi_update_htaccess_rules'))
{
	function aemi_update_htaccess_rules()
	{

		aemi_rules__expire_headers();
		aemi_rules__compression();
		aemi_rules__csph();
		aemi_rules__xframe_options();
		aemi_rules__content_type_nosniff();
		aemi_rules__hsts();
		aemi_rules__xss();
		aemi_rules__expect_ct();
		aemi_rules__referer_policy();
		aemi_rules__keep_alive();
		aemi_rules__x_powered_by();

		global $aemi_htaccess_rules;

		if (isset($aemi_htaccess_rules))
		{

			$aemi_htaccess_rules__str = '';
			foreach ($aemi_htaccess_rules as $mod => $str)
			{
				$aemi_htaccess_rules__str .= $str;
			}

			aemi_insert_htaccess( $aemi_htaccess_rules__str );
		}
	}
}