app.controller('TicketDetailCtrl', [
    '$scope', 'dataFactory', '$window', '$sce', '$filter', 'fileUploadService', 'constFactory',
    function TicketDetailCtrl($scope, dataFactory, $window, $sce, $filter, fileUploadService, constFactory) {
        const $ctrl = this;
        $scope.config = _config;
        $scope.addTicketformData = [];
        $scope.datevalue = "";
        $scope.ticketsFormSettings = [];
        $scope.ticketDetails = [];
        
        $scope.currentDate = new Date();
        var optLangs = [];
        $scope.showAddTicketBtn = false;
        $scope.newThreadData = {};
        $scope.newNoteData = {};

        $scope.ticketThreads = [];
        $scope.attachmentSrc = {};

        $scope.hasMentioned = [];

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
            $scope.editTicketError = false;
            // get ticket setting
            dataFactory.getTicketsFormSettings().then(function (resp) {
                $scope.ticketsFormSettings = resp.data;
            });

            dataFactory.getTicketDetailById($scope.config).then(function (resp) {
                if (resp.data.result) {
                    $scope.ticketDetails = resp.data.data;
                    if ($scope.ticketDetails.start_datetime != null) {
                        $scope.ticketDetails.start_datetime = new Date($scope.ticketDetails.start_datetime);
                    }

                    if ($scope.ticketDetails.due_datetime != null) {
                        $scope.ticketDetails.due_datetime = new Date($scope.ticketDetails.due_datetime);
                    }
                    $scope.ticketDetails.contentHTML = $sce.trustAsHtml($scope.ticketDetails.content);
                    $scope.ticketDetails.ticket_descHTML = $sce.trustAsHtml($scope.ticketDetails.ticket_desc);
                }
            });

            dataFactory.getTicketThreadListById($scope.config).then(function (resp) {
                if (resp.status == '200') {
                    $scope.ticketThreads = resp.data;
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
            // get ticket notes
            dataFactory.getTicketNotesListById($scope.config).then(function (resp) {
                if (resp.data.result) {
                    $scope.ticketNotes = resp.data.data;
                }
            });
        } // end init

        $scope.updateFormValidation = function (content){
            if (content && content != '<p><br></p>' ){
                document.getElementById("errMsgThreadContent").style.display = "none";
            } else {
                document.getElementById("errMsgThreadContent").style.display = "block";
            }
        }

        $scope.updateEditTicketFormValidation = function (){
            
            if (content && content != '<p><br></p>' ){
                document.getElementById("errMsgTicketStatus").style.display = "none";
            } else {
                document.getElementById("errMsgTicketStatus").style.display = "block";
            }
        }

        $scope.sendThread = function () {
            $scope.newThreadSubmitted = true;
            console.log($scope.newThreadData);
            $scope.sendThread.disabled=true;
            if ($scope.newThreadData.content == "" || $scope.newThreadData.content == "<p><br></p>" || $scope.newThreadData.content == undefined || $scope.newThreadData.content == "" || $scope.newThreadData.content.lenght == 0) {
                console.log(' sendThread - validation failture');
                console.log($scope.newThreadData.content);
                $scope.newThreadError = true;
            } else {
                $scope.newThreadError = false;
                // send thread 
                $scope.newThreadData.tickets_id = $scope.ticketDetails.id;
                $scope.newThreadData.subject = $scope.ticketDetails.subject + " (TICKETNO#" + $scope.ticketDetails.id + ")";
                $scope.newThreadData.to_email = $scope.ticketDetails.from_email;
                $scope.newThreadData.to_firstname = $scope.ticketDetails.from_firstname;
                $scope.newThreadData.to_lastname = $scope.ticketDetails.from_lastname;

                var uploadFiles = $scope.myFile;
                console.log($scope.myFile);
                console.log($("#uploadAttachment").val());
                var uploadFilesName = [];

                angular.forEach(uploadFiles, function (file, key) {
                    uploadFilesName.push(file.name);
                    var uploadUrl = constFactory.getUrlApi() + "/tickets/threads/attachment/upload", //Url of webservice/api/server
                        promise = fileUploadService.uploadFileToUrl(file, uploadUrl, $scope.newThreadData.tickets_id);

                    promise.then(function (response) {
                        console.log(response);
                        $scope.serverResponse = response;
                    }, function () {
                        $scope.serverResponse = 'An error has occurred';
                    });
                });

                $scope.newThreadData.file = uploadFilesName;

                dataFactory.addNewTicketThread($scope.newThreadData).then(function (resp) {
                    $scope.newThreadError = false;
                    // TODO ::check resp
                    if (resp.status == '200') {
                        dataFactory.getTicketThreadListById($scope.config).then(function (resp) {
                            if (resp.status == '200') {
                                $scope.ticketThreads = resp.data;
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

        // edit ticket
        $scope.editTicket = function (){
            $scope.ticketDetails.tassignee = $filter('getByValue')($scope.ticketsFormSettings.assignees, $scope.ticketDetails.assignee);
            $scope.ticketDetails.tstatus = $filter('getByValue')($scope.ticketsFormSettings.status, $scope.ticketDetails.status);
            $scope.ticketDetails.start_datetime = $filter('date')($scope.ticketDetails.start_datetime, "yyyy-MM-dd");
            $scope.ticketDetails.due_datetime = $filter('date')($scope.ticketDetails.due_datetime, "yyyy-MM-dd");
                    $("#edit_ticket_desc").summernote({
                        'code' : $scope.ticketDetails.ticket_desc,
                        height: '150px',
                        callbacks: {
                            onKeyup: function(e) {
                                setTimeout(function(){
                                    $scope.ticketDetails.ticket_desc = $('#edit_ticket_desc').val();
                            //        $scope.updateFormValidation($scope.newThreadData.content);
                                },200);
                              }
                        }
                    });
            
            $('#editTicketModal').modal('show');
        }

        $scope.updateTicket = function (){
            $scope.ticketDetails.assignee = $scope.ticketDetails.tassignee;
            dataFactory.updateTicketDetail($scope.ticketDetails).then(function (resp) {
                $scope.editTicketError = false;
                //  check resp
                if (resp.status == '200') {
                    $scope.ticketDetails.status = $scope.ticketDetails.tstatus.value;
                    $scope.ticketDetails.assignee = $scope.ticketDetails.tassignee.value;
                    $('#editTicketModal').modal('hide');
                } else {
                    console.log('error'+resp);
                }
            });
        }

        $scope.openAddTicketNote = function (id) {
            $scope.newNoteData.tickets_id = id;
           // var noteContent = $("#add_ticket_note_content").summernote();
            $("#add_ticket_note_content").summernote({
                    height: '300px',
                    callbacks: {
                        onKeyup: function (e) {
                            setTimeout(function () {
                                $scope.newNoteData.content = $('#add_ticket_note_content').val();
                            }, 200);
                        },
                        onChange: function (e){
                            console.log('on change');
                            $scope.newNoteData.content = $('#add_ticket_note_content').val();
                        }
                },
                    hint: {
                    mentions: $scope.ticketsFormSettings.assignees,
                    match: /\B@([a-z ]*)/i,
                    search: function (keyword, callback) {
                        callback($.grep(this.mentions, function (item) {
                            return item.name.toLowerCase().indexOf(keyword.toLowerCase()) == 0;
                        }));
                    },
                    template: function (item) {
                        return item.name;
                    },
                    content: function (item) { 
                        console.log(item);
                        $scope.hasMentioned.push(item.id);  
                        var returnVal =     $('<a>')
                        .attr('href', item.email)
                        .attr('id', 'mentioned')
                        .attr('title', item.email)
                        .text('@' + item.name)
                        .attr('data-name', item.name)
                        .attr('class', 'badge bg-primary text-white')
                     .attr('data-email', item.email)
                        .get(0);
                        console.log(returnVal);           
                        return returnVal;
                    }
                }
            });

            $('#addTicketNoteModal').modal('show');
        };
        function summernoteInsertNote(){
            setTimeout(() => { 
                console.log('insertText');
                $('#add_ticket_note_content').summernote('editor.insertText', ' ');
                console.log('insertText');
            }, 100);
            
        }

        $scope.addTicketNote = function (){
            console.log($scope.hasMentioned);
            console.log('addTicketNote');
            //$scope.editTicketError = true;
            console.log($('#add_ticket_note_content').val());
            $scope.newNoteData.content = $('#add_ticket_note_content').val();
        $scope.newNoteData.mentioned = $scope.hasMentioned;
            console.log($scope.newNoteData);
            //add_ticket_note_content
            dataFactory.addTicketNote($scope.newNoteData).then(function (resp) {
                $scope.editTicketNoteError = false;
                console.log(resp);
                // TODO ::check resp
                if (resp.status == '200') {
                    //$scope.ticketDetails.status = $scope.ticketDetails.tstatus.value;
                    // get ticket notes
                    dataFactory.getTicketNotesListById($scope.config).then(function (resp) {
                        console.log("ticket notes");
                        if (resp.data.result) {
                            $scope.ticketNotes = resp.data.data;

                        }
                    });
                    $('#addTicketNoteModal').modal('hide');

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
            console.log(filename);
            let fileExt = filename.split('.').pop();
            const regex = /(?:jpeg|jpg|tiff?|gif|png)/i;
            if (regex.test(fileExt)) {
                $scope.attachmentSrc = { 'src': $scope.config.email_attachment_path + filename };
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


]).directive('ticketDetailDirective', ['$compile', '$templateCache', function ($compile, $templateCache) {
    return {
        templateUrl: '../../../../public/libs/angularJs-1.8.2/src/htmlTpl/tickets/ngDetail.html',
        scope: true,
        restrict: 'E',
        link: function(scope, element,attrs) {
            var template = $templateCache.get('ticketDetailDirective');
            element.html(template);
            $compile(element.contents())(scope);
        }
    };
}]).directive('ticketThreadsDirective', ['$compile', '$templateCache', function ($compile, $templateCache) {
    return {
        templateUrl: '../../../../public/libs/angularJs-1.8.2/src/htmlTpl/tickets/ngDetail.html',
        scope: true,
        restrict: 'E',
        link: function(scope, element,attrs) {
            var template = $templateCache.get('ticketThreadsDirective');
            element.html(template);
            $compile(element.contents())(scope);

            // setup summernote
            $("#new_thread_content").summernote({
                height: '150px',
                callbacks: {
                    onKeyup: function(e) {
                        setTimeout(function(){
                            scope.newThreadData.content = $('#new_thread_content').val();
                            scope.updateFormValidation(scope.newThreadData.content);
                        },200);
                      }
                }
            });

        }
    };
}]);