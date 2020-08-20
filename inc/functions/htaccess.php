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