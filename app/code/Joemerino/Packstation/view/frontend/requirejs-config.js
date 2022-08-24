var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/view/shipping': {
                'Joemerino_Packstation/js/view/shipping': true
            },
            'Magento_Checkout/js/action/place-order': {
                'Joemerino_Packstation/js/action/place-order-mixin': true
            }
        }
    }
};

