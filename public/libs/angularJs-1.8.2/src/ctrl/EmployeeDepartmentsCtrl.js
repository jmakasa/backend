app.controller('EmployeeDepartmentsCtrl', [
    '$scope', 'dataFactory', '$window', '$sce', '$filter','constFactory',
    function EmployeeDepartmentsCtrl($scope, dataFactory, $window, $sce, $filter,constFactory) {
        const $ctrl = this;
        $scope.frmWebSettings = ["isNew,isUpcoming"];

        // get lang
        if ($window.sessionStorage.lang) {
            $scope.lang = $window.sessionStorage.lang;
        } else {
            $scope.lang = document.documentElement.getAttribute("lang");
        }

        // load init
        $ctrl.$onInit = () => {
            dataFactory.getTasksFormSettings().then(function (resp) {
                // console.log(resp);
                $scope.tasksFormSettings = resp.data;
            });

            // easyui datagrid taskList 
            $('#employeeList').datagrid({
                title: 'Employee Listing ( Double click the check the detail )',
                singleSelect: true,
                pagination: false,
                pageSize: 50,
                view: scrollview,
                height: 350,
                idField: 'data.id',
                url: "/marketing/backend/index.php/" + $scope.lang + '/api/employee/list/get',
                columns: [
                    [
                        { field: 'id', title: 'ID', width: '5%', sortable: true, align: 'center' },
                        {field: 'name', title: 'Name', width: '15%', sortable: true},
                        {field: 'username', title: 'Username', width: '15%', sortable: true},
                        {field: 'email', title: 'Email', width: '30%', sortable: true},
                        {field: 'position', title: 'Position', width: '10%', sortable: true},
                        {field: 'status', title: 'Status', width: '10%', sortable: true},
                    ]
                ],
                onDblClickRow:function (rowIndex, row) {
                    OpenInNewTab("/backend/index.php/"+$scope.lang+"/tasks/detail/"+row.id);
                }
            });

            // end easyui datagrid taskList 

        } // end init


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
