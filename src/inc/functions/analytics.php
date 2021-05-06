<?php

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
					?><script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $ga_id ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '<?php echo esc_js($ga_id) ?>');
</script><?php
					break;
				case 'analytics':
					?><script>
window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
ga('create', '<?php echo esc_js($ga_id) ?>', 'auto');
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
		if (is_enabled('aemi_bing_meta_tag',0) && $bing_content != '')
		{
			?><meta name="msvalidate.01" content="<?php echo esc_attr($bing_content) ?>" /><?php
		}
	}
}