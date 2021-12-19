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
            template: 'VBA_CompanyInvoiceDetail/company_detail',
            showError: ko.observable(false),
            showForm: 1
        },
        initialize: function () {
            this._super();
            this.companyLegalName = ko.observable(checkoutConfig.quoteData.extension_attributes.company_legal_name);
        },

        setCompanyLegalName: function (e) {
            var self = this;
            checkoutConfig.quoteData.extension_attributes.company_legal_name = $('#company_legal_name').val();
        },
    });
});
