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


    <script src="{{ asset('public/libs/angularJs-1.8.2/src/ctrl/EmployeesCtrl.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('public/libs/jquery-ui/jquery-ui.min.css') }}">
    <script src="{{ asset('public/libs/jquery-ui/jquery-ui.min.js') }}"></script>
@endpush
@section('content')
<style>
	.tree-icon{
		display:none;
	}
</style>
    <div class="container-fluid" ng-controller="EmployeesCtrl">
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
                                <li class="breadcrumb-item">
                                    <a href="{{ env('MARKETING_URL') }}marketing/mandashboard.php?action=view">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Employees</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col">
                        
                    </div>
                </div>
                <div class="row ">
                    <div class="col col-lg-2">
                        <div class="row ">
                            <div class="col">
                                <div id="p" class="easyui-panel" title="Departments"
                                    style="width:100%;height:750px;padding:10px;float:left;display:inline">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-orange mx-2"
                            ng-click="addDeptModal()"><i class="bi bi-plus"></i>&nbsp;Add</a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-orange mx-2"
                            ng-click="editDeptModal()"><i class="bi bi-pencil"></i>&nbsp;Edit</a>
                            <a href="javascript:void(0)"  class="btn btn-sm btn-orange mx-2"
                            ng-click="delDeptModal()"><i class="bi bi-trash"></i>&nbsp;Del</a>
                                    <ul class=" " id="departmentsTree"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-6">
                        <div class="row ">
                            <div class="col">
                                <empl-list-toolbar-directive></empl-list-toolbar-directive>
                                
                                <table id="employeesList" class="table  table-striped m-1">
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <no-selection-directive></no-selection-directive>
    <add-emp-depts-directive></add-emp-depts-directive>
    <edit-emp-depts-directive></edit-emp-depts-directive>
    <del-emp-depts-directive></del-emp-depts-directive>
    <add-empl-directive></add-empl-directive>
    <edit-empl-directive></edit-empl-directive>
    
    


    </div> <!-- end ng-ctrl-->
    


    </div>
    <script></script>
@endsection
