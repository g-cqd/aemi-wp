<?php

if (post_password_required() && is_disabled('aemi_display_comments',1))
{
    return;
}

global $wp_query;

$comments_by_type = aemi_separate_comments();

?><div id="post-reactions" class="post-reactions"><?php

if (have_comments())
{
    if (!empty($comments_by_type['comment']))
    {
        $comment_count = count($comments_by_type['comment'])
        
        ?><div id="comments-section" class="reaction-section">
            <h3 class="comments-title h1"><?php echo sprintf(
                esc_html(
                    _nx(
                        'One Comment',
                        '%1$s Comments',
                        $comment_count,
                        'comment title',
                        'aemi'
                    )
                ),
                number_format_i18n($comment_count),
                '<span>' . get_the_title() . '</span>'
            );

            ?></h3><?php

            if (get_comment_pages_count() > 1)
            {
                ?><nav id="comments-navigation" class="comments-navigation">
                    <div class="paginated-comments-links"><?php paginate_comments_links(); ?></div>
                </nav><?php    
            }
            ?><ul class="comments-list">
                <?php wp_list_comments([ 'type' => 'comment' ]); ?>
            </ul><?php
            if (get_comment_pages_count() > 1)
            {
                ?><nav id="comments-navigation" class="comments-navigation">
                    <div class="paginated-comments-links"><?php paginate_comments_links(); ?></div>
                </nav><?php
            }
        ?></div><?php
    }

    if (count($comments_by_type['trackback']) > 0)
    {
        ?><div id="trackbacks-section" class="reaction-section">
            <h3 id="trackbacks-title" class="h1">Trackbacks</h3>
            <ul class="trackbacks-list"><?php wp_list_comments('type=trackback'); ?></ul>
        </div><?php
    }

    if (count($comments_by_type['pingback']) > 0)
    {
        ?><div id="pingbacks-section" class="reaction-section">
            <h3 id="pingbacks-title" class="h1">Pingbacks</h3>
            <ul class="pingbacks-list"><?php wp_list_comments('type=pingback'); ?></ul>
        </div><?php
    }

}

if (
    comments_open() ||
    get_comments_number() && post_type_supports(get_post_type(), 'comments'))
{
    comment_form();
}

?></div>