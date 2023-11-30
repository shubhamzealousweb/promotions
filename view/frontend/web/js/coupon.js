define([
    "jquery",
    'Magento_Ui/js/modal/alert',
    "jquery/ui",
], function (jQuery, alert) {
    'use strict';

    return function (config, element) {
        if (config.is_popup) {
        	require(['jquery', 'Magento_Ui/js/modal/modal'],function(jQuery, modal) {
			    var options = {
			        type: 'popup',
			        responsive: true,
			        innerScroll: true,
			        title: 'Coupon Codes',
			        buttons: [{
			            text: 'Cancel',
			            class: '',
			            click: function () {
			                this.closeModal();
			            }
			        }]
			    };

			    var popup = modal(options, jQuery('.apply-coupon-code-grid-table'));
			    jQuery(".view-apply-coupon-grid").on('click',function(){
			        jQuery(".apply-coupon-code-grid-table").modal("openModal");
			    });
		    });
        } else {
        	jQuery(".view-apply-coupon-grid").click(function() {
				if (jQuery('.apply-coupon-code-grid-table').is(':visible')) {
					jQuery('.apply-coupon-code-grid-table').hide();
				} else {
					jQuery('.apply-coupon-code-grid-table').show();
				}
			});
        }
    }
});