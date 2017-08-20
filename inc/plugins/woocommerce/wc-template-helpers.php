<?php
/**
 * Overwriting default WooCommerce functions
 *
 * @package BS4_Skeleton
 */

if ( ! function_exists( 'bs4_wc_loop_grid_rows_splitter' ) ) {
	/**
	 * Split Bootstrap 'row' and start a new 'row' wrap in products loop.
	 *
	 * Based on 'wc_loop_per_row' setting in Customizer.
	 *
	 * @param int  $count Number for current post in loop.
	 * @param bool $echo  Optional. True echo, false return. Default true.
	 */
	function bs4_wc_loop_grid_rows_splitter( $count = null, $echo = true ) {
		global $woocommerce_loop;

		if ( null === $count ) {
			$count = $woocommerce_loop['loop'] - 1;
		}

		$per_row = (int) apply_filters( 'bs4_wc_loop_per_row', get_theme_mod( 'wc_loop_per_row', 3 ) );

		// Check if to echo or return output.
		if ( $echo ) {
			echo bs4_get_loop_rows_splitter( $count, $per_row ); // WPCS: XSS OK.
		} else {
			return bs4_get_loop_rows_splitter( $count, $per_row );
		}
	}
}

if ( ! function_exists( 'woocommerce_review_display_gravatar' ) ) {
	/**
	 * Overwrite default review authors gravatar with Bootstrap friendly display.
	 *
	 * @param array $comment WP_Comment.
	 */
	function woocommerce_review_display_gravatar( $comment ) {
		echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', 32 ), '', '', array(
			'class' => 'comment-avatar d-flex',
		) );
	}
}

if ( ! function_exists( 'woocommerce_template_loop_product_thumbnail' ) ) {
	/**
	 * Get the product thumbnail for the loop.
	 */
	function woocommerce_template_loop_product_thumbnail() {
		$image_size = apply_filters( 'single_product_archive_thumbnail_size', 'shop_catalog' );

		if ( '' !== get_the_post_thumbnail() ) {
			$output = get_the_post_thumbnail( get_the_ID(), $image_size, array(
				'class' => 'img-fluid w-100',
				'link_thumbnail' => true,
			) );
		}

		echo '<a href="' . get_the_permalink() . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">' . $output . '</a>'; // WPCS: XSS OK.
	}
}

if ( ! function_exists( 'woocommerce_template_loop_product_title' ) ) {
	/**
	 * Show the product title in the product loop. By default this is an H2.
	 */
	function woocommerce_template_loop_product_title() {
		the_title( '<header class="entry-header"><h4 class="woocommerce-loop-product__title"><a href="' . get_the_permalink() . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link entry-title">', '</a></h4></header>' );
	}
}

if ( ! function_exists( 'woocommerce_form_field' ) ) {
	/**
	 * Outputs a checkout/address form field.
	 *
	 * @param string $key   Field name.
	 * @param mixed  $args  Field arguments.
	 * @param string $value Field value. Default null.
	 */
	function woocommerce_form_field( $key, $args, $value = null ) {
		$defaults = array(
			'type'              => 'text',
			'label'             => '',
			'description'       => '',
			'placeholder'       => '',
			'maxlength'         => false,
			'required'          => false,
			'autocomplete'      => false,
			'id'                => $key,
			'class'             => array(),
			'label_class'       => array(),
			'input_class'       => array(),
			'return'            => false,
			'options'           => array(),
			'custom_attributes' => array(),
			'validate'          => array(),
			'default'           => '',
			'autofocus'         => '',
			'priority'          => '',
		);

		$args = wp_parse_args( $args, $defaults );
		$args = apply_filters( 'woocommerce_form_field_args', $args, $key, $value );

		if ( $args['required'] ) {
			$args['class'][] = 'validate-required';
			$required = ' <abbr class="required text-danger" title="' . esc_attr__( 'required', 'bs4' ) . '">*</abbr>';
		} else {
			$required = '';
		}

		if ( is_null( $value ) ) {
			$value = $args['default'];
		}

		// Custom attribute handling.
		$args['custom_attributes'] = array_filter( (array) $args['custom_attributes'] );

		if ( $args['maxlength'] ) {
			$args['custom_attributes']['maxlength'] = absint( $args['maxlength'] );
		}

		if ( ! empty( $args['autocomplete'] ) ) {
			$args['custom_attributes']['autocomplete'] = $args['autocomplete'];
		}

		if ( true === $args['autofocus'] ) {
			$args['custom_attributes']['autofocus'] = 'autofocus';
		}

		if ( ! empty( $args['validate'] ) ) {
			foreach ( $args['validate'] as $validate ) {
				$args['class'][] = 'validate-' . $validate;
			}
		}

		$field = '';
		$sort = $args['priority'] ? $args['priority'] : '';
		$extra_classes = $args['input_class'] ? esc_attr( ' ' . implode( ' ', $args['input_class'] ) ) : '';

		switch ( $args['type'] ) {
			case 'country' :
				$countries = 'shipping_country' === $key ? WC()->countries->get_shipping_countries() : WC()->countries->get_allowed_countries();

				if ( 1 === count( $countries ) ) {
					$field .= '<strong>' . current( array_values( $countries ) ) . '</strong>';
					$field .= '<input type="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="' . current( array_keys( $countries ) ) . '" ' . implode( ' ', $args['custom_attributes'] ) . ' class="country_to_state" />';
				} else {
					$field = sprintf(
						'<select name="%s" id="%s" class="country_to_state country_select form-control%s"%s>',
						esc_attr( $key ),
						esc_attr( $args['id'] ),
						$args['input_class'] ? esc_attr( ' ' . implode( ' ', $args['input_class'] ) ) : '',
						$args['custom_attributes'] ? implode( ' ', $args['custom_attributes'] ) : ''
					);

					$field .= '<option value="">' . esc_html__( 'Select a country&hellip;', 'bs4' ) . '</option>';

					foreach ( $countries as $ckey => $cvalue ) {
						$field .= '<option value="' . esc_attr( $ckey ) . '" ' . selected( $value, $ckey, false ) . '>' . $cvalue . '</option>';
					}

					$field .= '</select>';
					$field .= '<noscript><input type="submit" name="woocommerce_checkout_update_totals" value="' . esc_attr__( 'Update country', 'bs4' ) . '" /></noscript>';
				}

				break;
			case 'state' :
				/* Get country this state field is representing */
				$for_country = isset( $args['country'] ) ? $args['country'] : WC()->checkout->get_value( 'billing_state' === $key ? 'billing_country' : 'shipping_country' );
				$states = WC()->countries->get_states( $for_country );

				if ( is_array( $states ) && empty( $states ) ) {
					$field .= '<input type="hidden" class="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="" ' . implode( ' ', $args['custom_attributes'] ) . ' placeholder="' . esc_attr( $args['placeholder'] ) . '" />';
				} elseif ( ! is_null( $for_country ) && is_array( $states ) ) {
					$states_list = array();
					$states_list[''] = esc_html__( 'Select a state&hellip;', 'bs4' );
					foreach ( $states as $ckey => $cvalue ) {
						$states_list[ esc_attr( $ckey ) ] = $cvalue;
					}

					$field = bs4_form_select( esc_attr( $key ), esc_attr( $value ), $states_list, array(
						'id' => esc_attr( $args['id'] ),
						'class' => 'state_select form-control' . $extra_classes,
						'data-placeholder' => esc_attr( $args['placeholder'] ),
					), $args['custom_attributes'] );
				} else {
					$field = bs4_form_input( esc_attr( $key ), esc_attr( $value ), array(
						'id' => esc_attr( $args['id'] ),
						'class' => 'input-text form-control' . $extra_classes,
						'placeholder' => esc_attr( $args['placeholder'] ),
					), esc_attr( $value ), $args['custom_attributes'] );
				}

				break;
			case 'textarea' :
				$field = bs4_form_textarea( esc_attr( $key ), esc_attr( $value ), array(
					'name' => esc_attr( $key ),
					'id' => esc_attr( $args['id'] ),
					'class' => 'input-text form-control' . $extra_classes,
					'placeholder' => esc_attr( $args['placeholder'] ),
				), esc_textarea( $value ), $args['custom_attributes'] );

				break;
			case 'checkbox' :
				$field = '<label class="form-check-label">';
				$field .= bs4_form_checkbox( esc_attr( $key ), 1, array(
					'id' => esc_attr( $args['id'] ),
					'class' => 'input-checkbox form-check-input' . $extra_classes,
					'checked' => checked( $value, 1, false ),
				), $args['custom_attributes'] );
				$field .= '</label>';

				break;
			case 'password' :
			case 'text' :
			case 'email' :
			case 'tel' :
			case 'number' :
				$field = bs4_form_input( esc_attr( $key ), esc_attr( $value ), array(
					'id' => esc_attr( $args['id'] ),
					'class' => 'input-text form-control' . $extra_classes,
					'placeholder' => esc_attr( $args['placeholder'] ),
				), $args['custom_attributes'] );

				break;
			case 'select' :
				if ( ! empty( $args['options'] ) ) {
					foreach ( $args['options'] as $option_key => $option_text ) {
						if ( '' === $option_key ) {
							// If we have a blank option, select2 needs a placeholder.
							if ( empty( $args['placeholder'] ) ) {
								$args['placeholder'] = $option_text ? $option_text : __( 'Choose an option', 'bs4' );
							}

							$args['custom_attributes'] .= ' data-allow_clear="true"';
						}
					}

					$field = bs4_form_select( esc_attr( $key ), esc_attr( $value ), $args['options'], array(
						'id' => esc_attr( $args['id'] ),
						'class' => 'select form-control' . $extra_classes,
						'data-placeholder' => esc_attr( $args['placeholder'] ),
					), $args['custom_attributes'] );
				}

				break;
			case 'radio' :
				$field = '';

				if ( ! empty( $args['options'] ) ) {
					foreach ( $args['options'] as $option_key => $option_text ) {
						$field = '<label class="form-check-label">';
						$field .= bs4_form_radio( esc_attr( $key ), esc_attr( $option_key ), $value, array(
							'id' => esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ),
							'class' => 'input-radio form-check-input' . $extra_classes,
							'checked' => checked( $value, $option_key, false ),
							'label' => $option_text,
						), $args['custom_attributes'] );
						$field .= '</label>';
					}
				}

				break;
		}// End switch().

		if ( ! empty( $field ) ) {
			if ( 'checkbox' === $args['type'] || 'radio' === $args['type'] ) {
				$group_class = 'form-check';
			} else {
				$group_class = 'form-group';
			}

			$label_attr = array();

			if ( $args['label_class'] ) {
				if ( is_string( $args['label_class'] ) ) {
					$label_attr = array(
						'class' => $args['label_class'],
					);
				} else {
					$label_attr = array(
						'class' => esc_attr( join( ' ', $args['label_class'] ) ),
					);
				}
			}

			$field_html = sprintf(
				'<div%s class="%s %s" data-priority="%s">%s%s%s</div>',
				$args['id'] ? ' id="' . esc_attr( $args['id'] ) . '_field"' : '',
				$group_class,
				$args['class'] ? esc_attr( join( ' ', $args['class'] ) ) : '',
				esc_attr( $sort ),
				bs4_form_label( esc_attr( $args['label'] ) . $required, $args['id'], $label_attr ),
				$field,
				$args['description'] ? '<p class="description form-text">' . esc_html( $args['description'] ) . '</p>' : ''
			);

			$field = $field_html;
		}

		$field = apply_filters( 'woocommerce_form_field_' . $args['type'], $field, $key, $args, $value );

		if ( $args['return'] ) {
			return $field;
		} else {
			echo $field; // WPCS: XSS OK.
		}
	}
}// End if().
