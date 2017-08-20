<?php
/**
 * Class for WordPress Customizer multiple checkbox control
 *
 * @package BS4_Skeleton
 */

/**
 * Multiple checkbox customize control class.
 */
class BS4_Multi_Checkbox_WP_Customize_Control extends WP_Customize_Control {
	/**
	 * The type of customize control being rendered.
	 *
	 * @access public
	 *
	 * @var string
	 */
	public $type = 'multi_checkbox';

	/**
	 * Custom variable. Use to set if checkboxes should be sorted alphabetically.
	 *
	 * @access public
	 *
	 * @var bool
	 */
	public $sort_checkbox = false;

	/**
	 * Displays the control content.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function render_content() {
		if ( empty( $this->choices ) ) {
			return;
		}

		if ( $this->sort_checkbox ) {
			ksort( $this->choices );
		}
		?>

		<?php if ( ! empty( $this->label ) ) : ?>
			<span class="customize-control-title"><?php echo esc_attr( $this->label ); ?></span>
		<?php endif; ?>

		<?php if ( ! empty( $this->description ) ) : ?>
			<span class="description customize-control-description"><?php echo esc_attr( $this->description ); ?></span>
		<?php endif; ?>

		<?php foreach ( $this->choices as $value => $label ) : ?>
			<label>
				<input type="checkbox" <?php $this->link( $value ); ?> <?php checked( (bool) $this->value( $value ) ); ?>/>
				<?php echo esc_attr( $label ); ?>
			</label><br/>
		<?php endforeach; ?>
		<?php
	}
}
