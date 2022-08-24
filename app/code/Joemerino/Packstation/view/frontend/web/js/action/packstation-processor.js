define([
    'jquery',
    'Magento_Checkout/js/model/quote'
], function ($,quote) {
    'use strict';

    return function (paymentData) {

        if (paymentData['extension_attributes'] === undefined) {
            paymentData['extension_attributes'] = {};
        }
        console.log(paymentData);
        var packstationAddress = null;
        var shippingMethod =  quote.shippingMethod().method_code;
        var packstation_street_address_1 = null;
        var packstation_street_address_2 = null;
        var packstation_postcode = null;
        var packstation_city = null;
        if(shippingMethod == "packstation") {
            packstation_street_address_1 = jQuery('[name="packstation_shipping_field[packstation_street_address_1]"]').val();
            packstation_street_address_2 = jQuery('[name="packstation_shipping_field[packstation_street_address_2]"]').val();
            packstation_postcode = jQuery('[name="packstation_shipping_field[packstation_postcode]"]').val();
            packstation_city = jQuery('[name="packstation_shipping_field[packstation_city]"]').val();

            var packstationAddress = {
                packstation_street_address_1: packstation_street_address_1,
                packstation_street_address_2: packstation_street_address_2,
                packstation_postcode: packstation_postcode,
                packstation_city: packstation_city,
            }
        }
        paymentData['extension_attributes'] = packstationAddress;
    };
});