
  <div title='Overview'>
    <a href="javascript:void(0)" id="bteditintroduction" style="margin:5px;" class="btn btn-sm btn-orange" ng-click="editintro({{ $product->id }})">Edit Introduction</a>
{#basicInfo#}
    <div class="row">
        <label for="ov_display_type" class="col-sm-2 col-form-label text-end">Display Type</label>
      <div class="col-10">
        <select id="ov_display_type" class="form-select form-select-sm" aria-label="Display Type" ng-model="productDetails.intro_display_type">
          <option ng-repeat="dType in displayTypes" ng-value="{#dType.value#}">{#dType.name#}</option>
      </select>
      </div>
    </div>
    <div class="row">
      <div class="col-10">
        {!! $product->introduction !!}
      </div>
    </div>

<!-- Begin of Main Form Modal -->
<div class="modal fade" id="introFormModal" tabindex="-1" aria-labelledby="introFormModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Introduction</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- start form -->
        <div class="row">
          <div class="col">
            <label for="ovfm_display_type" class="form-label">Display Type</label>
            <select id="ovfm_display_type" class="form-select form-select-sm" aria-label="Display Type" ng-model="productDetails.intro_display_type">
              <option ng-repeat="dType in displayTypes" ng-value="{#dType.value#}">{#dType.name#}</option>
          </select>
        </div>
      </div>
        <div class="mb-3 row">
          <div class="col">
            <label for="ovfm_intro" class="form-label">Introduction</label>
            <textarea class="form-control form-control-sm" id="ovfm_intro" rows="8" ng-model="productDetails.introduction"></textarea>
          </div>
        </div>
        <!-- end form --> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" ng-click="updateIntro()">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- END of Main Form Modal -->

  </div>
