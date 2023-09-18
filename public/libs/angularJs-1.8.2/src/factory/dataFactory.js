app.factory('dataFactory', ['$http', '$location', '$window', function ($http, $location, $window) {
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

    var urlApi = URL + "/marketing/backend/index.php/" + lang + '/api';
    var config = {
        headers: {
            'Content-Type': 'application/json'
        }
    }
var urlUserApi = URL + "/marketing/backend/index.php/api/api";

    return {
        getBackendApi: function (){
            return urlApi;
        },
        getUploadFileUrl: function (){
            return urlApi + '/file_uploads/upload';
        },
        // product details page
        getProductDetailsById: function (id) {
            var requestData = {
                id: id,
            }
            return $http.post(urlApi + '/product/details', requestData, config);
        },
        // product details page
        getSocketTypeByPartno: function (partno) {
            var requestData = {
                partno: partno,
            }
            return $http.post(urlApi + '/socket/partno/get', requestData, config);
        },
        getKeywordsByPartno: function (partno) {
            var requestData = {
                partno: partno,
            }
            return $http.post(urlApi + '/keyword/partno/get', requestData, config);
        },
        getNavmenuListByPartno: function (partno) {
            var requestData = {
                partno: partno,
            }
            return $http.post(urlApi + '/2022_navmenu/belong_to', requestData, config);
        },
        updateBoxesIsSelected: function (requestData) {
            return $http.post(urlApi + '/boxes/is_selected/update', requestData, config);
        },
        getuploadedDatetimeByPartno: function (requestData) {
            return $http.post(urlApi + '/file_uploads/list/uploaded_datetime', requestData, config);
        },
        // email 
        getEmailList: function (orderSeq) {
            var requestData = {
                order: orderSeq
            }
            return $http.get(urlApi + '/email_contactus/list', requestData, config);
        },
        getEmailDetail: function (requestData) {
            return $http.post(urlApi + '/email_contactus/detail', requestData, config);
        },
        // tasks 
        getTasksFormSettings: function () {
            var requestData = {
            }
            return $http.get(urlApi + '/tasks/form/settings', requestData, config);
        },
        addNewTasks: function (requestData) {
            return $http.post(urlApi + '/tasks/add', requestData, config);
        },
        updateTaskDetail: function (requestData) {
            return $http.post(urlApi + '/tasks/detail/update', requestData, config);
        },
        getTaskDetailById: function (requestData) {
            return $http.post(urlApi + '/tasks/detail', requestData, config);
        },
         // tickets 
        getTicketsFormSettings: function () {
            var requestData = {}
            return $http.get(urlApi + '/tickets/form/settings', requestData, config);
        },
        getTicketsRecentUpdatedList: function (requestData) {
            return $http.post(urlApi + '/tickets/recent_updated/list', requestData, config);
        },
        addNewTickets: function (requestData) {
            return $http.post(urlApi + '/tickets/add', requestData, config);
        },
        updateTicketDetail: function (requestData) {
            return $http.post(urlApi + '/tickets/detail/update', requestData, config);
        },
        getTicketDetailById: function (requestData) {
            return $http.post(urlApi + '/tickets/detail', requestData, config);
        },
        // reviewsites
        addReviewsites: function (requestData) {
            return $http.post(urlApi + '/reviewsites/add', requestData, config);
        },
        editReviewsites: function  (requestData) {
            return $http.post(urlApi + '/reviewsites/edit', requestData, config);
        },
        deleteReviewsites: function  (requestData) {
            return $http.post(urlApi + '/reviewsites/delete', requestData, config);
        },
        getReviewsites: function (requestData) {
            return $http.post(urlApi + '/reviewsites/list', requestData, config);
        },
        getReviewsitesName:function (q){
            return $http.get(urlApi + '/reviewsites/get_name/'+q, '', config);
        },
        getReviewsitesById:function (requestData){
            return $http.post(urlApi + '/reviewsites/get_by_id', requestData, config);
        },
        exportReviewsiteConf:function (){
            return $http.post(urlApi + '/reviewsites/export_conf', '', config);
        },
        

        // product reviews
        addProductReviews: function (requestData) {
            return $http.post(urlApi + '/product_reviews/add', requestData, config);
        },
        editProductReviews: function (requestData) {
            return $http.post(urlApi + '/product_reviews/edit', requestData, config);
        },
        getProductReviews: function (requestData) {
            return $http.post(urlApi + '/product_reviews/add', requestData, config);
        },
        deleteProductReviews: function (requestData) {
            return $http.post(urlApi + '/product_reviews/delete', requestData, config);
        },
        removeImageProductReviews: function (requestData) {
            return $http.post(urlApi + '/product_reviews/remove_image', requestData, config);
        }, 
        getProductReviewsBySites: function (requestData) {
            return $http.post(urlApi + '/product_reviews/list/by_site', requestData, config);
        }, 

        

        


        // thread
        addNewThread: function (requestData) {
            return $http.post(urlApi + '/threads/add', requestData, config);
        },
        getThreadListById: function (requestData) {
            return $http.post(urlApi + '/threads/list_by_id', requestData, config);
        },
        // ticket thread
        addNewTicketThread: function (requestData) {
            return $http.post(urlApi + '/tickets/threads/add', requestData, config);
        },
        getTicketThreadListById: function (requestData) {
            return $http.post(urlApi + '/tickets/threads/list_by_id', requestData, config);
        },

        // ticket note
        addTicketNote: function (requestData) {
            return $http.post(urlApi + '/tickets/notes/add', requestData, config);
        },
        deleteTicketNote: function (requestData) {
            return $http.post(urlApi + '/tickets/notes/add', requestData, config);
        },
        getTicketNotesListById: function (requestData) {
            return $http.post(urlApi + '/tickets/notes/list_by_id', requestData, config);
        },

        //mentioned
        getMentionedByEmployeesId: function (requestData) {
            return $http.post(urlApi + '/mentioned/list_by_employees_id', requestData, config);
        },

        // employees
        getEmployeeList: function () {
            return $http.post(urlApi + '/employees/list/get', '', config);
        },
        addDept: function (requestData) {
            return $http.post(urlApi + '/employee_depts/add', requestData, config);
        },
        editDept: function (requestData) {
            return $http.post(urlApi + '/employee_depts/edit', requestData, config);
        },
        delDept: function (requestData) {
            return $http.post(urlApi + '/employee_depts/del', requestData, config);
        },
        getEmpl:function (requestData) {
            return $http.post(urlApi + '/employees/detail', requestData, config);
        }, 
        addEmpl: function (requestData) {
            return $http.post(urlApi + '/employees/add', requestData, config);
        },
        editEmpl: function (requestData) {
            return $http.post(urlApi + '/employees/edit', requestData, config);
        },
        delEmpl: function (requestData) {
            return $http.post(urlApi + '/employees/del', requestData, config);
        },
        getEmployeeSettings: function () {
            return $http.post(urlApi + '/employees/settings', '', config);
        },
        getEmployeeDepartments: function (state) {
            return $http.get(urlApi + '/employee_depts/'+state, '', config);
        },
        getEmployeeDepartmentDetail:function (requestData){
            return $http.post(urlApi + '/employee_depts/detail', requestData, config);
        },

        // upload file
        assignScheduleTasks: function (requestData){
            return $http.post(urlApi + '/file_uploads/schedule_tasks', requestData, config);
        },
        uploadFileNow: function (requestData){
            return $http.post(urlApi + '/file_uploads/upload_batch_now', requestData, config);
        },
        removeUploadedFile: function  (requestData){
            return $http.post(urlApi + '/file_uploads/remove_uploaded_file', requestData, config);
        },

        // uploadFile:function (requestData){
        //     return $http.post(urlApi + '/file_uploads/upload', requestData, config);
            // },
        uploadFile: function (file, uploadUrl,uploadType,folderPath = null) {
            //FormData, object of key/value pair for form fields and values
            var fileFormData = new FormData();
            fileFormData.append('file', file);
            fileFormData.append('diskType', uploadType);
            if (folderPath){
                fileFormData.append('folderPath', folderPath);
            }
            return $http.post(uploadUrl, fileFormData, {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined}
    
            });
        },

        // spec
        addSpecGroup: function (requestData) {
            return $http.post(urlApi + '/spec/group/add', requestData, config);
        },
        

        // end spec



        // login 
        userLogin:function (requestData) {
            return $http.post(urlUserApi + '/login', requestData, config);
        },

        




        // save call
        updateIntro: function (requestData) {
            return $http.post(urlApi + '/product/intro/update', requestData, config);
        },
        updateProductDetails: function (requestData) {
            return $http.post(urlApi + '/product/main/update', requestData, config);
        },
        updateSocketTypeByPartno: function (partno, data) {
            var requestData = {
                partno: partno,
                data: data
            }
            return $http.post(urlApi + '/socket/partno/update', requestData, config);
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

        //convert obj to ary
        convertObjToArr:function (obj){
            return $filter('objToArr')(obj);
        },

        // filter
        getValueByKey: function (ary, key) {
            return $filter('getByValue')(ary, key);
        },

        getValueById: function (ary, id) {
            return $filter('getById')(ary, id);
        },
        isEmpty: function (val) {
            return $filter('isEmpty')(val);
        },
        ticketStatusButton : function (value) {
            if (value == 'Open') {
                return '<span class="badge bg-primary text-white p-1 text-center fw-bold">' + value + '</span>';
            } else if (value == 'Prioritized') {
                return '<span class="badge bg-danger text-white p-1 text-center fw-bold">' + value + '</span>';
            } else if (value == 'In Progress') {
                return '<span class="badge bg-success text-white p-1 text-center fw-bold">' + value + '</span>';
            } else if (value == 'Review') {
                return '<span class="badge bg-info text-black p-1 text-center fw-bold">' + value + '</span>';
            } else if (value == 'Closed') {
                return '<span class="badge bg-dark text-white p-1 text-center fw-bold">' + value + '</span>';
            } else if (value == 'Re-Open') {
                return '<span class="badge bg-warning text-black p-1 text-center fw-bold">' + value + '</span>';
            } else {
                return value;
            }
        }
    }

}]);

app.filter("isEmptyData", function () {
    //var is = user && user.hasOwnProperty('role');
    return function (data, check) {
        if (data && data.hasOwnProperty(check)){
            if (data[check]== null || data[check] == undefined || data[check] == "" || data[check] == 0) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
});

app.filter("trustAsHtml", ['$sce', function ($sce) {
    return function (htmlCode) {
        return $sce.trustAsHtml(htmlCode);
    }
}]);
app.filter("newDate", function () {
    return function (date) {
        return new Date(date);
    }
});

app.filter("filenameFromPath", function () {
    return function (fullPath) {
        return fullPath.replace(/^.*[\\\/]/, '');
    }
});

app.filter('objToArr', function () {
    return function (obj) {
        var arr = [];
        Object.keys(obj).forEach(function(key)
        {
            arr.push(obj[key]);
        });
        
        return arr;
    }
});

app.filter('getByValue', function () {
    return function (input, val) {
        var i = 0, len = input.length;
        for (; i < len; i++) {
            if (input[i].value == val) {
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
            if (input[i].id == val) {
                return input[i];
            }
        }
        return null;
    }
});

app.filter('range', function () {
    return function (input, total) {
        total = parseInt(total);
        for (var i = 0; i < total; i++)
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

app.filter('duration_time', function () {
    return function (old_date) {
        var todayDate = new Date();
        var oldDate = new Date(old_date);
        let difference = todayDate.getTime() - oldDate.getTime();
        var diffNo = difference / (1000 * 3600 * 24);
        if (diffNo < 1){//less than 1 day
            if (difference / (1000 * 60 ) < 60){
                return '<span class="badge bg-danger">'+Math.round(difference / (1000 * 60)) + " mins ago</span>";
            } else {
                return '<span class="badge bg-danger">'+Math.round(difference / (1000 * 3600)) + " hours ago</span>";
            }
            
        } else {
            return '<span class="badge bg-secondary">' + Math.ceil(difference / (1000 * 3600 * 24)) + " days ago</span>";
        }
        


    }
});

app.filter('ticketStatus',function (){
    return function (value) {
        if (value == 'Open') {
            return '<span class="badge bg-primary text-white p-1 text-center fw-bold">' + value + '</span>';
        } else if (value == 'Prioritized') {
            return '<span class="badge bg-danger text-white p-1 text-center fw-bold">' + value + '</span>';
        } else if (value == 'In Progress') {
            return '<span class="badge bg-success text-white p-1 text-center fw-bold">' + value + '</span>';
        } else if (value == 'Review') {
            return '<span class="badge bg-info text-black p-1 text-center fw-bold">' + value + '</span>';
        } else if (value == 'Closed') {
            return '<span class="badge bg-dark text-white p-1 text-center fw-bold">' + value + '</span>';
        } else if (value == 'Re-Open') {
            return '<span class="badge bg-warning text-black p-1 text-center fw-bold">' + value + '</span>';
        } else {
            return value;
        }
    }
});


app.filter('split_string', function () {
    return function (input) {
        input = input || '';
        return input.split(/\s?,\s?/);
    };
});

app.filter('isEmpty', [function() {
    return function(object) {
        if(object.hasOwnProperty(object)){
            return Object.keys(object).length ===0;
        } else {
            return false;
        }
      
    }
  }]);

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
        link: function (scope, element, attrs) {
            element.bind('change', function () {

                $parse(attrs.ngFile).assign(scope, element[0].files);
                scope.$apply();
            });
        }
    };
}]);

app.directive('ngFiles', ['$parse', function ($parse) {

    function file_links(scope, element, attrs) {
        var onChange = $parse(attrs.ngFiles);
        element.on('change', function (event) {
            onChange(scope, { $files: event.target.files });
        });
    }

    return {
        restrict: 'A',
        link: file_links
    }
}]);



