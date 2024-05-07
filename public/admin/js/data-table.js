$(function() {
    'use strict'
    
    $('#datatable').DataTable({
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
        },
        select: true,
        order: [[0, "asc"]],
        lengthMenu: [10,20,50,75,100],
        drawCallback: function() {
            $.getScript('/admin/js/jquery.sweet-alert.js');
        }
    });

    $('#datatable-2').DataTable({
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
        },
        select: true,
        order: [[0, "asc"]],
        lengthMenu: [10,20,50,75,100],
        drawCallback: function() {
            $.getScript('/admin/js/jquery.sweet-alert.js');
        }
    });

    $('#datatable-3').DataTable({
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
        },
        select: true,
        order: [[0, "asc"]],
        lengthMenu: [10,20,50,75,100],
        columnDefs: [
            {
                orderable: false,
                targets: -1
            }
        ],
        drawCallback: function() {
            $.getScript('/admin/js/jquery.sweet-alert.js');
        }
    });

    $('#datatable-4').DataTable({
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
        },
        select: true,
        order: [[0, "asc"]],
        lengthMenu: [10,20,50,75,100],
        columnDefs: [
            {
                orderable: false,
                targets: 3
            }
        ],
        drawCallback: function() {
            $.getScript('/admin/js/jquery.sweet-alert.js');
        }
    });
});