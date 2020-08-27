import bootbox from 'bootbox';
import Axios from "axios";
import Chart from 'chart.js';

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
        },

        createChart: (data, labels, label, ctx) => {
            new Chart(ctx, {
                type: 'pie',
                responsive: true,
                maintainAspectRatio: true,
                tooltips: {
                    enabled: true,
                },
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: data,
                        backgroundColor: [
                            '#ec6868',
                            '#77d7a6',
                        ],
                        borderColor: [
                            '#ec6868',
                            '#77d7a6',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
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
        },

        chartManager: () => {
            let ctx = document.getElementById('myChart').getContext('2d');

            admin.asynchronious.genreStats().then(res => {
                let men = res.data.men;
                let women = res.data.women;
                let data = [men, women];
                let labels = ['Lahy', 'Vavy'];
                let label = '# Salan\'isan\'ny lahy sy vavy';

                admin.action.createChart(data, labels, label, ctx);
            });
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
        },

        genreStats: () => {
            return Axios.get(Routing.generate('genre_stats'));
        }
    }
};

export default admin;
