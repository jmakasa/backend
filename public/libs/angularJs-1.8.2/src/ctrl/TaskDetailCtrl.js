app.controller('TaskDetailCtrl', [
    '$scope', 'dataFactory', '$window', '$sce', '$filter', 'fileUploadService', 'constFactory',
    function TaskDetailCtrl($scope, dataFactory, $window, $sce, $filter, fileUploadService, constFactory) {
        const $ctrl = this;
        $scope.config = _config;
        $scope.addTaskformData = [];
        $scope.datevalue = "";
        $scope.tasksFormSettings = [];
        $scope.taskDetails = [];
        $scope.currentDate = new Date();
        var optLangs = [];
        $scope.showAddTaskBtn = false;
        $scope.newThreadData = {};

        $scope.taskThreads = [];
        $scope.attachmentSrc = {};
        // get lang
        if ($window.sessionStorage.lang) {
            $scope.lang = $window.sessionStorage.lang;
        } else {
            $scope.lang = document.documentElement.getAttribute("lang");
        }

        // load init
        $ctrl.$onInit = () => {
            $scope.newThreadError = false;
            $scope.newThreadSubmitted = false;
            $scope.editTaskError = false;
            // get task setting
            dataFactory.getTasksFormSettings().then(function (resp) {
                $scope.tasksFormSettings = resp.data;
            });

            dataFactory.getTaskDetailById($scope.config).then(function (resp) {
                console.log("task details");

                if (resp.data.result) {
                    console.log(resp.data.data);
                    $scope.taskDetails = resp.data.data;
                    $scope.taskDetails.start_datetime = new Date($scope.taskDetails.start_datetime);

                    if ($scope.taskDetails.due_datetime != null) {
                        $scope.taskDetails.due_datetime = new Date($scope.taskDetails.due_datetime);
                    }
                    $scope.taskDetails.contentHTML = $sce.trustAsHtml($scope.taskDetails.content);
                    $scope.taskDetails.task_descHTML = $sce.trustAsHtml($scope.taskDetails.task_desc);
                }
            });

            dataFactory.getThreadListById($scope.config).then(function (resp) {
                if (resp.status == '200') {
                    $scope.taskThreads = resp.data;
                }
            });

            $("#new_thread_content").summernote({
                height: '150px',
                callbacks: {
                    onKeyup: function(e) {
                        setTimeout(function(){
                            $scope.newThreadData.content = $('#new_thread_content').val();
                            $scope.updateFormValidation($scope.newThreadData.content);
                        },200);
                      }
                }
            });



        } // end init

        $scope.updateFormValidation = function (content){
            console.log(content);
            if (content && content != '<p><br></p>' ){
                document.getElementById("errMsgThreadContent").style.display = "none";

                
            } else {
                document.getElementById("errMsgThreadContent").style.display = "block";
            }
        }

        $scope.updateEditTaskFormValidation = function (){
            
            if (content && content != '<p><br></p>' ){
                document.getElementById("errMsgTaskStatus").style.display = "none";
            } else {
                document.getElementById("errMsgTaskStatus").style.display = "block";
            }
        }

        $scope.sendThread = function () {
            $scope.newThreadSubmitted = true;
            $scope.sendThread.disabled=true;
            if ($scope.newThreadData.content == "" || $scope.newThreadData.content == "<p><br></p>" || $scope.newThreadData.content == undefined || $scope.newThreadData.content == "" || $scope.newThreadData.content.lenght == 0) {
                console.log('form failed');
                $scope.newThreadError = true;
            } else {
                $scope.newThreadError = false;
                // TODO :: send thread 
                $scope.newThreadData.task_id = $scope.taskDetails.id;
                $scope.newThreadData.subject = $scope.taskDetails.subject + " (REFNO#" + $scope.taskDetails.id + ")";
                $scope.newThreadData.to_email = $scope.taskDetails.from_email;
                $scope.newThreadData.to_firstname = $scope.taskDetails.from_firstname;
                $scope.newThreadData.to_lastname = $scope.taskDetails.from_lastname;

                var uploadFiles = $scope.myFile;
                var uploadFilesName = [];

                angular.forEach(uploadFiles, function (file, key) {

                    uploadFilesName.push(file.name);
                    var uploadUrl = constFactory.getUrlApi() + "/threads/attachment/upload", //Url of webservice/api/server
                        promise = fileUploadService.uploadFileToUrl(file, uploadUrl, $scope.newThreadData.task_id);

                    promise.then(function (response) {
                        console.log(response);
                        $scope.serverResponse = response;
                    }, function () {
                        $scope.serverResponse = 'An error has occurred';
                    });
                });
                $scope.newThreadData.file = uploadFilesName;

                dataFactory.addNewThread($scope.newThreadData).then(function (resp) {
                    $scope.newThreadError = false;
                    // TODO ::check resp
                    if (resp.status == '200') {
                        dataFactory.getThreadListById($scope.config).then(function (resp) {
                            if (resp.status == '200') {
                                $scope.taskThreads = resp.data;
                                $scope.sendThread.disabled=false;
                                // clear form
                                $scope.resetForm();
                            }
                        });
                    } else {
                        console.log('error'+resp);
                    }
                });
            }

        }

        // edit task
        $scope.editTask = function (){
            console.log(" edit task ");
            $scope.taskDetails.tstatus = $filter('getByValue')($scope.tasksFormSettings.status,$scope.taskDetails.status);
                    $("#edit_task_desc").summernote({
                        'code' : $scope.taskDetails.task_desc,
                        height: '150px',
                        callbacks: {
                            onKeyup: function(e) {
                                setTimeout(function(){
                                    $scope.taskDetails.task_desc = $('#edit_task_desc').val();
                            //        $scope.updateFormValidation($scope.newThreadData.content);
                                },200);
                              }
                        }
                    });
            
            $('#editTaskModal').modal('show');
        }

        $scope.updateTask = function (){
            console.log('updateTask');
            //$scope.editTaskError = true;
            dataFactory.updateTaskDetail($scope.taskDetails).then(function (resp) {
                $scope.editTaskError = false;
                console.log(resp);
                // TODO ::check resp
                if (resp.status == '200') {
                    $scope.taskDetails.status = $scope.taskDetails.tstatus.value;
                    $('#editTaskModal').modal('hide');
                } else {
                    console.log('error'+resp);
                }
            });
        }

        // upload 
        $scope.resetForm = function () {
            $('#new_thread_content').summernote('reset');
            $scope.newThreadData = {};
            angular.element("input[type='file']").val(null);
            $scope.newThreadSubmitted = false;
        };
        // end upload 

        // button
        $scope.showAttachment = function (filename) {
            let fileExt = filename.split('.').pop();
            const regex = /(?:jpeg|jpg|tiff?|gif|png)/i;
            if (regex.test(fileExt)) {
                $scope.attachmentSrc = { 'src': $scope.config.attachment_path + filename };
                $('#attachmentModal').modal('show');
            } else {
                $window.open($scope.config.attachment_path + filename, '_blank');
            }
        }


        $scope.hideAllThreadCollapse = function () {
            $('.collapse').removeClass('show');
            $('.collapse').addClass('hide');
        }

        $scope.showAllThreadCollapse = function () {
            $('.collapse').removeClass('hide');
            $('.collapse').addClass('show');
        }
        // end button

        // watch
        $scope.$watch('newThreadData.content', function () {
             console.log($scope.newThreadData.content);
        });
        // end watch 


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