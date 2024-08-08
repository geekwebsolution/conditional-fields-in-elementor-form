(function( $ ) {
	'use strict';

	$( document ).ready( function () { 
        $("body").on("click",'.elementor-control-tag-area[data-setting="conditional_logic_id"]',function(e){
              $(this).after('<div class="elementor-control-dynamic-switcher elementor-control-unit-1 elementor-conditional-logic-add-tag" data-tooltip="add Tags" original-title=""><i class="eicon-database" aria-hidden="true"></i><span class="elementor-screen-only">Dynamic Tags</span></div>');
        }) 
        $("body").on("click",".elementor-conditional-logic-add-tag",function(e){
           var html ='<ul class="elementor-conditional-logic-sync">';
           var form = $(this).closest(".elementor-repeater-fields-wrapper").parents(".elementor-repeater-fields-wrapper");
           $(".elementor-form-field-shortcode",form).each(function() {
            const regex = /\".*?\"/gm;
            let m;
            var name = $(this).val();
            while ((m = regex.exec(name)) !== null) {
                if (m.index === regex.lastIndex) {
                    regex.lastIndex++;
                }
                m.forEach((match, groupIndex) => {
                    name = match.replaceAll('"',"");
                });
            }
             html +='<li title="Copy ID">'+name+'</li>'; 
           });
          html +='</ul>';
          $(this).closest(".elementor-control-input-wrapper").append(html);
        })
        
        $(document).mouseup(function(e) 
        {
            var container = $(".elementor-conditional-logic-sync");
            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0) 
            {
                container.hide();
            }
        });
        $("body").on("click",".elementor-conditional-logic-sync li",function(e){
           var vl = $(this).html();
           var field =$(this).closest(".elementor-control-input-wrapper").find(".elementor-control-tag-area"); 


           field.focus();
           navigator.clipboard.writeText(vl);
           $(this).html("Copied to Clipboard");
           setTimeout(function(){ 
          $(".elementor-conditional-logic-sync").remove();
          }, 500);
        })
    })

})( jQuery );
