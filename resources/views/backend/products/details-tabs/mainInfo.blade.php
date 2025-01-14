
  <div title='Main Info'>
    <a href="javascript:void(0)" style="margin:5px;" class="btn btn-sm btn-orange" ng-click="editMain({{ $product->id }})"{{--onclick="editmain()"--}}><i class="bi bi-pencil-fill"></i>&nbsp;Edit Main Info</a>
    @if ($product->iscooler)
    <a href="javascript:void(0)" style="margin:5px;" class="btn btn-sm btn-orange"  ng-click="editSocketType('{{ $product->partno }}')"><i class="bi bi-pencil-fill"></i>&nbsp;Edit Sockets</a>
    @endif
    <div class="row">
      <div class="col-2">
        <img src="{{ url('../../docs/products/'.$product->partno.'/Web_Library/Gallery/'.$img->docname) }}" class="img-thumbnail" >
      </div>
      <div class="col-8">
        <div class="row mb-3">
          <label for="mf_name" class="col-sm-2 col-form-label col-form-label-sm text-end">Name</label>
          <div class="col-4">
            <input type="text" class="form-control form-control-sm border-orange" id="mf_name" ng-model="productDetails.name" readonly>
          </div>
          <label for="mf_title" class="col-sm-2 col-form-label col-form-label-sm text-end">Title</label>
          <div class="col-4">
            <input type="text" class="form-control form-control-sm border-orange" id="mf_title" ng-model="productDetails.title" readonly>
          </div>
        </div>
        <div class="row mb-3">
          <label for="mf_related" class="col-sm-2 col-form-label col-form-label-sm text-end">Related Products</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-sm border-orange" id="mf_related" ng-model="productDetails.related" readonly>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="mf_longDesc" class="col-sm-2 col-form-label col-form-label-sm text-end">Long Description</label>
          <div class="col-sm-10">
            <textarea class="form-control form-control-sm border-orange"  rows="4" ng-model="productDetails.longdesc"  readonly></textarea>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="mf_status" class="col-sm-2 col-form-label col-form-label-sm text-end">&nbsp;</label>
          <div class="col-sm-10">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="mf_active" ng-model="productDetails.active" disabled>
              <label class="form-check-label" for="inlineCheckbox1">Active Detail Page & Search</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="mf_newproduct" ng-model="productDetails.newproduct" disabled>
              <label class="form-check-label" for="inlineCheckbox2">New Product</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="mf_iscooler" ng-model="productDetails.iscooler" disabled>
              <label class="form-check-label" for="inlineCheckbox3">is Cooler</label>
            </div>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="mf_longDesc" class="col-sm-2 col-form-label col-form-label-sm text-end">Keywords</label>
          <div class="col-sm-10">
            <textarea class="form-control form-control-sm border-orange" id="mf_keywords" rows="3" ng-model="productDetails.keywords" readonly></textarea>
            <p>* The keyword should be manage on keyword page. You can add EXTRA keywords (seperate with comma ,) if there is out of the keyword list. </p>
          </div>
        </div>
        @if ($product->iscooler)
        <div class="mb-3 row">
          <label for="mf_longDesc" class="col-sm-2 col-form-label col-form-label-sm text-end">CPU sockets</label>
          <div class="col-sm-10">
            <textarea class="form-control form-control-sm border-orange" id="mf_sockets" rows="3" ng-model="productDetails.cpuSockets" readonly>
              {# productDetails.cpuSockets| implode:', '  #}
            </textarea>
          </div>
        </div>
        @endif
      </div>
    </div>  
    
<!-- Begin of Main Form Modal -->
<div class="modal fade" id="mainFormModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Main Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- start form -->
        <div class="mb-3 row">
          <label for="mf_name" class="col-sm-2 col-form-label col-form-label-sm text-end">Name</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-sm" id="mf_name" ng-model="productDetails.name">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="mf_title" class="col-sm-2 col-form-label text-end">Title</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-sm" id="mf_title" ng-model="productDetails.title">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="mf_related" class="col-sm-2 col-form-label text-end">Related Products</label>
          <div class="col-sm-10">
            <input type="text" class="form-control form-control-sm" id="mf_related" ng-model="productDetails.related">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="mf_longDesc" class="col-sm-2 col-form-label text-end">Long Description</label>
          <div class="col-sm-10">
            <textarea class="form-control form-control-sm" id="mf_longDesc" rows="8" ng-model="productDetails.longdesc"></textarea>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="mf_longDesc" class="col-sm-2 col-form-label text-end">&nbsp;</label>
          <div class="col-sm-10">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="mf_active" ng-model="productDetails.active">
              <label class="form-check-label" for="inlineCheckbox1">Active Detail Page & Search</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="mf_newproduct" ng-model="productDetails.newproduct">
              <label class="form-check-label" for="inlineCheckbox2">New Product</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="mf_iscooler" ng-model="productDetails.iscooler">
              <label class="form-check-label" for="inlineCheckbox3">is Cooler</label>
            </div>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="mf_longDesc" class="col-sm-2 col-form-label text-end">Keywords</label>
          <div class="col-sm-10">
            <textarea class="form-control form-control-sm" id="mf_keywords" rows="3" ng-model="productDetails.keywords"></textarea>
          </div>
        </div>
        <!-- end form --> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" ng-click="updateProductDetails()">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- END of Main Form Modal -->

<!-- Begin of socket Form Modal -->
<div class="modal fade" id="socketTypeFormModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Socket</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- start form -->
        <h5><span class="badge bg-success">Intel</span></h5>
        <div class="mb-3">
          @foreach ($socketType['intel'] as $sType)
            <div class="form-check form-check-inline col-sm-2 ">
              <input class="form-check-input" type="checkbox" id="st_{{ $sType['skey'] }}" value="{{ $sType['skey'] }}" ng-model="socketTypeList.{{ $sType['skey'] }}" >
              <label class="form-check-label" for="st_{{ $sType['skey'] }}">{{ $sType['display_name'] }}</label>
            </div>
          @endforeach
        </div>
        <h5><span class="badge bg-info">AMD</span></h5>
        <div class="mb-3">
          @foreach ($socketType['amd'] as $sType)
            <div class="form-check form-check-inline col-sm-2 ">
              <input class="form-check-input" type="checkbox" id="st_{{ $sType['skey'] }}" value="{{ $sType['skey'] }}" ng-model="socketTypeList.{{ $sType['skey'] }}" >
              <label class="form-check-label" for="st_{{ $sType['skey'] }}">{{ $sType['display_name'] }}</label>
            </div>
          @endforeach
        </div>
        <!-- end form --> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary"  ng-click="updateSocketType('{{ $product->partno }}')">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- END of Main Form Modal -->  
  </div>
