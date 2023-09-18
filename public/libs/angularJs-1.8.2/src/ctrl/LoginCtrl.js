app.controller('LoginCtrl', [
    '$scope', 'dataFactory', 'authFactory','$window', '$sce', '$filter','constFactory',
    function LoginCtrl($scope, dataFactory, authFactory,$window, $sce, $filter,constFactory) {
        const $ctrl = this;
        $scope.loginData = {};
        console.log($window.localStorage);

        // get lang
        if ($window.sessionStorage.lang) {
            $scope.lang = $window.sessionStorage.lang;
        } else {
            $scope.lang = document.documentElement.getAttribute("lang");
            $window.sessionStorage.lang = $scope.lang;
        }

        // load init
        $ctrl.$onInit = () => {

        } // end init

        $scope.submitLogout = function (){
            console.log('logout');
            authFactory.userLogout().then(function (resp) {
                 console.log(resp);
                // console.log(resp.status);
                // console.log(resp.data);
                // if
                // storage token
                if (resp){
                    console.log(authFactory.userRefresh());
                    // TODO :: redirect to page
                } else {
                    // TODO :: failed
                }
            });
        }

        $scope.submitLogin = function (){
            console.log("click");
            authFactory.userLogin($scope.loginData).then(function (resp) {
                 console.log(resp);
                // console.log(resp.status);
                // console.log(resp.data);
                // if
                // storage token
                if (resp.data.status && resp.data.status == 'success'){
                    authFactory.storeLogin(resp.data);
                    console.log($window.sessionStorage.jwtToken);
                    console.log($window.sessionStorage);
                    console.log(authFactory.getJwtToken());
                    // TODO :: redirect to page
                } else {
                    // TODO :: failed
                }
            });
        }

        
        $scope.loginInfo = function (){
            var uInfo = authFactory.userProfile().then(function (resp) {

            
            if (resp.status ==200){
                console.log(resp.data);
                return resp.data; 
            } else {
                return resp;
            }
            
            });
            
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
