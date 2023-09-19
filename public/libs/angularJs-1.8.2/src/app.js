var app = angular.module('akasa-web', [], ['$httpProvider', function ($httpProvider) {
    $httpProvider.defaults.headers.post['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8;';
}]);

app.config(function ($interpolateProvider) {
    // To prevent the conflict of `{{` and `}}` symbols
    // between Blade template engine and AngularJS templating we need
    // to use different symbols for AngularJS.

    $interpolateProvider.startSymbol('{#');
    $interpolateProvider.endSymbol('#}');
});
// add header into header
// app.config(function ($httpProvider){
//     $httpProvider.interceptors.push(['$q', '$location','$window', function ($q, $window,$location) {
//         return {
//             'request': function (config,$window) {
//                 config.headers = config.headers || {};
//                 console.log(angular.isUndefined($window));
//                 console.log(angular.isUndefined($window.sessionStorage));
//                 console.log(angular.isUndefined($window.sessionStorage.jwtToken));
//                 console.log(angular.isUndefined($window.sessionStorage['jwtToken']));
                
//                 console.log($window.sessionStorage);
//                 if (angular.isDefined($window.sessionStorage['jwtToken'])) {
//                     config.headers.Authorization = $window.sessionStorage.jwtToken;
//                 } 
//                 return config;
//             },
//             'responseError': function (response) {
//                 if (response.status === 401 || response.status === 403) {
//                     $location.path('/signin');
//                 }
//                 return $q.reject(response);
//             }
//         };
//      }]);
// });

app.factory('constFactory', ['$location','$window', function ($location,$window) {
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
    var backendUrlApi = URL + "/marketing/backend/index.php/" + lang + '/api';
    return {
        // product details page
        getUrlApi: function () {
            return URL + "/marketing/backend/index.php/" + lang + '/api';
        },
        getUploadFileUrlApi: function () {
            return  backendUrlApi + '/file_uploads/upload';
        },
        getBaseHostUrl: function (){
            return URL;
        },
        getMarketingUrl: function (){
            return URL+ "/marketing";
        },
        getBackendUrl: function (){
            return URL+ "/marketing/backend/index.php" + lang;
        },
        getEmailAttachmentsUrl: function (){
            return URL+ "/marketing/email_attachments";
        }
    }
}]);


app.directive("datepicker", function () {

    function link(scope, element, attrs) {
        // CALL THE "datepicker()" METHOD USING THE "element" OBJECT.
        element.datepicker({
            dateFormat: "yy-mm-dd"
        });
    }

    return {
        require: 'ngModel',
        link: link
    };
});

app.directive('fileUploadsModel', function ($parse) {
    return {
        restrict: 'A', //the directive can be used as an attribute only
        /*
         link is a function that defines functionality of directive
         scope: scope associated with the element
         element: element on which this directive used
         attrs: key value pair of element attributes
         */
        link: function (scope, element, attrs) {
            var model = $parse(attrs.fileUploadsModel),
                modelSetter = model.assign; //define a setter for fileUploadsModel
            //Bind change event on the element
            element.bind('change', function () {
                //Call apply on scope, it checks for value changes and reflect them on UI
                scope.$apply(function () {
                    //set the model value
                   // modelSetter(scope, element[0].files[0]);
                   modelSetter(scope, element[0].files);
                });
            });
        }
    };
});

app.directive('noSelectionDirective', ['$compile', '$templateCache', function ($compile, $templateCache) {
    return {
        templateUrl: 'libs/angularJs-1.8.2/src/htmlTpl/commonModal.html',
        scope: true,
        restrict: 'E',
        link: function (scope, element, attrs) {
            var template = $templateCache.get('noSeletionModalTpl');
            element.html(template);
            $compile(element.contents())(scope);
        }
    };
}]);

app.directive('msgModalDirective', ['$compile', '$templateCache', function ($compile, $templateCache) {
    return {
        templateUrl: 'libs/angularJs-1.8.2/src/htmlTpl/commonModal.html',
        scope: true,
        restrict: 'E',
        link: function (scope, element, attrs) {
            var template = $templateCache.get('msgModalTpl');
            element.html(template);
            $compile(element.contents())(scope);
        }
    };
}]);