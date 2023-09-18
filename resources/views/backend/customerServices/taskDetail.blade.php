@extends('backend.layout')
@push('extra-js')
    <script type="text/javascript">
        var _config = {
            id: '{{ $id }}',
            attachment_path: '{{ asset('public/threads_attachments') }}/{{ $id }}/'
        };
    </script>
    <script src="{{ asset('public/libs/angularJs-1.8.2/src/ctrl/TaskDetailCtrl.js') }}"></script>
    <script src="{{ asset('public/libs/angularJs-1.8.2/src/service/fileService.js') }}"></script>
    {{-- datagrid-detailview.js --}}
    <script src="{{ asset('public/libs/easyui/extension/datagrid-detailview.js') }}"></script>
@endpush
@section('content')
    <div class="container-fluid" ng-controller="TaskDetailCtrl">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{env('MARKETING_URL')}}marketing/mandashboard.php?action=view">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ URL::route('cs.viewlist', array('locale' => app()->getLocale())) }}">Customer
                                        Service</a></li>
                                <li class="breadcrumb-item"><a href="#">Task</a></li>
                                <li class="breadcrumb-item active" aria-current="page"></li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col">
                    </div>
                </div>
                <div class="row">
                    <div class="col col-lg-6">
                        <div class="row">
                            <div class="col">
                                <h4>Task Detail</h4>
                            </div>
                        </div>
                        <div class="card border-orange">
                            <div class="card-header bg-orange">
                                Task #{#config.id#} <span class="badge bg-info text-dark">{#taskDetails.status#}</span>
                            </div>
                            <div class="card-body">
                              <a href="javascript:void(0);" ng-click="editTask()" class="btn btn-sm btn-orange float-end"><i class="bi bi-pencil-fill"></i>&nbsp;Edit</a>
                                <h5 class="card-title">{#taskDetails.subject#}</h5>
                                <table class="table">
                                    <tr>
                                        <td>Status:</td>
                                        <td>{#taskDetails.status#}</td>
                                        <td>Start Date:</td>
                                        <td>{#taskDetails.start_datetime|date:'yyyy/MM/dd'#}</td>
                                    </tr>
                                    <tr>
                                        <td>Assignee:</td>
                                        <td>{#taskDetails.assignee#}</td>
                                        <td>Due Date:</td>
                                        <td><span ng-show="taskDetails.due_datetime">{#taskDetails.due_datetime#}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Assignor:</td>
                                        <td>{#taskDetails.assignor#}</td>
                                        <td>Type:</td>
                                        <td>{#taskDetails.type#}</td>
                                    </tr>
                                    <tr>
                                        <td>Sender Email:</td>
                                        <td>{#taskDetails.from_email#}</td>
                                        <td>Created Date:</td>
                                        <td>{#taskDetails.created_at|date:'yyyy/MM/dd HH:m:s'#}</td>
                                    </tr>
                                    <tr>
                                        <td>Sender Firstname:</td>
                                        <td>{#taskDetails.from_firstname#}</td>
                                        <td>Sender Lastname:</td>
                                        <td>{#taskDetails.from_lastname#}</td>
                                    </tr>
                                    <tr>
                                        <td>Subject:</td>
                                        <td colspan='3'>{#taskDetails.subject#}</td>
                                    </tr>
                                    <tr>
                                        <td>Content:</td>
                                        <td colspan='3'>
                                            <ng-bind-html ng-bind-html="taskDetails.content | trustAsHtml"></ng-bind-html>
                                        </td>
                                    </tr>
                                    <tr class="bg-warning p-2 text-dark bg-opacity-15">
                                        <td>Task Description:</td>
                                        <td colspan='3'>
                                            <ng-bind-html ng-bind-html="taskDetails.task_desc | trustAsHtml"></ng-bind-html>
                                        </td>
                                    </tr>
                                    <tr ng-show="taskDetails.attachment">
                                        <td colspan='4'>Attachments:{#taskDetails.attachment#}</td>
                                    </tr>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-6">
                        {{-- thread list --}}
                        <div class="row">
                            <div class="col col-6">

                                <h4>All Threads</h4>
                            </div>
                            <div class="col col-6">
                                <span class="float-end">
                                    <button type="button" class="btn btn-primary btn-sm mb-1"
                                        ng-click="showAllThreadCollapse()">Show All Collapse</button>
                                    <button type="button" class="btn btn-secondary btn-sm mb-1"
                                        ng-click="hideAllThreadCollapse()">Hide All Collapse</button>
                                </span>
                            </div>
                        </div>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item" ng-repeat="thread in taskThreads">
                                <h4 class="accordion-header d-grid gap-2" id="headingOne">
                                    <button class="accordion-button" style="width:100%" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse{#thread.id#}"
                                        aria-expanded="true" aria-controls="collapse{#thread.id#}">
                                        <i class="bi bi-paperclip" ng-if="thread.attachment_cnt"></i> {#thread.id#} |
                                        {#thread.subject#} | <span
                                            class="badge bg-warning text-dark">{#thread.from_email#}</span> | <span
                                            data-ng-bind-html="thread.created_at| date:'yyyy-MM-dd HH:mm:ss' | date_ago|trustAsHtml"></span>&nbsp;
                                    </button>
                                </h4>
                                <div id="collapse{#thread.id#}" class="accordion-collapse collapse hide"
                                    aria-labelledby="headingOne">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col">
                                                <span data-ng-bind-html="thread.content|trustAsHtml"></span>
                                            </div>
                                        </div>
                                        <div class="row" ng-if="thread.attachment_cnt">
                                            <hr>
                                            <h5>Attachments :</h5>
                                            <div class="col col-2" ng-repeat="file in thread.attachment|split_string">
                                                <img src="{#config.attachment_path#}{#file#}" class="img-thumbnail"
                                                    alt="{#file#}" ng-click="showAttachment(file)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- END thread list --}}

                        <div class="card border-orange">
                            <div class="card-header bg-orange">
                                New Thread
                            </div>
                            <div class="card-body">
                                <form class="ng-invalid ng-invalid-required" name="addNewThreadFrm"
                                    ng-submit="submitAddNewThread(addNewThreadFrm)">
                                    <table class="table">
                                        <tr>
                                            <td class="text-end">To:</td>
                                            <td colspan="3">{#taskDetails.from_firstname#} {#taskDetails.from_lastname#}
                                                <{#taskDetails.from_email#}>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">CC:</td>
                                            <td><input name="cc" type="text" class="form-control form-control-sm"
                                                    id="new_thread_cc" ng-model="newThreadData.to_cc"></td>
                                            <td class="text-end">BCC:</td>
                                            <td><input name="bcc" type="text" class="form-control form-control-sm"
                                                    id="new_thread_bcc" ng-model="newThreadData.to_bcc"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">Content:</td>
                                            <td colspan="3">
                                                <textarea class="form-control form-control-sm" id="new_thread_content" name="content" rows="3"
                                                    ng-model="newThreadData.content"></textarea>
                                                    
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">Attachment:</td>
                                            <td colspan="3">
                                                <input type="file" file-uploads-model="myFile" class="form-control"
                                                    id="uploadAttachment" multiple />
                                            </td>
                                        </tr>
                                    </table>
                                    <div ng-if="newThreadError" id='errMsgThreadContent' class="alert alert-danger" role="alert">
                                      Thread Content is required
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="d-grid gap-2 d-md-block">
                                    <button class="btn btn-primary" type="button" ng-click="sendThread()"><i class="bi bi-send me-2"></i>Add New
                                        Thread</button>
                                    <button class="btn btn-secondary" type="button" ng-click="resetForm()"><i
                                            class="bi bi-x-lg me-2"></i>Clear</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <!-- Begin of Main Form Modal -->
            <div class="modal fade" id="addTaskFormModal" tabindex="-1" aria-labelledby="addTaskModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Task Form</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form class="ng-invalid ng-invalid-required" name="addTaskFrm"
                            ng-submit="submitAddTask(addTaskFrm)">
                            <div class="modal-body">

                                <!-- start form -->
                                <div class="mb-3 row">
                                    <label for="atf_post_date"
                                        class="col-sm-2 col-form-label col-form-label-sm text-end">Date :</label>
                                    <div class="col-sm-3 fs-6 border border-dark">
                                        {#addTaskformData.post_date#}
                                    </div>
                                    <label for="atf_ip" class="col-sm-2 col-form-label col-form-label-sm text-end">IP
                                        :</label>
                                    <div class="col-sm-3 fs-6 border border-dark">
                                        {#addTaskformData.ip#}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="atf_firstname"
                                        class="col-sm-2 col-form-label col-form-label-sm text-end">Firstname :</label>
                                    <div class="col-sm-3 fs-6 border border-dark">
                                        {#addTaskformData.firstname#}
                                    </div>
                                    <label for="atf_lastname"
                                        class="col-sm-2 col-form-label col-form-label-sm text-end">Lastname :</label>
                                    <div class="col-sm-3 fs-6 border border-dark">
                                        {#addTaskformData.lastname#}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="atf_email"
                                        class="col-sm-2 col-form-label col-form-label-sm text-end">Email :</label>
                                    <div class="col-sm-8 fs-6 border border-dark">
                                        {#addTaskformData.email#}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="atf_subject"
                                        class="col-sm-2 col-form-label col-form-label-sm text-end">Subject :</label>
                                    <div class="col-sm-8 fs-6 border border-dark">
                                        {#addTaskformData.subject#}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="atf_longDesc" class="col-sm-2 col-form-label text-end">Description
                                        :</label>
                                    <div class="col-sm-8 fs-6 border border-dark">
                                        <span ng-bind-html="addTaskformData.descriptionHTML"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row" ng-show="addTaskformData.attachments">
                                    <label for="atf_attachments" class="col-sm-2 col-form-label text-end">Attachments
                                        :</label>
                                    <div class="col-sm-10">
                                        <img src="{#addTaskformData.attachments#}" class="img-thumbnail">
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3 row">
                                    <label for="atf_task_desc" class="col-sm-2 col-form-label text-end">Task Description
                                        :*</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control form-control-sm" id="atf_task_desc" name="task_desc" rows="3"
                                            ng-model="addTaskformData.task_desc"></textarea>
                                        <div ng-show="!addTaskformData.validate_task_desc" class="text-danger fs-6">Task
                                            Desc is required</div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="atf_assignee" class="col-sm-2 col-form-label text-end">Assignee :*</label>
                                    <div class="col-sm-3">
                                        <select ng-model="addTaskformData.assignee" name="assignee"
                                            ng-options="assignee.name for assignee in tasksFormSettings.assignees track by assignee.email"
                                            class="form-select form-select-sm" required>
                                            <option value="">-- Select Assignee --</option>
                                        </select>
                                        <div ng-show="!addTaskformData.validate_assignee" class="text-danger fs-6">
                                            Assignee is required</div>
                                    </div>
                                    <label for="atf_start_datetime" class="col-sm-2 col-form-label text-end">Start date
                                        :*</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" name="start_datetime"
                                            id="start_datetime" datepicker ng-model="addTaskformData.start_datetime"
                                            required />
                                        <div ng-show="!addTaskformData.validate_start_datetime" class="text-danger fs-6 ">
                                            Start date is required</div>
                                    </div>

                                </div>
                                <div class="mb-3 row">
                                    <label for="atf_status" class="col-sm-2 col-form-label text-end">Status :*</label>
                                    <div class="col-sm-3">
                                        <select ng-model="addTaskformData.tstatus" name="tstatus"
                                            ng-options="status.value for status in tasksFormSettings.status"
                                            class="form-select form-select-sm" required>
                                            <option value="">-- Select Status --</option>
                                        </select>
                                        <div ng-show="!addTaskformData.validate_tstatus" class="text-danger fs-6">Status
                                            is required</div>
                                    </div>
                                    <label for="atf_due_datetime" class="col-sm-2 col-form-label text-end">Due
                                        date</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="due_datetime"
                                            datepicker ng-model="addTaskformData.due_datetime" />
                                    </div>
                                </div>

                                <!-- end form -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" ng-disabled="!newThreadError"
                                    ng-click="submitAddTask()">Add Task</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END of Main Form Modal -->
            <!-- image modal -->
            <div class="modal fade" id="attachmentModal" tabindex="-1" aria-labelledby="addTaskModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Attachment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img ng-src="{#attachmentSrc.src#}" id="attachmentPreview" class="img-fluid">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end image modal -->
            <!-- edit task modal -->
            <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="ng-invalid ng-invalid-required" name="editTaskFrm"
                            ng-submit="updateTask(editTaskFrm)">
                                <div class="mb-3 row">
                                    <label for="atf_task_desc" class="col-sm-2 col-form-label text-end">Task Description
                                        :*</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control form-control-sm" id="edit_task_desc" name="task_desc" rows="3"
                                            ng-model="taskDetails.task_desc"></textarea>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="atf_status" class="col-sm-2 col-form-label text-end">Status :*</label>
                                    <div class="col-sm-3">
                                      <select ng-model="taskDetails.tstatus" name="status" ng-options="status.value for status in tasksFormSettings.status"  class="form-select form-select-sm" required>
                                      </select>
                                    </div>
                                    <label for="atf_due_datetime" class="col-sm-2 col-form-label text-end">Due date</label>
                                    <div class="col-sm-3">
                                      <input type="text" class="form-control form-control-sm" id="edit_due_datetime" name="edit_due_datetime" datepicker ng-model="taskDetails.due_datetime"/>
                                    </div>
                                  </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="updateTask()">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end edit task modal -->
        </div>
    </div>
    @endsection
