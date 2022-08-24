    // define([
    //     'uiComponent'
   
    // ], function (Component) {
    //     'use strict';
   
    //     return Component.extend({
    //         defaults: {
    //             template: 'Joemerino_Packstation/checkout/shipping/additional-fields'
    //         }    
    //     });
    // });
define([
    'uiComponent',
    'ko',
    'Magento_Checkout/js/model/quote',
    'jquery',
    'mage/mage'

], function (Component, ko, quote,$) {
    'use strict';
    
    return Component.extend({
        defaults: {
            template: 'Joemerino_Packstation/checkout/shipping/additional-fields'
        },
        initialize: function () {
            this._super();
            
            
            return this;
        },
        initObservable: function () {
            var self = this._super();

            this.showPackingstationform = ko.computed(function() {
                var method = quote.shippingMethod();
                
                if(method && method['carrier_code'] !== undefined) {
                    
                    if(method['carrier_code'] === 'packstation') {
                        return true;
                    }
                }
                
                return false;

            }, this);


            return this;
        }
    });
});