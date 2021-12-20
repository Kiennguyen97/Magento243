define([
    'underscore',
    'jquery',
    'uiRegistry',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function (_, $, registry, wrapper, quote) {
    'use strict';

    return function (payloadExtender) {
        return wrapper.wrap(payloadExtender, function (original, payload) {
            var payloadOriginal = original(payload),
                payloadWithShippingHandling = payloadOriginal;

                if (window.checkoutConfig.quoteData.extension_attributes.shipping_handling !== 'undefined' && window.checkoutConfig.storeCode === 'usa_bezdan_storeview') {
                    var handlingData = {
                        shipping_handling: window.checkoutConfig.quoteData.extension_attributes.shipping_handling
                    };
                    if (_.isUndefined(payloadWithShippingHandling.addressInformation.extension_attributes)) {
                        payloadWithShippingHandling.addressInformation.extension_attributes = {};
                    }

                    if (handlingData) {
                        _.extend(payloadWithShippingHandling.addressInformation.extension_attributes, handlingData);
                    }
                }

            return payloadWithShippingHandling;
        });
    };
});
