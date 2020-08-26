<?php

class Aemi_Dropdown_Options extends WP_Customize_Control {

	function __construct($wp_customize,$setting,$args) {
		parent::__construct($wp_customize,$setting,$args);
		$this->enqueue();
	}

	public $type = 'dropdown-options';

	public function enqueue() {
		if (!wp_script_is('aemi-dropdown-options','enqueue'))
		{
			wp_enqueue_script( 'aemi-dropdown-options', trailingslashit( get_template_directory_uri() ) . 'inc/customizer/custom-controls/js/dropdown-options.js', array( 'jquery' ) );

			aemi_defer_scripts(['aemi-dropdown-options']);
		}
	}

	public function render_content() {

		if ( empty( $this->choices ) )
			return; ?>

		<?php if ( !empty( $this->label ) ) : ?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<?php endif; ?>

		<?php if ( !empty( $this->description ) ) : ?>
			<span class="description customize-control-description"><?php echo $this->description; ?></span>
		<?php endif; ?>

		<?php $current_value = $this->value(); ?>

		<select>
			<?php foreach ( $this->choices as $value => $label ) : ?>
				<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $current_value ); ?>>
					<?php echo esc_html( $label ); ?>
				</option>
			<?php endforeach; ?>
		</select>

		<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value ); ?>" />
	<?php }
}