$(function() {
    'use strict'

    let urlRegion = 'master-data/regions';
    let urlProvince = 'master-data/provinces/index';
    let urlCity = 'master-data/cities/index';
    let urlSubdistrict = 'master-data/subdistricts/index';
    let urlVillage = 'master-data/villages/index';
    
    $('#pills-provinces-tab').click(function () {
        let datatableProvince = $('#datatable-province').DataTable({
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
            },
            select: true,
            order: [[0, "asc"]],
            lengthMenu: [20,50,75,100],
            processing: true,
            serverSide: true,
            bDestroy: true,
            ajax: {
                url: urlProvince,
                type: "GET",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columnDefs: [
                {
                    targets: -1,
                    render: function (data, type, row) {
                        return '<div class="form-group"><div class="row"><a href="master-data/provinces/'+data.province+'" class= "btn btn-icon-only btn-outline-info btn-sm mx-2" title="View"><svg class="icon icon-xxs" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M569.354 231.631C512.969 135.949 407.81 72 288 72 168.14 72 63.004 135.994 6.646 231.631a47.999 47.999 0 0 0 0 48.739C63.031 376.051 168.19 440 288 440c119.86 0 224.996-63.994 281.354-159.631a47.997 47.997 0 0 0 0-48.738zM288 392c-75.162 0-136-60.827-136-136 0-75.162 60.826-136 136-136 75.162 0 136 60.826 136 136 0 75.162-60.826 136-136 136zm104-136c0 57.438-46.562 104-104 104s-104-46.562-104-104c0-17.708 4.431-34.379 12.236-48.973l-.001.032c0 23.651 19.173 42.823 42.824 42.823s42.824-19.173 42.824-42.823c0-23.651-19.173-42.824-42.824-42.824l-.032.001C253.621 156.431 270.292 152 288 152c57.438 0 104 46.562 104 104z"/></svg></a><a href="master-data/provinces/edit/'+data.province+'" class="btn btn-icon-only btn-outline-success btn-sm mx-2" title="Edit"><svg class="icon icon-xxs" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M290.74 93.24l128.02 128.02-277.99 277.99-114.14 12.6C11.35 513.54-1.56 500.62.14 485.34l12.7-114.22 277.9-277.88zm207.2-19.06l-60.11-60.11c-18.75-18.75-49.16-18.75-67.91 0l-56.55 56.55 128.02 128.02 56.55-56.55c18.75-18.76 18.75-49.16 0-67.91z"/></svg></a><a href="javascript:void(0)" class= "swal-delete btn btn-icon-only btn-outline-danger btn-sm mx-2" data-url="master-data/provinces/delete/'+data.province+'" title="Delete"><svg class="icon icon-xxs" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M0 84V56c0-13.3 10.7-24 24-24h112l9.4-18.7c4-8.2 12.3-13.3 21.4-13.3h114.3c9.1 0 17.4 5.1 21.5 13.3L312 32h112c13.3 0 24 10.7 24 24v28c0 6.6-5.4 12-12 12H12C5.4 96 0 90.6 0 84zm415.2 56.7L394.8 467c-1.6 25.3-22.6 45-47.9 45H101.1c-25.3 0-46.3-19.7-47.9-45L32.8 140.7c-.4-6.9 5.1-12.7 12-12.7h358.5c6.8 0 12.3 5.8 11.9 12.7z"/></svg></a></div></div>';
                    }
                }
            ],
            columns: [
                {
                    data: 'no'
                },
                {
                    data: 'name'
                },
                {
                    data: null,
                    orderable: false
                }
            ],
            drawCallback: function() {
                $.getScript('/admin/js/jquery.sweet-alert.js');
            }
        });
    
        $('#datatable-province').on('page.dt', function() {
            let page = datatableProvince.page.info().page + 1;
            datatableProvince.ajax.url(urlProvince + "?page=" + page);
    
            $('#datatable-province').on('order.dt', function() {
                datatableProvince.ajax.url(urlProvince + "?page=1");
            });
        })
    
        $('#datatable-province').on('length.dt', function(e, settings, len) {
            datatableProvince.ajax.url(urlProvince + "?page=1");
        });
    
        $('#datatable-province').on('search.dt', function() {
            if (datatableProvince.search(this.value) !== '') {
                datatableProvince.ajax.url(urlProvince + "?page=1");
            }
        });
    })

    $('#pills-cities-tab').click(function () {
        let datatableCity = $('#datatable-city').DataTable({
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
            },
            select: true,
            order: [[0, "asc"]],
            lengthMenu: [20,50,75,100],
            processing: true,
            serverSide: true,
            bDestroy: true,
            ajax: {
                url: urlCity,
                type: "GET",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columnDefs: [
                {
                    targets: -1,
                    render: function (data, type, row) {
                        return '<div class="form-group"><div class="row"><a href="master-data/cities/'+data.city+'" class= "btn btn-icon-only btn-outline-info btn-sm mx-2" title="View"><svg class="icon icon-xxs" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M569.354 231.631C512.969 135.949 407.81 72 288 72 168.14 72 63.004 135.994 6.646 231.631a47.999 47.999 0 0 0 0 48.739C63.031 376.051 168.19 440 288 440c119.86 0 224.996-63.994 281.354-159.631a47.997 47.997 0 0 0 0-48.738zM288 392c-75.162 0-136-60.827-136-136 0-75.162 60.826-136 136-136 75.162 0 136 60.826 136 136 0 75.162-60.826 136-136 136zm104-136c0 57.438-46.562 104-104 104s-104-46.562-104-104c0-17.708 4.431-34.379 12.236-48.973l-.001.032c0 23.651 19.173 42.823 42.824 42.823s42.824-19.173 42.824-42.823c0-23.651-19.173-42.824-42.824-42.824l-.032.001C253.621 156.431 270.292 152 288 152c57.438 0 104 46.562 104 104z"/></svg></a><a href="master-data/cities/'+data.city+'/edit" class="btn btn-icon-only btn-outline-success btn-sm mx-2" title="Edit"><svg class="icon icon-xxs" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M290.74 93.24l128.02 128.02-277.99 277.99-114.14 12.6C11.35 513.54-1.56 500.62.14 485.34l12.7-114.22 277.9-277.88zm207.2-19.06l-60.11-60.11c-18.75-18.75-49.16-18.75-67.91 0l-56.55 56.55 128.02 128.02 56.55-56.55c18.75-18.76 18.75-49.16 0-67.91z"/></svg></a><a href="javascript:void(0)" class= "swal-delete btn btn-icon-only btn-outline-danger btn-sm mx-2" data-url="master-data/cities/delete/'+data.city+'" title="Delete"><svg class="icon icon-xxs" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M0 84V56c0-13.3 10.7-24 24-24h112l9.4-18.7c4-8.2 12.3-13.3 21.4-13.3h114.3c9.1 0 17.4 5.1 21.5 13.3L312 32h112c13.3 0 24 10.7 24 24v28c0 6.6-5.4 12-12 12H12C5.4 96 0 90.6 0 84zm415.2 56.7L394.8 467c-1.6 25.3-22.6 45-47.9 45H101.1c-25.3 0-46.3-19.7-47.9-45L32.8 140.7c-.4-6.9 5.1-12.7 12-12.7h358.5c6.8 0 12.3 5.8 11.9 12.7z"/></svg></a></div></div>';
                    }
                }
            ],
            columns: [
                {
                    data: 'no'
                },
                {
                    data: 'province'
                },
                {
                    data: 'name'
                },
                {
                    data: null,
                    orderable: false
                }
            ],
            drawCallback: function() {
                $.getScript('/admin/js/jquery.sweet-alert.js');
            }
        });
    
        $('#datatable-city').on('page.dt', function() {
            let page = datatableCity.page.info().page + 1;
            datatableCity.ajax.url(urlCity + "?page=" + page);
    
            $('#datatable-city').on('order.dt', function() {
                datatableCity.ajax.url(urlCity + "?page=1");
            });
        })
    
        $('#datatable-city').on('length.dt', function(e, settings, len) {
            datatableCity.ajax.url(urlCity + "?page=1");
        });
    
        $('#datatable-city').on('search.dt', function() {
            if (datatableCity.search(this.value) !== '') {
                datatableCity.ajax.url(urlCity + "?page=1");
            }
        });
    })

    $('#pills-subdistricts-tab').click(function () {
        let datatableSubdistrict = $('#datatable-subdistrict').DataTable({
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
            },
            select: true,
            order: [[0, "asc"]],
            lengthMenu: [20,50,75,100],
            processing: true,
            serverSide: true,
            bDestroy: true,
            ajax: {
                url: urlSubdistrict,
                type: "GET",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columnDefs: [
                {
                    targets: -1,
                    render: function (data, type, row) {
                        return '<div class="form-group"><div class="row"><a href="master-data/subdistricts/'+data.subdistrict+'" class= "btn btn-icon-only btn-outline-info btn-sm mx-2" title="View"><svg class="icon icon-xxs" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M569.354 231.631C512.969 135.949 407.81 72 288 72 168.14 72 63.004 135.994 6.646 231.631a47.999 47.999 0 0 0 0 48.739C63.031 376.051 168.19 440 288 440c119.86 0 224.996-63.994 281.354-159.631a47.997 47.997 0 0 0 0-48.738zM288 392c-75.162 0-136-60.827-136-136 0-75.162 60.826-136 136-136 75.162 0 136 60.826 136 136 0 75.162-60.826 136-136 136zm104-136c0 57.438-46.562 104-104 104s-104-46.562-104-104c0-17.708 4.431-34.379 12.236-48.973l-.001.032c0 23.651 19.173 42.823 42.824 42.823s42.824-19.173 42.824-42.823c0-23.651-19.173-42.824-42.824-42.824l-.032.001C253.621 156.431 270.292 152 288 152c57.438 0 104 46.562 104 104z"/></svg></a><a href="master-data/subdistricts/'+data.subdistrict+'/edit" class="btn btn-icon-only btn-outline-success btn-sm mx-2" title="Edit"><svg class="icon icon-xxs" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M290.74 93.24l128.02 128.02-277.99 277.99-114.14 12.6C11.35 513.54-1.56 500.62.14 485.34l12.7-114.22 277.9-277.88zm207.2-19.06l-60.11-60.11c-18.75-18.75-49.16-18.75-67.91 0l-56.55 56.55 128.02 128.02 56.55-56.55c18.75-18.76 18.75-49.16 0-67.91z"/></svg></a><a href="javascript:void(0)" class= "swal-delete btn btn-icon-only btn-outline-danger btn-sm mx-2" data-url="master-data/subdistricts/delete/'+data.subdistrict+'" title="Delete"><svg class="icon icon-xxs" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M0 84V56c0-13.3 10.7-24 24-24h112l9.4-18.7c4-8.2 12.3-13.3 21.4-13.3h114.3c9.1 0 17.4 5.1 21.5 13.3L312 32h112c13.3 0 24 10.7 24 24v28c0 6.6-5.4 12-12 12H12C5.4 96 0 90.6 0 84zm415.2 56.7L394.8 467c-1.6 25.3-22.6 45-47.9 45H101.1c-25.3 0-46.3-19.7-47.9-45L32.8 140.7c-.4-6.9 5.1-12.7 12-12.7h358.5c6.8 0 12.3 5.8 11.9 12.7z"/></svg></a></div></div>';
                    }
                }
            ],
            columns: [
                {
                    data: 'no'
                },
                {
                    data: 'province',
                    className: 'w-25',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'city',
                    className: 'w-25',
                    searchable: true,
                },
                {
                    data: 'name',
                    className: 'w-25',
                    searchable: true,
                    orderable: true
                },
                {
                    data: null,
                    orderable: false,
                    className: 'w-25'
                }
            ],
            drawCallback: function() {
                $.getScript('/admin/js/jquery.sweet-alert.js');
            }
        });
    
        $('#datatable-subdistrict').on('page.dt', function() {
            let page = datatableSubdistrict.page.info().page + 1;
            datatableSubdistrict.ajax.url(urlSubdistrict + "?page=" + page);
    
            $('#datatable-subdistrict').on('order.dt', function() {
                datatableSubdistrict.ajax.url(urlSubdistrict + "?page=1");
            });
        })
    
        $('#datatable-subdistrict').on('length.dt', function(e, settings, len) {
            datatableSubdistrict.ajax.url(urlSubdistrict + "?page=1");
        });
    
        $('#datatable-subdistrict').on('search.dt', function() {
            if (datatableSubdistrict.search(this.value) !== '') {
                datatableSubdistrict.ajax.url(urlSubdistrict + "?page=1");
            }
        });
    })

    $('#pills-villages-tab').click(function () {
        let datatableVillage = $('#datatable-village').DataTable({
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
            },
            select: true,
            order: [[0, "asc"]],
            lengthMenu: [20,50,75,100],
            processing: true,
            serverSide: true,
            bDestroy: true,
            ajax: {
                url: urlVillage,
                type: "GET",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columnDefs: [
                {
                    targets: -1,
                    render: function (data, type, row) {
                        return '<div class="form-group"><div class="row"><a href="master-data/villages/'+data.village+'" class= "btn btn-icon-only btn-outline-info btn-sm mx-2" title="View"><svg class="icon icon-xxs" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M569.354 231.631C512.969 135.949 407.81 72 288 72 168.14 72 63.004 135.994 6.646 231.631a47.999 47.999 0 0 0 0 48.739C63.031 376.051 168.19 440 288 440c119.86 0 224.996-63.994 281.354-159.631a47.997 47.997 0 0 0 0-48.738zM288 392c-75.162 0-136-60.827-136-136 0-75.162 60.826-136 136-136 75.162 0 136 60.826 136 136 0 75.162-60.826 136-136 136zm104-136c0 57.438-46.562 104-104 104s-104-46.562-104-104c0-17.708 4.431-34.379 12.236-48.973l-.001.032c0 23.651 19.173 42.823 42.824 42.823s42.824-19.173 42.824-42.823c0-23.651-19.173-42.824-42.824-42.824l-.032.001C253.621 156.431 270.292 152 288 152c57.438 0 104 46.562 104 104z"/></svg></a><a href="master-data/villages/'+data.village+'/edit" class="btn btn-icon-only btn-outline-success btn-sm mx-2" title="Edit"><svg class="icon icon-xxs" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M290.74 93.24l128.02 128.02-277.99 277.99-114.14 12.6C11.35 513.54-1.56 500.62.14 485.34l12.7-114.22 277.9-277.88zm207.2-19.06l-60.11-60.11c-18.75-18.75-49.16-18.75-67.91 0l-56.55 56.55 128.02 128.02 56.55-56.55c18.75-18.76 18.75-49.16 0-67.91z"/></svg></a><a href="javascript:void(0)" class= "swal-delete btn btn-icon-only btn-outline-danger btn-sm mx-2" data-url="master-data/villages/delete/'+data.village+'" title="Delete"><svg class="icon icon-xxs" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M0 84V56c0-13.3 10.7-24 24-24h112l9.4-18.7c4-8.2 12.3-13.3 21.4-13.3h114.3c9.1 0 17.4 5.1 21.5 13.3L312 32h112c13.3 0 24 10.7 24 24v28c0 6.6-5.4 12-12 12H12C5.4 96 0 90.6 0 84zm415.2 56.7L394.8 467c-1.6 25.3-22.6 45-47.9 45H101.1c-25.3 0-46.3-19.7-47.9-45L32.8 140.7c-.4-6.9 5.1-12.7 12-12.7h358.5c6.8 0 12.3 5.8 11.9 12.7z"/></svg></a></div></div>';
                    }
                }
            ],
            columns: [
                {
                    data: 'no'
                },
                {
                    data: 'province',
                    className: 'w-20'
                },
                {
                    data: 'city',
                    className: 'w-20'
                },
                {
                    data: 'subdistrict',
                    className: 'w-20'
                },
                {
                    data: 'name',
                    className: 'w-20'
                },
                {
                    data: 'postal_code',
                    className: 'w-20'
                },
                {
                    data: null,
                    orderable: false,
                    className: 'w-25'
                }
            ],
            drawCallback: function() {
                $.getScript('/admin/js/jquery.sweet-alert.js');
            }
        });

        $('#datatable-village').on('page.dt', function() {
            let page = datatableVillage.page.info().page + 1;
            datatableVillage.ajax.url(urlVillage + "?page=" + page);
    
            $('#datatable-village').on('order.dt', function() {
                datatableVillage.ajax.url(urlVillage + "?page=1");
            });
        })
    
        $('#datatable-village').on('length.dt', function(e, settings, len) {
            datatableVillage.ajax.url(urlVillage + "?page=1");
        });
    
        $('#datatable-village').on('search.dt', function() {
            if (datatableVillage.search(this.value) !== '') {
                datatableVillage.ajax.url(urlVillage + "?page=1");
            }
        });
    })

    let datatableRegion = $('#datatable-region').DataTable({
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
        },
        select: true,
        order: [[0, "asc"]],
        lengthMenu: [20,50,75,100],
        processing: true,
        serverSide: true,
        ajax: {
            url: urlRegion,
            type: "GET",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        columnDefs: [
            {
                targets: -1,
                render: function (data, type, row) {
                    console.log(data)
                    return '<div class="form-group"><div class="row"><a href="master-data/regions/'+data.region+'" class= "btn btn-icon-only btn-outline-info btn-sm mx-2" title="View"><svg class="icon icon-xxs" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M569.354 231.631C512.969 135.949 407.81 72 288 72 168.14 72 63.004 135.994 6.646 231.631a47.999 47.999 0 0 0 0 48.739C63.031 376.051 168.19 440 288 440c119.86 0 224.996-63.994 281.354-159.631a47.997 47.997 0 0 0 0-48.738zM288 392c-75.162 0-136-60.827-136-136 0-75.162 60.826-136 136-136 75.162 0 136 60.826 136 136 0 75.162-60.826 136-136 136zm104-136c0 57.438-46.562 104-104 104s-104-46.562-104-104c0-17.708 4.431-34.379 12.236-48.973l-.001.032c0 23.651 19.173 42.823 42.824 42.823s42.824-19.173 42.824-42.823c0-23.651-19.173-42.824-42.824-42.824l-.032.001C253.621 156.431 270.292 152 288 152c57.438 0 104 46.562 104 104z"/></svg></a><a href="master-data/regions/'+data.region+'/edit" class="btn btn-icon-only btn-outline-success btn-sm mx-2" title="Edit"><svg class="icon icon-xxs" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M290.74 93.24l128.02 128.02-277.99 277.99-114.14 12.6C11.35 513.54-1.56 500.62.14 485.34l12.7-114.22 277.9-277.88zm207.2-19.06l-60.11-60.11c-18.75-18.75-49.16-18.75-67.91 0l-56.55 56.55 128.02 128.02 56.55-56.55c18.75-18.76 18.75-49.16 0-67.91z"/></svg></a></div></div>';
                }
            }
        ],
        columns: [
            {
                data: 'no'
            },
            {
                data: 'name'
            },
            {
                data: 'provinces'
            },
            {
                data: null,
                orderable: false
            }
        ],
        drawCallback: function() {
            $.getScript('/admin/js/jquery.sweet-alert.js');
        }
    });

    $('#datatable-region').on('page.dt', function() {
        let page = datatableRegion.page.info().page + 1;
        datatableRegion.ajax.url(urlRegion + "?page=" + page);

        $('#datatable-region').on('order.dt', function() {
            datatableRegion.ajax.url(urlRegion + "?page=1");
        });
    })

    $('#datatable-region').on('length.dt', function(e, settings, len) {
        datatableRegion.ajax.url(urlRegion + "?page=1");
    });

    $('#datatable-region').on('search.dt', function() {
        if (datatableRegion.search(this.value) !== '') {
            datatableRegion.ajax.url(urlRegion + "?page=1");
        }
    });
});