<?php

if ( ! function_exists( 'aemi_log' ) ) {
	/**
	 * @param $params
	 */
	function aemi_log( ...$params ) {
		?>
		<script>console.log( <?php echo wp_json_encode( $params ); ?> );</script>
		<?php
	}
}

if ( ! function_exists( 'aemi_category_transient_flusher' ) ) {
	/**
	 * @return null
	 */
	function aemi_category_transient_flusher() {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		delete_transient( 'aemi_categories' );
	}
}

if ( ! function_exists( 'aemi_format_title' ) ) {
	/**
	 * @param $title
	 * @param $desc_class
	 * @param $desc_content
	 * @return mixed
	 */
	function aemi_format_title( $title, $desc_class = '', $desc_content = '' ): string {
		$markup_title = '';
		$markup_desc  = '';

		if ( is_string( $title ) && ! empty( $title ) ) {
			$markup_title = '<h1 class="post-title">' . esc_html( $title ) . '</h1>';
		}
		if (
			is_string( $desc_class ) && is_string( $desc_content ) &&
			! empty( $desc_class ) && ! empty( $desc_content )
		) {
			$markup_desc = '<div class="archive-type ' . esc_attr( $desc_class ) . '">' . esc_html( $desc_content ) . '</div>';
		} elseif ( is_string( $desc_content ) && ! empty( $desc_content ) ) {
			$markup_desc = '<span class="screen-reader-text"> • ' . esc_html( $desc_content ) . '</span>';
		}

		return $markup_title . $markup_desc;
	}
}

if ( ! function_exists( 'aemi_archive_title' ) ) {
	/**
	 * @param $bool
	 */
	function aemi_archive_title( $bool = true ) {
		$raw_title    = '';
		$desc_class   = '';
		$desc_content = '';

		if ( is_category() ) {
			$raw_title    = single_cat_title( '', false );
			$desc_class   = 'cat';
			$desc_content = __( 'Category', 'aemi' );
		} elseif ( is_tag() ) {
			$raw_title    = single_tag_title( '', false );
			$desc_class   = 'tag';
			$desc_content = __( 'Tag', 'aemi' );
		} elseif ( is_author() ) {
			$raw_title    = get_the_author();
			$desc_class   = 'author';
			$desc_content = __( 'Author', 'aemi' );
		} elseif ( is_year() ) {
			$raw_title    = get_the_date( 'Y' );
			$desc_class   = 'year';
			$desc_content = __( 'Year', 'aemi' );
		} elseif ( is_month() ) {
			$raw_title    = get_the_date( 'F Y' );
			$desc_class   = 'month';
			$desc_content = __( 'Month', 'aemi' );
		} elseif ( is_day() ) {
			$raw_title    = get_the_date( 'j F Y' );
			$desc_class   = 'day';
			$desc_content = __( 'Day', 'aemi' );
		} elseif ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$raw_title = __( 'Asides', 'aemi' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$raw_title = __( 'Galleries', 'aemi' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$raw_title = __( 'Images', 'aemi' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$raw_title = __( 'Videos', 'aemi' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$raw_title = __( 'Quotes', 'aemi' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$raw_title = __( 'Links', 'aemi' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$raw_title = __( 'Statuses', 'aemi' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$raw_title = __( 'Audios', 'aemi' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$raw_title = __( 'Chats', 'aemi' );
		} elseif ( is_post_type_archive() ) {
			$raw_title = post_type_archive_title( '', false );
		} elseif ( is_tax() ) {
			$tax          = get_taxonomy( get_queried_object()->taxonomy );
			$raw_title    = single_term_title( '', false );
			$desc_class   = $tax->labels->singular_name;
			$desc_content = $tax->labels->singular_name;
		} else {
			$raw_title = __( 'Archives', 'aemi' );
		}
		if ( $bool ) {
			return aemi_format_title( $raw_title, $desc_class, $desc_content );
		}
		return wp_strip_all_tags( aemi_format_title( $raw_title, null, $desc_content ) );
	}
}

if ( ! function_exists( 'aemi_get_the_archive_title' ) ) {
	/**
	 * @param $title
	 */
	function aemi_get_the_archive_title( $title ) {
		return aemi_archive_title();
	}
}

if ( ! function_exists( 'aemi_get_title' ) ) {
	/**
	 * @param $post
	 * @return mixed
	 */
	function aemi_get_title( $post = null ) {
		$title = '';

		switch ( true ) {
			case is_search():
				$query = get_search_query();
				if ( empty( $query ) ) {
					$title = __( 'What are you looking for?', 'aemi' );
				} else {
					if ( have_posts() ) {
						$title = esc_html( $query ) . ' • ' . __( 'Search Results', 'aemi' );
					} else {
						$title = __( 'Nothing Found', 'aemi' );
					}
				}
				break;
			case is_archive():
				$title = aemi_archive_title( false );
				break;
			case is_404():
				$title = __( 'Code 404', 'aemi' ) . ' • ' . __( 'Page not Found', 'aemi' );
				break;
			case is_home() && is_front_page():
			case is_front_page():
				$title = get_bloginfo( 'name' );
				break;
			case is_home():
				$title = __( 'Latest Posts', 'aemi' );
				break;
			default:
				$title = single_post_title( '', false );
				break;
		}
		return $title;
	}
}

if ( ! function_exists( 'aemi_get_the_content' ) ) {
	/**
	 * @param $wp_post
	 * @return mixed
	 */
	function aemi_get_the_content( $wp_post ) {
		if ( ! isset( $wp_post ) ) {
			global $post;
			$wp_post = $post;
		}
		$content = $wp_post->post_content;
		$content = apply_filters( 'the_content', $content );
		$content = str_replace( ']]>', ']]&gt;', $content );
		return $content;
	}
}

if ( ! function_exists( 'aemi_get_meta_desc' ) ) {
	/**
	 * @param $wp_post
	 */
	function aemi_get_meta_desc( $wp_post ) {
		if ( ! isset( $wp_post ) ) {
			global $post;
			$wp_post = $post;
		}

		$meta_desc = '';

		switch ( true ) {
			case is_archive():
				$meta_desc = get_the_archive_description();
				// No break here, it's fully intentional.
			case is_search():
				$query = get_search_query();
				if ( empty( $query ) ) {
					$meta_desc = __( 'The search is not precise enough to display a relevant result.', 'aemi' );
				} else {
					if ( have_posts() ) {
						$meta_desc = __( 'Here are the search results for', 'aemi' ) . ': "' . esc_html( $query ) . '".';
					} else {
						$meta_desc = __( 'Nothing Found', 'aemi' );
					}
				}
				break;
			case is_404():
				$meta_desc = __( 'The page you are looking for is no longer available or never existed.', 'aemi' );
				break;
			case is_home() && is_front_page():
			case is_front_page():
			case is_home():
				$meta_desc = get_theme_mod( 'aemi_site_description', '' );
				if ( empty( $meta_desc ) ) {
					$meta_desc = get_bloginfo( 'description' );
				}
				break;
			default:
				if ( is_enabled( 'aemi_add_meta_tags', 0 ) ) {
					echo '<!-- frff -->';
					$meta_desc = wp_trim_words( get_post_meta( $wp_post->ID, 'aemi_meta_desc', true ), 25, '...' );
				}
				break;
		}
		if ( '' === $meta_desc ) {
			$meta_desc = wp_trim_words( aemi_get_the_content( $wp_post ), 25, '...' );
		}

		return wp_strip_all_tags( $meta_desc );
	}
}

if ( ! function_exists( 'aemi_ensure_https' ) ) {
	/**
	 * @param $string
	 * @return mixed
	 */
	function aemi_ensure_https( $string ) {
		if ( is_ssl() ) {
			return strtr( $string, array( 'http:' => '' ) );
		}
		return $string;
	}
}

if ( ! function_exists( 'aemi_title_parts' ) ) {
	/**
	 * @param $parts
	 * @return mixed
	 */
	function aemi_title_parts( $parts ) {
		$parts['title'] = aemi_get_title();
		return $parts;
	}
}

if ( ! function_exists( 'aemi_title_separator' ) ) {
	/**
	 * Modify the default separator in page title
	 *
	 * @return str
	 */
	function aemi_title_separator() {
		$mod = get_theme_mod( 'aemi_title_separator', '•' );
		if ( empty( $mod ) ) {
			return '•';
		}
		return $mod;
	}
}

if ( ! function_exists( 'aemi_site_header_colorscheme' ) ) {
	function aemi_site_header_colorscheme( $classes ) {

		$is_singular                   = is_singular();
		$has_thumbnail                 = has_post_thumbnail();
		$has_single_covering_thumbnail = $has_thumbnail && 'covered' === get_theme_mod( 'aemi_thumbnails_display', 'covered' );
		$has_to_be_dark                = $is_singular && $has_thumbnail && $has_single_covering_thumbnail;

		if ( $has_to_be_dark ) {
			$classes[] = 'color-scheme-dark';
		}

		return $classes;
	}
}

if ( ! function_exists( 'aemi_entry_header_colorscheme' ) ) {
	function aemi_entry_header_colorscheme( $classes ) {

		$is_singular                   = is_singular();
		$has_thumbnail                 = has_post_thumbnail();
		$has_loop_covering_thumbnail   = $has_thumbnail && 'cover' === get_theme_mod( 'aemi_post_layout', 'cover' );
		$has_single_covering_thumbnail = $has_thumbnail && 'covered' === get_theme_mod( 'aemi_thumbnails_display', 'covered' );
		$has_to_be_dark                = ! $is_singular && $has_loop_covering_thumbnail || $is_singular && $has_single_covering_thumbnail;

		if ( $has_to_be_dark ) {
			$classes[] = 'color-scheme-dark';
		}

		return $classes;
	}
}

if ( ! function_exists( 'aemi_get_site_header_classes' ) ) {
	function aemi_get_site_header_classes() {
		$classes = apply_filters( 'aemi_site_header_classes_filter', array() );
		echo ' class="' . esc_attr( implode( ' ', $classes ) ) . '" ';
	}
}


if ( ! function_exists( 'aemi_get_entry_header_classes' ) ) {
	function aemi_get_entry_header_classes() {
		$classes = apply_filters( 'aemi_entry_header_classes_filter', array( 'post-header' ) );
		echo ' class="' . esc_attr( implode( ' ', $classes ) ) . '" ';
	}
}


if ( ! function_exists( 'aemi_body_background_color' ) ) {
	function aemi_body_background_color() {
		$aemi_bg = esc_attr( get_background_color() );
		if ( ! empty( $aemi_bg ) ) {
			printf( ' style="background-color:%s;" ', $aemi_bg );
		}
	}
}
