app.controller('CustomerServicesCtrl', [
    '$scope', 'dataFactory', '$window', '$sce', '$filter', 'constFactory',
    function CustomerServicesCtrl($scope, dataFactory, $window, $sce, $filter, constFactory) {
        const $ctrl = this;
        $scope.config = _config;
        $scope.listsOptions = [];
        $scope.frmCreateProduct = [];
        $scope.frmWebSettings = ["isNew,isUpcoming"];
        $scope.optionContactReason = [];
        $scope.addTicketformData = {
            "id": '',
            "post_date": "",
            "contact_reason": "",
            "firstname": "",
            "lastname": "",
            "office_service": "",
            "email": "",
            "phone": "",
            "subject": "",
            "description": " ",
            "attachments": "",
            "ip": "",
            "region": "",
            "status": '',
            "created_at": ""
        };
        $scope.attachmentSrc = {};
        $scope.datevalue = "";
        $scope.ticketsFormSettings = [];
        $scope.currentDate = new Date();
        var optLangs = [];
        $scope.showAddTicketBtn = false;

        // get lang
        if ($window.sessionStorage.lang) {
            $scope.lang = $window.sessionStorage.lang;
        } else {
            $scope.lang = document.documentElement.getAttribute("lang");
        }

        // load init
        $ctrl.$onInit = () => {
            angular.element(document).ready(function () {
                // get ticket settings
                dataFactory.getTicketsFormSettings().then(function (resp) {
                    $scope.ticketsFormSettings = resp.data;
                    console.log($scope.ticketsFormSettings);
                    // define ticket type
                    $('#searchTicketType').combobox({
                        width: 265,
                        data: $scope.ticketsFormSettings.optType,
                        valueField: 'value', textField: 'text',
                        label: 'Contact Reason :', labelWidth: '105px', labelAlign: 'right',
                        onChange: function (value) {
                            $scope.doSearch();
                        },
                    });
                    $('#searchTicketType').combobox('setValue', 'ALL');
                    // END define ticket type
                    // define ticket status
                    $('#searchTicketStatus').combobox({
                        width: 265,
                        data: $scope.ticketsFormSettings.optStatus,
                        valueField: 'value', textField: 'text',
                        label: 'Status :', labelWidth: '105px', labelAlign: 'right',
                        onChange: function (value) {
                            $scope.doSearch();
                        },
                    });
                    $('#searchTicketStatus').combobox('setValue', 'ALL');
                    // END define ticket status
                    // define ticket assignee
                    $('#searchTicketAssignee').combobox({
                        width: 265,
                        data: $scope.ticketsFormSettings.optAssignees,
                        valueField: 'id', textField: 'name',
                        label: 'Assignee :', labelWidth: '105px', labelAlign: 'right',
                        onChange: function (value) {
                            $scope.doSearch();
                        },
                    });
                    $('#searchTicketAssignee').combobox('setValue', 'ALL');
                    // END define ticket assignee
                });

                // easyui datagrid ticketList 
                $('#ticketList').datagrid({
                    // title: 'Ticket Listing ( Double click the check the detail )',
                    toolbar: '#allTicketListtoolbar',
                    singleSelect: true,
                    pagination: false,
                    pageSize: 50,
                    view: scrollview,
                    height: 700,
                    idField: 'data.id',
                    url: "/backend/index.php/" + $scope.lang + '/api/tickets/list',
                    columns: [
                        [
                            { field: 'id', title: 'ID', width: '5%', sortable: true, align: 'center' },
                            {
                                field: 'subject', title: 'Subject', width: '30%', sortable: true,
                                formatter: function (value, row, index) {
                                    //      console.log(row);
                                    if (row.attachments) {
                                        return value + '<i class="bi bi-paperclip float-end"></i>';
                                    } else {
                                        return value;
                                    }
                                }
                            },
                            //             //<i class="bi bi-paperclip"></i>
                            { field: 'from_firstname', title: 'Firstname', width: '7%', sortable: true },
                            { field: 'from_lastname', title: 'Lastname', width: '7%', sortable: true },
                            { field: 'from_email', title: 'Email', width: '20%', sortable: true },
                            {
                                field: 'start_datetime', title: 'Start Date', width: '8%', sortable: true,
                                formatter: function (value, row, index) {
                                    if (value) {
                                        return $filter('date')(new Date(value), "yyyy-MM-dd");
                                    } else {
                                        return '';
                                    }

                                }
                            },
                            {
                                field: 'assignee_id', title: 'Assignee', width: '10%', sortable: true,
                                formatter: function (value, row, index) {
                                    //return value;
                                     if (value) {
                                        var objAssignee = $filter('getById')($scope.ticketsFormSettings.assignees, value);
                                        return objAssignee.name;
                                    } else {
                                        return '';
                                    }
                                }
                            },
                            {
                                field: 'status', title: 'Status', width: '8%', sortable: true,
                                formatter: function (value, row, index) {
                                    return dataFactory.ticketStatusButton(value);
                                }
                            },
                            // { field: 'action', title: 'Action', width: '5%', sortable: false,
                            //     formatter: function (value, row, index) {
                            //          return '<a href="#" class="btn btn-sm btn-orange" ng-click="addTicketModal('+row.id+')"><i class="bi bi-pencil"></i></a>';
                            //     }
                            // },
                        ]
                    ],
                    onSelect: function (idx, row) {
                        $scope.addTicketformData = row;
                        //$scope.addTicketformData.id = row.id;

                    },
                    onDblClickRow: function (rowIndex, row) {
                        OpenInNewTab("/backend/index.php/" + $scope.lang + "/tickets/detail/" + row.id);
                    }
                });
                // easyui datagrid ticketList 
                $('#ticketRecentUpdatedList').datagrid({
                    // title: 'Ticket Listing ( Double click the check the detail )',
                    //    toolbar: '#allTicketListtoolbar',
                    singleSelect: true,
                    pagination: false,
                    pageSize: 10,
                    view: scrollview,
                    height: '350',
                    idField: 'data.id',
                    url: "/backend/index.php/" + $scope.lang + '/api/tickets/recent_updated/list',
                    columns: [
                        [
                            {
                                field: 'subject', title: 'Subject', width: '60%', sortable: true,
                                formatter: function (value, row, index) {
                                    if (row.attachments) {
                                        return value + '<i class="bi bi-paperclip float-end"></i>';
                                    } else {
                                        return value;
                                    }
                                }
                            },
                            {
                                field: 'assignee_id', title: 'Assignee', width: '20%', sortable: true,
                                formatter: function (value, row, index) {
                                    if (value) {
                                        var objAssignee = $filter('getById')($scope.ticketsFormSettings.assignees, value);
                                        return objAssignee.name;
                                    } else {
                                        return '';
                                    }

                                }
                            },
                            {
                                field: 'status', title: 'Status', width: '20%', sortable: true,
                                formatter: function (value, row, index) {
                                    return dataFactory.ticketStatusButton(value);

                                }
                            },

                        ]
                    ],
                    onSelect: function (idx, row) {
                        $scope.addTicketformData = row;
                        //$scope.addTicketformData.id = row.id;

                    },
                    onDblClickRow: function (rowIndex, row) {
                        OpenInNewTab("/backend/index.php/" + $scope.lang + "/tickets/detail/" + row.id);
                    }
                });

                // mentioned
                $('#youBeenMentionedList').datagrid({
                    // title: 'Ticket Listing ( Double click the check the detail )',
                    //    toolbar: '#allTicketListtoolbar',
                    singleSelect: true,
                    pagination: false,
                    pageSize: 10,
                    view: scrollview,
                    height: '350',
                    idField: 'data.id',
                    url: "/backend/index.php/" + $scope.lang + '/api/mentioned/list_by_employees_id',
                    queryParams: {
                        users_id: $scope.config.user_id,
                        type: 'ticket_notes'
                    },
                    columns: [
                        [
                            {
                                field: 'id', title: 'ID', width: '10%', sortable: true,
                                formatter: function (value, row, index) {
                                    return row.data.ticket.id;
                                }
                            },
                            {
                                field: 'type', title: 'Ticket Note', width: '90%', sortable: true,
                                formatter: function (value, row, index) {
                                    return row.data.ticket.subject +" "+dataFactory.ticketStatusButton(row.data.ticket.status);
                   
                                }
                            },
                            
                        ]
                    ],
                    onDblClickRow: function (rowIndex, row) {
                        console.log(row);
                        OpenInNewTab("/backend/index.php/" + $scope.lang + "/tickets/detail/" + row.data.ticket.id+"#collapse"+row.collapse_idx);
                    }
                });
            });
        } // end init

        $scope.doSearch = function () {
            $('#ticketList').datagrid('load', {
                type: $('#searchTicketType').val(),
                status: $('#searchTicketStatus').val(),
                assignee_id: $('#searchTicketAssignee').val()
            });
        }

        $scope.showTicketModal = function () {
            $scope.addTicketformData.submitting = true;
            $scope.addTicketformData.descriptionHTML = $sce.trustAsHtml($scope.addTicketformData.description);
            $scope.addTicketformData.assignee = $filter('getById')($scope.ticketsFormSettings.assignees, $scope.addTicketformData.assignee_id);
            $scope.addTicketformData.tstatus = $filter('getByValue')($scope.ticketsFormSettings.status, $scope.addTicketformData.status);
            $scope.addTicketformData.start_datetime = $filter('date')($scope.currentDate, "yyyy-MM-dd");
            $("#atf_ticket_desc").summernote({
                height: '150px',
                callbacks: {
                    onChange: function (contents, $editable) {
                        if (contents) {
                            ticketFrm.ticket_desc.$valid = true;
                        }
                        $scope.addTicketformData.ticket_desc = contents;
                    },
                }
            });

            
            //  $scope.addTicketformData.tstatus = $scope.ticketsFormSettings.status[0];

            console.log($scope.addTicketformData);
            setTimeout(function () {
                $('#ticketFormModal').modal('show');
            }, 0);
        }

        $scope.submitAddTicket = function () {
            $scope.addTicketformData.submitted = true;
            if ($scope.addTicketformData.ticket_desc) {
                dataFactory.updateTicketDetail($scope.addTicketformData).then(function (resp) {
                    $scope.addTicketformData.submitted = false;
                    $scope.addTicketformData.tstatus = '';
                    $scope.addTicketformData.ticket_desc = '';
                    $scope.addTicketformData.start_datetime = '';
                    $scope.addTicketformData.due_datetime = '';
                    $scope.addTicketformData.assignee = '';
                    $('#ticketFormModal').modal('hide');
                    $('#ticketList').datagrid("reload");
                    $('#ticketRecentUpdatedList').datagrid("reload");
                });
            }

        }

        $scope.resetFilter = function () {
            $('#searchTicketType').combobox('setValue', 'ALL');
            $('#searchTicketStatus').combobox('setValue', 'ALL');
            $('#searchTicketAssignee').combobox('setValue', 'ALL');
            $('#ticketList').datagrid("reload");
        }



        $scope.formatDate = function (date) {
            function pad(n) {
                return n < 10 ? '0' + n : n;
            }

            return date && date.getFullYear() +
                '-' + pad(date.getMonth() + 1) +
                '-' + pad(date.getDate());
        };

        $scope.parseDate = function (s) {
            var tokens = /^(\d{4})-(\d{2})-(\d{2})$/.exec(s);

            return tokens && new Date(tokens[1], tokens[2] - 1, tokens[3]);
        };
    }


]);
