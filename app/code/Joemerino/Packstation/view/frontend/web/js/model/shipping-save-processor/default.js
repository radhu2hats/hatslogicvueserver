define([
    'ko',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/resource-url-manager',
    'mage/storage',
    'Magento_Checkout/js/model/payment-service',
    'Magento_Checkout/js/model/payment/method-converter',
    'Magento_Checkout/js/model/error-processor',
    'Magento_Checkout/js/model/full-screen-loader',
    'Magento_Checkout/js/action/select-billing-address',
    'mage/utils/wrapper'
    ], function (
    ko,
    quote,
    resourceUrlManager,
    storage,
    paymentService,
    methodConverter,
    errorProcessor,
    fullScreenLoader,
    selectBillingAddressAction,
    wrapper
    ) {
    'use strict';
    
    return function (defaultJS) {
        defaultJS.saveShippingInformation = wrapper.wrapSuper(defaultJS.saveShippingInformation, function (hash) {
            //this._super(hash); 
            var payload;

                if (!quote.billingAddress()) {
                    selectBillingAddressAction(quote.shippingAddress());
                }
                
                var shippingMethod = quote.shippingMethod().method_code+'_'+quote.shippingMethod().carrier_code;

                var packstation_street_address_1 = null;
                var packstation_street_address_2 = null;
                var packstation_postcode = null;
                var packstation_city = null;

                if(shippingMethod == "packstation_packstation") {
                    packstation_street_address_1 = jQuery('[name="packstation_shipping_field[packstation_street_address_1]"]').val();
                    packstation_street_address_2 = jQuery('[name="packstation_shipping_field[packstation_street_address_2]"]').val();
                    packstation_postcode = jQuery('[name="packstation_shipping_field[packstation_postcode]"]').val();
                    packstation_city = jQuery('[name="packstation_shipping_field[packstation_city]"]').val();
                }
                payload = {
                    addressInformation: {
                        shipping_address: quote.shippingAddress(),
                        billing_address: quote.billingAddress(),
                        shipping_method_code: quote.shippingMethod().method_code,
                        shipping_carrier_code: quote.shippingMethod().carrier_code,
                        extension_attributes:{
                            packstation_street_address_1: packstation_street_address_1,
                            packstation_street_address_2: packstation_street_address_2,
                            packstation_postcode: packstation_postcode,
                            packstation_city: packstation_city,
                        }
                    }
                };

                fullScreenLoader.startLoader();

                return storage.post(
                    resourceUrlManager.getUrlForSetShippingInformation(quote),
                    JSON.stringify(payload)
                ).done(
                    function (response) {
                        quote.setTotals(response.totals);
                        paymentService.setPaymentMethods(methodConverter(response.payment_methods));
                        fullScreenLoader.stopLoader();
                    }
                ).fail(
                    function (response) {
                        errorProcessor.process(response);
                        fullScreenLoader.stopLoader();
                    }
                );
            
    
        });
    
        return defaultJS;
    };
});