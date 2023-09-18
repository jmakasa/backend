app.controller('FooterCtrl', [
    '$scope', 'dataFactory',
    function FooterCtrl($scope,dataFactory) {
        const $ctrl = this;
        $scope.message = 'Product PAGE - AngularJS lang : ' + document.documentElement.getAttribute("lang");
        $scope.listsOptions = [];
        $scope.frmCreateProduct = [];
        
        // load init
        $ctrl.$onInit = () => {
            // get lang
            $scope.lang = document.documentElement.getAttribute("lang");

            // get lists of options
            dataFactory.getListsOptions().then(function (response) {
                $scope.listsOptions = response.data;
                console.log($scope.listsOptions);
                $scope.bindSelectedCategory($scope.selectedCategoryData);
            }, function (error) {
                $scope.status = 'Unable to load lists of options data: ' + error.message;
                console.log(" getListsOptions : Unable to load lists of options data:  " + error.message)
            });

            // get product list for parent product and related product
            dataFactory.getProductsOptions().then(function (response) {
                $scope.productList = response.data;
                console.log($scope.productList);
                // TODO : bind product
               // $scope.bindSelectedCategory($scope.selectedCategoryData);
            }, function (error) {
                $scope.status = 'Unable to load product list data: ' + error.message;
                console.log(" getListsOptions : Unable to load product list data:  " + error.message)
            });
            
        }
       // $scope.optCategory = [];
        $scope.selectCategoryAll = false;
        $scope.selectedCategory = [];
        $scope.selectedKeywords = [];
        $scope.selectedTags = [];


        $scope.check = function(){
            $scope.selectedCategoryData = [];
            angular.forEach($scope.listsOptions.category, function(category){
              if (category.selected) $scope.selectedCategory.push(category.id);
            });
          }

        // bind selected checkbox
            $scope.bindSelectedCategory = function (selectedCategoryData) {
                angular.forEach(selectedCategoryData, function(id){
                    angular.forEach($scope.listsOptions.category, function(category, index){
                        console.log(index);
                        if (category.id == id) {
                            $scope.listsOptions.category[index].selected = true;
                        }
                      });
                });
                
            }
        // TODO : bind product
            

            

    }
        
    
]);                                                  
