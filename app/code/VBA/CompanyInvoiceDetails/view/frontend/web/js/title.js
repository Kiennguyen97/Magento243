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
            template: 'VBA_CompanyInvoiceDetails/title'
        },
        initialize: function () {
            this._super();
        },
    });
});
