<?php
if ( post_password_required() )
{
	return;
}
?>

<div id="comments" class="comments-area">
	<?php if ( have_comments() )
	{
		?><h3 class="comments-title"><?php
			printf( esc_html( _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comment title', 'aemi' ) ), number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
		?></h3>
		<div id="comments-list" class="comments"><?php
			if ( get_comment_pages_count() > 1 )
			{
				?><nav id="comments-navigation" class="comments-navigation" role="navigation">
					<div class="paginated-comments-links"><?php paginate_comments_links(); ?></div>
				</nav><?php
			}
			?><ul><?php
				wp_list_comments();
			?></ul><?php
			if ( get_comment_pages_count() > 1 )
			{
				?><nav id="comments-navigation" class="comments-navigation" role="navigation">
					<div class="paginated-comments-links"><?php paginate_comments_links(); ?></div>
				</nav><?php
			}
		?></div><?php
	}
	if ( comments_open() || get_comments_number() && post_type_supports( get_post_type(), 'comments' ) )
	{
		comment_form();
	}
?></div>
