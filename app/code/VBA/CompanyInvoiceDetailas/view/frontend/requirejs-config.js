var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-billing-address': {
                'VBA_CompanyInvoiceDetails/js/action/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/action/set-shipping-information': {
                'VBA_CompanyInvoiceDetails/js/action/set-shipping-information-mixin': true
            },
            'Magento_Checkout/js/action/create-shipping-address': {
                'VBA_CompanyInvoiceDetails/js/action/create-shipping-address-mixin': true
            },
            'Magento_Checkout/js/action/place-order': {
                'VBA_CompanyInvoiceDetails/js/action/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/action/create-billing-address': {
                'VBA_CompanyInvoiceDetails/js/action/set-billing-address-mixin': true
            }
        }
    }
};
