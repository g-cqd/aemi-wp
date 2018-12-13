<article id="post-lead" class="post no-results not-found">

	<div class="post-header">

		<h1 class="post-title">

			<?php esc_html_e( 'Nothing Found', 'aemi' ); ?>

		</h1>

	</div>

	<div class="post-content">

		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) { ?>

			<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'aemi' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php } else if ( is_search() ) { ?>

			<p><?php esc_html_e( 'Sorry, nothing matched your search. Please try again.', 'aemi' ); ?></p>

			<?php get_search_form(); ?>

		<?php } else { ?>

			<p><?php esc_html_e( 'Nothing found for the requested page. Try a search instead?', 'aemi' ); ?></p>

			<?php get_search_form(); ?>

		<?php } ?>

	</div>

</article>
