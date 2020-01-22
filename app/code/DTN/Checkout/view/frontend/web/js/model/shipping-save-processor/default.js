// define([
//     'jquery',
//     'mage/utils/wrapper',
//     'Magento_Checkout/js/model/quote'
// ], function ($, wrapper, quote) {
//     'use strict';

//     return function (setShippingInformationAction) {
//         return wrapper.wrap(setShippingInformationAction, function (originalAction) {
//             var shippingAddress = quote.shippingAddress();
//             if (shippingAddress['extension_attributes'] === undefined) {
//                 shippingAddress['extension_attributes'] = {};
//             }
//             shippingAddress['extension_attributes']['special_request'] = jQuery('[name="special_request"]').val();
//             return originalAction();
//         });
//     };
// });
define(
    [
        'jquery',
        'ko',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/resource-url-manager',
        'mage/storage',
        'Magento_Checkout/js/model/payment-service',
        'Magento_Checkout/js/model/payment/method-converter',
        'Magento_Checkout/js/model/error-processor',
        'Magento_Checkout/js/model/full-screen-loader',
        'Magento_Checkout/js/action/select-billing-address'
    ],
    function (
        $,
        ko,
        quote,
        resourceUrlManager,
        storage,
        paymentService,
        methodConverter,
        errorProcessor,
        fullScreenLoader,
        selectBillingAddressAction
    ) 
    {
        'use strict';

        return {
            saveShippingInformation: function () {
                var payload;
                if (!quote.billingAddress()) {
                    selectBillingAddressAction(quote.shippingAddress());
                }
				
				var special = $('[name="custom_attributes[special_request]"]').val();

                payload = {
                    addressInformation: {
                        shipping_address: quote.shippingAddress(),
                        billing_address: quote.billingAddress(),
                        shipping_method_code: quote.shippingMethod().method_code,
                        shipping_carrier_code: quote.shippingMethod().carrier_code,
                        extension_attributes:{
                            special_request: special	
                    
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
            }
        };
    }
);
 

