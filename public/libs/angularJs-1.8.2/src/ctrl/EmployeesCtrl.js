app.controller('EmployeesCtrl', [
    '$scope', 'dataFactory', '$window', '$sce', '$filter', 'constFactory', '$timeout','authFactory','$rootScope',
    function EmployeesCtrl($scope, dataFactory, $window, $sce, $filter, constFactory, $timeout,authFactory,$rootScope) {
        const $ctrl = this;
        $scope.frmWebSettings = ["isNew,isUpcoming"];
        $scope.frmSettings = [];
        $scope.newDeparmentFormData = {};
        $scope.editDeparmentFormData = {};
        $scope.selectedDept = {};
        $scope.selectedEmpl = {};
        $scope.newEmplFormData = {};
        $scope.editEmplFormData = {};

        // get lang
        if ($window.sessionStorage.lang) {
            $scope.lang = $window.sessionStorage.lang;
        } else {
            $scope.lang = document.documentElement.getAttribute("lang");
        }

        // load init
        $ctrl.$onInit = () => {
            dataFactory.getEmployeeSettings().then(function (resp) {
                console.log(resp);
                $scope.frmSettings = resp.data;
            });
            // easyui datagrid employeeList 
            $timeout(function () {
                $('#employeesList').datagrid({
                    title: 'Employee Listing ( Double click the check the detail )',
                    toolbar: '#employeesListToolbar',
                    singleSelect: true,
                    pagination: false,
                    pageSize: 50,
                    view: scrollview,
                    height: 750,
                    idField: 'data.id',
                    url: "/marketing/backend/index.php/" + $scope.lang + '/api/employees/list/get',
                    columns: [
                        [
                            { field: 'id', title: 'ID', width: '5%', sortable: true, align: 'center' },
                            { field: 'name', title: 'Name', width: '15%', sortable: true },
                            { field: 'username', title: 'Username', width: '15%', sortable: true },
                            { field: 'email', title: 'Email', width: '30%', sortable: true },
                            { field: 'location', title: 'Location', width: '8%', sortable: true },
                            { field: 'position', title: 'Position', width: '13%', sortable: true },
                            { field: 'status', title: 'Status', width: '10%', sortable: true },
                        ]
                    ],
                    onClickRow: function (idx, row) {
                        $scope.selectedEmpl = row;
                    },
                    onDblClickRow: function (rowIndex, row) {
                        console.log(" onDblClickRow");
                        //OpenInNewTab("/backend/index.php/"+$scope.lang+"/tasks/detail/"+row.id);
                    }
                });
            }, 500);

            $('#departmentsTree').tree({
                //navmenuOpenListUrl
                url: "/marketing/backend/index.php/" + $scope.lang + '/api/employee_depts/get/open',
                method: "GET",
                animate: true,
                formatter: function (node) {
                    //      console.log(node);
                    if (node.status == 'Active') {
                        var s = node.name;
                        if (node.children && node.children.length > 0) {
                            s += '&nbsp;<i class="icon-check2">&nbsp;&nbsp;&nbsp;&nbsp;</i><span style=\'color:blue\'>(' + node.children.length + ')</span>';
                        } else {
                            s += '&nbsp;<i class="icon-check2">&nbsp;&nbsp;&nbsp;&nbsp;</i>';
                        }
                        return s;
                    } else {
                        var s = node.name;
                        s += '&nbsp;<i class="icon-x-circle">&nbsp;&nbsp;&nbsp;&nbsp;</i>';
                        return s;
                    }
                },
                onBeforeLoad: function (node, param) {
                    if (node != null && node.children.length === 0) {
                        return false;
                    }
                },
                onClick: function (data) {
                    $scope.selectedDept = data;
                }
            });
            // end easyui datagrid employeeList 
        } // end init

        // START department add, edit, delete
        $scope.addDeptModal = function () {
            $scope.newDeparmentFormData.submitting = false;
            $('#addDeptFormModal').modal('show');
        }

        $scope.editDeptModal = function () {
            // get department data
            if ($filter('isEmptyData')($scope.selectedDept, 'id')) {
                dataFactory.getEmployeeDepartmentDetail($scope.selectedDept).then(function (resp) {
                    if (resp.status == 200 && resp.data) {
                        $timeout(function () {
                            $scope.editDeparmentFormData = resp.data;
                            $scope.editDeparmentFormData.parent_department = $filter('getByValue')($scope.frmSettings.departments, $scope.editDeparmentFormData.parent_id);
                            $('#editDeptFormModal').modal('show');
                        }, 100);
                    } else {
                        alert(" Failed to request ");
                    }
                });
            } else {
                $scope.errContent = "Please select one of departments and try again.";
                $('#noSelectionModal').modal('show');
            }
        }

        $scope.delDeptModal = function () {
            // get department data
            if ($filter('isEmptyData')($scope.selectedDept, 'id')) {
                console.log($scope.selectedDept);
                $('#delDeptFormModal').modal('show');

            } else {
                $scope.errContent = "Please select one of departments and try again.";
                $('#noSelectionModal').modal('show');
            }
        }

        $scope.submitDelDept = function () {
            dataFactory.delDept($scope.selectedDept).then(function (resp) {
                if (resp.status == 200 && resp.data) {
                    $timeout(function () {
                        $scope.selectedDept = {};
                        $('#delDeptFormModal').modal('hide');
                    }, 100);
                } else {
                    alert(" Failed to request ");
                }
            });
        }


        $scope.submitAddDept = function () {
            console.log('submitAddDept');
            console.log($scope.newDeparmentFormData);
            $scope.newDeparmentFormData.submitting = true;
            // check name
            if ($filter('isEmptyData')($scope.newDeparmentFormData, 'name')) {
                $scope.newDeparmentFormData.invalid_name = false;
                $scope.newDeparmentFormData.submitting = true;
            } else {
                $scope.newDeparmentFormData.invalid_name = true;
                $scope.newDeparmentFormData.submitting = false;
            }
            // done validation
            if (!$scope.newDeparmentFormData.invalid_name) {
                // console.log('ready to add');
                console.log($scope.newDeparmentFormData);
                dataFactory.addDept($scope.newDeparmentFormData).then(function (resp) {
                    console.log(resp);
                    $scope.newDeparmentFormData.submitting = false;
                    $scope.newDeparmentFormData.name = '';
                    $('#addDeptFormModal').modal('hide');
                    $('#departmentsTree').tree('reload');
                });

            }
        }

        $scope.submitEditDept = function () {
            console.log('submitEditDepartment');
            $scope.editDeparmentFormData.submitting = true;
            console.log($scope.editDeparmentFormData);
            dataFactory.editDept($scope.editDeparmentFormData).then(function (resp) {
                console.log(resp);
                $scope.editDeparmentFormData.submitting = false;
                $scope.editDeparmentFormData.name = '';
                $('#editDeptFormModal').modal('hide');
                $('#departmentsTree').tree('reload');
                // $('#emailList').datagrid("reload");
            });

        }

        $scope.submitDelDept = function () {
            console.log('submitEditDepartment');
            $scope.editDeparmentFormData.submitting = true;
            console.log($scope.editDeparmentFormData);
            dataFactory.editDept($scope.editDeparmentFormData).then(function (resp) {
                console.log(resp);
                $scope.editDeparmentFormData.submitting = false;
                $scope.editDeparmentFormData.name = '';
                $('#editDeptFormModal').modal('hide');
                $('#departmentsTree').tree('reload');
                // $('#emailList').datagrid("reload");
            });
        }
        // END department add, edit, delete

        // START employee add, edit
        $scope.addEmplModal = function () {
            $scope.newEmplFormData.submitting = false;
            $('#addEmplFormModal').modal('show');
        }

        $scope.submitAddEmpl = function () {
            $scope.newEmplFormData.submitting = true;
            var validation = $scope.validationNewEmployee($scope.newEmplFormData);
            // done validation
            if (validation) {
                dataFactory.addEmpl($scope.newEmplFormData).then(function (resp) {
                    $scope.newEmplFormData.submitting = false;
                    $('#addEmplFormModal').modal('hide');
                    $scope.newEmplFormData = {};
                    $('#employeesList').datagrid('reload');
                });

            }
        }

        $scope.editEmplModal = function () {
            // get department data
            if ($filter('isEmptyData')($scope.selectedEmpl, 'id')) {
                dataFactory.getEmpl($scope.selectedEmpl).then(function (resp) {
                    console.log(resp);
                    if (resp.status == 200 && resp.data) {
                        $timeout(function () {
                            $scope.editEmplFormData = resp.data;
                            $scope.editEmplFormData.updated_at = $filter('date')($scope.editEmplFormData.updated_at, "yyyy-MM-dd HH:mm:ss");
                            if ($filter('isEmptyData')($scope.editEmplFormData.in_departments[0], 'id')) {
                                var aryDepartments = $filter('objToArr')($scope.frmSettings.departments);
                                $scope.editEmplFormData.department = $filter('getById')(aryDepartments, $scope.editEmplFormData.in_departments[0].employee_departments_id);
                            }
                            $scope.editEmplFormData.status = $filter('getByValue')($scope.frmSettings.status, $scope.editEmplFormData.status);
                            $('#editEmplFormModal').modal('show');
                        }, 100);
                    } else {
                        alert(" Failed to request ");
                    }
                });
            } else {
                $scope.errContent = "Please select one of employees and try again.";
                $('#noSelectionModal').modal('show');
            }
        }
        $scope.submitEditEmpl = function () {
            console.log('submitEditEmpl');
            $scope.editEmplFormData.submitting = true;
            console.log($scope.editEmplFormData);
            dataFactory.editEmpl($scope.editEmplFormData).then(function (resp) {
                $scope.editEmplFormData.submitting = false;
                $scope.editEmplFormData = {};
                $('#editEmplFormModal').modal('hide');
                $('#employeesList').datagrid('reload');
                // $('#emailList').datagrid("reload");
            });
        }
        // END employee edit


        // watch
        $scope.$watch('newEmplFormData.name', function () {
            if ($filter('isEmptyData')($scope.newEmplFormData, 'name')) {
                $scope.newEmplFormData.invalid_name = false;
            }
        });
        $scope.$watch('newEmplFormData.username', function () {
            if ($filter('isEmptyData')($scope.newEmplFormData, 'username')) {
                $scope.newEmplFormData.invalid_username = false;
            }
        });
        $scope.$watch('newEmplFormData.email', function () {
            if ($filter('isEmptyData')($scope.newEmplFormData, 'email')) {
                $scope.newEmplFormData.invalid_email = false;
            }
        });
        $scope.$watch('newEmplFormData.password', function () {
            if ($filter('isEmptyData')($scope.newEmplFormData, 'password')) {
                if ($scope.newEmplFormData.password.length >=8){
                    $scope.newEmplFormData.invalid_password_length = false;
                }
                $scope.newEmplFormData.invalid_password = false;
            }
        });
        
        $scope.$watch('newEmplFormData.password_confirm', function () {
            if ($filter('isEmptyData')($scope.newEmplFormData, 'password_confirm')  && $scope.newEmplFormData.password == $scope.newEmplFormData.password_confirm) {
                $scope.newEmplFormData.invalid_password_confirm = false;
            }
        });
        // end watch 

        $scope.validationNewEmployee = function (newEmplFormData) {
            var goahead = false;
            // check name
            if ($filter('isEmptyData')(newEmplFormData, 'name')) {
                $scope.newEmplFormData.invalid_name = false;
                $scope.newEmplFormData.submitting = true;
            } else {
                $scope.newEmplFormData.invalid_name = true;
                $scope.newEmplFormData.submitting = false;
            }

            // check username
            if ($filter('isEmptyData')(newEmplFormData, 'username')) {
                $scope.newEmplFormData.invalid_username = false;
                $scope.newEmplFormData.submitting = true;
            } else {
                $scope.newEmplFormData.invalid_username = true;
                $scope.newEmplFormData.submitting = false;
            }
            // check email
            if ($filter('isEmptyData')(newEmplFormData, 'email')) {
                $scope.newEmplFormData.invalid_email = false;
                $scope.newEmplFormData.submitting = true;
            } else {
                $scope.newEmplFormData.invalid_email = true;
                $scope.newEmplFormData.submitting = false;
            }

            // check password
            if ($filter('isEmptyData')(newEmplFormData, 'password')) {

                $scope.newEmplFormData.invalid_password = false;
                $scope.newEmplFormData.submitting = true;

                // check password length
                if ($scope.newEmplFormData.password.length >= 8){
                    $scope.newEmplFormData.invalid_password_length = false;
                    $scope.newEmplFormData.submitting = true;
                } else {
                    $scope.newEmplFormData.invalid_password_length = true;
                    $scope.newEmplFormData.submitting = false;
                }
                
            } else {
                $scope.newEmplFormData.invalid_password = true;
                $scope.newEmplFormData.submitting = false;
            }
            
            // check password_confirm
            if ($filter('isEmptyData')(newEmplFormData, 'password_confirm') && $scope.newEmplFormData.password == $scope.newEmplFormData.password_confirm) {
                $scope.newEmplFormData.invalid_password_confirm = false;
                $scope.newEmplFormData.submitting = true;
            } else {
                $scope.newEmplFormData.invalid_password_confirm = true;
                $scope.newEmplFormData.submitting = false;
            }

            if  ($scope.newEmplFormData.invalid_name
                ||$scope.newEmplFormData.invalid_username
                ||$scope.newEmplFormData.invalid_email
                ||$scope.newEmplFormData.invalid_password
                ||$scope.newEmplFormData.invalid_password_confirm
                ||$scope.newEmplFormData.invalid_password_length
                ){
                    return false;
                } else {
                    return true;
                }
            
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


]).directive('addEmpDeptsDirective', ['$compile', '$templateCache', function ($compile, $templateCache) {
    return {
        templateUrl: '../../../../public/libs/angularJs-1.8.2/src/htmlTpl/employees/ngDepartments.html',
        scope: true,
        restrict: 'E',
        link: function (scope, element, attrs) {
            var template = $templateCache.get('addDeptFormTpl');
            element.html(template);
            $compile(element.contents())(scope);
        }
    };
}]).directive('editEmpDeptsDirective', ['$compile', '$templateCache', function ($compile, $templateCache) {
    return {
        templateUrl: '../../../../public/libs/angularJs-1.8.2/src/htmlTpl/employees/ngDepartments.html',
        scope: true,
        restrict: 'E',
        link: function (scope, element, attrs) {
            var template = $templateCache.get('editDeptFormTpl');
            element.html(template);
            $compile(element.contents())(scope);
        }
    };
}]).directive('delEmpDeptsDirective', ['$compile', '$templateCache', function ($compile, $templateCache) {
    return {
        templateUrl: '../../../../public/libs/angularJs-1.8.2/src/htmlTpl/employees/ngDepartments.html',
        scope: true,
        restrict: 'E',
        link: function (scope, element, attrs) {
            var template = $templateCache.get('delDeptFormTpl');
            element.html(template);
            $compile(element.contents())(scope);
        }
    };
}]).directive('addEmplDirective', ['$compile', '$templateCache', function ($compile, $templateCache) {
    return {
        templateUrl: '../../../../public/libs/angularJs-1.8.2/src/htmlTpl/employees/ngEmployees.html',
        scope: true,
        restrict: 'E',
        link: function (scope, element, attrs) {
            var template = $templateCache.get('addEmplFormTpl');
            element.html(template);
            $compile(element.contents())(scope);
        }
    };
}]).directive('editEmplDirective', ['$compile', '$templateCache', function ($compile, $templateCache) {
    return {
        templateUrl: '../../../../public/libs/angularJs-1.8.2/src/htmlTpl/employees/ngEmployees.html',
        scope: true,
        restrict: 'E',
        link: function (scope, element, attrs) {
            var template = $templateCache.get('editEmplFormTpl');
            element.html(template);
            $compile(element.contents())(scope);
        }
    };
}]).directive('emplListToolbarDirective', ['$compile', '$templateCache', function ($compile, $templateCache) {
    return {
        templateUrl: '../../../../public/libs/angularJs-1.8.2/src/htmlTpl/employees/ngEmployees.html',
        scope: true,
        restrict: 'E',
        link: function (scope, element, attrs) {
            var template = $templateCache.get('emplListToolbarTpl');
            element.html(template);
            $compile(element.contents())(scope);
        }
    };
}]);