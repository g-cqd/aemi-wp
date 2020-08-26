<?php

if (!function_exists('aemi_add_meta_twitter'))
{
	function aemi_add_meta_twitter()
	{
		foreach (get_post_types(['public'=>true]) as $type)
		{
			add_meta_box(
				'aemi_meta_twitter',
				__( 'Twitter', 'aemi' ),
				'aemi_meta_twitter_callback',
				$type
			);

			if (!wp_script_is('aemi-meta-twitter','enqueue'))
			{
				wp_enqueue_script( 'aemi-meta-twitter', trailingslashit( get_template_directory_uri() ) . 'inc/metaboxes/js/aemi-meta-twitter.js', array( 'jquery' ) );
			}
		}
	}
}

if (!function_exists('aemi_meta_twitter_data_fallback'))
{
	function aemi_meta_twitter_data_fallback($post,$type)
	{
		if (isset($post))
		{
			$mod = get_theme_mod('aemi_meta_twitter_' . $type, '');
			$meta = get_post_meta($post->ID, 'aemi_meta_twitter_' . $type, true);
			if ($meta != '')
			{
				return $meta;
			}
			else if ($mod != '')
			{
				return $mod;
			}
			else if ($type == 'card')
			{
				return 'summary';
			}
		}
	}
}

if (!function_exists('aemi_meta_twitter_data'))
{
	function aemi_meta_twitter_data($post)
	{
		$data = [];
		
		if (!is_enabled('aemi_add_meta_og',0))
		{
			$data = array_filter(
				aemi_get_meta_data($post),
				function ($key)
				{ return in_array($key, ['title','description','image']); },
				ARRAY_FILTER_USE_KEY
			);
		}

		$data['card']		= [ 'value' => aemi_meta_twitter_data_fallback($post,'card') ];
		$data['site']		= [ 'value' => aemi_meta_twitter_data_fallback($post,'site') ];
		$data['creator']	= [ 'value' => aemi_meta_twitter_data_fallback($post,'creator') ];
		
		return $data;
	}
}


if (!function_exists('aemi_meta_twitter_callback'))
{
	function aemi_meta_twitter_callback($post)
	{
		wp_nonce_field( 'aemi_meta_twitter_nonce', 'aemi_meta_twitter_nonce' );

		$opt = aemi_meta_twitter_data($post);

		$types = [
			'summary' => __('Summary', 'aemi'),
			'summary_large_image' => __('Summary with Large Image', 'aemi')
		];

		?>
		<fieldset>
			<label for="aemi_meta_twitter_card">
				<?php echo esc_html__('Twitter: Card Type','aemi') ?>
				<select id="aemi_meta_twitter_card" name="aemi_meta_twitter_card">
					<?php foreach ($types as $value => $text) : ?>
					<option value="<?php echo esc_attr($value); ?>" <?php echo selected($value,$opt['card']['value']); ?>><?php echo esc_html($text) ?></option>
					<?php endforeach; ?>
				</select>
			</label>
		</fieldset>
		<fieldset>
			<label for="aemi_meta_twitter_site">
				<?php echo esc_html__('Twitter: Site Account','aemi') ?>
				<input type="text" id="aemi_meta_twitter_site" name="aemi_meta_twitter_site" value="<?php echo esc_attr( $opt['site']['value'] ); ?>">
			</label>
		</fieldset>
		<fieldset>
			<label for="aemi_meta_twitter_creator">
				<?php echo esc_html__('Twitter: Creator Account','aemi') ?>
				<input type="text" id="aemi_meta_twitter_creator" name="aemi_meta_twitter_creator" value="<?php echo esc_attr( $opt['creator']['value'] ); ?>">
			</label>
		</fieldset>
		<?php if (!is_enabled('aemi_add_meta_og',0)): ?>
		<fieldset>
			<label for="aemi_meta_twitter_title">
				<?php echo esc_html__('Twitter: Content Title','aemi') ?>
				<input type="text" id="aemi_meta_twitter_title" name="aemi_meta_twitter_title" value="<?php echo esc_attr( $opt['title']['value'] ); ?>">
			</label>
		</fieldset>
		<fieldset>
			<label for="aemi_meta_twitter_description">
				<?php echo esc_html__('Twitter: Content Description','aemi') ?>
				<input type="text" id="aemi_meta_twitter_description" name="aemi_meta_twitter_description" value="<?php echo esc_attr( $opt['description']['value'] ); ?>">
			</label>
		</fieldset>
		<fieldset>
			<label for="aemi_meta_twitter_image">
				<?php echo esc_html__('Twitter: Content Image','aemi') ?>

				<button class="button aemi_meta_twitter_media_button" data-custom-plugin-media-uploader-target=".aemi_meta_twitter_image"><?php echo esc_html__( 'Upload File', 'aemi' ) ?></button>

				<input id="aemi_meta_twitter_image" name="aemi_meta_twitter_image" class="aemi_meta_twitter_image" type="hidden" value="<?php echo esc_attr( $opt['image']['value'] ) ?>">
			</label>
		</fieldset><?php
		endif;
	}
}

if (!function_exists('aemi_save_meta_twitter_data'))
{
	function aemi_save_meta_twitter_data( $post_id )
	{

		if (!isset($_POST['aemi_meta_twitter_nonce']))
			{ return; }

		if (!wp_verify_nonce($_POST['aemi_meta_twitter_nonce'], 'aemi_meta_twitter_nonce'))
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


		update_post_meta( $post_id, 'aemi_meta_twitter_card', sanitize_text_field( $_POST['aemi_meta_twitter_card'] ) );
		update_post_meta( $post_id, 'aemi_meta_twitter_site', sanitize_text_field( $_POST['aemi_meta_twitter_site'] ) );
		update_post_meta( $post_id, 'aemi_meta_twitter_creator', sanitize_text_field( $_POST['aemi_meta_twitter_creator'] ) );
		update_post_meta( $post_id, 'aemi_meta_twitter_title', sanitize_text_field( $_POST['aemi_meta_twitter_title'] ) );
		update_post_meta( $post_id, 'aemi_meta_twitter_description', sanitize_text_field( $_POST['aemi_meta_twitter_description'] ) );
		update_post_meta( $post_id, 'aemi_meta_twitter_image', sanitize_text_field( $_POST['aemi_meta_twitter_image'] ) );

	}
}


if (!function_exists('aemi_meta_twitter__action'))
{
	function aemi_meta_twitter__action()
	{

		global $post;

		$data = aemi_meta_twitter_data($post);

		if ($data['card']['value'] != '')
		{
			?><meta property="twitter:card" content="<?php echo esc_attr( $data['card']['value'] ) ?>"><?php
		}
		if ($data['site']['value'] != '')
		{
			?><meta property="twitter:site" content="<?php echo esc_attr( $data['site']['value'] ) ?>"><?php
		}
		if ($data['creator']['value'] != '')
		{
			?><meta property="twitter:creator" content="<?php echo esc_attr( $data['creator']['value'] ) ?>"><?php
		}
		if (!is_enabled('aemi_add_meta_og',0))
		{
			if ($data['title']['value'] != '')
			{
				?><meta property="twitter:title" content="<?php echo esc_attr( $data['title']['value'] ) ?>"><?php
			}
			if ($data['description']['value'] != '')
			{
				?><meta property="twitter:description" content="<?php echo esc_attr( $data['description']['value'] ) ?>"><?php
			}
			if ($data['image']['value'] != '')
			{
				?><meta property="twitter:image" content="<?php echo esc_attr( $data['image']['value'] ) ?>"><?php
			}
		}
	}
}

if ( is_enabled('aemi_add_meta_twitter',0))
{
	add_action( 'add_meta_boxes',	'aemi_add_meta_twitter' );
	add_action( 'save_post',		'aemi_save_meta_twitter_data' );
	add_action( 'aemi_head',		'aemi_meta_twitter__action' );
}