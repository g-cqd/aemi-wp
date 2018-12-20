<?php get_header(); ?>

<article id="post-lead" class="post not-found">

	<div class="post-header">

		<h1 class="post-title">

			<?php esc_html_e( _x( 'Error 404', '404 error', 'aemi' ) ); ?>

		</h1>

	</div>

	<div class="post-content">

		<p><?php esc_html_e( _x( 'Nothing found for the requested page. Try a search instead?', 'not found text', 'aemi' ) ) ; ?></p>

		<?php get_search_form(); ?>

	</div>

</article>

<?php get_footer(); ?>
