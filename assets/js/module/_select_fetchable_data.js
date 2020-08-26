require('select2');

$(document).ready(function () {
    $('.username-data').select2({
        ajax: {
            url: Routing.generate('ajax_admin'),
            data: function (params) {
                return {
                    search: params.term,
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            }
        }
    });
});
