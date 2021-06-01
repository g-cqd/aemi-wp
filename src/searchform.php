<?php
/**
 * Aemi WordPress Theme
 * Search Form Template
 *
 * @package  aemi.searchform
 * @author   Guillaume COQUARD <contact@aemi.dev>
 * @license  http://www.gnu.org/licenses/gpl-3.0.txt GNU Public License 3
 * @link     https://github.com/aemi-dev/aemi-wp/tree/main/src/searchform.php
 */

global $aemi_search_form_id;

$current_search_form_id = $aemi_search_form_id;
++$aemi_search_form_id;

$aemi_search_text = __( 'Search for &hellip;', 'aemi' );

?><form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div id="search-container">
		<label class="screen-reader-text" for="search-input<?php echo esc_html( '-' . $current_search_form_id ); ?>"><?php echo esc_html( $aemi_search_text ); ?></label>
		<input type="search" id="search-input<?php echo esc_html( '-' . $current_search_form_id ); ?>" class="search-input" placeholder="<?php echo esc_attr( $aemi_search_text ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr( $aemi_search_text ); ?>" required/>
		<button type="submit" class="search-submit no-style" title="<?php echo esc_attr__( 'Search', 'aemi' ); ?>">
			<span class="search-icon"></span>
		</button>
	</div>
</form>
<?php
