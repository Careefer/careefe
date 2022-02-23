$(window).load(function(){
    $("body").on("click", ".btn-filter", function() {
        $(".filter").addClass("show-filter");
        $("body,html").addClass("fixed");
    });

    $(".filter .btn-back").click(function() {
        $(".filter").removeClass("show-filter");
        $("body,html").removeClass("fixed");
    });
});


function draw_table(column_sort = null)
{   
    var TableDatatablesAjax = function() {
        var a = function() {
                $(".date-picker").datepicker({
                    rtl: App.isRTL(),
                    autoclose: !0
                })
            },
            e = function() {
                var a = new Datatable;
                a.init({
                    src: $("#datatable_ajax"),
                    onSuccess: function(a, e) {},
                    onError: function(a) {},
                    onDataLoad: function(a) {},
                    loadingMessage: "Loading...",
                    dataTable: {
                        bStateSave: false,
                        fnStateSaveParams: function(a, e) {
                            return $("#datatable_ajax tr.filter .form-control").each(function() {
                                e[$(this).attr("name")] = $(this).val()
                            }), e
                        },
                        fnStateLoadParams: function(a, e) {
                            return $("#datatable_ajax tr.filter .form-control").each(function() {
                                var a = $(this);
                                e[a.attr("name")] && a.val(e[a.attr("name")])
                            }), !0
                        },
                        lengthMenu: [
                            [10, 20, 50, 100, 150, -1],
                            [10, 20, 50, 100, 150, "All"]
                        ],
                        "aoColumns": column_sort,
                        pageLength: 10,
                        "order": [
                            [0,"desc"]
                        ],

                        ajax: {
                            url: "",
                            "type": "GET",
                        }
                    }
                }), a.getTableWrapper().on("click", ".table-group-action-submit", function(e) {
                    e.preventDefault();
                    var t = $(".table-group-action-input", a.getTableWrapper());
                    "" != t.val() && a.getSelectedRowsCount() > 0 ? (a.setAjaxParam("customActionType", "group_action"), a.setAjaxParam("customActionName", t.val()), a.setAjaxParam("id", a.getSelectedRows()), a.getDataTable().ajax.reload(), a.clearAjaxParams()) : "" == t.val() ? App.alert({
                        type: "danger",
                        icon: "warning",
                        message: "Please select an action",
                        container: a.getTableWrapper(),
                        place: "prepend"
                    }) : 0 === a.getSelectedRowsCount() && App.alert({
                        type: "danger",
                        icon: "warning",
                        message: "No record selected",
                        container: a.getTableWrapper(),
                        place: "prepend"
                    })
                })
            }
        return {
            init: function() {
                a(), e()
            }
        }
    }();
    TableDatatablesAjax.init();

    //$('#datatable_ajax_wrapper').children('.row:first').remove();
}


/*function draw_country_table(column_sort = null)
{   
    var TableDatatablesAjax = function() {
        var a = function() {
                $(".date-picker").datepicker({
                    rtl: App.isRTL(),
                    autoclose: !0
                })
            },
            e = function() {
                var a = new Datatable;
                a.init({
                    src: $("#datatable_ajax"),
                    onSuccess: function(a, e) {},
                    onError: function(a) {},
                    onDataLoad: function(a) {},
                    loadingMessage: "Loading...",
                    dataTable: {
                        bStateSave: false,
                        searching : false,
                        "dom": "Bfrtip",
                        buttons: [ 
                            {
                                extend: "excel",
                                className: "btn green active btn-outline btn-circle",
                                text: "<span><i class='fa fa-download'></i> Excel</span>",
                                title: "Countries",
                                autoFilter: true,
                                exportOptions: {
                                    columns: [0,1,2,3]
                                }
                            }
                        ],
                        fnStateSaveParams: function(a, e) {
                            return $("#datatable_ajax tr.filter .form-control").each(function() {
                                e[$(this).attr("name")] = $(this).val()
                            }), e
                        },
                        fnStateLoadParams: function(a, e) {
                            return $("#datatable_ajax tr.filter .form-control").each(function() {
                                var a = $(this);
                                e[a.attr("name")] && a.val(e[a.attr("name")])
                            }), !0
                        },
                        lengthMenu: [
                            [10, 20, 50, 100, 150, -1],
                            [10, 20, 50, 100, 150, "All"]
                        ],
                        "aoColumns": [
                            {"bSortable": true},
                            {"bSortable": true},
                            {"bSortable": true},
                            {"bSortable": true},
                            {"bSortable": false}
                        ],
                        pageLength: 10,

                        ajax: {
                            url: "",
                            "type": "GET",
                        }
                    }
                }), a.getTableWrapper().on("click", ".table-group-action-submit", function(e) {
                    e.preventDefault();
                    var t = $(".table-group-action-input", a.getTableWrapper());
                    "" != t.val() && a.getSelectedRowsCount() > 0 ? (a.setAjaxParam("customActionType", "group_action"), a.setAjaxParam("customActionName", t.val()), a.setAjaxParam("id", a.getSelectedRows()), a.getDataTable().ajax.reload(), a.clearAjaxParams()) : "" == t.val() ? App.alert({
                        type: "danger",
                        icon: "warning",
                        message: "Please select an action",
                        container: a.getTableWrapper(),
                        place: "prepend"
                    }) : 0 === a.getSelectedRowsCount() && App.alert({
                        type: "danger",
                        icon: "warning",
                        message: "No record selected",
                        container: a.getTableWrapper(),
                        place: "prepend"
                    })
                })
            }
        return {
            init: function() {
                a(), e()
            }
        }
    }();
    TableDatatablesAjax.init();

    //$('#datatable_ajax_wrapper').children('.row:first').remove();
}*/

function draw_candidate_table(column_sort = null)
{   
    var TableDatatablesAjax = function() {
        var a = function() {
                $(".date-picker").datepicker({
                    rtl: App.isRTL(),
                    autoclose: !0
                })
            },
            e = function() {
                var a = new Datatable;
                a.init({
                    src: $("#datatable_ajax"),
                    onSuccess: function(a, e) {},
                    onError: function(a) {},
                    onDataLoad: function(a) {},
                    loadingMessage: "Loading...",
                    dataTable: {
                        bStateSave: false,
                        searching : false,
                        "dom": "Bfrtip",
                        buttons: [ 
                            {
                                extend: "excel",
                                className: "btn green active btn-outline btn-circle",
                                text: "<span><i class='fa fa-download'></i> Excel</span>",
                                title: "Candidates",
                                autoFilter: true,
                                exportOptions: {
                                    columns: [0,1,2,3,4,5]
                                }
                            }
                        ],
                        fnStateSaveParams: function(a, e) {
                            return $("#datatable_ajax tr.filter .form-control").each(function() {
                                e[$(this).attr("name")] = $(this).val()
                            }), e
                        },
                        fnStateLoadParams: function(a, e) {
                            return $("#datatable_ajax tr.filter .form-control").each(function() {
                                var a = $(this);
                                e[a.attr("name")] && a.val(e[a.attr("name")])
                            }), !0
                        },
                        lengthMenu: [
                            [10, 20, 50, 100, 150, -1],
                            [10, 20, 50, 100, 150, "All"]
                        ],
                        "aoColumns": [
                            {"bSortable": true},
                            {"bSortable": true},
                            {"bSortable": true},
                            {"bSortable": true},
                            {"bSortable": true},
                            {"bSortable": true},
                            {"bSortable": false}
                        ],
                        pageLength: 10,

                        ajax: {
                            url: "",
                            "type": "GET",
                        }
                    }
                }), a.getTableWrapper().on("click", ".table-group-action-submit", function(e) {
                    e.preventDefault();
                    var t = $(".table-group-action-input", a.getTableWrapper());
                    "" != t.val() && a.getSelectedRowsCount() > 0 ? (a.setAjaxParam("customActionType", "group_action"), a.setAjaxParam("customActionName", t.val()), a.setAjaxParam("id", a.getSelectedRows()), a.getDataTable().ajax.reload(), a.clearAjaxParams()) : "" == t.val() ? App.alert({
                        type: "danger",
                        icon: "warning",
                        message: "Please select an action",
                        container: a.getTableWrapper(),
                        place: "prepend"
                    }) : 0 === a.getSelectedRowsCount() && App.alert({
                        type: "danger",
                        icon: "warning",
                        message: "No record selected",
                        container: a.getTableWrapper(),
                        place: "prepend"
                    })
                })
            }
        return {
            init: function() {
                a(), e()
            }
        }
    }();
    TableDatatablesAjax.init();
}

function draw_employer_table()
{   
    var TableDatatablesAjax = function() {
        var a = function() {
                $(".date-picker").datepicker({
                    rtl: App.isRTL(),
                    autoclose: !0
                })
            },
            e = function() {
                var a = new Datatable;
                a.init({
                    src: $("#datatable_ajax"),
                    onSuccess: function(a, e) {},
                    onError: function(a) {},
                    onDataLoad: function(a) {},
                    loadingMessage: "Loading...",
                    dataTable: {
                        bStateSave: false,
                        searching : false,
                        "dom": "Bfrtip",
                        buttons: [ 
                            {
                                extend: "excel",
                                className: "btn green active btn-outline btn-circle",
                                text: "<span><i class='fa fa-download'></i> Excel</span>",
                                title: "Employers",
                                autoFilter: true,
                                exportOptions: {
                                    columns: [0,1,2,3,4]
                                }
                            }
                        ],
                        fnStateSaveParams: function(a, e) {
                            return $("#datatable_ajax tr.filter .form-control").each(function() {
                                e[$(this).attr("name")] = $(this).val()
                            }), e
                        },
                        fnStateLoadParams: function(a, e) {
                            return $("#datatable_ajax tr.filter .form-control").each(function() {
                                var a = $(this);
                                e[a.attr("name")] && a.val(e[a.attr("name")])
                            }), !0
                        },
                        lengthMenu: [
                            [10, 20, 50, 100, 150, -1],
                            [10, 20, 50, 100, 150, "All"]
                        ],
                        "aoColumns": [
                            {data: 'employer_id', name: 'employer_id', "bSortable": true},
							{data: 'name', name: 'name', "bSortable": true},
							{data: 'head_office', name: 'head_office', "bSortable": false},
							{data: 'branch_offices.name', name: 'branch_offices.name', "bSortable": false},
							{data: 'industry.name', name: 'industry.name', "bSortable": false},
							{data: 'status', name: 'status', "bSortable": true},
							{data: 'action', name: 'action', "bSortable": false, searchable: false}
                            // {"bSortable": true},
                            // {"bSortable": true},
                            // {"bSortable": true},
                            // {"bSortable": true},
                            // {"bSortable": true},
                            // {"bSortable": true},
                            // {"bSortable": false}
                        ],
                        pageLength: 10,

                        ajax: {
                            url: "",
                            "type": "GET",
                        }
                    }
                }), a.getTableWrapper().on("click", ".table-group-action-submit", function(e) {
                    e.preventDefault();
                    var t = $(".table-group-action-input", a.getTableWrapper());
                    "" != t.val() && a.getSelectedRowsCount() > 0 ? (a.setAjaxParam("customActionType", "group_action"), a.setAjaxParam("customActionName", t.val()), a.setAjaxParam("id", a.getSelectedRows()), a.getDataTable().ajax.reload(), a.clearAjaxParams()) : "" == t.val() ? App.alert({
                        type: "danger",
                        icon: "warning",
                        message: "Please select an action",
                        container: a.getTableWrapper(),
                        place: "prepend"
                    }) : 0 === a.getSelectedRowsCount() && App.alert({
                        type: "danger",
                        icon: "warning",
                        message: "No record selected",
                        container: a.getTableWrapper(),
                        place: "prepend"
                    })
                })
            }
        return {
            init: function() {
                a(), e()
            }
        }
    }();
    TableDatatablesAjax.init();
}

function draw_specialist_table(sorts)
{   
    var TableDatatablesAjax = function() {
        var a = function() {
                $(".date-picker").datepicker({
                    rtl: App.isRTL(),
                    autoclose: !0
                })
            },
            e = function() {
                var a = new Datatable;
                a.init({
                    src: $("#datatable_ajax"),
                    onSuccess: function(a, e) {},
                    onError: function(a) {},
                    onDataLoad: function(a) {},
                    loadingMessage: "Loading...",
                    dataTable: {
                        bStateSave: false,
                        searching : false,
                        "dom": "Bfrtip",
                        buttons: [ 
                            {
                                extend: "excel",
                                className: "btn green active btn-outline btn-circle",
                                text: "<span><i class='fa fa-download'></i> Excel</span>",
                                title: "Specialist",
                                autoFilter: true,
                                exportOptions: {
                                    columns: [0,1,2,3,4,5]
                                }
                            }
                        ],
                        fnStateSaveParams: function(a, e) {
                            return $("#datatable_ajax tr.filter .form-control").each(function() {
                                e[$(this).attr("name")] = $(this).val()
                            }), e
                        },
                        fnStateLoadParams: function(a, e) {
                            return $("#datatable_ajax tr.filter .form-control").each(function() {
                                var a = $(this);
                                e[a.attr("name")] && a.val(e[a.attr("name")])
                            }), !0
                        },
                        lengthMenu: [
                            [10, 20, 50, 100, 150, -1],
                            [10, 20, 50, 100, 150, "All"]
                        ],
                        "aoColumns": [
                            {data: 'specialist_id', name: 'specialist_id', "bSortable": true},
                            {data: 'name', name: 'name', "bSortable": true},
                            {data: 'email', name: 'email', "bSortable": true},
                            {data: 'locaton', name: 'locaton', "bSortable": true},
                            {data: 'functional_area', name: 'functional_area', "bSortable": true},
                            {data: 'status', name: 'status', "bSortable": true},
                            {data: 'action', name: 'action', "bSortable": false},
                        ],
                        pageLength: 10,

                        ajax: {
                            url: "",
                            "type": "GET",
                        }
                    }
                }), a.getTableWrapper().on("click", ".table-group-action-submit", function(e) {
                    e.preventDefault();
                    var t = $(".table-group-action-input", a.getTableWrapper());
                    "" != t.val() && a.getSelectedRowsCount() > 0 ? (a.setAjaxParam("customActionType", "group_action"), a.setAjaxParam("customActionName", t.val()), a.setAjaxParam("id", a.getSelectedRows()), a.getDataTable().ajax.reload(), a.clearAjaxParams()) : "" == t.val() ? App.alert({
                        type: "danger",
                        icon: "warning",
                        message: "Please select an action",
                        container: a.getTableWrapper(),
                        place: "prepend"
                    }) : 0 === a.getSelectedRowsCount() && App.alert({
                        type: "danger",
                        icon: "warning",
                        message: "No record selected",
                        container: a.getTableWrapper(),
                        place: "prepend"
                    })
                })
            }
        return {
            init: function() {
                a(), e()
            }
        }
    }();
    TableDatatablesAjax.init();
}

/*function draw_currency_rate_conversion_table(column_sort = null)
{   
    var TableDatatablesAjax = function() {
        var a = function() {
                $(".date-picker").datepicker({
                    rtl: App.isRTL(),
                    autoclose: !0
                })
            },
            e = function() {
                var a = new Datatable;
                a.init({
                    src: $("#datatable_ajax"),
                    onSuccess: function(a, e) {},
                    onError: function(a) {},
                    onDataLoad: function(a) {},
                    loadingMessage: "Loading...",
                    dataTable: {
                        bStateSave: false,
                        searching : false,
                        "dom": "Bfrtip",
                        buttons: [ 
                            {
                                extend: "excel",
                                className: "btn green active btn-outline btn-circle",
                                text: "<span><i class='fa fa-download'></i> Excel</span>",
                                title: "Currency Rate Conversions",
                                autoFilter: true,
                                exportOptions: {
                                    columns: [0,1,2]
                                }
                            }
                        ],
                        fnStateSaveParams: function(a, e) {
                            return $("#datatable_ajax tr.filter .form-control").each(function() {
                                e[$(this).attr("name")] = $(this).val()
                            }), e
                        },
                        fnStateLoadParams: function(a, e) {
                            return $("#datatable_ajax tr.filter .form-control").each(function() {
                                var a = $(this);
                                e[a.attr("name")] && a.val(e[a.attr("name")])
                            }), !0
                        },
                        lengthMenu: [
                            [10, 20, 50, 100, 150, -1],
                            [10, 20, 50, 100, 150, "All"]
                        ],
                        "aoColumns": [
                            {"bSortable": true},
                            {"bSortable": true},
                            {"bSortable": true},
                            {"bSortable": false}
                        ],
                        pageLength: 10,

                        ajax: {
                            url: "",
                            "type": "GET",
                        }
                    }
                }), a.getTableWrapper().on("click", ".table-group-action-submit", function(e) {
                    e.preventDefault();
                    var t = $(".table-group-action-input", a.getTableWrapper());
                    "" != t.val() && a.getSelectedRowsCount() > 0 ? (a.setAjaxParam("customActionType", "group_action"), a.setAjaxParam("customActionName", t.val()), a.setAjaxParam("id", a.getSelectedRows()), a.getDataTable().ajax.reload(), a.clearAjaxParams()) : "" == t.val() ? App.alert({
                        type: "danger",
                        icon: "warning",
                        message: "Please select an action",
                        container: a.getTableWrapper(),
                        place: "prepend"
                    }) : 0 === a.getSelectedRowsCount() && App.alert({
                        type: "danger",
                        icon: "warning",
                        message: "No record selected",
                        container: a.getTableWrapper(),
                        place: "prepend"
                    })
                })
            }
        return {
            init: function() {
                a(), e()
            }
        }
    }();
    TableDatatablesAjax.init();

    //$('#datatable_ajax_wrapper').children('.row:first').remove();
}*/

function draw_manage_jobs_table(column_sort = null)
{   
    var TableDatatablesAjax = function() {
        var a = function() {
                $(".date-picker").datepicker({
                    rtl: App.isRTL(),
                    autoclose: !0
                })
            },
            e = function() {
                var a = new Datatable;
                a.init({
                    src: $("#datatable_ajax"),
                    onSuccess: function(a, e) {},
                    onError: function(a) {},
                    onDataLoad: function(a) {},
                    loadingMessage: "Loading...",
                    dataTable: {
                        bStateSave: false,
                        searching : true,
                        "dom": "Bfrtip",
                        buttons: [ 
                            {
                                extend: "excel",
                                className: "btn green active btn-outline btn-circle",
                                text: "<span><i class='fa fa-download'></i> Excel</span>",
                                title: "jobs",
                                autoFilter: true,
                                exportOptions: {
                                    columns: [0,1,2,3,4,5,6,7,8,9,10,11,12]
                                }
                            }
                        ],
                        fnStateSaveParams: function(a, e) {
                            return $("#datatable_ajax tr.filter .form-control").each(function() {
                                e[$(this).attr("name")] = $(this).val()
                            }), e
                        },
                        fnStateLoadParams: function(a, e) {
                            return $("#datatable_ajax tr.filter .form-control").each(function() {
                                var a = $(this);
                                e[a.attr("name")] && a.val(e[a.attr("name")])
                            }), !0
                        },
                        lengthMenu: [
                            [10, 20, 50, 100, 150, -1],
                            [10, 20, 50, 100, 150, "All"]
                        ],
                        "aoColumns": [
                            {"bSortable": true},
                            {"bSortable": true},
                            {"bSortable": true},
                            {"bSortable": true},
                            {"bSortable": true},
                            {"bSortable": true},
                            {"bSortable": true},
                            {"bSortable": true},
                            {"bSortable": true},
                            {"bSortable": true},
                            {"bSortable": true},
                            {"bSortable": true},
                            {"bSortable": true},
                            {"bSortable": true}
                        ],
                        pageLength: 10,

                        "order": [
                            [11,"desc"]
                        ],
                        
                        ajax: {
                            url: "",
                            "type": "GET",
                        }
                    }
                }), a.getTableWrapper().on("click", ".table-group-action-submit", function(e) {
                    e.preventDefault();
                    var t = $(".table-group-action-input", a.getTableWrapper());
                    "" != t.val() && a.getSelectedRowsCount() > 0 ? (a.setAjaxParam("customActionType", "group_action"), a.setAjaxParam("customActionName", t.val()), a.setAjaxParam("id", a.getSelectedRows()), a.getDataTable().ajax.reload(), a.clearAjaxParams()) : "" == t.val() ? App.alert({
                        type: "danger",
                        icon: "warning",
                        message: "Please select an action",
                        container: a.getTableWrapper(),
                        place: "prepend"
                    }) : 0 === a.getSelectedRowsCount() && App.alert({
                        type: "danger",
                        icon: "warning",
                        message: "No record selected",
                        container: a.getTableWrapper(),
                        place: "prepend"
                    })
                })
            }
        return {
            init: function() {
                a(), e()
            }
        }
    }();
    TableDatatablesAjax.init();
}

function draw_normal_datatable(sort_arr)
{
    var grid,ServiceDatatablesAjax = function () {
    
        var handleDemo = function () {

         grid = new Datatable();

            grid.init({
                src: $("#datatable_ajax"),
                onSuccess: function (grid, response) {
                    // grid:        grid object
                    // response:    json object of server side ajax response
                    // execute some code after table records loaded
                },
                onError: function (grid) {
                    // execute some code on network or other general error  
                },
                onDataLoad: function (grid) {
                    // execute some code on ajax data load
                },
                loadingMessage: 'Loading...',
                dataTable: {
                    // save datatable state(pagination, sort, etc) in cookie.
                    "bStateSave": false,
                    "bSort": true,
                    destroy: true,

                   "dom": "<'table-group-actions d-flex'><'table-responsive't><'pagination-wrap'pl>",
                    // save custom filters to the state
                    "fnStateSaveParams": function (oSettings, sValue) {
                        $("#datatable_ajax tr.filter .form-control").each(function () {
                            sValue[$(this).attr('name')] = $(this).val();
                        });

                        return sValue;
                    },
                    // read the custom filters from saved state and populate the filter inputs
                    "fnStateLoadParams": function (oSettings, oData) {
                        //Load custom filters
                        $("#datatable_ajax tr.filter .form-control").each(function () {
                            var element = $(this);
                            if (oData[element.attr('name')]) {
                                element.val(oData[element.attr('name')]);
                            }
                        });

                        return true;
                    },
                    "lengthMenu": [
                        [10, 20, 50, 100, 150, -1],
                        [10, 20, 50, 100, 150, "All"] // change per page values here
                    ],
                    "aoColumns": sort_arr,
                    "pageLength": 10, // default record count per page
                    "ajax": {
                         // ajax 
                        "url" : "",
                        'type':'get'
                    },
                    "order": default_sort_column
                }
            });

            // handle group actionsubmit button click
            grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {

                e.preventDefault();

                var action = $(".table-group-action-input", grid.getTableWrapper());
                
                if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
                    grid.setAjaxParam("customActionType", "group_action");
                    grid.setAjaxParam("customActionName", action.val());
                    grid.setAjaxParam("id", grid.getSelectedRows());
                    grid.getDataTable().ajax.reload();
                    grid.clearAjaxParams();
                }
                else if (action.val() == "") {
                    App.alert({
                        type: 'danger',
                        icon: 'warning',
                        message: 'Please select an action',
                        container: grid.getTableWrapper(),
                        place: 'prepend'
                    });
                }
                else if (grid.getSelectedRowsCount() === 0) {
                    App.alert({
                        type: 'danger',
                        icon: 'warning',
                        message: 'No record selected',
                        container: grid.getTableWrapper(),
                        place: 'prepend'
                    });
                }
            });
        }

        return {
            //main function to initiate the module
            init: function () {

                handleDemo();
            }
        };
    }();

    jQuery(document).ready(function () {
        ServiceDatatablesAjax.init();
    });
}

function datatable_with_export(sort_arr,default_sort_column,export_columns,file_name = 'downloads',hide_columns = [])
{
    var grid,ServiceDatatablesAjax = function () {
        
        var handleDemo = function () {

         grid = new Datatable();

            grid.init({
                src: $("#datatable_ajax"),
                onSuccess: function (grid, response) {
                    // grid:        grid object
                    // response:    json object of server side ajax response
                    // execute some code after table records loaded
                },
                onError: function (grid) {
                    // execute some code on network or other general error  
                },
                onDataLoad: function (grid) {
                    // execute some code on ajax data load
                },
                loadingMessage: 'Loading...',
                dataTable: {
                    // save datatable state(pagination, sort, etc) in cookie.
                    "bStateSave": false,
                    "bSort": true,
                    destroy: true,

                    //"dom": "<'table-group-actions d-flex'><'table-responsive't><'pagination-wrap'pl>",

                    "dom": "<'actions-wrap payout-actions'<'table-group-actions d-flex'>B><'table-responsive't><'pagination-wrap'pl>",
                    buttons: [ 
                        {
                            extend: "csv",
                            className: "btn yellow btn-outline ",
                            text: "<span><i class='fa fa-download'></i> Export CSV</span>",
                            title: file_name,
                            exportOptions: {
                                columns: export_columns
                            }
                        }
                    ],

                    // save custom filters to the state
                    "fnStateSaveParams": function (oSettings, sValue) {
                        $("#datatable_ajax tr.filter .form-control").each(function () {
                            sValue[$(this).attr('name')] = $(this).val();
                        });

                        return sValue;
                    },
                    // read the custom filters from saved state and populate the filter inputs
                    "fnStateLoadParams": function (oSettings, oData) {
                        //Load custom filters
                        $("#datatable_ajax tr.filter .form-control").each(function () {
                            var element = $(this);
                            if (oData[element.attr('name')]) {
                                element.val(oData[element.attr('name')]);
                            }
                        });

                        return true;
                    },
                    "lengthMenu": [
                        [10, 20, 50, 100, 150, -1],
                        [10, 20, 50, 100, 150, "All"] // change per page values here
                    ],
                    "aoColumns": sort_arr,
                    "pageLength": 10, // default record count per page
                    "ajax": {
                         // ajax 
                        "url" : "",
                        "type":'get'
                    },
                    "order": default_sort_column,
                    "columnDefs": hide_columns,
                }
            });
        }
        
        return {
            //main function to initiate the module
            init: function () {

                handleDemo();
            }

        };

    }();

    jQuery(document).ready(function () {
        ServiceDatatablesAjax.init();
        //$('.filter-submit').trigger('click');
    });
}

function draw_ajax_table_with_export(sorts,export_column,default_sort_column = 0,download_excel_file_name="download")
{   
    var TableDatatablesAjax = function() {
        var a = function() {
                $(".date-picker").datepicker({
                    rtl: App.isRTL(),
                    autoclose: !0
                })
            },
            e = function() {
                var a = new Datatable;
                a.init({
                    src: $("#datatable_ajax"),
                    onSuccess: function(a, e) {},
                    onError: function(a) {},
                    onDataLoad: function(a) {},
                    loadingMessage: "Loading...",
                    dataTable: {
                        bStateSave: false,
                        searching : false,
                        "dom": "Bfrtip",
                        buttons: [ 
                            {
                                extend: "excel",
                                className: "btn green active btn-outline btn-circle",
                                text: "<span><i class='fa fa-download'></i> Export CSV</span>",
                                title: download_excel_file_name,
                                autoFilter: true,
                                exportOptions: {
                                    columns: export_column
                                }
                            }
                        ],
                        fnStateSaveParams: function(a, e) {
                            return $("#datatable_ajax tr.filter .form-control").each(function() {
                                e[$(this).attr("name")] = $(this).val()
                            }), e
                        },
                        fnStateLoadParams: function(a, e) {
                            return $("#datatable_ajax tr.filter .form-control").each(function() {
                                var a = $(this);
                                e[a.attr("name")] && a.val(e[a.attr("name")])
                            }), !0
                        },
                        lengthMenu: [
                            [10, 20, 50, 100, 150, -1],
                            [10, 20, 50, 100, 150, "All"]
                        ],
                        "aoColumns": sorts ,
                        pageLength: 10,
                        "order": [
                            [default_sort_column,"desc"]
                        ],

                        ajax: {
                            url: "",
                            "type": "GET",
                        }
                    }
                }), a.getTableWrapper().on("click", ".table-group-action-submit", function(e) {
                    e.preventDefault();
                    var t = $(".table-group-action-input", a.getTableWrapper());
                    "" != t.val() && a.getSelectedRowsCount() > 0 ? (a.setAjaxParam("customActionType", "group_action"), a.setAjaxParam("customActionName", t.val()), a.setAjaxParam("id", a.getSelectedRows()), a.getDataTable().ajax.reload(), a.clearAjaxParams()) : "" == t.val() ? App.alert({
                        type: "danger",
                        icon: "warning",
                        message: "Please select an action",
                        container: a.getTableWrapper(),
                        place: "prepend"
                    }) : 0 === a.getSelectedRowsCount() && App.alert({
                        type: "danger",
                        icon: "warning",
                        message: "No record selected",
                        container: a.getTableWrapper(),
                        place: "prepend"
                    })
                })
            }
        return {
            init: function() {
                a(), e()
            }
        }
    }();
    TableDatatablesAjax.init();
}


