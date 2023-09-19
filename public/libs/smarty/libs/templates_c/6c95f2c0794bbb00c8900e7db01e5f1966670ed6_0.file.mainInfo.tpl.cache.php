<?php
/* Smarty version 3.1.34-dev-7, created on 2023-05-19 09:02:47
  from '/akasa/www/marketing/templates/products/mainInfo.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_64673b377953d6_95790181',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6c95f2c0794bbb00c8900e7db01e5f1966670ed6' => 
    array (
      0 => '/akasa/www/marketing/templates/products/mainInfo.tpl',
      1 => 1684486954,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64673b377953d6_95790181 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '17475113664673b377918d6_84956074';
?>

<div title='Main Info'>
  <a href="javascript:void(0)" style="margin:5px;" class="btn btn-sm btn-orange" ng-click="editMain(<?php echo $_smarty_tpl->tpl_vars['record']->value['id'];?>
)"><i class="bi bi-pencil-fill"></i>&nbsp;Edit Main Info</a>
  <?php if (($_smarty_tpl->tpl_vars['record']->value['iscooler'])) {?>
  <a href="javascript:void(0)" style="margin:5px;" class="btn btn-sm btn-orange"  ng-click="editSocketType('<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
')"><i class="bi bi-pencil-fill"></i>&nbsp;Edit Sockets</a>
  <?php }?>
  <div class="row">
    <div class="col-2">
      <img src="/docs/products/<?php echo $_smarty_tpl->tpl_vars['record']->value['partno'];?>
/Web_Library/Gallery/<?php echo $_smarty_tpl->tpl_vars['listpic']->value['docname'];?>
" class="img-thumbnail" >
      <category-directive></category-directive>
    </div>
    <div class="col-6">
      <main-info-directive></main-info-directive>
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
      <div class="mb-3 row"><!-- pstatus-->
        <label for="mf_longDesc" class="col-sm-2 col-form-label text-end">Product Status</label>
        <div class="col-sm-10">
          <select id="mf_pstatus" name="pstatus" class="form-select form-select-sm" ng-model="productDetails.pstatus" ng-change="changeProductStatus()">
            <option ng-repeat="psOpt in pstatusOpts" ng-value="{#psOpt.value#}">{#psOpt.name#}</option>
          </select>
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
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['newSocketlist']->value['intel'], 'sType');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['sType']->value) {
?>
                  <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_<?php echo $_smarty_tpl->tpl_vars['sType']->value['skey'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['sType']->value['skey'];?>
" ng-model="socketTypeList.<?php echo $_smarty_tpl->tpl_vars['sType']->value['skey'];?>
" >
            <label class="form-check-label" for="st_<?php echo $_smarty_tpl->tpl_vars['sType']->value['skey'];?>
"><?php echo $_smarty_tpl->tpl_vars['sType']->value['display_name'];?>
</label>
          </div>
          <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      </div>
      <h5><span class="badge bg-info">AMD</span></h5>
      <div class="mb-3">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['newSocketlist']->value['amd'], 'sType');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['sType']->value) {
?>
          <div class="form-check form-check-inline col-sm-2 ">
            <input class="form-check-input" type="checkbox" id="st_<?php echo $_smarty_tpl->tpl_vars['sType']->value['skey'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['sType']->value['skey'];?>
" ng-model="socketTypeList.<?php echo $_smarty_tpl->tpl_vars['sType']->value['skey'];?>
" >
            <label class="form-check-label" for="st_<?php echo $_smarty_tpl->tpl_vars['sType']->value['skey'];?>
"><?php echo $_smarty_tpl->tpl_vars['sType']->value['display_name'];?>
</label>
          </div>
          <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      </div>
      <!-- end form --> 
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary"  ng-click="updateSocketType('{| $product->partno |}')">Save changes</button>
    </div>
  </div>
</div>
</div>
<!-- END of Main Form Modal -->  
</div>
<?php }
}
