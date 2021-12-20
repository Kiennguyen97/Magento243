var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/model/shipping-save-processor/payload-extender': {
                'Gssi_ShippingHandling/js/shipping-save-processor/payload-extender-mixin': true
            },
            'Magento_Checkout/js/view/shipping': {
                'Gssi_ShippingHandling/js/view/shipping-mixin': true
            }
        }
    }
};
