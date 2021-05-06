<?php

global $aemi_search_form_id;

if (!isset($aemi_search_form_id))
{
	$aemi_search_form_id += 1;
}
else {
	$aemi_search_form_id = 0;
}

?><form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
	<div id="search-container">
		<label class="screen-reader-text" for="search-input<?php echo esc_html('-' . $aemi_search_form_id); ?>"><?php echo esc_html__('Search for &hellip;', 'aemi'); ?></label>
		<input type="search" id="search-input<?php echo esc_html('-' . $aemi_search_form_id); ?>" class="search-input" placeholder="<?php echo esc_attr__('Search for &hellip;', 'aemi'); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr__('Search for &hellip;', 'aemi'); ?>" required/>
		<button type="submit" class="search-submit no-style" title="<?php echo esc_attr__('Search', 'aemi'); ?>">
			<span class="search-icon"></span>
		</button>
	</div>
</form><?php
