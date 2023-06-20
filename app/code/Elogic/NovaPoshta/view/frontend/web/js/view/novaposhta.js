define([
    'Magento_Ui/js/form/form',
    'ko',
    'jquery',
    'Magento_Checkout/js/model/quote',
    'mage/url',
    'Magento_Checkout/js/model/shipping-rate-registry'
], function (Component, ko, $, quote,url, rateRegistry) {
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
            this.dataCity = ko.observableArray();
            this.dataDepartment = ko.observableArray();
            this.dataPostBox = ko.observableArray();
            this.dataStreet = ko.observableArray();
            this.dataResponse = ko.observableArray();

            //Variable config data
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
            this.getNovaPoshtaData();
            this.getCities();
            //hide options of type of delivery
            this.showCourier = ko.observable(false);
            this.showpostbox = ko.observable(false);

            return this;
        },
        /**
         * Get config data
         */
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
                // Todo: if price not set, get it using api and send parameters of product
                this.priceDepartment = 70;
                this.pricePostBox = 70;
                this.priceCourier = 105;
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
            let responseData = null;

            $.ajax({
                url: 'https://api.novaposhta.ua/v2.0/json/',
                dataType: 'json',
                type: 'POST',
                async: false,
                data: JSON.stringify({
                    'modelName': model,
                    'calledMethod': method,
                    'apiKey': this.apiKey,
                    'methodProperties': properties
                }),
                showLoader: false,

                success: function (data) {
                    if(data.data.length !== 0) {
                        responseData = data.data;
                    }
                }
            });
            return responseData;
        },
        /**
         * Get list of cities
         */
        getCities:function (){
            let cities = this.MakeRequest('Address','getCities');
            this.dataCity(cities);
        },
        /**
         * Call method
         * @param obj
         * @param event
         */
        getDepartments: function (obj, event){
            this.selectedCity = event.target.value;
            this.getWarehouses();
            this.getStreet();
        },
        /**
         * Get list of departments and postboxes
         */
        getWarehouses: function (){
            const _self = this;

            const errMessageDepartment = $("#delivery-error-message-department");
            const errMessagePostBox = $("#delivery-error-message-postbox");

            let property = {'CityRef': this.selectedCity};
            let warehouses = this.MakeRequest('Address', 'getWarehouses', property);

            _self.dataDepartment.removeAll();
            _self.dataPostBox.removeAll();

            // If response data is null, show error message
            if(!warehouses)
            {
                errMessagePostBox.show();
                errMessageDepartment.show();
            }
            // Package data for Post Box and Department
            for (const department in warehouses) {
                if(warehouses[department].CategoryOfWarehouse === "Postomat") {
                    _self.dataPostBox.push(warehouses[department]);
                }
                else {
                    _self.dataDepartment.push(warehouses[department]);
                }
            }
            // Check if list of departments is not empty
            if(_self.dataDepartment().length > 0)
            {
                errMessageDepartment.hide();
                //Check if list of post boxes is not empty
                if(_self.dataPostBox().length > 0) {
                    errMessagePostBox.hide();
                }
                else{
                    //if empty show message
                    errMessagePostBox.show();
                }
            }
            else{
                //if empty show message
                errMessageDepartment.show();
            }
        },
        /**
         * Get list of Streets
         */
        getStreet: function () {
            let property = {'CityRef': this.selectedCity};
            let streets = this.MakeRequest('Address', 'getStreet', property);
            this.dataStreet(streets);
        },
        /**
         * Select delivery type
         * @param obj
         * @param event
         */
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
         * Set new text price on storefront
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
