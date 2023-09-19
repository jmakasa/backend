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


<script src="{{ asset('public/libs/angularJs-1.8.2/src/ctrl/EmployeeDepartmentsCtrl.js') }}?v=123"></script>
<link rel="stylesheet" href="{{ asset('public/libs/jquery-ui/jquery-ui.min.css') }}">
    <script src="{{ asset('public/libs/jquery-ui/jquery-ui.min.js') }}"></script>
@endpush
@section('content')
<div class="container-fluid" ng-controller="EmployeeDepartmentsCtrl">
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
                            <li class="breadcrumb-item"><a href="{{env('MARKETING_URL')}}marketing/mandashboard.php?action=view">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Employees</li>
                        </ol>
                    </nav>
                </div>
                <div class="col">
                </div>
            </div>
                <div class="row ">
                  <div class="col col-lg-6">
                    <div class="row ">
                      <div class="col">
                    <table id="employeeList" class="table  table-striped m-1">
                    </table>
                  </div>
                </div>
              </div>
              <div class="col col-lg-6">
                <div class="card border-warning">
                  <div class="card-header">
                    <i class="bi bi-envelope"></i>&nbsp;Email Content
                  </div>
                  <div class="card-body">

                  </div>
                  <div class="card-footer text-body-secondary">
                  </div>
                </div>
              </div>

            </div>

        </div>
    </div>
</div>
<script>

</script>
@endsection