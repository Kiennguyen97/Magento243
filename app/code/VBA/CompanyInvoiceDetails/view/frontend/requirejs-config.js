var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/model/payment/method-group': {
                'Ccc_Checkout/js/model/payment/method-group-mixin': true
            },
            'Magento_Checkout/js/action/set-billing-address': {
                'Ccc_Checkout/js/action/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/action/set-shipping-information': {
                'Ccc_Checkout/js/action/set-shipping-information-mixin': true
            },
            'Magento_Checkout/js/action/create-shipping-address': {
                'Ccc_Checkout/js/action/create-shipping-address-mixin': true
            },
            'Magento_Checkout/js/action/place-order': {
                'Ccc_Checkout/js/action/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/action/create-billing-address': {
                'Ccc_Checkout/js/action/set-billing-address-mixin': true
            }
        }
    }
};
