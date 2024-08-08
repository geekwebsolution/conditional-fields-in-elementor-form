<?php
use Elementor\Widget_Base;
use ElementorPro\Modules\Forms\Classes;
use Elementor\Controls_Manager;
use ElementorPro\Plugin;

class Superaddons_Elemntor_HTML1_Field extends \ElementorPro\Modules\Forms\Fields\Field_Base {
	private $fixed_files_indices = false;
    
	public function get_type() {
		return 'html1';
	}
	public function editor_preview_footer() {
		add_action( 'wp_footer', array($this,"telephone_content_template_script"));
	}
	function telephone_content_template_script(){
		?>
		<script>
		jQuery( document ).ready( () => {
			elementor.hooks.addFilter(
				'elementor_pro/forms/content_template/field/html1',
				function ( inputField, item, i ) {
					return `<div class="elementor-field-html-type">${item.field_html1}</div>`;
				}, 10, 3
			);
		});
		</script>
		<?php
	}
	public function get_name() {
		return esc_html__( 'HTML', 'elementor-telephone' );
	}

	/**
	 * @param      $item
	 * @param      $item_index
	 * @param Form $form
	 */
	public function update_controls( $widget ) {
		$elementor = \ElementorPro\Plugin::elementor();
		$control_data = $elementor->controls_manager->get_control_from_stack( $widget->get_unique_name(), 'form_fields' );
		if ( is_wp_error( $control_data ) ) {
			return;
		}	
		$field_controls = [
			'field_html1' => [
				'name' => 'field_html1',
				'label' => esc_html__( 'HTML', 'elementor-pro' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'condition' => [
					'field_type' => $this->get_type(),
				],
				'tab' => 'content',
				'inner_tab' => 'form_fields_content_tab',
				'tabs_wrapper' => 'form_fields_tabs',
			],
		];
		$control_data['fields'] = $this->inject_field_controls( $control_data['fields'], $field_controls );
		$widget->update_control( 'form_fields', $control_data );
	}
	public function render( $item, $item_index, $form ) {

		if ( isset($item['required'] ) && $item['required']  == "true" ) {
			$form->add_render_attribute( 'input' . $item_index, 'value', "Please remove HTML type required." );
			$form->remove_render_attribute( 'input' . $item_index, 'type');
			$form->add_render_attribute( 'input' . $item_index, 'type', "hidden" );
			?>
			<input <?php $form->print_render_attribute_string( 'input' . $item_index ); ?>>
			<?php
		}
		?>
		<div class="elementor-field-html-type" id="form-field-field_<?php echo esc_html($item["_id"]) ?>">
			<?php echo $item['field_html1']; ?>
			
		</div>
		<?php
	}

	public function __construct() {
		parent::__construct();
		add_action( 'elementor/preview/init', array( $this, 'editor_preview_footer' ) );
	}
}