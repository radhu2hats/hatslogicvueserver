define(
    [
        'jquery',
        'Magento_Checkout/js/model/quote',
        'mage/validation',
    ],
    function ($,quote) {
        'use strict';

        return {

            /**
             * Validate checkout agreements
             *
             * @returns {Boolean}
             */
            validate: function () {
                var valid = true;
                var isPackstation = false;
                var packstation_street_address_1 = jQuery('[name="packstation_shipping_field[packstation_street_address_1]"]').val();
                var packstation_street_address_2 = jQuery('[name="packstation_shipping_field[packstation_street_address_2]"]').val();
                var packstation_postcode = jQuery('[name="packstation_shipping_field[packstation_postcode]"]').val();
                var  packstation_city = jQuery('[name="packstation_shipping_field[packstation_city]"]').val();
                var method = quote.shippingMethod();
                console.log(method);
                if(method && method['carrier_code'] !== undefined) {
                    
                    if(method['carrier_code'] !== 'packstation') {
                        return true;
                    }

                    if(method['carrier_code'] === 'packstation') {
                        isPackstation = true;
                    }

                }
                
                if( packstation_street_address_1 == '' || packstation_street_address_2 == '' || packstation_city == '' || packstation_postcode == ''){ //should use Regular expression in real store.
                    valid = false;
                    $('html, body').animate({
                        scrollTop: $('#packstation-wrapper').offset().top
                    }, 500);
                }
                
                

                $('#packstation-wrapper').find('input').each(function(index, elem) {
                    var elemId = $(elem).attr('id'); 
                    
                    if(!isPackstation){
                        return valid;
                    }

                    if($(elem).val() == ''){
                        $("#error-"+elemId).show(); 
                    }else{
                        $("#error-"+elemId).hide();
                    }
                });
                console.log(valid);
                return valid;
            }
        };
    }
);
