/**
 * Webkul Software
 *
 * @category Webkul
 * @package Webkul_CheckoutCustomization
 * @author Webkul
 * @copyright Copyright (c)  Webkul Software Private Limited (https://webkul.com)
 * @license https://store.webkul.com/license.html
 */
 define(['jquery', 'underscore', 'mage/utils/wrapper'], function ($, _, wrapper) {
    'use strict';
    return function (payloadExtender) {
        return wrapper.wrap(payloadExtender, function (originalPayloadExtender, payload) {
            originalPayloadExtender(payload);
            var packstationAddress = null;
            var shippingMethod =  payload.addressInformation.shipping_method_code;
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
            
            _.extend(payload.addressInformation.extension_attributes,
                packstationAddress
            );
        });
    };
});