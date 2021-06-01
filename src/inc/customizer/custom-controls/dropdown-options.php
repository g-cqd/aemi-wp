<?php

include_once ABSPATH . 'wp-includes/class-wp-customize-control.php';

class Aemi_Dropdown_Options extends WP_Customize_Control {

	/**
	 * @param $wp_customize
	 * @param $setting
	 * @param $args
	 */
	function __construct( $wp_customize, $setting, $args ) {
		parent::__construct( $wp_customize, $setting, $args );
		$this->enqueue();
	}

	/**
	 * @var string
	 */
	public $type = 'dropdown-options';

	public function enqueue() {
		if ( ! wp_script_is( 'aemi-dropdown-options', 'enqueue' ) ) {
			wp_enqueue_script(
				'aemi-dropdown-options',
				trailingslashit( get_template_directory_uri() ) . 'inc/customizer/custom-controls/js/dropdown-options.js',
				array( 'jquery' ),
				null,
				false
			);

			aemi_defer_scripts( array( 'aemi-dropdown-options' ) );
		}
	}

	/**
	 * @return null
	 */
	public function render_content() {

		if ( empty( $this->choices ) ) {
			return;
		}
		?>

		<?php if ( ! empty( $this->label ) ) { ?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<?php } ?>

		<?php if ( ! empty( $this->description ) ) { ?>
			<span class="description customize-control-description"><?php echo $this->description; ?></span>
		<?php } ?>

		<?php $current_value = $this->value(); ?>

		<select>
			<?php foreach ( $this->choices as $value => $label ) { ?>
				<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $current_value ); ?>>
					<?php echo esc_html( $label ); ?>
				</option>
			<?php } ?>
		</select>

		<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value ); ?>" />
		<?php
	}
}
