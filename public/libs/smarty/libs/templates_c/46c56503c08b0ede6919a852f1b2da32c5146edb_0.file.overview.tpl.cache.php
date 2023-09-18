<?php
/* Smarty version 3.1.34-dev-7, created on 2023-06-12 14:36:16
  from '/akasa/www/marketing/templates/products/overview.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_64872d60d64d32_52440205',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '46c56503c08b0ede6919a852f1b2da32c5146edb' => 
    array (
      0 => '/akasa/www/marketing/templates/products/overview.tpl',
      1 => 1683706433,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64872d60d64d32_52440205 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '187779632464872d60d64920_10979648';
?>

<div title='Overview'>
  
<overview-content-directive intro_display_type="{#productDetails.intro_display_type#}"></overview-content-directive>
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
<?php }
}
