<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use ElementorPro\Plugin;
class CFIEF_Repeater_Control extends \Elementor\Control_Repeater {

	public function get_type() {
		return 'cfief_conditional_logic_repeater';
	}

	public function enqueue() {
		wp_enqueue_script( 'cfief_conditional_logic_repeater', plugin_dir_url( __DIR__ ) .'assets/js/repeater-control.js', array('jquery'), CFIEF_VERSION, array("in_footer"=>true) );
	}
	public function get_default_value() {
		return [];
	}

	/**
	 * Get repeater control default settings.
	 *
	 * Retrieve the default settings of the repeater control. Used to return the
	 * default settings while initializing the repeater control.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @return array Control default settings.
	 */
	protected function get_default_settings() {
		return [
			'fields' => [],
			'title_field' => '',
			'prevent_empty' => true,
			'is_repeater' => true,
			'item_actions' => [
				'add' => true,
				'duplicate' => true,
				'remove' => true,
				'sort' => true,
			],
		];
	}

	/**
	 * Get repeater control value.
	 *
	 * Retrieve the value of the repeater control from a specific Controls_Stack.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $control  Control
	 * @param array $settings Controls_Stack settings
	 *
	 * @return mixed Control values.
	 */
	public function get_value( $control, $settings ) {
		$value = parent::get_value( $control, $settings );

		if ( ! empty( $value ) ) {
			foreach ( $value as &$item ) {
				foreach ( $control['fields'] as $field ) {
					$control_obj = \Elementor\Plugin::$instance->controls_manager->get_control( $field['type'] );

					// Prior to 1.5.0 the fields may contains non-data controls.
					if ( ! $control_obj instanceof Base_Data_Control ) {
						continue;
					}

					$item[ $field['name'] ] = $control_obj->get_value( $field, $item );
				}
			}
		}

		return $value;
	}

	/**
	 * Import repeater.
	 *
	 * Used as a wrapper method for inner controls while importing Elementor
	 * template JSON file, and replacing the old data.
	 *
	 * @since 1.8.0
	 * @access public
	 *
	 * @param array $settings     Control settings.
	 * @param array $control_data Optional. Control data. Default is an empty array.
	 *
	 * @return array Control settings.
	 */
	public function on_import( $settings, $control_data = [] ) {
		if ( empty( $settings ) || empty( $control_data['fields'] ) ) {
			return $settings;
		}

		$method = 'on_import';

		foreach ( $settings as &$item ) {
			foreach ( $control_data['fields'] as $field ) {
				if ( empty( $field['name'] ) || empty( $item[ $field['name'] ] ) ) {
					continue;
				}

				$control_obj = \Elementor\Plugin::$instance->controls_manager->get_control( $field['type'] );

				if ( ! $control_obj ) {
					continue;
				}

				if ( method_exists( $control_obj, $method ) ) {
					$item[ $field['name'] ] = $control_obj->{$method}( $item[ $field['name'] ], $field );
				}
			}
		}

		return $settings;
	}

	public function content_template() {
		?>
		<label>
			<span class="elementor-control-title">{{{ data.label }}}</span>
		</label>
		<div class="elementor-repeater-fields-wrapper"></div>
		<# if ( itemActions.add ) { #>
			<div class="elementor-button-wrapper">
				<button class="elementor-button elementor-repeater-add" type="button">
					<i class="eicon-plus" aria-hidden="true"></i>
					<# if ( data.button_text ) { #>
						<?php echo esc_html__( '{{{ data.button_text }}}', 'elementor' ); ?>
					<# } else { #>
						<?php echo esc_html__( 'Add', "conditional-fields-in-elementor-form" ); ?>
					<# } #>
				</button>
			</div>
		<# } #>
		<?php
	}
}