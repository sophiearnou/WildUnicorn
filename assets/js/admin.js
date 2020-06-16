import('./common');

import '../scss/admin.scss';

// doc : https://gist.github.com/jrunestone/2fbe5d6d5e425b7c046168b6d6e74e95#file-jquery-datatables-webpack
var $ = require('jquery');
require('datatables.net-bs4')($);
require('datatables.net-buttons-bs4')($);
require('datatables.net-responsive-bs4')($);

$(document).ready(function () {
    console.log("test");
    $('#event-table').dataTable({
        responsive: true,
        ordering: true,
        fixedHeader: true,
    });
    $('#category-table').dataTable({
        responsive: true,
        ordering: true,
        fixedHeader: true,
    });
    $('#image-table').dataTable({
        responsive: true,
        ordering: true,
        fixedHeader: true,
    });
    $('#user-table').dataTable({
        responsive: true,
        ordering: true,
        fixedHeader: true,
    });
});