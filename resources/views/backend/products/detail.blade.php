@extends('backend.layout')
@push('extra-js')
<script type="text/javascript">
  var _config = {
      partno: '{{$product->partno }}',
      id: '{{$product->id }}'
  };
</script>
<script src="{{ asset('public/js/angularJs-1.8.2/src/ctrl/ProductDetailCtrl.js') }}"></script>
@endpush
@section('content')

<div class="container-fluid" ng-controller="ProductDetailCtrl">
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
                            <li class="breadcrumb-item"><a href="marketing/manproducts.php?action=viewlist&webmenu=new">Library</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$product->partno }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col">
                    <a href="javascript:void(0)" class="btn btn-sm btn-primary" iconCls="icon-box-arrow-left" plain="true" onclick="export2oldweb()"><i class="bi bi-file-arrow-down"></i>&nbsp;Export to akasa10 WebPage</a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-orange" onclick="export2206web()"><i class="bi bi-file-arrow-down"></i>&nbsp;Export to akasa2206 WebPage</a>
                    <a href="../akasa2206/update.php?tpl=product/product.detail.tpl&&model={|$record.partno|}" class="btn btn-sm btn-orange" target="_blank"><i class="bi bi-eye-fill"></i>&nbsp;View Detail Page (Akasa 2206)
                    </a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-orange" onclick="copyProduct()"><i class="bi bi-files"></i>&nbsp;Copy Product</a>
                </div>
            </div>
            <div class="row">
                <div class="col">

                    <!-- Begin of tabs -->
                    <div class="easyui-tabs" style="width:1800px;height:870px;border:1px solid #d4a375" id="tt">
                     
                    @include('backend/products/details-tabs/mainInfo')
                    @include('backend/products/details-tabs/overview')
                    
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $('#tt').tabs({
      border: false,
      onSelect: function (title) {
        // check title to load tab content
        // Specification, Reviews (NEW), Related Products

        console.log(title + ' is selected');
        if (title == 'Simply') {
          dispmainform();
        }
        if (title == 'Specification') {
          $('#specList').datagrid('reload');
          $('#spec_group_list').tree('reload');
        } else if (title == 'Related Products') {
          $('#related_boxes').datalist('reload');
        }

      }
    });

    function editmain() {
    $.ajax({
      url: "./manproducts.php?action=getmainform&id={|$record.id|}&lang={|$lang|}",
      type: "GET",
      dataType: "json",
      success: function (data) {
        $('#mainform').form('load', data);
        if (data.active == '1') {
          $('#mf_active').checkbox('check');
        } else {
          $('#mf_active').checkbox('uncheck');
        }
        if (data.newproduct == '1') {
          $('#mf_newproduct').checkbox('check');
        } else {
          $('#mf_newproduct').checkbox('uncheck');
        }
        if (data.iscooler == '1') {
          $('#mf_iscooler').checkbox('check');
        } else {
          $('#mf_iscooler').checkbox('uncheck');
        }
        if (data.displaypartnoline == '1') {
          $('#mf_displaypartnoline').checkbox('check');
        } else {
          $('#mf_displaypartnoline').checkbox('uncheck');
        }
        $('#mainformdlg').dialog('open');
      }
    });
  }
</script>
@endsection