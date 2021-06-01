<?php
/**
 * Aemi WordPress Theme
 * Footer Template
 *
 * @package  aemi.footer
 * @author   Guillaume COQUARD <contact@aemi.dev>
 * @license  http://www.gnu.org/licenses/gpl-3.0.txt GNU Public License 3
 * @link     https://github.com/aemi-dev/aemi-wp/tree/main/src/footer.php
 */

?>
				<?php do_action( 'aemi_content_beforeend' ); ?>
			</div>
			<?php do_action( 'aemi_content_afterend' ); ?>
			<?php do_action( 'aemi_main_beforeend' ); ?>
		</main>
		<?php do_action( 'aemi_main_afterend' ); ?>
		<?php do_action( 'aemi_aside_beforebegin' ); ?>
		<aside id="site-aside">
			<?php do_action( 'aemi_aside_afterbegin' ); ?>
			<?php do_action( 'aemi_aside' ); ?>
			<?php do_action( 'aemi_aside_beforeend' ); ?>
		</aside>
		<?php do_action( 'aemi_aside_afterend' ); ?>
		<?php do_action( 'aemi_footer_beforebegin' ); ?>
		<footer id="site-footer">
			<?php do_action( 'aemi_footer_afterbegin' ); ?>
			<?php do_action( 'aemi_footer' ); ?>
			<?php do_action( 'aemi_footer_beforeend' ); ?>
		</footer>
		<?php do_action( 'aemi_footer_afterend' ); ?>
		<?php do_action( 'aemi_body_beforeend' ); ?>
	</body>
</html>
