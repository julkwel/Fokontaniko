import bootbox from 'bootbox';
import Axios from "axios";

const admin = {
    action: {
        confirmOnDelete: () => {
            $('.btn-confirm').on('click', function (evt) {
                let link = $(this).attr('href');
                let msg = $(this).data('msg');

                evt.preventDefault();

                bootbox.confirm({
                    message: `Tena hofafanao tokoa ve ${msg} ?`,
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
                tags: true,
                theme: 'bootstrap4',
                language: 'fr',
                minimumInputLength: 2,
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

    auto: {
        switchMode: () => {
            $('.switch-mode').on('change', function (evt) {
                evt.preventDefault();
                let user = $(this).data('user');
                admin.asynchronious.theming(user).then(res => {
                    let element = document.body;
                    if (res.data.theme === 1) {
                        element.classList.toggle("dark-mode");
                    } else {
                        element.classList.remove("dark-mode");
                    }
                });
            })
        },

        scrolling: () => {
            let elm = document.getElementById('recent-activity');
            elm.onscroll = function () {
                if (elm.scrollTop + elm.clientHeight === elm.scrollHeight) {
                    admin.asynchronious.historyScroll(page).then(res => {
                        $('.recent-activity').append(res.data);
                    });
                }
            }
        }
    },

    asynchronious: {
        theming: (user = null) => {
            if (user) {
                return Axios.post(Routing.generate('switch_mode', {user: user}));
            }
            return Promise.reject(new Error('andramo indray'));
        },

        historyScroll: (page = 0) => {
            return Axios.get(Routing.generate('history_list', {page: page}));
        }
    }
};

export default admin;
