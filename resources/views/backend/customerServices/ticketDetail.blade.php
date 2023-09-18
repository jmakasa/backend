@extends('backend.layout')
@push('extra-js')
    <script type="text/javascript">
        var _config = {
            id: '{{ $id }}',
            attachment_path: '{{ asset('public/ticket_threads_attachments') }}/{{ $id }}/',
            email_attachment_path: '{{ asset('public/email_attachments') }}/'
        };
    </script>
    <script src="{{ asset('public/libs/angularJs-1.8.2/src/ctrl/TicketDetailCtrl.js') }}"></script>
    <script src="{{ asset('public/libs/angularJs-1.8.2/src/service/fileService.js') }}"></script>
    {{-- datagrid-detailview.js --}}
    <script src="{{ asset('public/libs/easyui/extension/datagrid-detailview.js') }}"></script>
@endpush
@section('content')
    <div class="container-fluid" ng-controller="TicketDetailCtrl">
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
                                <li class="breadcrumb-item"><a href="#">Ticket</a></li>
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
                                <h4>Ticket Detail</h4>
                            </div>
                        </div>
                        <ticket-detail-directive></ticket-detail-directive>
                    </div>
                    <div class="col col-lg-6">
                        <ticket-threads-directive></ticket-threads-directive>
                         <!-- {{-- END thread list --}} -->
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
                          <td colspan="3">{#ticketDetails.from_firstname#} {#ticketDetails.from_lastname#}
                              <{#ticketDetails.from_email#}>
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
                  <button class="btn btn-secondary" type="button" ng-click="resetForm()"><i class="bi bi-x-lg me-2"></i>Clear</button>
              </div>
          </div>
      </div>
                    </div>
                </div>
            </div>


            <!-- Begin of Main Form Modal -->
            <div class="modal fade" id="addTicketFormModal" tabindex="-1" aria-labelledby="addTicketModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Ticket Form</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form class="ng-invalid ng-invalid-required" name="addTicketFrm"
                            ng-submit="submitAddTicket(addTicketFrm)">
                            <div class="modal-body">

                                <!-- start form -->
                                <div class="mb-3 row">
                                    <label for="atf_post_date"
                                        class="col-sm-2 col-form-label col-form-label-sm text-end">Date :</label>
                                    <div class="col-sm-3 fs-6 border border-dark">
                                        {#addTicketformData.post_date#}
                                    </div>
                                    <label for="atf_ip" class="col-sm-2 col-form-label col-form-label-sm text-end">IP
                                        :</label>
                                    <div class="col-sm-3 fs-6 border border-dark">
                                        {#addTicketformData.ip#}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="atf_firstname"
                                        class="col-sm-2 col-form-label col-form-label-sm text-end">Firstname :</label>
                                    <div class="col-sm-3 fs-6 border border-dark">
                                        {#addTicketformData.firstname#}
                                    </div>
                                    <label for="atf_lastname"
                                        class="col-sm-2 col-form-label col-form-label-sm text-end">Lastname :</label>
                                    <div class="col-sm-3 fs-6 border border-dark">
                                        {#addTicketformData.lastname#}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="atf_email"
                                        class="col-sm-2 col-form-label col-form-label-sm text-end">Email :</label>
                                    <div class="col-sm-8 fs-6 border border-dark">
                                        {#addTicketformData.email#}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="atf_subject"
                                        class="col-sm-2 col-form-label col-form-label-sm text-end">Subject :</label>
                                    <div class="col-sm-8 fs-6 border border-dark">
                                        {#addTicketformData.subject#}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="atf_longDesc" class="col-sm-2 col-form-label text-end">Description
                                        :</label>
                                    <div class="col-sm-8 fs-6 border border-dark">
                                        <span ng-bind-html="addTicketformData.descriptionHTML"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row" ng-show="addTicketformData.attachments">
                                    <label for="atf_attachments" class="col-sm-2 col-form-label text-end">Attachments
                                        :</label>
                                    <div class="col-sm-10">
                                        <img src="{#addTicketformData.attachments#}" class="img-thumbnail">
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3 row">
                                    <label for="atf_ticket_desc" class="col-sm-2 col-form-label text-end">Ticket Description
                                        :*</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control form-control-sm" id="atf_ticket_desc" name="ticket_desc" rows="3"
                                            ng-model="addTicketformData.ticket_desc"></textarea>
                                        <div ng-show="!addTicketformData.validate_ticket_desc" class="text-danger fs-6">Ticket
                                            Desc is required</div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="atf_assignee" class="col-sm-2 col-form-label text-end">Assignee :*</label>
                                    <div class="col-sm-3">
                                        <select ng-model="addTicketformData.assignee" name="assignee"
                                            ng-options="assignee.name for assignee in ticketsFormSettings.assignees track by assignee.email"
                                            class="form-select form-select-sm" required>
                                            <option value="">-- Select Assignee --</option>
                                        </select>
                                        <div ng-show="!addTicketformData.validate_assignee" class="text-danger fs-6">
                                            Assignee is required</div>
                                    </div>
                                    <label for="atf_start_datetime" class="col-sm-2 col-form-label text-end">Start date
                                        :*</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" name="start_datetime"
                                            id="start_datetime" datepicker ng-model="addTicketformData.start_datetime"
                                            required />
                                        <div ng-show="!addTicketformData.validate_start_datetime" class="text-danger fs-6 ">
                                            Start date is required</div>
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
                                        <div ng-show="!addTicketformData.validate_tstatus" class="text-danger fs-6">Status
                                            is required</div>
                                    </div>
                                    <label for="atf_due_datetime" class="col-sm-2 col-form-label text-end">Due
                                        date</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="due_datetime"
                                            datepicker ng-model="addTicketformData.due_datetime" />
                                    </div>
                                </div>

                                <!-- end form -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" ng-disabled="!newThreadError"
                                    ng-click="submitAddTicket()">Add Ticket</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END of Main Form Modal -->
            <!-- image modal -->
            <div class="modal fade" id="attachmentModal" tabindex="-1" aria-labelledby="addTicketModalLabel"
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
            <!-- edit ticket modal -->
            <div class="modal fade" id="editTicketModal" tabindex="-1" aria-labelledby="addTicketModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Ticket</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="ng-invalid ng-invalid-required" name="editTicketFrm"
                            ng-submit="updateTicket(editTicketFrm)">
                                <div class="mb-3 row">
                                    <label for="atf_ticket_desc" class="col-sm-2 col-form-label text-end">Ticket Description
                                        :*</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control form-control-sm" id="edit_ticket_desc" name="ticket_desc" rows="3"
                                            ng-model="ticketDetails.ticket_desc"></textarea>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="atf_status" class="col-sm-2 col-form-label text-end">Status :*</label>
                                    <div class="col-sm-3">
                                      <select ng-model="ticketDetails.tstatus" name="status" ng-options="status.value for status in ticketsFormSettings.status"  class="form-select form-select-sm" required>
                                      </select>
                                    </div>
                                    <label for="atf_due_datetime" class="col-sm-2 col-form-label text-end">Start date</label>
                                    <div class="col-sm-3">
                                      <input type="text" class="form-control form-control-sm" id="edit_start_datetime" name="edit_start_datetime" datepicker ng-model="ticketDetails.start_datetime"/>
                                    </div>
                                    
                                  </div>
                                  <div class="mb-3 row">
                                    <label for="atf_assignee" class="col-sm-2 col-form-label text-end">Assignee :</label>
                                    <div class="col-sm-3">
                                        <select ng-model="ticketDetails.tassignee" name="assignee"
                                            ng-options="assignee.text for assignee in ticketsFormSettings.assignees track by assignee.value"
                                            class="form-select form-select-sm" required ng-disabled='true'>
                                            <option value="">-- Select Assignee --</option>
                                        </select>
                                        {{-- <div ng-show="!addTicketformData.validate_assignee" class="text-danger fs-6">
                                            Assignee is required</div> --}}
                                    </div>
                                    <label for="atf_due_datetime" class="col-sm-2 col-form-label text-end">Due date</label>
                                    <div class="col-sm-3">
                                      <input type="text" class="form-control form-control-sm" id="edit_due_datetime" name="edit_due_datetime" datepicker ng-model="ticketDetails.due_datetime"/>
                                    </div>
                                  </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="updateTicket()">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end edit ticket modal -->
                        <!-- edit ticket modal -->
                        <div class="modal fade" id="addTicketNoteModal" tabindex="-1" aria-labelledby="addTicketNoteModal"
                        aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addTicketNoteModalLabel">Add Note</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="ng-invalid ng-invalid-required" name="addTicketNoteFrm"
                                    ng-submit="updateTicketNote(addTicketNoteFrm)">
                                        <div class="mb-3 row justify-content-md-center">
                                            <div class="col-sm-10">
                                                <label for="add_ticket_note_content">Ticket note content
                                                    :*</label>
                                                <textarea class="form-control form-control-sm" id="add_ticket_note_content" name="ticket_note_content" rows="3"
                                                    ng-model="newNoteData.content"></textarea>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="addTicketNote()">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <!-- end edit ticket modal -->
        </div>
    </div>
    @endsection
