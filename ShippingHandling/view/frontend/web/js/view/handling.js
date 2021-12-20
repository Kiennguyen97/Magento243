define([
    'jquery',
    'ko',
    'uiComponent',
    'mage/url',
    'Magento_Checkout/js/model/quote'
], function ($, ko, Component, urlBuilder, quote) {
    'use strict';
    return Component.extend({
        defaults: {
            template: 'Gssi_ShippingHandling/handling-temp',
            showError: ko.observable(false),
            showForm: window.checkoutConfig.storeCode === 'usa_bezdan_storeview'
        },
        initialize: function () {
            this._super();

            this.handlingValue = ko.observable(checkoutConfig.quoteData.extension_attributes.shipping_handling);
        },

        initObservable: function () {

            this._super()
                .observe({
                    wantsShowHandling: ko.observable(false)
                });

            this.wantsShowHandling.subscribe(function (newValue) {
                if(newValue){
                    document.getElementById('shipping_handling_filed').type = 'text';
                }else{
                    document.getElementById('shipping_handling_filed').type = 'password';
                }
            });

            return this;
        },

        setHandlingValue: function (e) {
            var self = this;
            checkoutConfig.quoteData.extension_attributes.shipping_handling = $('#shipping_handling_filed').val();
        },

        getHandlingUrl: function () {
            if (checkoutConfig.handling.handlingUrl !== 'undefined') {
                return checkoutConfig.handling.handlingUrl;
            }
            return '#';
        },

    });
});
