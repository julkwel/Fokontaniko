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
        }
    },
};

$(document).ready(function () {
    admin.action.confirmOnDelete();
});
