<?php

get_header();

$query = get_search_query();

if (have_posts())
{
    ?><article id="entry-head" class="entry">
    <header class="post-header">
        <div class="post-info">
            <h1 class="post-title"><?php echo $query === '' ? esc_html__('What are you looking for?', 'aemi') : $query ?></h1>
            <?php
            if ($query === '')
            {
                printf(
                    '<div class="archive-details search">%s</div>',
                    esc_html__(
                        'Is looking for "anything" useful?',
                        'aemi'
                    )
                );
            }
            else
            {
                printf(
                    '<div class="archive-details search">%s</div>',
                    esc_html__('Search Results', 'aemi')
                );
            }
            ?>
        </div>
    </header>
    <?php if ($query === '')
    {
    ?><main class="post-content">
        <?php get_search_form(); ?>
    </main>
</article><?php
    }
    else
    {
?></article>
<?php get_template_part('loop');
    }
}
else
{
    get_template_part('inc/parts/content', 'none');
}

get_footer();
