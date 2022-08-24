define([
    'jquery',
    'mage/utils/wrapper',
    'Joemerino_Packstation/js/action/packstation-processor'
], function ($, wrapper, shippingCommentProcessor) {
    'use strict';

    return function (placeOrderAction) {

        return wrapper.wrap(placeOrderAction, function (originalAction, paymentData, messageContainer) {
            shippingCommentProcessor(paymentData);

            return originalAction(paymentData, messageContainer);
        });
    };
});