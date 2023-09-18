app.service('fileUploadService', function ($http, $q) {

    this.uploadFileToUrl = function (file, uploadUrl,id = null) {
        //FormData, object of key/value pair for form fields and values
        var fileFormData = new FormData();
        fileFormData.append('file', file);
        if (id){
            fileFormData.append('id', id);
        }
        return $http.post(uploadUrl, fileFormData, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined}

        });
    }
});