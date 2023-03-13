define([
    'ko',
    'uiComponent',
    'jquery'
], function (ko, Component, $) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Elogic_Directory/geodb/connection',
            connectionFailedMessage: 'Connection failed. Check your Api key and Host',
            emptyApiKeyMessage: 'Please fill the "API Key (X-RapidAPI-Key)" field for a connection test',
            emptyApiHostMessage: 'Please fill the "API Host (X-RapidAPI-Host)" field for a connection test',
            successApiMessage:  'The connection is established successfully',
            apiKeyInputId: 'directory_geo_db_geo_db_key',
            apiHostInputId: 'directory_geo_db_geo_db_host',
            url: '',
            success: false,
            message: '',
            visible: false
        },

        /**
         * Init observable variables
         * @return {Object}
         */
        initObservable: function () {
            this._super()
                .observe([
                    'success',
                    'message',
                    'visible'
                ]);

            return this;
        },

        /**
         * @override
         */
        initialize: function () {
            this._super();
            this.messageClass = ko.computed(function () {
                return 'message-validation message message-' + (this.success() ? 'success' : 'error');
            }, this);

            if (!this.success()) {
                this.showMessage(false, this.connectionFailedMessage);
            }
        },

        /**
         * @param {boolean} success
         * @param {String} message
         */
        showMessage: function (success, message) {
            this.message(message);
            this.success(success);
            this.visible(true);
        },

        /**
         * Send request to server to test connection to Geo DB API and display the result
         */
        testConnection: function () {
            const apiKey = document.getElementById(this.apiKeyInputId).value;
            const apiHost = document.getElementById(this.apiHostInputId).value;

            if (apiKey.length === 0) {
                this.showMessage(false, this.emptyApiKeyMessage);
                return;
            }
            if (apiHost.length === 0) {
                this.showMessage(false, this.emptyApiHostMessage);
                return;
            }

            this.visible(false);

            $.ajax({
                type: 'POST',
                url: this.url,
                dataType: 'json',
                data: {
                    'x-rapidapi-key': apiKey,
                    'x-rapidapi-host' : apiHost
                },
                success: function (response) {
                    this.showMessage(response.success === true, response.message);
                }.bind(this),
                error: function () {
                    this.showMessage(false, this.connectionFailedMessage);
                }.bind(this)
            });
        }
    });
});
