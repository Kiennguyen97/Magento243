define([
    'jquery',
    'ko',
    'uiComponent',
    'mage/url',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/view/billing-address'
], function ($, ko, Component, urlBuilder, quote, billing) {
    'use strict';
    return Component.extend({
        defaults: {
            template: 'VBA_CompanyInvoiceDetail/company_detail',
            showError: ko.observable(false),
            showForm: ko.observable(true)
        },

        initialize: function () {
            this._super().observe({
                isAddressSameAsShipping: true,
            });


            // this.company = ko.observable(checkoutConfig.quoteData.extension_attributes.company);
            this.companyLegalName = ko.observable(checkoutConfig.quoteData.extension_attributes.company_legal_name);
            this.companyAddress = ko.observable(checkoutConfig.quoteData.extension_attributes.company_address);
            this.vatTax = ko.observable(checkoutConfig.quoteData.extension_attributes.vat_tax);
            this.companyRepresentative = ko.observable(checkoutConfig.quoteData.extension_attributes.company_representative);
            this.companyEmail = ko.observable(checkoutConfig.quoteData.extension_attributes.company_email);
            this.recheckAddressSameAsShipping();
        },

        recheckAddressSameAsShipping : function (e) {
            $(document).ready(function (){
                var check = 0

                $(document).on('change', 'input[name="billing-address-same-as-shipping"]', function () {
                    var fieldSet = $('.fieldset.company-invoice-detail-fieldset');

                    if(this.checked) {
                        fieldSet.show();
                    }else {
                        fieldSet.hide();
                    }
                })
            });
        },

        // setCompany: function (e) {
        //     var self = this;
        //     checkoutConfig.quoteData.extension_attributes.company = $('#company').val();
        // },
        setCompanyLegalName: function (e) {
            var self = this;
            checkoutConfig.quoteData.extension_attributes.company_legal_name = $('#company_legal_name').val();
        },

        setCompanyAddress: function (e) {
            var self = this;
            checkoutConfig.quoteData.extension_attributes.company_address = $('#company_address').val();
        },

        setVatTax: function (e) {
            var self = this;
            checkoutConfig.quoteData.extension_attributes.vat_tax = $('#vat_tax').val();
        },

        setCompanyRepresentative: function (e) {
            var self = this;
            checkoutConfig.quoteData.extension_attributes.company_representative = $('#company_representative').val();
        },

        setCompanyEmail: function (e) {
            var self = this;
            checkoutConfig.quoteData.extension_attributes.company_email = $('#company_email').val();
        },
    });
});
