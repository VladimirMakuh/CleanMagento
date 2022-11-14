define([
    'Magento_Ui/js/form/form',
    'ko',
    'jquery',
    'Magento_Checkout/js/model/quote'

], function (Component,ko,$, quote) {
    'use strict';

    return Component.extend({
        initObservable: function () {
            const self = this._super();
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
            this.dataStreet = ko.observableArray();
            this.enable = ko.observable();
            this.apiKey = ko.observable();
            this.selectedCity = ko.observable();

            this.isDepartment = ko.observable();

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
        },
        /**
         * Make request
         * @param model
         * @param method
         * @param properties
         * @constructor
         */
        MakeRequest: function(model,method, properties = null) {
            const errorMessage = $("#delivery-error-message-department");
            const errorMessagePostBox = $("#delivery-error-message-postbox");
            const self = this;
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
                        if(data.data.length !== 0)
                        {
                            errorMessage.hide();
                            if(!data.data.PostMachineType){
                                errorMessagePostBox.hide();
                            }
                            self.dataDepartment(data.data);
                            break;
                        }
                        errorMessagePostBox.show();
                        errorMessage.show();
                        self.dataDepartment(null);
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
        getDepartment: function (obj, event){
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
        selectPostBox: function (){
            if(!$("#post-box").prop('checked'))
            {
                document.getElementById('post-box').checked = true;
            }
            $(".delivery-novaposhta-department").hide();
            $("#list-courier").hide();
            $(".delivery-novaposhta-postbox").show();
            console.log("postbox");
        },
        selectDepartment: function (event) {
            $(".delivery-novaposhta-postbox").hide();
            $("#list-courier").hide();
            $(".delivery-novaposhta-department").show();
            console.log("department");
        },
        selectCourier: function () {
            $("#courier").prop('checked', true);
            $(".delivery-novaposhta-postbox").hide();
            $(".delivery-novaposhta-department").hide();
            $("#list-courier").show();
            console.log("courier");
        },
        /**
         * Form submit handler
         *
         * This method can have any name.
         */
        onSubmit: function () {
            // trigger form validation
            this.source.set('params.invalid', false);
            this.source.trigger('shippingDelivery.data.validate');

            // verify that form data is valid
            if (!this.source.get('params.invalid')) {
                // data is retrieved from data provider by value of the customScope property
                const formData = this.source.get('shippingDelivery');
                // do something with form data
                console.dir(formData);
            }
        }
    });

});
