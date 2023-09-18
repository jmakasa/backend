app.controller('EmailsCtrl', [
    '$scope', 'dataFactory', '$window', '$sce', '$filter',
    function ProductCtrl($scope, dataFactory, $window, $sce, $filter) {
        const $ctrl = this;
        $scope.message = 'Product PAGE - AngularJS lang : ' + document.documentElement.getAttribute("lang");
        $scope.listsOptions = [];
        $scope.frmCreateProduct = [];
        $scope.frmWebSettings = ["isNew,isUpcoming"];
        $scope.addTaskformData = [];
        $scope.datevalue = "";
        $scope.tasksFormSettings = [];
        $scope.currentDate = new Date();
        var optLangs =[];

        // get lang
        if ($window.sessionStorage.lang) {
            $scope.lang = $window.sessionStorage.lang;
        } else {
            $scope.lang = document.documentElement.getAttribute("lang");
        }
        const emailBoxHeaderTpl = "<table class='table table-striped  table-bordered border-orange'><tr><td>From</td><td>REPLACE_FROM</td></tr><tr><td>Date</td><td>REPLACE_DATE</td></tr><tr><td>Subject</td><td>REPLACE_SUBJECT</td></tr><tr><td>Contact Reason</td><td>REPLACE_REASON</td></tr><tr><td>Office Service</td><td>REPLACE_OFFICE</td></tr><tr><td>Phone</td><td>REPLACE_PHONE</td></tr><tr><td>IP</td><td>REPLACE_IP</td></tr><tr><td>Region</td><td>REPLACE_REGION</td></tr>";
        const emailBoxContentTpl = "<tr><td colspan='2'>Content</td></tr><tr><td colspan='2'>REPLACE_CONTENT</td></tr></table>"
        const attachmentBox = "<table class='table table-striped'>REPLACE_DATA</table>";
        const attachmentBoxRow = "<tr><td><a href='REPLACE_LINK' target='_blank'>REPLACE_FILENAME</a></td></tr>";

        function closeEmailBox() {
            $('#dlgEmailContent').dialog('close');
            $('#emailBox').html("");
        }

        // load init
        $ctrl.$onInit = () => {
            // get lang
            $scope.lang = document.documentElement.getAttribute("lang");


            dataFactory.getTasksFormSettings().then(function (resp) {
               // console.log(resp);
                $scope.tasksFormSettings = resp.data;
            });

            // easyui datagrid
            $('#emailList').datagrid({
                title: 'Email Listing',
                singleSelect: true,
                pagination: false,
                pageSize: 50,
                view: scrollview,
                height: 800,
                idField: 'data.id',
                url: "/marketing/backend/index.php/" + lang + '/api/email_contactus/list',
                columns: [
                    [{
                            field: 'id',
                            title: 'ID',
                            width: '5%',
                            sortable: true,
                            align: 'center'
                        },
                        {
                            field: 'contact_reason',
                            title: 'Contact Reason',
                            width: '15%',
                            sortable: true,
                            align: 'center'
                        },
                        {
                            field: 'firstname',
                            title: 'Firstname',
                            width: '10%',
                            sortable: true
                        },
                        {
                            field: 'lastname',
                            title: 'Lastname',
                            width: '10%',
                            sortable: true
                        },
                        {
                            field: 'subject',
                            title: 'Subject',
                            width: '40%',
                            sortable: true,
                            formatter: function (value, row, index) {
                                  console.log(row);
                                if (row.attachments) {
                                    return value + '<i class="bi bi-paperclip float-end"></i>';
                                } else {
                                    return value;
                                }
                            }
                        },
                        //<i class="bi bi-paperclip"></i>
                        {
                            field: 'region',
                            title: 'Region',
                            width: '10%',
                            sortable: true
                        },
                        {
                            field: 'tstatus',
                            title: 'Task Status',
                            width: '10%',
                            sortable: true
                        }
                    ]
                ],
                onClickRow: function (rowIndex, row) {
                    $('#emailBox').html("");
                    $('#attachmentsBox').html("");
                    var fd = new FormData();
                    fd.append('id', row.id);
                    $.ajax({
                        // url: 'manemail_contactus.php?action=get_email_by_id',
                        url: "/marketing/backend/index.php/" + lang + '/api/email_contactus/detail',
                        type: 'post',
                        data: fd,
                        async: true,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function (response) {
                            if (response.result) {
                                $scope.addTaskformData = response.email;
                                let boxContentHeader = emailBoxHeaderTpl;
                                boxContentHeader = boxContentHeader.replace(/REPLACE_FROM/g, $scope.addTaskformData.email);
                                boxContentHeader = boxContentHeader.replace(/REPLACE_DATE/g, $scope.addTaskformData.created_at);
                                boxContentHeader = boxContentHeader.replace(/REPLACE_SUBJECT/g, $scope.addTaskformData.subject);
                                boxContentHeader = boxContentHeader.replace(/REPLACE_REASON/g, $scope.addTaskformData.contact_reason);
                                $scope.addTaskformData.fullname = $scope.addTaskformData.firstname + " " + $scope.addTaskformData.lastname
                                boxContentHeader = boxContentHeader.replace(/REPLACE_NAME/g, $scope.addTaskformData.fullname);
                                boxContentHeader = boxContentHeader.replace(/REPLACE_PHONE/g, $scope.addTaskformData.phone);
                                boxContentHeader = boxContentHeader.replace(/REPLACE_OFFICE/g, $scope.addTaskformData.office_service);
                                boxContentHeader = boxContentHeader.replace(/REPLACE_IP/g, $scope.addTaskformData.ip);
                                boxContentHeader = boxContentHeader.replace(/REPLACE_REGION/g, $scope.addTaskformData.region);
                                let boxContentContent = emailBoxContentTpl;
                                boxContentContent = boxContentContent.replace(/REPLACE_CONTENT/g, $scope.addTaskformData.description);

                                boxContentHeader += boxContentContent;

                                $("#emailBox").append(boxContentHeader);
                                //    $('#dlgEmailContent').dialog('open');

                                if ($scope.addTaskformData.attachments) {
                                    let attBoxRow = attachmentBoxRow;
                                    let filname = $scope.addTaskformData.attachments.split('/').reverse()[0];
                                    attBoxRow = attBoxRow.replace(/REPLACE_LINK/g, $scope.addTaskformData.attachments);
                                    attBoxRow = attBoxRow.replace(/REPLACE_FILENAME/g, filname);
                                    let attBox = attachmentBox;
                                    attBox = attBox.replace(/REPLACE_DATA/g, attBoxRow);
                                    $("#attachmentsBox").append(attBox);
                                } else {
                                    $("#attachmentsBox").append('No Attachments');
                                }

                            } else {
                                console.log('error');
                            }

                        }
                    });

                    // ajax call 
                },
            });

        } // end init

        $scope.addTaskModal = function () {
            $scope.addTaskformData.submitting = true;
            $scope.addTaskformData.descriptionHTML = $sce.trustAsHtml($scope.addTaskformData.description);
            $("#atf_task_desc").summernote({
                height: '150px',
                callbacks: {
                    onChange: function (contents, $editable) {
                        if (contents) {
                            addTaskFrm.task_desc.$valid = true;
                        }
                        $scope.addTaskformData.task_desc = contents;
                    },
                }
            });

            $scope.addTaskformData.start_datetime = $filter('date')($scope.currentDate, "yyyy-MM-dd");
            $scope.addTaskformData.tstatus = $scope.tasksFormSettings.status[0];
            $('#addTaskFormModal').modal('show');

        }

        $scope.submitAddTask = function () {
            // make sure the task desc validation
            if ($scope.addTaskformData.task_desc == null || $scope.addTaskformData.task_desc == undefined || $scope.addTaskformData.task_desc == "" || $scope.addTaskformData.task_desc.lenght == 0) {
                $scope.addTaskformData.validate_task_desc = false;
            } else {
                $scope.addTaskformData.validate_task_desc = true;
            }
            updateValidateTaskForm();

            if ($scope.addTaskformData.submitting && $scope.addTaskformData.validate_task_desc && $scope.addTaskformData.validate_assignee && $scope.addTaskformData.validate_start_datetime) {
                dataFactory.addNewTasks($scope.addTaskformData).then(function (resp) {
                    console.log(resp);
                    $scope.addTaskformData.submitting = false;
                    $scope.addTaskformData.tstatus = '';
                    $scope.addTaskformData.task_desc = '';
                    $scope.addTaskformData.start_datetime = '';
                    $scope.addTaskformData.due_datetime = '';
                    $scope.addTaskformData.assignee = '';
                    $('#addTaskFormModal').modal('hide');
                });
            }

        }


        $scope.$watch('addTaskformData.tstatus', function () {
            // console.log('has changed addTaskformData.tstatus');
            // console.log($scope.addTaskformData.task_desc);
            if ($scope.addTaskformData.tstatus == null || $scope.addTaskformData.tstatus == undefined || $scope.addTaskformData.tstatus == "" || $scope.addTaskformData.tstatus.lenght == 0) {
                $scope.addTaskformData.validate_tstatus = false;
            } else {
                $scope.addTaskformData.validate_tstatus = true;
            }
            updateValidateTaskForm();
        });

        $scope.$watch('addTaskformData.task_desc', function () {
            // console.log('has changed addTaskformData.task_desc');
            // console.log($scope.addTaskformData.task_desc);
            if ($scope.addTaskformData.task_desc == null || $scope.addTaskformData.task_desc == undefined || $scope.addTaskformData.task_desc == "" || $scope.addTaskformData.task_desc.lenght == 0) {
                $scope.addTaskformData.validate_task_desc = false;
            } else {
                $scope.addTaskformData.validate_task_desc = true;
            }
            updateValidateTaskForm();
        });
        $scope.$watch('addTaskformData.start_datetime', function () {
            // console.log('has changed addTaskformData.start_datetime');
            // console.log($scope.addTaskformData.start_datetime);
            if ($scope.addTaskformData.start_datetime == null || $scope.addTaskformData.start_datetime == undefined || $scope.addTaskformData.start_datetime == "" || $scope.addTaskformData.start_datetime.lenght == 0) {
                $scope.addTaskformData.validate_start_datetime = false;
            } else {
                $scope.addTaskformData.validate_start_datetime = true;
            }
            updateValidateTaskForm();
        });
        $scope.$watch('addTaskformData.assignee', function () {
            // console.log('has changed addTaskformData.assignee');
            // console.log($scope.addTaskformData.assignee);
            if ($scope.addTaskformData.assignee == null || $scope.addTaskformData.assignee == undefined || $scope.addTaskformData.assignee == "" || $scope.addTaskformData.assignee.lenght == 0) {
                $scope.addTaskformData.validate_assignee = false;
            } else {
                $scope.addTaskformData.validate_assignee = true;
            }
            updateValidateTaskForm();
        });

        function updateValidateTaskForm() {
            if ($scope.addTaskformData.validate_task_desc && $scope.addTaskformData.validate_assignee && $scope.addTaskformData.validate_start_datetime && $scope.addTaskformData.validate_tstatus) {
                $scope.addTaskformData.submitting = true;
            } else {
                $scope.addTaskformData.submitting = false;
            }
            // console.log($scope.addTaskformData.submitting);
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
