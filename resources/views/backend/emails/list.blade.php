@extends('backend.layout')
@push('extra-js')
{{--
<script type="text/javascript">
  var _config = {
      partno: '{{$product->partno }}',
      id: '{{$product->id }}'
  };
</script>
--}}


<script src="{{ asset('public/libs/angularJs-1.8.2/src/ctrl/EmailsCtrl.js') }}"></script>
@endpush
@section('content')

<div class="container-fluid" ng-controller="EmailsCtrl">
  
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="marketing/mandashboard.php?action=view">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Email List</li>
                        </ol>
                    </nav>
                </div>
                <div class="col">
                </div>
            </div>
            <div class="row ">
              <div class="col col-lg-6 p-2">
                <table id="emailList" class="table  table-striped">
                </table>
              </div>
              <div class="col col-lg-6">
                <a href="javascript:void(0)" style="margin:5px;" class="btn btn-sm btn-orange" ng-click="addTaskModal()"><i class="bi bi-pencil-fill"></i>&nbsp;Add task</a>
                <h6><i class="bi bi-envelope"></i>&nbsp;Email Content</h6>
                <div id="emailBox"></div>
                <h6><i class="bi bi-paperclip"></i>&nbsp;Attachments</h6>
                <div id="attachmentsBox"></div>
              </div>

            </div>

        </div>
    </div>


<!-- Begin of Main Form Modal -->
<div class="modal fade" id="addTaskFormModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Task Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="ng-invalid ng-invalid-required" name="addTaskFrm"  ng-submit="submitAddTask(addTaskFrm)">
      <div class="modal-body">
        
        <!-- start form -->
        <div class="mb-3 row">
          <label for="atf_post_date" class="col-sm-2 col-form-label col-form-label-sm text-end">Date :</label>
          <div class="col-sm-3 fs-6 border border-dark">
            {#addTaskformData.post_date#}
          </div>
          <label for="atf_ip" class="col-sm-2 col-form-label col-form-label-sm text-end">IP :</label>
          <div class="col-sm-3 fs-6 border border-dark">
            {#addTaskformData.ip#}
          </div>
        </div>
        <div class="mb-3 row">
          <label for="atf_firstname" class="col-sm-2 col-form-label col-form-label-sm text-end">Firstname :</label>
          <div class="col-sm-3 fs-6 border border-dark">
            {#addTaskformData.firstname#}
          </div>
          <label for="atf_lastname" class="col-sm-2 col-form-label col-form-label-sm text-end">Lastname :</label>
          <div class="col-sm-3 fs-6 border border-dark">
            {#addTaskformData.lastname#}
          </div>
        </div>
        <div class="mb-3 row">
          <label for="atf_email" class="col-sm-2 col-form-label col-form-label-sm text-end">Email :</label>
          <div class="col-sm-8 fs-6 border border-dark">
            {#addTaskformData.email#}
          </div>
        </div>
        <div class="mb-3 row">
          <label for="atf_subject" class="col-sm-2 col-form-label col-form-label-sm text-end">Subject :</label>
          <div class="col-sm-8 fs-6 border border-dark">
            {#addTaskformData.subject#}
          </div>
        </div>
        <div class="mb-3 row">
          <label for="atf_longDesc" class="col-sm-2 col-form-label text-end">Description :</label>
          <div class="col-sm-8 fs-6 border border-dark">
            <span ng-bind-html="addTaskformData.descriptionHTML"></span>
          </div>
        </div>
        <div class="mb-3 row" ng-show="addTaskformData.attachments">
          <label for="atf_attachments" class="col-sm-2 col-form-label text-end">Attachments :</label>
          <div class="col-sm-10">
            <img src="{#addTaskformData.attachments#}" class="img-thumbnail">
          </div>
        </div>
        <hr>
        <div class="mb-3 row">
          <label for="atf_task_desc" class="col-sm-2 col-form-label text-end">Task Description :*</label>
          <div class="col-sm-8">
            <textarea class="form-control form-control-sm" id="atf_task_desc" name="task_desc" rows="3" ng-model="addTaskformData.task_desc"></textarea>
            <div ng-show="!addTaskformData.validate_task_desc" class="text-danger fs-6">Task Desc is required</div>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="atf_assignee" class="col-sm-2 col-form-label text-end">Assignee :*</label>
          <div class="col-sm-3">
            <select ng-model="addTaskformData.assignee" name="assignee" ng-options="assignee.name for assignee in tasksFormSettings.assignees track by assignee.email"  class="form-select form-select-sm" required>
              <option value="">-- Select Assignee --</option>
            </select>
            <div ng-show="!addTaskformData.validate_assignee" class="text-danger fs-6">Assignee is required</div>
          </div>
          <label for="atf_start_datetime" class="col-sm-2 col-form-label text-end">Start date :*</label>
          <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm" name="start_datetime"  id="start_datetime" datepicker ng-model="addTaskformData.start_datetime" required/>
            <div ng-show="!addTaskformData.validate_start_datetime" class="text-danger fs-6 ">Start date is required</div>
        </div>
          
        </div>
        <div class="mb-3 row">
          <label for="atf_status" class="col-sm-2 col-form-label text-end">Status :*</label>
          <div class="col-sm-3">
            <select ng-model="addTaskformData.tstatus" name="tstatus" ng-options="status.value for status in tasksFormSettings.status"  class="form-select form-select-sm" required>
              <option value="">-- Select Status --</option>
            </select>
            <div ng-show="!addTaskformData.validate_tstatus" class="text-danger fs-6">Status is required</div>
          </div>
          <label for="atf_due_datetime" class="col-sm-2 col-form-label text-end">Due date</label>
          <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm" id="due_datetime" datepicker ng-model="addTaskformData.due_datetime"/>
          </div>
        </div>
      
        <!-- end form --> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" ng-disabled="!addTaskformData.submitting" ng-click="submitAddTask()">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>
<!-- END of Main Form Modal -->
</div>
<script>

</script>
@endsection