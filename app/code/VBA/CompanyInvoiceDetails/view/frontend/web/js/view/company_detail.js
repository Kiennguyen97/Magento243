define([
    'jquery',
    'ko',
    'uiComponent',
    'mage/url',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/view/billing-address',
    'Magento_Customer/js/model/address-list'
], function ($, ko, Component, urlBuilder, quote, billing, addressList) {
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

            var addressOptions = addressList().filter(function (address) {
                    return address.getType() === 'customer-address';
                });
            $(document).ready(function (){
                var check = 0;
                var checkedInput = '.payment-group .payment-method._active input[name="billing-address-same-as-shipping"]:checked'

                var interval = setInterval(function (){
                    if ($(document).find('input[name="billing-address-same-as-shipping"]').length > 0){
                        var fieldSet = $('.fieldset.company-invoice-detail-fieldset');
                        if ($(checkedInput).length > 0) {
                            fieldSet.show();
                        }else if(addressOptions.length < 2 && $('.action.action-edit-address').length < 1) {
                            fieldSet.hide();
                        }else {
                            fieldSet.show();
                        }
                        clearInterval(interval);
                    }
                },1000);

                $(document).on('click', '.payment-group .payment-method .payment-method-title', function () {
                    var fieldSet = $('.fieldset.company-invoice-detail-fieldset');
                    if ($(checkedInput).length > 0) {
                        fieldSet.show();
                    }else if(addressOptions.length < 2 && $('.action.action-edit-address').length < 1) {
                        fieldSet.hide();
                    }else {
                        fieldSet.show();
                    }
                })

                $(document).on('change', 'input[name="billing-address-same-as-shipping"]', function () {
                    var fieldSet = $('.fieldset.company-invoice-detail-fieldset');
                    if(this.checked) {
                        fieldSet.show();
                    }else if(addressOptions.length < 2 && $('.action.action-edit-address').length < 1) {
                        fieldSet.hide();
                    }else {
                        fieldSet.show();
                    }
                })
            });
        },

        setCompany: function (e) {
            var self = this;
            var value = $('#company').val();
            $('input[name="company"]').val(value);
            $('input[name="company"]').trigger('change');
        },

        setCompanyLegalName: function (e) {
            var self = this;
            var value = $('#company_legal_name').val();
            $('input[name="custom_attributes[company_legal_name]"]').val(value);
            $('input[name="custom_attributes[company_legal_name]"]').trigger('change');
            checkoutConfig.quoteData.extension_attributes.company_legal_name = value;
        },

        setCompanyAddress: function (e) {
            var self = this;
            var value = $('#company_address').val();
            $('input[name="custom_attributes[company_address]"]').val(value);
            $('input[name="custom_attributes[company_address]"]').trigger('change');
            checkoutConfig.quoteData.extension_attributes.company_address = value;
        },

        setVatTax: function (e) {
            var self = this;
            var value = $('#vat_tax').val();
            $('input[name="custom_attributes[vat_tax]"]').val(value);
            $('input[name="custom_attributes[vat_tax]"]').trigger('change');
            checkoutConfig.quoteData.extension_attributes.vat_tax = value;
        },

        setCompanyRepresentative: function (e) {
            var self = this;
            var value = $('#company_representative').val();
            $('input[name="custom_attributes[company_representative]"]').val(value);
            $('input[name="custom_attributes[company_representative]"]').trigger('change');
            checkoutConfig.quoteData.extension_attributes.company_representative = value;
        },

        setCompanyEmail: function (e) {
            var self = this;
            var value = $('#company_email').val();
            $('input[name="custom_attributes[company_email]"]').val(value);
            $('input[name="custom_attributes[company_email]"]').trigger('change');
            checkoutConfig.quoteData.extension_attributes.company_email = value;
        },
    });
});
