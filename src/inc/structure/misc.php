<?php

if ( ! function_exists( 'aemi_only_search_content' ) ) {
	function aemi_only_search_content() {
		?>
<main class="post-content">
		<?php get_search_form(); ?>
</main>
		<?php
	}
}
