<?php
use Elementor\Controls_Manager;
use ElementorPro\Modules\Forms\actions\Redirect;
use Elementor\Modules\DynamicTags\Module as TagsModule;

class Superaddons_Redirect_Conditional_Logic extends Redirect {
	public function get_name() {
		return 'redirect_logic';
	}
	public function get_label() {
		return esc_html__( 'Redirect Conditional Logic', 'elementor-pro' );
	}
	protected function get_control_id( $control_id ) {
		return $control_id . '_conditional_logic';
	}
	public function register_settings_section( $widget ) {
        $options_logic = array(
            "==" => esc_html__("is","conditional-logic-for-elementor-forms"),
            "!=" => esc_html__("not is","conditional-logic-for-elementor-forms"),
            "e" => esc_html__("empty","conditional-logic-for-elementor-forms"),
            "!e" => esc_html__("not empty","conditional-logic-for-elementor-forms"),
            "c" => esc_html__("contains","conditional-logic-for-elementor-forms"),
            "!c" => esc_html__("does not contain","conditional-logic-for-elementor-forms"),
            "^" => esc_html__("starts with","conditional-logic-for-elementor-forms"),
            "~" => esc_html__("ends with","conditional-logic-for-elementor-forms"),
            ">" => esc_html__("greater than","conditional-logic-for-elementor-forms"),
            "<" => esc_html__("less than","conditional-logic-for-elementor-forms"),
            "array" => esc_html__("list array (a,b,c)","conditional-logic-for-elementor-forms"),
            "!array" => esc_html__("not list array (a,b,c)","conditional-logic-for-elementor-forms"),
            "array_contain" => esc_html__("list array contain (a,b,c)","conditional-logic-for-elementor-forms"),
            "!array_contain" => esc_html__("not list array contain (a,b,c)","conditional-logic-for-elementor-forms"),
        );
        $options_pro = array();

		$widget->start_controls_section(
			$this->get_control_id( 'section_redirect' ),
			[
				'label' => $this->get_label(),
				'condition' => [
					'submit_actions' => $this->get_name(),
				],
			]
		);
		$control_id_conditional_logic = $this->get_control_id( 'redirect_conditional_logic' );
		$widget->add_control(
			$control_id_conditional_logic,
			[
				'label' => esc_html__( 'Enable Conditional Logic', 'elementor-pro' ),
				'render_type' => 'none',
				'type' => Controls_Manager::SWITCHER,
			]
		);
		$widget->add_control(
			$this->get_control_id( 'redirect_conditional_logic_display' ),
			[
				'label' => esc_html__( 'Display mode', "conditional-logic-for-elementor-forms" ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Redirect if', "conditional-logic-for-elementor-forms" ),
                        'icon' => 'fa fa-eye',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'Disable if', "conditional-logic-for-elementor-forms" ),
                        'icon' => 'fa fa-eye-slash',
                    ],
                ],
                'default' => 'show',
                'condition' => [
                    $control_id_conditional_logic => 'yes'
                ],
			]
		);
		$widget->add_control(
			$this->get_control_id( 'redirect_conditional_logic_trigger' ),
			[
				'label' => esc_html__( 'When to Trigger', "conditional-logic-for-elementor-forms" ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    "ALL"=>"ALL",
                    "ANY"=>"ANY"
                ],
                'default' => 'ALL',
                'condition' => [
                    $control_id_conditional_logic => 'yes'
                ],
			]
		);
		$widget->add_control(
			$this->get_control_id( 'redirect_conditional_logic_datas' ),
			[
				'name'           => 'redirect_conditional_logic_datas',
                'label'          => esc_html__( 'Fields if', "conditional-logic-for-elementor-forms" ),
                'type'           => 'conditional_logic_repeater',
                'fields'         => [
                    [
                        'name' => 'conditional_logic_id',
                        'label' => esc_html__( 'Field ID', "conditional-logic-for-elementor-forms" ),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default' => '',
                    ],
                     [
                        'name' => 'conditional_logic_operator',
                        'label' => esc_html__( 'Operator', "conditional-logic-for-elementor-forms" ),
                        'type' => Controls_Manager::SELECT,
                        'label_block' => true,
                        'options' => $options_logic,
                        'options_pro' => $options_pro,
                       'default' => '==',
                    ],
                    [
                        'name' => 'conditional_logic_value',
                        'label' => esc_html__( 'Value to compare', "conditional-logic-for-elementor-forms" ),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default' => '',
                    ],
                ],
                'condition' => [
                        $control_id_conditional_logic => 'yes'
                    ],
                'style_transfer' => false,
                'title_field'    => '{{{ conditional_logic_id  }}} {{{ conditional_logic_operator  }}} {{{ conditional_logic_value  }}}',
                'default'        => array(
                    array(
                        'conditional_logic_id' => '',
                        'conditional_logic_operator' => '==',
                        'conditional_logic_value' => '',
                    ),
                   ),
			]
		);
		$widget->add_control(
			$this->get_control_id( 'redirect_to' ),
			[
				'label' => esc_html__( 'Redirect To', 'elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'https://your-link.com', 'elementor-pro' ),
				'dynamic' => [
					'active' => true,
					'categories' => [
						TagsModule::POST_META_CATEGORY,
						TagsModule::TEXT_CATEGORY,
						TagsModule::URL_CATEGORY,
					],
				],
				'label_block' => true,
				'render_type' => 'none',
				'classes' => 'elementor-control-direction-ltr',
			]
		);

		$widget->end_controls_section();
	}

	public function on_export( $element ) {
		unset(
			$element['settings'][$this->get_control_id( 'redirect_to' )]
		);
		return $element;
	}

	public function run( $record, $ajax_handler ) {
		$settings = $record->get( 'form_settings' );
		$send_status = true;
		if( $settings[$this->get_control_id( 'redirect_conditional_logic' )] == "yes" ){
			$display = $settings[$this->get_control_id( 'redirect_conditional_logic_display' )];
            $trigger = $settings[$this->get_control_id( 'redirect_conditional_logic_trigger' )];
            $datas = $settings[$this->get_control_id( 'redirect_conditional_logic_datas' )];
            $rs = array();
            $form_fields = $record->get("fields");
            foreach ( $datas as $logic_key => $logic_values ) {
                if(isset($form_fields[$logic_values["conditional_logic_id"]])){
                    $value_id = $form_fields[$logic_values["conditional_logic_id"]]["value"];
                    if( is_array($value_id) ){
                        $value_id = implode(", ",$value_id);
                    }
                }else{
                   $value_id = $logic_values["conditional_logic_id"];
                }
                $operator = $logic_values["conditional_logic_operator"];
                $value = $logic_values["conditional_logic_value"];
                $rs[] = $this->elementor_conditional_logic_check_single($value_id,$operator,$value);
            }
            if( $trigger =="ALL"  ){
                $check_rs = true;
                foreach ( $rs as $fkey => $fvalue ) {
                    if( $fvalue == false ){
                        $check_rs =false;
                        break;
                    }
                }
          }else{
                $check_rs = false;
                foreach ( $rs as $fkey => $fvalue ) {
                    if( $fvalue == true ){
                        $check_rs =true;
                        break;
                    }
                }
          }
          if($display == "show"){
          		if( $check_rs == true ){
          			$send_status = true;
          		}else{
          			$send_status = false;
          		}
          }else{
          		if( $check_rs == true ){
          			$send_status = false;
          		}else{
          			$send_status = true;
          		}
          }
		}
		if( $send_status ==  true ){
			$redirect_to = $settings[$this->get_control_id( 'redirect_to' )];
			$redirect_to = $record->replace_setting_shortcodes( $redirect_to, true );
			if ( ! empty( $redirect_to ) && filter_var( $redirect_to, FILTER_VALIDATE_URL ) ) {
				$ajax_handler->add_response_data( 'redirect_url', $redirect_to );
			}
		}
		
	}
	function elementor_conditional_logic_check_single($value_id,$operator,$value){
        $rs = false;
        switch($operator) {
              case "==":
                    if( $value_id == $value){
                        $rs = true;
                    }   
                break;
              case "!=":
                    if( $value_id != $value){
                            $rs = true;
                    }
                    break;
              case "e":
                    if( $value_id == ""){
                            $rs = true;
                    }
                    break;
              case "!e":
                    if( $value_id != ""){
                            $rs = true;
                    }
                    break;
              case "c":
                    if( str_contains($value_id,$value) ){
                        $rs = true;
                    }
                    break;
               case "!c":
                    if( !str_contains($value_id,$value) ){
                        $rs = true;
                    }
                break;
               case "^":
                    if( str_starts_with($value_id,$value) ){
                        $rs = true;
                    }
                    break;
               case "~":
                    if( str_ends_with($value_id,$value) ){
                        $rs = true;
                    }
                    break;
               case ">":
                    if( $value_id > $value){
                        $rs = true;
                    }
                    break;
                case "<":
                    if( $value_id < $value){
                            $rs = true;
                    }
                    break;
                case "array":
                    $values= array_map('trim', explode(',', $value));
                    if( in_array($value_id,$values)){
                            $rs = true;
                    }
                    break;
                case "!array":
                    $values= array_map('trim', explode(',', $value));
                    if( !in_array($value_id,$values)){
                            $rs = true;
                    }
                    break;
                case "array_contain":
                    $values= array_map('trim', explode(',', $value));
                    foreach($values as $vl){
                        if( str_contains($value_id,$vl) ){
                            $rs = true;
                        }
                    }
                    break;
                case "!array_contain":
                    $values= array_map('trim', explode(',', $value));
                    $rs = true;
                    foreach($values as $vl){
                        if( str_contains($value_id,$vl) ){
                            $rs = false;
                           
                        }
                    }    
                    break;   
              default: 
                break;
            }
            return $rs;
    }
}