<?php

if ( ! function_exists( 'aemi_page_header' ) )
{
	function aemi_page_header()
	{ ?>

		<div class="post-header">

			<?php aemi_featured_image();

			if ( ! is_front_page() ) {

				?>

				<div class="post-info">

					<?php the_title( '<h1 class="post-title" itemprop="name">', '</h1>' );

					aemi_post_meta_header(); ?>

				</div>

				<?php

			}

			?>

		</div>

		<?php
	}
}

if ( ! function_exists( 'aemi_page_content' ) )
{
	function aemi_page_content()
	{ ?>

		<div class="post-content" itemprop="mainContentOfPage">

			<?php

			the_content();

			wp_link_pages(array(
				'before'    => '<div id="post-pagination" class="pagination"><div class="button">',
				'after'     => '</div></div>',
				'next_or_number' => 'next',
				'nextpagelink' => esc_html_x( 'next page', 'next page post pagination', 'aemi' ) . ' &rarr;',
				'previouspagelink' => '&larr; ' . esc_html_x( 'previous page', 'previous page post pagination', 'aemi' ),
				'separator' => '</div><div class="button">'
			) );

			?>

		</div>

		<?php

	}
}
