<form role="search" method="get" class="search-form" action="<?= home_url( '/' ); ?>">
	<div id="search-container">
		<label class="screen-reader-text"><?= esc_html__( 'Search for &hellip;', 'aemi' ) ?></label>
		<input type="search" id="search-input" class="search-input" placeholder="<?= esc_attr__( 'Search for &hellip;', 'aemi' ) ?>" value="<?= get_search_query() ?>" name="s" title="<?= esc_attr__( 'Search for &hellip;', 'aemi' ) ?>" />
		<button type="submit" class="search-submit no-style" title="<?= esc_attr__('Search','aemi')?>">
			<span class="search-icon"></span>
		</button>
	</div>
</form>
<?php
