/**
 * @api
 */
define([
    'Magento_Ui/js/form/element/select',
    'uiRegistry',
], function (Element, registry) {
    'use strict';

    return Element.extend({
        defaults: {
            imports: {
                update: '${ $.parentName }.country_id:value',
                city: '${ $.parentName }.city'
            },
            options: [],
            visible: false
        },

        initialize: function () {
            this._super();

            if (this.name.includes('steps.billing-step')) {
                this.visible(false)
            }
        },

        /**
         * On country update we check for city
         *
         * @param {string} countryId
         */
        update: function (countryId) {

            let options = [],
                cityValue,
                cities,
                countries = JSON.parse(window.checkoutConfig.cities);

            if(Object.keys(countries).length <= 1 && countries[0]['enable'] === 0)
            {
                return false;
            }

            if (countries && countries[countryId] && countries[countryId].length) {
                cities = countries[countryId];

                options = cities.map(function (city) {
                    return {title: city, value: city, labeltitle: city, label: city}
                })
            }

            if (!options || !options.length) {
                this.visible(false);
                this.value(null);
            }

            if (options && options.length) {
                options = [{title: "", value: "", label: "Please select a city"}].concat(options);
                this.visible(true);

                cityValue = registry.get(this.imports.city).value();

                if (!this.value() && cityValue) {
                    this.value(cityValue)
                }
            }

            this.options(options);
        },
    });
});
