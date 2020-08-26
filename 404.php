<?php

get_header();

?><article id="entry-head" class="entry post page-404 not-found">
    <header class="post-header">
        <div class="post-info">
            <h1 class="post-title"><?php echo esc_html__('Code 404', 'aemi') ?></h1>
            <div class="archive-details 404-not-found"><?php
                esc_html_e('You\'re taking a wrong turn. The page you are looking for is no longer available or never existed. Please try a search instead.', 'aemi');
            ?></div>
        </div>
    </header>
    <main class="post-content"><?php
        get_search_form();
    ?></main>
</article><?php 

get_footer();
