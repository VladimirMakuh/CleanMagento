define([
    'Magento_Ui/js/form/form',
    'ko',
    'jquery',
    'Magento_Checkout/js/model/quote',
    'Magento_Tax/js/view/checkout/shipping_method/price',
    'mage/url',
    'Magento_Checkout/js/model/shipping-rate-registry'
], function (Component, ko, $, quote, price,url, rateRegistry) {
    'use strict';

    return Component.extend({
        initObservable: function () {
            this.showNovaposhta = ko.computed(function () {
                let method = quote.shippingMethod();
                if(method !== undefined && method !== null){
                    if(method['carrier_code'] === 'novaposhta'){
                        return true;
                    }
                }
                return false;
            }, this);

            return this;
        },

        initialize: function () {
            this._super();
            // Variable
            this.data = ko.observableArray();
            this.dataDepartment = ko.observableArray();
            this.dataPostBox = ko.observableArray();
            this.dataStreet = ko.observableArray();

            //novaposhta store settings
            this.enable = ko.observable();
            this.apiKey = ko.observable();
            this.enableCustomPrice = ko.observable();
            this.priceDepartment = ko.observable();
            this.pricePostBox = ko.observable();
            this.priceCourier = ko.observable();


            this.selectedCity = ko.observable();
            this.selectedTypeDelivery = 0;

            this.deliveryType = ko.observable("department");

            //Visible variable
            this.getCities();
            this.getNovaPoshtaData();
            //hide options of type of delivery
            this.showCourier = ko.observable(false);
            this.showpostbox = ko.observable(false);

            return this;
        },

        getNovaPoshtaData: function () {
            const data = window.checkoutConfig.novaposhta;
            this.enable = data.enable;
            this.apiKey = data.api_key;
            if (data.enableCustomPrice)
            {
                this.priceDepartment = data.departmentPrice;
                this.pricePostBox = data.postBoxPrice;
                this.priceCourier = data.courierPrice;
            }
            else
            {
                this.priceDepartment = 50;
                this.pricePostBox = 50;
                this.priceCourier = 85;
            }
        },
        /**
         *
         * Make request to NovaPoshta Api
         * @param model
         * @param method
         * @param properties
         * @constructor
         */
        MakeRequest: function(model,method, properties = null) {
            const self = this;

            const errorMessage = $("#delivery-error-message-department");
            const errorMessagePostBox = $("#delivery-error-message-postbox");
            $.ajax({
                url: 'https://api.novaposhta.ua/v2.0/json/',
                dataType: 'json',
                type: 'POST',
                data: JSON.stringify({
                    'modelName': model,
                    'calledMethod': method,
                    'apiKey': this.apiKey,
                    'methodProperties': properties
                }),
                showLoader: false
            }).done(function(data) {
                switch (method)
                {
                    case "getCities" :
                        self.data(data.data);
                        break;

                    case "getWarehouses" :
                        self.dataDepartment.removeAll();
                        self.dataPostBox.removeAll();

                        if(data.data.length ===0)
                        {
                            errorMessagePostBox.show();
                            errorMessage.show();
                            break;
                        }
                        //
                        for (const department in data.data) {
                            if(data.data[department].CategoryOfWarehouse === "Postomat") {
                                self.dataPostBox.push(data.data[department]);
                            }
                            else {
                                self.dataDepartment.push(data.data[department]);
                            }
                        }
                        // Show error message
                        if(self.dataDepartment().length > 0)
                        {
                            errorMessage.hide();
                            if(self.dataPostBox().length > 0) {
                                errorMessagePostBox.hide();
                            }
                            else{
                                errorMessagePostBox.show();
                            }
                        }
                        else{
                            errorMessage.show();
                        }
                        break;

                    case "getStreet" :
                        if(data.data.length !== 0)
                        {
                            self.dataStreet(data.data);
                            break;
                        }
                        self.dataStreet(null);
                        break;
                }})
        },
        getCities:function (){
            return  this.MakeRequest('Address','getCities');
        },
        getDepartments: function (obj, event){
            this.selectedCity = event.target.value;
            this.getWarehouses();
            this.getStreet();
        },
        getWarehouses: function (){
            let property = {'CityRef': this.selectedCity};
            return this.MakeRequest('Address', 'getWarehouses', property);
        },
        getStreet: function () {

            let property = {'CityRef': this.selectedCity};
            return this.MakeRequest('Address', 'getStreet', property);
        },
        selectTypeDelivery: function (obj, event){
            switch (event.target.value) {
                case 'postbox' :
                    $("#postbox").prop('checked', true);
                    $(".delivery-novaposhta-department").hide();
                    $("#list-courier").hide();
                    $(".delivery-novaposhta-postbox").show();
                    this.setNovaPoshtaPrice(this.priceDepartment);
                    break;
                case 'courier' :
                    $("#courier").prop('checked', true);
                    $(".delivery-novaposhta-postbox").hide();
                    $(".delivery-novaposhta-department").hide();
                    $("#list-courier").show();
                    this.setNovaPoshtaPrice(this.priceCourier);
                    break;
                case 'department' :
                    $("#department").prop('checked', true);
                    $(".delivery-novaposhta-postbox").hide();
                    $("#list-courier").hide();
                    $(".delivery-novaposhta-department").show();
                    this.setNovaPoshtaPrice(this.priceDepartment);
                    break;
            }
        },

        /**
         * Set new text price on storefront novaposhta
         * @param price
         */
        setNovaPoshtaPrice: function (price) {
            jQuery("#label_carrier_novaposhta_novaposhta").closest("tr.row")
                .find("span.price > span.price")
                .text("$" + parseInt(price).toFixed(2).toString())
        },
        /**
         * Form submit handler
         *
         * This method can have any name.
         */
        onSubmit: function () {
            // trigger form validation
            this.source.set('params.invalid', false);
            this.source.trigger('ShippingDeliveryProvider.data.validate');

            // verify that form data is valid
            if (!this.source.get('params.invalid')) {
                // data is retrieved from data provider by value of the customScope property
                const formData = this.source.get('ShippingDeliveryProvider');
                // do something with form data
                console.dir(formData);
            }
        }
    });
});
