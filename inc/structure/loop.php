<?php

if (!function_exists('aemi_loop_filtering'))
{
	function aemi_loop_filtering($query)
	{
		if (!is_admin() && $query->is_main_query())
		{
			if (is_enabled('aemi_loop_cat_filtering', 0))
			{
				$cat_IDs = get_theme_mod('aemi_loop_cat_filters', []);
				$query->set('cat', $cat_IDs);
			}
			if (is_enabled('aemi_loop_add_types', 0))
			{
				$added_types = get_theme_mod('aemi_loop_added_types', ['post']);
				$query->set('post_type', $added_types);
				if ($query->is_search)
				{
					$query->set('post_type', $added_types);
				}
			}
		}
	}
}