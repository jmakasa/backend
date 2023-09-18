@extends('backend.layout')
@push('extra-js')
    
<script type="text/javascript">
  var _config = {
      user_id: '{{$userId}}'
  };
</script>


<script src="{{ asset('public/libs/angularJs-1.8.2/src/ctrl/CustomerServicesCtrl.js') }}"></script>
<script src="{{ asset('public/libs/angularJs-1.8.2/src/service/fileService.js') }}"></script>
@endpush
@section('content')
    <div class="container-fluid" ng-controller="CustomerServicesCtrl">
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
                                <li class="breadcrumb-item"><a
                                        href="{{ env('MARKETING_URL') }}marketing/mandashboard.php?action=view">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Customer Service</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col">
                    </div>
                </div>
                <div class="row ">
                    <div class="col col-lg-8">
                        <div class="row mt-2">
                            <div class="col">
                                <div class="panel main_panel">
                                    <div class="panel-header">
                                        <div class="panel-title" id="allProductsTitle">All Tickets</div>
                                        <div class="panel-tool"></div>
                                    </div>
                                    <div class="panel-body">
                                        <div id="allTicketListtoolbar" style="height:40px;" class="datagrid-toolbar">
                                            <div style="height:30px;margin-top:5px;">
                                                <input id="searchTicketType" name="type" type="text">
                                                <input id="searchTicketAssignee" name="assignee" type="text">
                                                <input id="searchTicketStatus" name="status" type="text">
                                                <a href="javascript:void(0);" class="btn btn-sm btn-orange"
                                            ng-click="resetFilter()" title="Reset"><i class="bi bi-arrow-clockwise"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-orange float-end"
                                            ng-click="showTicketModal()"><i class="bi bi-pencil"></i> Update </a>
                                        </div>
                                        </div>
                                        <table id="ticketList" class="table  table-striped m-1"></table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-4">
                        <div class="row mt-2">
                            <div class="col">
                                <div class="panel main_panel">
                                    <div class="panel-header">
                                        <div class="panel-title" id="allProductsTitle">Recent Updated</div>
                                        <div class="panel-tool"></div>
                                    </div>
                                    <div class="panel-body">
                                        <table id="ticketRecentUpdatedList" class="table  table-striped m-1"></table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <div class="panel main_panel">
                                    <div class="panel-header">
                                        <div class="panel-title" id="allProductsTitle">You have been mentioned</div>
                                        <div class="panel-tool"></div>
                                    </div>
                                    <div class="panel-body">
                                        <table id="youBeenMentionedList" class="table  table-striped m-1"></table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

  <!-- Begin of ticket Form Modal -->
  <div class="modal fade" id="ticketFormModal" tabindex="-1" aria-labelledby="ticketFormModal"
  aria-hidden="true">
  <div class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Ticket Form</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form class="ng-invalid ng-invalid-required" name="ticketFrm" ng-submit="submitAddTicket(ticketFrm)">
              <div class="modal-body">
                  <!-- start form -->
                  <div class="mb-3 row">
                      <label for="atf_ticket_desc" class="col-sm-2 col-form-label text-end">Ticket Description
                          :*</label>
                      <div class="col-sm-8">
                          <textarea class="form-control form-control-sm" id="atf_ticket_desc" name="ticket_desc" rows="3"
                              ng-model="addTicketformData.ticket_desc"></textarea>
                          <span ng-show="addTicketformData.submitted && !addTicketformData.ticket_desc" class="text-danger fs-6">Ticket Desc
                              is required</span>
                      </div>
                  </div>
                  <div class="mb-3 row">
                      <label for="atf_assignee" class="col-sm-2 col-form-label text-end">Assignee :*</label>
                      <div class="col-sm-3">
                          <select ng-model="addTicketformData.assignee" name="assignee"
                              ng-options="assignee.name for assignee in ticketsFormSettings.assignees track by assignee.id"
                              class="form-select form-select-sm" required>
                              <option value="">-- Select Assignee --</option>
                          </select>
                          {{-- <div ng-show="!addTicketformData.validate_assignee" class="text-danger fs-6">Assignee is
                              required</div> --}}
                      </div>
                      <label for="atf_start_datetime" class="col-sm-2 col-form-label text-end">Start date
                          :*</label>
                      <div class="col-sm-3">
                          <input type="text" class="form-control form-control-sm" name="start_datetime"
                              id="start_datetime" datepicker ng-model="addTicketformData.start_datetime"
                              required />
                          {{-- <div ng-show="!addTicketformData.validate_start_datetime" class="text-danger fs-6 ">
                              Start date is required</div> --}}
                      </div>
 
                  </div>
                  <div class="mb-3 row">
                      <label for="atf_status" class="col-sm-2 col-form-label text-end">Status :*</label>
                      <div class="col-sm-3">
                          <select ng-model="addTicketformData.tstatus" name="tstatus"
                              ng-options="status.value for status in ticketsFormSettings.status"
                              class="form-select form-select-sm" required>
                              <option value="">-- Select Status --</option>
                          </select>
                          {{-- <div ng-show="!addTicketformData.validate_tstatus" class="text-danger fs-6">Status is
                              required</div> --}}
                      </div>
                      <label for="atf_due_datetime" class="col-sm-2 col-form-label text-end">Due date</label>
                      <div class="col-sm-3">
                          <input type="text" class="form-control form-control-sm" id="due_datetime"
                              datepicker ng-model="addTicketformData.due_datetime" />
                      </div>
                    </div>
                  <!-- end form -->
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="button" class="btn btn-primary"
                      ng-click="submitAddTicket()">Update</button>
              </div>
          </form>
      </div>
  </div>
 </div>
 <!-- END of ticket Form Modal -->

    </div>
@endsection
