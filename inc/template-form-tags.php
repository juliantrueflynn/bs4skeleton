<?php
/**
 * Helper functions for displaying form fields and labels.
 *
 * @package	BS4_Skeleton
 */

if ( ! function_exists( 'bs4_form_input' ) ) {
	/**
	 * Text input field
	 *
	 * @param string       $name  Field name.
	 * @param string       $value Field value.
	 * @param array        $attr  Field arguments.
	 * @param string|array $extra Field custom attributes.
	 */
	function bs4_form_input( $name, $value, $attr = array(), $extra = '' ) {
		$defaults = array(
			'type' => 'text',
			'id' => $name,
			'name' => $name,
			'value' => $value,
			'class' => 'form-control',
		);

		$r = array_merge( $defaults, $attr );

		return '<input' . bs4_attributes_to_string( $r ) . " />\n";
	}
}

if ( ! function_exists( 'bs4_form_input_hidden' ) ) {
	/**
	 * Hidden input field
	 *
	 * @param string       $name  Field name.
	 * @param string       $value Field value.
	 * @param array        $attr  Field arguments.
	 * @param string|array $extra Field custom attributes.
	 */
	function bs4_form_input_hidden( $name, $value, $attr = array(), $extra = '' ) {
		$defaults = array(
			'type' => 'hidden',
			'name' => $name,
			'value' => $value,
		);

		$r = array_merge( $defaults, $attr );

		return '<input' . bs4_attributes_to_string( $r ) . " />\n";
	}
}

if ( ! function_exists( 'bs4_form_password' ) ) {
	/**
	 * Password input field
	 *
	 * Identical to the input function but adds the "password" type
	 *
	 * @param string       $name  Field name.
	 * @param string       $value Field value.
	 * @param array        $attr  Field arguments.
	 * @param string|array $extra Field custom attributes.
	 */
	function bs4_form_password( $name, $value, $attr = array(), $extra = '' ) {
		$defaults = array(
			'type' => 'password',
			'name' => $name,
			'value' => $value,
			'class' => 'form-control',
		);

		$r = array_merge( $defaults, $attr );

		return '<input' . bs4_attributes_to_string( $r ) . " />\n";
	}
}

if ( ! function_exists( 'bs4_form_textarea' ) ) {
	/**
	 * Textarea field
	 *
	 * @param string       $name  Field name.
	 * @param string       $value Field value.
	 * @param array        $attr  Field arguments.
	 * @param string|array $extra Field custom attributes.
	 */
	function bs4_form_textarea( $name, $value, $attr = array(), $extra = '' ) {
		$defaults = array(
			'name' => $name,
			'id' => $name,
			'rows' => '2',
			'class' => 'form-control',
		);

		$r = array_merge( $defaults, $attr );

		return '<textarea' . bs4_attributes_to_string( $r ) . '>'
			. esc_textarea( $value )
			. "</textarea>\n";
	}
}

if ( ! function_exists( 'bs4_form_select' ) ) {
	/**
	 * Select field
	 *
	 * @param string       $name    Field arguments.
	 * @param bool         $value   Selected value.
	 * @param array        $options Select options.
	 * @param array        $args    Field arguments.
	 * @param string|array $extra   Additional attributes.
	 */
	function bs4_form_select( $name = '', $value, $options = array(), $args = array(), $extra = '' ) {
		$defaults = array(
			'id' => $name,
			'name' => $name,
			'value' => $value,
			'class' => '',
		);

		$r = array_merge( $defaults, $args );

		$form = '<select' . bs4_attributes_to_string( $r ) . ">\n";

		foreach ( $options as $key => $val ) {
			$form .= '<option value="' . esc_html( $key ) . '" ' . selected( $value, $key, false ) . '>' . esc_attr( $val ) . "</option>\n";
		}

		return $form . "</select>\n";
	}
}// End if().

if ( ! function_exists( 'bs4_form_checkbox' ) ) {
	/**
	 * Checkbox field
	 *
	 * @param string       $name  Field arguments.
	 * @param string       $value Field value.
	 * @param array        $attr  Field arguments.
	 * @param string|array $extra Additional attributes.
	 */
	function bs4_form_checkbox( $name = '', $value, $attr = array(), $extra = '' ) {
		$defaults = array(
			'type' => 'checkbox',
			'name' => $name,
			'value' => '',
			'class' => 'form-check-input',
		);

		$r = array_merge( $defaults, $attr );

		return '<label class="form-check-label"><input' . bs4_attributes_to_string( $r ) . " /></label>\n";
	}
}// End if().

if ( ! function_exists( 'bs4_form_radio' ) ) {
	/**
	 * Radio button
	 *
	 * @param string       $name  Field arguments.
	 * @param string       $value Field value.
	 * @param array        $args  Field arguments.
	 * @param string|array $extra Additional attributes.
	 */
	function bs4_form_radio( $name, $value, $args = array(), $extra = '' ) {
		$defaults = array(
			'type' => 'radio',
			'name' => $name,
			'value' => '',
			'label' => '',
			'class' => 'form-check-input',
		);

		$r = array_merge( $defaults, $args );

		$label_text = '';

		if ( '' === $r['label'] && isset( $r['label'] ) ) {
			$label_text = ' ' . $r['label'];
		}

		return '<label class="form-check-label"><input' . bs4_attributes_to_string( $r ) . " />' . $label_text . '</label>\n";
	}
}

if ( ! function_exists( 'bs4_form_label' ) ) {
	/**
	 * Form field label
	 *
	 * @param string       $label_text The text to appear onscreen.
	 * @param string       $id         The id the label applies to.
	 * @param string|array $attributes Additional attributes.
	 */
	function bs4_form_label( $label_text = '', $id = '', $attributes = array() ) {
		$label = '<label';

		if ( '' !== $id ) {
			$label .= ' for="' . $id . '"';
		}

		$label .= bs4_attributes_to_string( $attributes );

		return $label . '>' . $label_text . '</label>';
	}
}

if ( ! function_exists( 'bs4_attributes_to_string' ) ) {
	/**
	 * Attributes array to field attributes string.
	 *
	 * @param string|array $attributes Field attributes.
	 */
	function bs4_attributes_to_string( $attributes ) {
		if ( empty( $attributes ) ) {
			return '';
		}

		if ( is_array( $attributes ) ) {
			$atts = '';

			foreach ( $attributes as $key => $val ) {
				// Skip attributes with empty value.
				if ( ! $val ) {
					continue;
				}

				if ( 'required' === $key && true === $val ) {
					$atts .= ' required';
					continue;
				}

				$atts .= ' ' . $key . '="' . $val . '"';
			}

			return $atts;
		}

		if ( is_string( $attributes ) ) {
			return ' ' . $attributes;
		}

		return false;
	}
}// End if().

if ( ! function_exists( 'bs4_custom_attributes_to_string' ) ) {
	/**
	 * Custom attributes array to field attributes string.
	 *
	 * @param string|array $attributes Field attributes.
	 */
	function bs4_custom_attributes_to_string( $attributes ) {
		if ( empty( $attributes ) ) {
			return '';
		}

		if ( is_array( $attributes ) ) {
			$atts = '';

			foreach ( $attributes as $attribute ) {
				// Skip attributes with empty value.
				if ( ! $val ) {
					continue;
				}

				$atts .= $attribute;
			}

			return $atts;
		}

		if ( is_string( $attributes ) ) {
			return ' ' . $attributes;
		}

		return false;
	}
}// End if().
