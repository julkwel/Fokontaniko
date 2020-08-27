import admin from "js/module/_admin_manager";

require('../css/admin.css');

require('../vendor/js/vendor/jquery-2.2.4.min.js');
require('../vendor/js/popper.min.js');
require('../vendor/js/bootstrap.min.js');
require('../vendor/js/metisMenu.min.js');
require('../vendor/js/jquery.slimscroll.min.js');
require('../vendor/js/jquery.slicknav.min.js');
require('../vendor/js/owl.carousel.min.js');

require('../vendor/js/plugins.js');
require('../vendor/js/scripts.js');
require('./module/_select_fetchable_data');

$(document).ready(function () {
    admin.action.confirmOnDelete();
    admin.action.searchParent();
    admin.auto.switchMode();
});


