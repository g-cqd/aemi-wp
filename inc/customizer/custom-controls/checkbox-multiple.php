<?php

class Aemi_Checkbox_Multiple extends WP_Customize_Control {

	function __construct($wp_customize,$setting,$args) {
		parent::__construct($wp_customize,$setting,$args);
		$this->enqueue();
	}

	public $type = 'checkbox-multiple';

	public function enqueue() {
		if (!wp_script_is('aemi-checkbox-multiple','enqueue'))
		{
			wp_enqueue_script( 'aemi-checkbox-multiple', trailingslashit( get_template_directory_uri() ) . 'inc/customizer/custom-controls/js/checkbox-multiple.js', array( 'jquery' ) );

			aemi_defer_scripts(['aemi-checkbox-multiple']);
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

		<?php $multi_values = !is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value(); ?>

		<ul>
			<?php foreach ( $this->choices as $value => $label ) : ?>

				<li>
					<label>
						<input type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php checked( in_array( $value, $multi_values ) ); ?> />
						<?php echo esc_html( $label ); ?>
					</label>
				</li>

			<?php endforeach; ?>
		</ul>

		<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( implode( ',', $multi_values ) ); ?>" />
	<?php }
}