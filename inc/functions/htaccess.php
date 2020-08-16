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
<filesmatch "\.(jpg|jpeg|gif|png|css|js|mov|svg|pdf|webp|webm|woff|woff2)$">
ExpiresActive on
ExpiresDefault "access plus 1 year"
</filesmatch>
</ifmodule>\n
EOD;
		aemi_rules__add(
			get_theme_mod('aemi_add_expire_headers',0)==1,
			'expire_headers',
			$expire_headers
		);
	}
}

if (!function_exists('aemi_rules__gzip_compression'))
{
	function aemi_rules__gzip_compression()
	{
		$gzip_compression = <<<EOD
\n<IfModule mod_gzip.c>
  mod_gzip_on Yes
  mod_gzip_dechunk Yes
  mod_gzip_item_include file .(html?|txt|svg|css|js|php|pl)$
  mod_gzip_item_include handler ^cgi-script$
  mod_gzip_item_include mime ^text/.*
  mod_gzip_item_include mime ^application/x-javascript.*
  mod_gzip_item_exclude mime ^image/.*
  mod_gzip_item_exclude rspheader ^Content-Encoding:.*gzip.*
</IfModule>
<IfModule mod_deflate.c>
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

  BrowserMatch ^Mozilla/4 gzip-only-text/html
  BrowserMatch ^Mozilla/4\.0[678] no-gzip
  BrowserMatch \bMSIE !no-gzip !gzip-only-text/html
  Header append Vary User-Agent
</IfModule>\n
EOD;
		aemi_rules__add(
			get_theme_mod('aemi_add_gzip_compression',0)==1,
			'gzip_compression',
			$gzip_compression
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
		$xframe_options = <<<EOD
\n<IfModule mod_headers.c>
Header always set X-FRAME-OPTIONS "DENY"
</IfModule>\n
EOD;
		aemi_rules__add(
			get_theme_mod('aemi_add_xframe_options',0)==1,
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
Header always set Strict-Transport-Security "max-age=63072000; includeSubDomains"
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
Header set X-XSS-Protection "1; mode=block"
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
		$referer_param = get_theme_mod('aemi_add_referer','not-set-up');
		$referer = <<<EOD
\n<IfModule headers_module.c>
Header always set Referrer-Policy "$referer_param"
</IfModule>\n
EOD;
		aemi_rules__add(
			$referer_param!='not-set-up',
			'referer_policy',
			$referer
		);
	}
}

if (!function_exists('aemi_update_htaccess_rules'))
{
	function aemi_update_htaccess_rules()
	{

		aemi_rules__expire_headers();
		aemi_rules__gzip_compression();
		aemi_rules__csph();
		aemi_rules__xframe_options();
		aemi_rules__content_type_nosniff();
		aemi_rules__hsts();
		aemi_rules__xss();
		aemi_rules__expect_ct();
		aemi_rules__referer_policy();

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