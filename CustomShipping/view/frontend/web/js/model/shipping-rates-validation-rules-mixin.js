define(['jquery'], function ($) {
    'use strict';

    return function (targetFunction) {
        targetFunction.getObservableFields = function () {
            var self = this,
                observableFields = [];

            $.each(self.getRules(), function (carrier, fields) {
                $.each(fields, function (field) {
                    if (observableFields.indexOf(field) === -1) {
                        observableFields.push(field);
                    }
                });
            });

            // Add your custom logic here to include additional observable fields
            observableFields.push('country_id'); // Load shipping method on Country change
            observableFields.push('region_id'); // Load shipping method on Region change
            // Add more fields as needed

            return observableFields;
        };

        return targetFunction;
    };
});
