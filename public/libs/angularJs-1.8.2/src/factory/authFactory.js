app.factory('authFactory', ['$http', '$location', '$window','$rootScope', function ($http, $location, $window,$rootScope) {
    // get lang
    if ($window.sessionStorage.lang) {
        lang = $window.sessionStorage.lang;
    } else {
        if (document.documentElement.getAttribute("lang")) {
            lang = document.documentElement.getAttribute("lang");
        } else {
            lang = "en";
        }
        $window.sessionStorage.lang = lang;
    }
    
    var URL = $location.protocol() + "://" + $location.host();
    if ($location.port() != '80') {
        URL = URL + ":" + $location.port();
    }
//config.headers.Authorization = $window.sessionStorage.jwtToken;
    var urlApi = URL + "/backend/index.php/" + lang + '/api';
    if (hasJwtToken()){
        var config = {
            headers: {
                'Content-Type': 'application/json',
                'Authorization' : hasJwtToken()
            }
        }
    } else {
        var config = {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    }
    console.log(config);
    
    
    
    var urlUserApi = URL + "/backend/index.php/api/api";

    function hasJwtToken(){
        if ($window.sessionStorage.userInfo) {
            return $window.sessionStorage.jwtToken;
        } else {
            return false;
        }
    }

    function setConfigHeader(){
        if (hasJwtToken()){
            var config = {
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization' : hasJwtToken()
                }
            }
            
        } else {
            var config = {
                headers: {
                    'Content-Type': 'application/json'
                }
            }
        }
        return config;
    }


    return {
        // login 
        userLogin: function (requestData) {
            var config = setConfigHeader();
            return $http.post(urlUserApi + '/login', requestData, config);
        },
        userLogout: function () {
            var config = setConfigHeader();
            return $http.post(urlUserApi + '/logout', '', config);
        },
        userRefresh:function (){
            $window.sessionStorage.removeItem('userInfo');
            $window.sessionStorage.removeItem('jwtToken');
            $window.sessionStorage.removeItem('accessToken');
            return $window.sessionStorage;
        },
        userProfile: function (requestData) {
            var config = setConfigHeader();
            return $http.post(urlUserApi + '/profile', requestData, config);
        },
        // store the key
        storeLogin: function (loginInfo) {
            if (loginInfo.status == 'success') {
                $window.sessionStorage.setItem('userInfo', JSON.stringify(loginInfo.user));
                $window.sessionStorage.setItem('jwtToken', "Bearer " + loginInfo.access_token);
                $window.sessionStorage.setItem('accessToken', "Bearer " + loginInfo.access_token);
                $rootScope.jwt = "Bearer " + loginInfo.access_token;
                console.log($rootScope.jwt);
                return $window.sessionStorage.userInfo;
            } else {
                return false;
            }
        },
        getJwtToken: function () {
            return hasJwtToken();
        },
        getAccessToken: function () {
            if ($window.sessionStorage.userInfo) {
                return $window.sessionStorage.accessToken;
            } else {
                return false;
            }
        },
        getHeaderConfig:function (){
            return config;
        },
        getLoginInfo : function (){
            return $window.sessionStorage.userInfo;
        }
        



    }

}]);