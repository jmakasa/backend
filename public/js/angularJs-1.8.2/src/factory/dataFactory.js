app.factory('dataFactory', ['$http','$location','$window', function ($http, $location,$window) {
    // get lang
    if ($window.sessionStorage.lang){
        lang = $window.sessionStorage.lang;
    } else {
        if (document.documentElement.getAttribute("lang")){
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

var urlApi = URL + "/marketing/backend/index.php/" + lang + '/api';
var config = {
    headers : {
        'Content-Type': 'application/json'
    }
}
return {
    // product details page
    getProductDetailsById:function (id){
        var requestData = {
            id: id,
        }
        return $http.post(urlApi + '/product/details',requestData,config);
    },
    // product details page
    getSocketTypeByPartno:function (partno){
        var requestData = {
            partno: partno,
        }
        return $http.post(urlApi + '/socket/partno/get',requestData,config);
    },
    getKeywordsByPartno:function (partno){
        var requestData = {
            partno: partno,
        }
        return $http.post(urlApi + '/keyword/partno/get',requestData,config);
    },
    // email 
    getEmailList:function (){
        var requestData = {
        }
        return $http.post(urlApi + '/email_contactus/list',requestData,config);
    },

    // save call
    updateIntro:function (requestData){
        return $http.post(urlApi + '/product/intro/update',requestData,config);
    },
    updateProductDetails:function (requestData){
        return $http.post(urlApi + '/product/main/update',requestData,config);
    },
    updateSocketTypeByPartno:function (partno,data){
        var requestData = {
            partno: partno,
            data:data
        }
        return $http.post(urlApi + '/socket/partno/update',requestData,config);
    },
    

    // END save call
    // end product details page
    // list optons
    getListsOptions: function () {
        return $http.get(urlApi + '/lists_options');
    },
    getProductsOptions: function () {
        return $http.get(urlApi + '/product_list');
    },
    //

    // filter
    getValueByKey: function (ary, key) {
        return $filter('getByValue')(ary, key);
    },

    getValueById: function (ary, id) {
        return $filter('getById')(ary, id);
    },
}

}]);

app.filter('getByValue', function () {
return function (input, val) {
    var i = 0, len = input.length;
    for (; i < len; i++) {
        if (+input[i].value == +val) {
            return input[i];
        }
    }
    return null;
}
});

app.filter('getById', function () {
return function (input, val) {
    var i = 0, len = input.length;
    for (; i < len; i++) {
        if (+input[i].id == +val) {
            return input[i];
        }
    }
    return null;
}
});

app.filter('range', function() {
return function(input, total) {
total = parseInt(total);
for (var i=0; i<total; i++)
  input.push(i);
return input;
};
});

app.filter('implode', function () {
return function join(array, separator, prop) {
    if (!Array.isArray(array)) {
        return array; // if not array return original - can also throw error
    }

    return (!angular.isUndefined(prop) ? array.map(function (item) {
        return item[prop];
    }) : array).join(separator);
};
});

app.directive('ngEnter', function () {
return function (scope, element, attrs) {
    element.bind("keydown keypress", function (event) {
        if (event.which === 13) {
            scope.$apply(function () {
                scope.$eval(attrs.ngEnter);
            });

            event.preventDefault();
        }
    });
};
});
app.directive('ngFile', ['$parse', function ($parse) {
return {
restrict: 'A',
link: function(scope, element, attrs) {
element.bind('change', function(){

$parse(attrs.ngFile).assign(scope,element[0].files);
scope.$apply();
});
}
};
}]);

app.directive('ngFiles', ['$parse', function ($parse) {

function file_links(scope, element, attrs) {
    var onChange = $parse(attrs.ngFiles);
    element.on('change', function (event) {
        onChange(scope, {$files: event.target.files});
    });
}

return {
    restrict: 'A',
    link: file_links
}
}]);

