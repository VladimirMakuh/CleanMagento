/*global define,alert*/
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
    ) {
        'use strict';

        return {
            getDeliveryData: function () {
            return {
                "DeliveryType" : this.getTypeDelivery(),
                "DeliveryCheckpoint" : this.getDeliveryInformation(),
                "Price" : this.getPriceNovaPoshta(),
            };

            },
            getTypeDelivery: function () {
               return document.querySelector('input[name=deliverytype]:checked').value;
            },
            getPriceNovaPoshta: function () {
                let price = jQuery("#label_carrier_novaposhta_novaposhta").closest("tr.row")
                    .find("span.price > span.price").text();
                let strprice = price.replace('$','');
                let floatPrice = parseFloat(strprice).toFixed(2);
                return floatPrice;
            },
            getDeliveryInformation: function () {
                const typeDelivery = this.getTypeDelivery();
                let data = [];

                //get selected city
                let selectedCity = $("#delivery-city option:selected").text();
               // data.push( $("#delivery-city option:selected").text());
                switch (typeDelivery){
                    case 'department' :
                        data = {
                            "City" : selectedCity,
                            "Department" : $("#delivery-departmant option:selected").text()
                        };
                        break;
                    case 'postbox' :
                        data = {
                            "City" : selectedCity,
                            "PostBox" : $("#delivery-post-box option:selected").text()
                        };
                        break;
                    case 'courier' :
                        data = {
                            "City" : selectedCity,
                            "Courier" : {
                                "Street" : $("#delivery-courier-street option:selected").text(),
                                "House" : $("#delivery-courier-house option:selected").text(),
                                "Flat" : $("#delivery-courier-flat option:selected").text()
                            }
                        };
                        break;
                }
                return data;
            },

            saveShippingInformation: function () {
                var payload;
                if (!quote.billingAddress()) {
                    selectBillingAddressAction(quote.shippingAddress());
                }

                payload = {
                    addressInformation: {
                        shipping_address: quote.shippingAddress(),
                        billing_address: quote.billingAddress(),
                        shipping_method_code: quote.shippingMethod().method_code,
                        shipping_carrier_code: quote.shippingMethod().carrier_code,
                        extension_attributes:{
                            delivery_novaposhta: JSON.stringify(this.getDeliveryData()),
                        },
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
