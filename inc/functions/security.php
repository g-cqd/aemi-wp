<?php

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