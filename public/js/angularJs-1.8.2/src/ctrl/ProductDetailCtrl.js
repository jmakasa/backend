app.controller('ProductDetailCtrl', [
    '$scope', 'dataFactory','$window',
    function ProductDetailCtrl($scope, dataFactory,$window) {
        console.log($window.sessionStorage);
        // get lang
        if ($window.sessionStorage.lang){
            $scope.lang = $window.sessionStorage.lang;
        } else {
            $scope.lang = document.documentElement.getAttribute("lang");
        }
        console.log($scope.lang);
        
        const $ctrl = this;
        $scope.message = '';
        $scope.productDetails = [];
        $scope.socketTypeList = [];

        $scope.config = _config;

        // load init
        $ctrl.$onInit = () => {
            
            
            dataFactory.getProductDetailsById($scope.config.id).then(function (resp) {
                if (resp.data) {
                    $scope.productDetails = resp.data;
                    if ($scope.productDetails.active == 1) {
                        $scope.productDetails.active = true;
                    }
                    if ($scope.productDetails.iscooler == 1) {
                        $scope.productDetails.iscooler = true;
                    }
                    if ($scope.productDetails.newproduct == 1) {
                        $scope.productDetails.newproduct = true;
                    }
                }
            }, function (error) {
                $scope.status = 'Unable to load lists of options data: ' + error.message;
                console.log(" getListsOptions : Unable to load lists of options data:  " + error.message)
            });

            dataFactory.getSocketTypeByPartno($scope.config.partno).then(function (resp) {
                $scope.socketTypeList = resp.data;
                $scope.productDetails.cpuSockets = $scope.socketTypeList.display_name;
            });


        }
        $scope.displayTypes = [
            {
                value: 1,
                name: 'Fix width (1366px)'
            },
            {
                value: 2,
                name: 'Center'
            },
            {
                value: 3,
                name: 'Full width'
            },
        ]


        // click function
        // main info tab
        $scope.editMain = function (id) {
            dataFactory.getProductDetailsById(id).then(function (resp) {
                if (resp.data) {
                    $scope.productDetails = resp.data;
                    if ($scope.productDetails.active == 1) {
                        $scope.productDetails.active = true;
                    }
                    if ($scope.productDetails.iscooler == 1) {
                        $scope.productDetails.iscooler = true;
                    }
                    if ($scope.productDetails.newproduct == 1) {
                        $scope.productDetails.newproduct = true;
                    }
                    $("#mf_longDesc").summernote({
                        'code': $scope.productDetails.longdesc,
                        callbacks: {
                            onChange: function (contents, $editable) {
                                $scope.productDetails.longdesc = contents;
                            }
                        }
                    });
                    $('#mainFormModal').modal('show');
                }
                //   $scope.bindSelectedCategory($scope.selectedCategoryData);
            }, function (error) {
                $scope.status = 'Unable to load lists of options data: ' + error.message;
                console.log(" getListsOptions : Unable to load lists of options data:  " + error.message)
            });
        }

        $scope.editSocketType = function (partno) {
            console.log(partno);
            dataFactory.getSocketTypeByPartno(partno).then(function (resp) {
                $scope.socketTypeList = resp.data;
                $scope.productDetails.cpuSockets = $scope.socketTypeList.display_name;
            });

            $('#socketTypeFormModal').modal('show');
        }
        // END main info tab

        // overview tab
        $scope.editintro = function (id) {
            $("#ovfm_intro").summernote({
                'code': $scope.productDetails.introduction,
                callbacks: {
                    onChange: function (contents, $editable) {
                        $scope.productDetails.introduction = contents;
                        //     console.log('onChange:', contents, $editable);
                    }
                }
            });
            //$("#ovfm_intro").summernote('height', 500);
            $('#introFormModal').modal('show');
        }
        $scope.updateIntro = function () {
            console.log($scope.productDetails);
            dataFactory.updateIntro($scope.productDetails).then(function (resp) {
              //  console.log(resp);
                $('#introFormModal').modal('hide');
            });
        }

        $scope.updateProductDetails = function () {
            console.log($scope.productDetails);
            dataFactory.updateProductDetails($scope.productDetails).then(function (resp) {
              //  console.log(resp);
              //  if (resp.data){
                    $('#mainFormModal').modal('hide');
              //  }
                
            });
        }

        $scope.updateSocketType = function (partno) {
            dataFactory.updateSocketTypeByPartno(partno,$scope.socketTypeList).then(function (resp) {
              //  console.log(resp);
              //  if (resp.data){
                 //   $('#mainFormModal').modal('hide');
              //  }
                
            });
        }
        
        // end overview tab

    }


]);                                                  
