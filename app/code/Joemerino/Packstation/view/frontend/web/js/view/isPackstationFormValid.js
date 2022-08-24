define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/additional-validators',
        'Joemerino_Packstation/js/model/isPackstationFormValid'
    ],
    function (Component, additionalValidators, packStationValidation) {
        'use strict';
        additionalValidators.registerValidator(packStationValidation);
        return Component.extend({});
    }
);