(function( $ ) {
	'use strict';

	$( document ).ready( function () {
    	jQuery( document ).on( 'elementor/popup/show', () => {
			$( ".elementor-form" ).each(function( index ) {
			  var form = $(this).closest(".elementor-widget-container");
			  elementor_conditional_logic_load(form);
			});
		} );
		window.addEventListener( 'elementor/frontend/init', () => {
			$( ".elementor-form" ).each(function( index ) {
			  var form = $(this).closest(".elementor-widget-container");
			  elementor_conditional_logic_load(form);
			});
		} );
		$("body").on("change",".elementor-form input,.elementor-form select,.elementor-form textarea",function(e){
    		var form = $(this).closest(".elementor-widget-container");
    		elementor_conditional_logic_load(form);
    	})
    	$("input").on("done_load_repeater",function(e,item){
    		$( ".elementor-form" ).each(function( index ) {
			  var form = $(this).closest(".elementor-widget-container");
			  elementor_conditional_logic_load(form);
			});
    	})
		function elementor_conditional_logic_check_single(value_id,operator,value){
			var rs = false;
			switch(operator) {
				  case "==":
				    	if( value_id == value){
				    		rs = true;
				    	}	
				    break;
				  case "!=":
					    if( value_id != value){
					    		rs = true;
					    }
					    break;
				  case "e":
					    if( value_id == ""){
					    		rs = true;
					    }
					    break;
				  case "!e":
					    if( value_id != ""){
					    		rs = true;
					    }
					    break;
				  case "c":
					    if( value_id.includes(value)){
					    		rs = true;
					    }
					    break;
				   case "!c":
					    if( !value_id.includes(value)){
					    		rs = true;
					    }
				    break;
				   case "^":
					    if( value_id.startsWith(value)){
					    		rs = true;
					    }
					    break;
				   case "~":
					    if( value_id.endsWith(value) ){
					    		rs = true;
					    }
					    break;
				   case ">":
					    if( value_id > value){
					    		rs = true;
					    }
					    break;
				    case "<":
					    if( value_id < value){
					    		rs = true;
					    }
					    break;   
				}
				return rs;
		}
    	function elementor_conditional_logic_load(form){
    		var datas = $(".conditional_logic_data_js",form).val();
    		datas = jQuery.parseJSON(datas);
			//console.log(datas);
    		$.each( datas, function( field_key, field_value ) {
			  var field = elementor_conditional_logic_get_element_by_id(field_key,form);
			  
			  var display = field_value.display;
			  var trigger = field_value.trigger;
			  var rs = [];
			  
			  $.each( field_value.datas, function( conditional_logic_key, conditional_logic_values ) { 
			  	 var value_id = elementor_conditional_logic_get_value_by_id(conditional_logic_values.conditional_logic_id,form);
			  	 rs.push( elementor_conditional_logic_check_single(value_id,conditional_logic_values.conditional_logic_operator,conditional_logic_values.conditional_logic_value));
			  })
			  //console.log(rs);
			 // console.log(field_key);
			  if( trigger =="ALL"  ){
			  		var check_rs = true;
		  			$.each( rs, function( fkey, fvalue ) {
		  				if( fvalue == false ){
		  					check_rs =false;
		  					return false; 
		  				}
		  			})
		  			if( display == "show" ) {
		  				if( check_rs == true ){
		  					field.removeClass("hidden");
		  					elementor_conditional_logic_fixed_required_show(field);
		  				}else{
		  					field.addClass("hidden");
		  					field.find('input').removeAttr('required');
		  					elementor_conditional_logic_fixed_required_hidden(field);
		  				}
		  			}else{
		  				if( check_rs == true ){
		  					field.addClass("hidden");
		  					field.find('input').removeAttr('required');
		  					elementor_conditional_logic_fixed_required_hidden(field);
		  				}else{
		  					field.removeClass("hidden");
		  					elementor_conditional_logic_fixed_required_show(field);
		  				}
		  			}
			  }else{
			  		var check_rs = false;
		  			$.each( rs, function( fkey, fvalue ) {
		  				if( fvalue == true ){
		  					check_rs =true;
		  					return false; 
		  				}
		  			})
		  			if( display == "show" ) {
		  				if( check_rs == true ){
		  					field.removeClass("hidden");
		  					elementor_conditional_logic_fixed_required_show(field);
		  				}else{
		  					field.addClass("hidden");
		  					field.find('input').removeAttr('required');
		  					elementor_conditional_logic_fixed_required_hidden(field);
		  				}
		  			}else{
		  				if( check_rs == true ){
		  					field.addClass("hidden");
		  					elementor_conditional_logic_fixed_required_hidden(field);
		  				}else{
		  					field.removeClass("hidden");
		  					elementor_conditional_logic_fixed_required_show(field);
		  				}
		  			}	
			  }
			});
    	}
      function elementor_conditional_logic_fixed_required_show(field){
      	if(field.find(".elementor-field-repeater-data").length > 0 ){
      		var fields_repeater = field.find(".elementor-field-required");
      		fields_repeater.each(function( index ) {
			  elementor_conditional_logic_fixed_required_show_repeater($(this))
			});
      		return;
      	}else{
      		elementor_conditional_logic_fixed_required_show_repeater(field)
      	}
      }
      function elementor_conditional_logic_fixed_required_show_repeater(field){
      	if( field.hasClass("elementor-field-type-radio") ){
      		var value = field.data("check_required");
      		if(value == "yes"){
				field.data("check_required","no");
				field.removeAttr("data-check_required");
      			field.find("input").last().prop("checked", false);
      		}
      	}
      	else if( field.hasClass("elementor-field-type-date") ){
      		var value = field.find("input").val();
      		if(value == "1023-01-01"){
      			field.find("input").val("");
      		}
      	}
      	else if( field.hasClass("elementor-field-type-time") ){
      		var value = field.find("input").val();
      		if(value == "11:47"){
      			field.find("input").val("");
      		}
      	}
      	else if( field.hasClass("elementor-field-type-tel") ){
      		var value = field.find("input").val();
      		if(value == "1234567892"){
      			field.find("input").val("");
      		}
      	}
      	else if( field.hasClass("elementor-field-type-url") ){
      		var value = field.find("input").val();
      		if(value == "https://rednumber_dev_check.com"){
      			field.find("input").val("");
      		}
      	}
      	else if( field.hasClass("elementor-field-type-email") ){
      		var value = field.find("input").val();
      		if(value == "rednumber_dev_check@test.com"){
      			field.find("input").val("");
      		}
      	}
      	else if( field.hasClass("elementor-field-type-number") ){
      		var value = field.find("input").val();
      		if(value == "29081990"){
      			field.find("input").val("");
      		}
      	}else if( field.hasClass("elementor-field-type-select") ){
			var value = field.find("select").data("check_required");
			if(value == "yes"){
				field.find("select").data("check_required","no");
				field.find("select").removeAttr("data-check_required");
				field.find("select option:last").removeAttr("selected");
			}
		}
      	else if( field.hasClass("elementor-field-type-textarea") ){
      		var value = field.find("textarea").val();
      		if(value == "rednumber_dev_check"){
      			field.find("textarea").val("");
      		}
      	}else{
      		var value = field.find("input").val();
      		if(value == "rednumber_dev_check"){
      			field.find("input").val("");
      		}
      	}
      }
      function elementor_conditional_logic_fixed_required_hidden(field){
      	if(field.find(".elementor-field-repeater-data").length > 0 ){
      		var fields_repeater = field.find(".elementor-field-required");
      		fields_repeater.each(function( index ) {
			  elementor_conditional_logic_fixed_required_hidden_repeater($(this))
			});
      		return;
      	}else{
      		elementor_conditional_logic_fixed_required_hidden_repeater(field)
      	}
      }
      function elementor_conditional_logic_fixed_required_hidden_repeater(field){
		field.find("input").attr("aria-required");
		field.find("input").removeAttr("required");
		field.find("select").removeAttr("required");
		field.find("textarea").removeAttr("required");
      	if( field.hasClass("elementor-field-type-radio") ){
      		var value = field.find("input:checked").val();
      		if(value === undefined){
      			field.attr("data-check_required","yes");
      			field.find("input").last().prop("checked", true);
      			field.find("input").last().attr("data-logic-last", true);
      		}
      	}
      	else if( field.hasClass("elementor-field-type-upload") ){
			if(field.hasClass("elementor-field-required") ){
				alert("Conditional logic: Please do not use required in the upload field");
			}
			field.find("input").removeAttr("aria-required");
      	}
      	else if( field.hasClass("elementor-field-type-html1") ){
      	}
      	else if( field.hasClass("elementor-field-type-date") ){
      		var value = field.find("input").val();
      		field.find("input").removeAttr("aria-required");
      		if(value == ""){
      			field.find("input").val("1023-01-01");
      		}
      	}
      	else if( field.hasClass("elementor-field-type-time") ){
      		var value = field.find("input").val();
      		field.find("input").removeAttr("aria-required");
      		if(value == ""){
      			field.find("input").val("11:47");
      		}
      	}
      	else if( field.hasClass("elementor-field-type-tel") ){
      		var value = field.find("input").val();
      		field.find("input").removeAttr("aria-required");
      		if(value == ""){
      			field.find("input").val("1234567892");
      		}
      	}
      	else if( field.hasClass("elementor-field-type-url") ){
      		var value = field.find("input").val();
      		field.find("input").removeAttr("aria-required");
      		if(value == ""){
      			field.find("input").val("https://rednumber_dev_check.com");
      		}
      	}
      	else if( field.hasClass("elementor-field-type-email") ){
      		var value = field.find("input").val();
      		field.find("input").removeAttr("aria-required");
      		if(value == ""){
      			field.find("input").val("rednumber_dev_check@test.com");
      		}
      	}
      	else if( field.hasClass("elementor-field-type-number") ){
      		var value = field.find("input").val();
      		field.find("input").removeAttr("aria-required");
      		field.find("input").removeAttr("min").removeAttr("max").removeAttr("aria-required");
      		if(value == ""){
      			field.find("input").val("29081990");
      		}
      	}
      	else if( field.hasClass("elementor-field-type-textarea") ){
      		var value = field.find("textarea").val();
      		field.find("textarea").removeAttr("aria-required");
      		if(value == ""){
      			field.find("textarea").val("rednumber_dev_check");
      		}
      	}else if( field.hasClass("elementor-field-type-select") ){
			var value = field.find("select").val();
			field.find("select").removeAttr("aria-required");
			if(value == ""){
				field.find("select").attr("data-check_required","yes");
				var myVal = field.find("select option:last").val();
				field.find("select").val(myVal);
			}
		}else if( field.hasClass("elementor-field-type-acceptance") ){
			if(field.find("input").is(':checked')) {
			}else{
				field.find("input").removeAttr("aria-required");
				field.find("input").attr("data-logic-last",true);
				field.find("input").prop("checked", true);
			}
		}
		else{
      		var value = field.find("input").val();
      		field.find("input").removeAttr("aria-required");
      		if(value == ""){
      			field.find("input").val("rednumber_dev_check");
      		}
      	}
      }
      function elementor_conditional_logic_get_value_by_id(id = "",form = "body"){
      	var rs = "";
		
      	if( $(".elementor-field-group-"+id,form).hasClass("elementor-field-type-radio") ){
      		rs= $(".elementor-field-group-"+id +" input:checked",form).val();
      	}
      	else if( $(".elementor-field-group-"+id,form).hasClass("elementor-field-type-checkbox") ){
      		var data = [];
      		$(".elementor-field-group-"+id +" input:checked",form).each(function(){
      			data.push($(this).val());
      		})
      		rs= data.join(", ");
      	}
      	else if( $(".elementor-field-group-"+id,form).hasClass("elementor-field-type-select") ){
      		rs= $(".elementor-field-group-"+id +" select",form).val();
      	}else if( $(".elementor-field-group-"+id,form).hasClass("elementor-field-type-textarea") ){
      		rs= $(".elementor-field-group-"+id +" textarea",form).val();
      	}
      	else{
      		rs= $(".elementor-field-group-"+id +" input",form).val();
      	}
      	if( rs === undefined){
      		return id;
      	}else{
      		return rs;
      	}
      }
      function elementor_conditional_logic_get_element_by_id(id = "",form=""){
      	if($('[data-id-repeater="form-field-'+id+'"]',form).length > 0) {
      		if( $('[data-id-repeater="form-field-'+id+'"]',form).length > 0 ){
	      		return $('[data-id-repeater="form-field-'+id+'"]',form).closest(".elementor-field-group");
	      	}else{
	      		return $('[data-id-repeater="form-field-'+id+'-0"]',form).closest(".elementor-field-group");
	      	}
      	}else{
      		if( $("#form-field-"+id,form).length > 0 ){
	      		return $("#form-field-"+id,form).closest(".elementor-field-group");
	      	}else{
	      		return $("#form-field-"+id+"-0",form).closest(".elementor-field-group");
	      	}
      	}
      }    
    })

})( jQuery );