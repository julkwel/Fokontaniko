import bootbox from 'bootbox';

const admin = {
    action: {
        confirmOnDelete: () => {
            $('.btn-confirm').on('click', function (evt) {
                let link = $(this).attr('href');
                let user = $(this).data('user');

                evt.preventDefault();

                bootbox.confirm({
                    message: "Tena hofafanao tokoa ve i " + user,
                    buttons: {
                        confirm: {
                            label: 'Eny',
                            className: 'btn-danger btn-sm col-md-6'
                        },
                        cancel: {
                            label: 'Tsia',
                            className: 'btn-success btn-sm col-md-6',
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            window.location.href = link;
                        }
                    }
                })
            })
        },

        searchParent: () => {
            $('.select2-parent').select2({
                tag: true,
                ajax: {
                    method: 'GET',
                    dataType: 'json',
                    url: Routing.generate('find_ajax_parent'),
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
        }
    },
};

$(document).ready(function () {
    admin.action.confirmOnDelete();
    admin.action.searchParent();
});
