(function($) {
    "use strict";
    window.addEventListener('elementor/init', function () {
      var RepeaterControlItemView = elementor.modules.controls.Repeater.extend({
        className: function className() {
          return elementor.modules.controls.Repeater.prototype.className.apply(this, arguments) + ' elementor-control-type-repeater';
        },
        onButtonAddRowClick: function onButtonAddRowClick(event) {
          var count_item = $(".elementor-repeater-fields",this.el).length;
          if(count_item < 2 || elementor_pro_conditional_logic_editor.pro == "ok"){
            elementor.modules.controls.Repeater.prototype.onButtonAddRowClick.apply(this, arguments);
          }else{
            alert("Please Upgrade to pro version");
          }
          event.stopPropagation();
        }
      });
      elementor.addControlView('cfief_conditional_logic_repeater', RepeaterControlItemView);
    });
})(jQuery);