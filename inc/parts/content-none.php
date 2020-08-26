<article id="entry-head" class="entry post no-results not-found">
	<header class="post-header">
		<div class="post-info">
			<h1 class="post-title"><?php echo esc_html__('Nothing Found', 'aemi') ?></h1>
			<div class="archive-details not-found"><?php
				if (is_home() && current_user_can('publish_posts'))
				{
					printf(
						wp_kses(
							__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'aemi'),
							[ 'a' => [ 'href' => [] ] ]
						),
						esc_url(admin_url('post-new.php'))
					);
				}
				else if (is_search())
				{
					esc_html_e('Sorry, nothing matched your search. Please try again.', 'aemi');
				}
				else
				{
					esc_html_e('Nothing found for the requested page. Try a search instead?', 'aemi');
				}
			?></div>
		</div>
	</header>
	<main class="post-content"><?php get_search_form(); ?></main>
</article>
