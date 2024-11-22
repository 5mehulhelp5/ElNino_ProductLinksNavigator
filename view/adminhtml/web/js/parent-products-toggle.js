/*
 * Copyright (c) 2024.
 * Released under the MIT License.
 *
 * This file is part of the El Niño BV open-source project (https://elnino.tech/).
 * Source code is available at https://github.com/elninotech.
 *
 * You may freely use, modify, and distribute this file in accordance with the terms of the MIT License.
 *
 */

define([
    'uiComponent',
    'jquery',
    'ko'
], function (Component, $, ko) {
    'use strict';

    return Component.extend({
        defaults: {
            isVisible: ko.observable(false),
            listens: {
                'isVisible': 'onVisibilityChange'
            }
        },

        /**
         * Initialize component
         */
        initialize: function () {
            this._super();
            this.loadVisibility();
        },

        /**
         * Load visibility based on backend data
         */
        loadVisibility: function () {
            let self = this;

            $.ajax({
                url: self.url,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    self.isVisible(response.hasParentProducts);
                }
            });
        },

        /**
         * Triggered when visibility is changed
         */
        onVisibilityChange: function (isVisible) {
            if (!isVisible) {
                this.visible(false);
            }
        }
    });
});
