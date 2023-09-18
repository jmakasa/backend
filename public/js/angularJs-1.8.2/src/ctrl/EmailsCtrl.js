app.controller('EmailsCtrl', [
    '$scope', 'dataFactory','$window',
    function ProductCtrl($scope,dataFactory,$window) {
        const $ctrl = this;
        $scope.message = 'Product PAGE - AngularJS lang : ' + document.documentElement.getAttribute("lang");
        $scope.listsOptions = [];
        $scope.frmCreateProduct = [];
        $scope.frmWebSettings = ["isNew,isUpcoming"];

        // get lang
        if ($window.sessionStorage.lang){
            $scope.lang = $window.sessionStorage.lang;
        } else {
            $scope.lang = document.documentElement.getAttribute("lang");
        }
        
        // load init
        $ctrl.$onInit = () => {
            // get lang
            $scope.lang = document.documentElement.getAttribute("lang");

            // get lists of options
            dataFactory.getEmailList().then(function (response) {
                $scope.emailList = response.data;
                $('#emailList').datagrid({
                    singleSelect: true,
                    pagination: true,
                    pageSize: 10,
                    pageList: [10, 20, 40],
                    height: 800,
                    idField: 'data.id',
                    url: $scope.emailList,
                    columns: [[
                      { field: 'id', title: 'ID', width: '5%', sortable: true, align: 'center' },
                      { field: 'contact_reason', title: 'Contact Reason', width: '15%', sortable: true, align: 'center' },
                      { field: 'firstname', title: 'Firstname', width: '10%', sortable: true },
                      { field: 'lastname', title: 'Lastname', width: '10%', sortable: true },
                      { field: 'subject', title: 'Subject', width: '50%', sortable: true },
                      { field: 'region', title: 'Region', width: '10%', sortable: true }
                    ]],
                });

            }, function (error) {
                $scope.status = 'Unable to load emails data: ' + error.message;
                console.log(" emailList : Unable to load emails data:  " + error.message)
            });
            
        }
       // $scope.optCategory = [];
        $scope.selectCategoryAll = false;
        $scope.selectedCategory = [];
        $scope.selectedKeywords = [];
        $scope.selectedTags = [];

            

    }
        
    
]);                                                  
