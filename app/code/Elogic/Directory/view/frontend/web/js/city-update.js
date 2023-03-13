define([
    'jquery',
    'mage/utils/wrapper',
    'mage/template',
    'mage/validation',
    'underscore',
    'jquery/ui'
], function ($) {
    'use strict';
    return function () {

        const string = JSON.stringify($citiesJson),
            obj = JSON.parse(string);

        if(obj[0]['enable'] === 0)
        {
            return false;
        }

        const cityInput = $("[name*='city']").val();

        $(document).ready(function (){
            let country_id = $("[name*='country_id']").val();
            let country = [];

            if (country_id) {
                $.each(obj, function (index, value) {
                    if (value.country_id === country_id) {
                        country.push(value.city_name);
                    }
                });
                let city = $("[name*='city']"),
                    selectCity = city.replaceWith("<select class='required-entry' name='city' id='city'>") + '</select>',
                    htmlSelect = '<option>Select a city</option>',
                    options;

                $.each(country, function (index, value) {
                    if ( value === cityInput.toUpperCase()) {
                        options = '<option value="' + value + '" selected>' + value + '</option>';
                    } else {
                        options = '<option value="' + value + '">' + value + '</option>';
                    }

                    htmlSelect += options;
                });

                $('#city').append(htmlSelect);
            }

        });

        $(document).on('change', "[name*='country_id']", function () {

            const country_id = $(this).val(),
                countryName = this.name,
                cityInputName = countryName.replace("country_id", "city"),
                country = [];

            if (country_id) {
                $.each(obj, function (index, value) {
                    if (value.country_id === country_id) {
                        country.push(value.city_name);
                    }
                });
                let city = $("[name*='" + cityInputName + "']"),
                    selectCity = city.replaceWith("<select class='required-entry' name='" + cityInputName + "' id='city'>") + '</select>',
                    htmlSelect = '<option>Select City</option>',
                    options;

                $.each(country, function (index, value) {
                    options = '<option value="' + value + '">' + value + '</option>';
                    htmlSelect += options;
                });

                $('#city').append(htmlSelect);
            }
        });
    };
});
