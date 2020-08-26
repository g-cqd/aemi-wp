<?php

if (!function_exists('aemi_add_meta_og'))
{
	function aemi_add_meta_og()
	{
		foreach (get_post_types(['public'=>true]) as $type)
		{
			add_meta_box(
				'aemi_meta_og',
				__( 'Open Graph', 'aemi' ),
				'aemi_meta_og_callback',
				$type
			);

			if (!wp_script_is('aemi-meta-og','enqueue'))
			{
				wp_enqueue_script( 'aemi-meta-og', trailingslashit( get_template_directory_uri() ) . 'inc/metaboxes/js/aemi-meta-og.js', array( 'jquery' ) );
			}
		}
	}
}

if (!function_exists('aemi_get_meta_data'))
{
	function aemi_get_meta_data($post)
	{
		global $wp;

		$wp_post = null;

		switch (true) {
			case is_search():
			case is_archive():
			case is_404():
				break;
			default:
				$wp_post = $post;
				break;
		}

		$data = [
			'site_name'		=>	[ 'value' => get_bloginfo('name') ],
			'url'			=>	[ 'value' => esc_url(home_url( $wp->request )) ],
		];

		if (isset($wp_post))
		{
			$data['author']			=	[ 'value' => get_post_meta( $wp_post->ID, 'aemi_meta_author', true )		];
			$data['description']	=	[ 'value' => get_post_meta( $wp_post->ID, 'aemi_meta_description', true )	];
			$data['keywords']		=	[ 'value' => get_post_meta( $wp_post->ID, 'aemi_meta_keywords', true )		];
			$data['title']			=	[ 'value' => get_post_meta( $wp_post->ID, 'aemi_meta_og_title', true )		];
			$data['image']			=	[ 'value' => get_post_meta( $wp_post->ID, 'aemi_meta_og_image', true )		];
			$data['type']			=	[ 'value' => get_post_meta( $wp_post->ID, 'aemi_meta_og_type', true )		];
		}
		else
		{
			$data['author']			=	[ 'value' => '' ];
			$data['description']	=	[ 'value' => '' ];
			$data['keywords']		=	[ 'value' => '' ];
			$data['title']			=	[ 'value' => '' ];
			$data['image']			=	[ 'value' => '' ];
			$data['type']			=	[ 'value' => '' ];
		}
		

		if ($data['title']['value'] == '')
		{
			$data['title']['value'] = wp_get_document_title();
		}

		if ($data['description']['value'] == '')
		{
			$data['description']['value'] = aemi_get_meta_desc($wp_post);
		}
		if ($data['image']['value'] == '')
		{
			if (isset($wp_post) && has_post_thumbnail($wp_post))
			{
				$data['image']['value'] = get_the_post_thumbnail_url($wp_post,'aemi-small');
			}
			else if (has_site_icon())
			{
				$data['image']['value'] = get_site_icon_url();
			}
			else if (function_exists('has_custom_logo') && has_custom_logo())
			{
				$data['image']['value'] = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'aemi-small' );
			}
			else if (function_exists('jetpack_has_site_logo') && jetpack_has_site_logo())
			{
				if (function_exists('jetpack_get_site_logo'))
				{
					$data['image']['value'] = jetpack_get_site_logo();
				}
			}
			else {
				$light_scheme_logo = get_theme_mod('aemi_light_scheme_logo');
				$dark_scheme_logo = get_theme_mod('aemi_dark_scheme_logo');
				if ($dark_scheme_logo != '')
				{
					$data['image']['value'] = $dark_scheme_logo;
				}
				else if ($light_scheme_logo != '')
				{
					$data['image']['value'] = $light_scheme_logo;
				}
			}
		}
		if ($data['type']['value'] == '')
		{
			if (isset($wp_post))
			{

			}
			$data['type']['value'] = 'website';
		}

		return $data;
	}
}

if (!function_exists('aemi_meta_og_namespace'))
{
	function aemi_meta_og_namespace()
	{
		if (is_enabled('aemi_add_meta_og',0))
		{
			return 'prefix="og: http://ogp.me/ns#"';
		}
	}
}


if (!function_exists('aemi_meta_og_callback'))
{
	function aemi_meta_og_callback($post)
	{
		wp_nonce_field( 'aemi_meta_og_nonce', 'aemi_meta_og_nonce' );

		$opt = aemi_get_meta_data($post);

		$types = [
			'article',
			'book',
			'music.song',
			'music.album',
			'music.playlist',
			'music.radio_station',
			'profile',
			'video.movie',
			'video.episode',
			'video.tv_show',
			'video.other',
			'website'
		];

		?>
		<fieldset>
			<label for="aemi_meta_og_title">
				<?php echo esc_html__('Open Graph: Title','aemi') ?>
				<input type="text" id="aemi_meta_og_title" name="aemi_meta_og_title" value="<?php echo esc_attr( $opt['title']['value'] ) ?>">
			</label>
		</fieldset>
		<fieldset>
			<label for="aemi_meta_og_description">
				<?php echo esc_html__('Open Graph: Description','aemi') ?>
				<input type="text" id="aemi_meta_og_description" name="aemi_meta_og_description" value="<?php echo esc_attr( $opt['description']['value'] ) ?>">
			</label>
		</fieldset>
		<fieldset>
			<label for="aemi_meta_og_image">
				<?php echo esc_html__('Open Graph: Image','aemi') ?>
				
				<button class="button aemi_meta_og_media_button" data-custom-plugin-media-uploader-target=".aemi_meta_og_image"><?php echo esc_html__( 'Upload File', 'aemi' ) ?></button>

				<input id="aemi_meta_og_image" name="aemi_meta_og_image" class="aemi_meta_og_image" type="hidden" value="<?php echo esc_attr( $opt['image']['value'] ) ?>">
			</label>
		</fieldset>
		<fieldset>
			<label for="aemi_meta_og_type">
				<?php echo esc_html__('Open Graph: Type','aemi'); ?>
				<select id="aemi_meta_og_type" name="aemi_meta_og_type">
					<?php foreach ($types as $val) : ?>
					<option value="<?php echo esc_attr($val); ?>" <?php echo selected($val,$opt['type']['value']); ?>><?php echo esc_html($val) ?></option>
					<?php endforeach; ?>
				</select>
			</label>
		</fieldset><?php
	}
}

if (!function_exists('aemi_save_meta_og_data'))
{
	function aemi_save_meta_og_data( $post_id )
	{

		if (!isset($_POST['aemi_meta_og_nonce']))
			{ return; }

		if (!wp_verify_nonce($_POST['aemi_meta_og_nonce'], 'aemi_meta_og_nonce'))
			{ return; }

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			{ return; }

		if (isset($_POST['post_type']) && 'page' == $_POST['post_type'])
		{
			if (!current_user_can('edit_page', $post_id))
				{ return; }
		}
		else
		{
			if (!current_user_can('edit_post', $post_id))
				{ return; }
		}
		if (is_multisite() && ms_is_switched())
			{ return $post_id; }

		update_post_meta( $post_id, 'aemi_meta_og_title', sanitize_text_field( $_POST['aemi_meta_og_title'] ) );
		update_post_meta( $post_id, 'aemi_meta_og_description', sanitize_text_field( $_POST['aemi_meta_og_description'] ) );
		update_post_meta( $post_id, 'aemi_meta_og_image', sanitize_text_field( $_POST['aemi_meta_og_image'] ) );
		update_post_meta( $post_id, 'aemi_meta_og_type', sanitize_text_field( $_POST['aemi_meta_og_type'] ) );
	}
}


if (!function_exists('aemi_meta_og__action'))
{
	function aemi_meta_og__action()
	{
		global $post;

		$data = aemi_get_meta_data($post);

		if ($data['site_name']['value'] != '')
		{
			?><meta property="og:site_name" content="<?php echo esc_attr( $data['site_name']['value'] ) ?>"><?php
		}
		if ($data['url']['value'] != '')
		{
			?><meta property="og:url" content="<?php echo esc_attr( $data['url']['value'] ) ?>"><?php
		}
		if ($data['title']['value'] != '')
		{
			?><meta property="og:title" content="<?php echo esc_attr( $data['title']['value'] ) ?>"><?php
		}
		if ($data['description']['value'] != '')
		{
			?><meta property="og:description" content="<?php echo esc_attr( $data['description']['value'] ) ?>"><?php
		}
		if ($data['image']['value'] != '')
		{
			?><meta property="og:image" content="<?php echo esc_attr( $data['image']['value'] ) ?>"><?php
		}
		if ($data['type']['value'] != '')
		{
			?><meta property="og:type" content="<?php echo esc_attr( $data['type']['value'] ) ?>"><?php
		}
	}
}

if ( get_theme_mod('aemi_add_meta_og', 0) == 1 )
{
	add_action( 'add_meta_boxes',	'aemi_add_meta_og' );
	add_action( 'save_post',		'aemi_save_meta_og_data' );
	add_action( 'aemi_head',		'aemi_meta_og__action' );
}