
define([
    'jquery',
    'Magento_Checkout/js/model/quote',
    'Magento_Ui/js/modal/alert',
    'uiRegistry'
], function ($, quote, Alert, registry) {
    'use strict';

    return function (target) {
        return target.extend({

            /**
             * Set shipping information handler
             */
            setShippingInformation: function () {
                if (this.validateShippingInformation() && $("#shipping_handling_filed").val() === '' && window.checkoutConfig.storeCode === 'usa_bezdan_storeview') {
                    var input = document.getElementById('shipping_handling_filed');
                    input.focus();
                    input.select();
                    registry.get('index=shipping-handling').showError(true);
                    return false;
                } else {
                    registry.get('index=shipping-handling').showError(false);
                }
                this._super();
            }
        });
    }
});
