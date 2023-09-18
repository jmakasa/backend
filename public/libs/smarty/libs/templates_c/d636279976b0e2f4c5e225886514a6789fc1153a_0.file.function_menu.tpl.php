<?php
/* Smarty version 3.1.34-dev-7, created on 2023-01-30 17:13:37
  from '/akasa/www/marketing/templates/function_menu.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_63d7fac179a3f8_50420271',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd636279976b0e2f4c5e225886514a6789fc1153a' => 
    array (
      0 => '/akasa/www/marketing/templates/function_menu.tpl',
      1 => 1670839625,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63d7fac179a3f8_50420271 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- function  menu -->
<a href="#" class="easyui-menubutton" data-options="menu:'#mm_function',iconCls:'icon-display'">Menu</a>
<div id="mm_function" style="width:230px;">
  <?php if ($_smarty_tpl->tpl_vars['webmenu']->value == 'new') {?>
  <div>
    <span>Export</span>
    
    <div>
      <div href="#" onclick="exportAllMenucat()" target="_blank" data-options="iconCls:'icon-files'">
        [akasa2206] Export All Lists 
      </div>
      <div href="#" onclick="exportalldetail()" target="_blank" data-options="iconCls:'icon-files'">
        [akasa2206] Export All Product Details 
      </div>
      <div href="#" onclick="exportLegacyProduct()" target="_blank" data-options="iconCls:'icon-files'">
        [akasa2206] Export Legacy Product 
      </div>

      <div href="#" onclick="createkeyword2206()" target="_blank" data-options="iconCls:'icon-files'">
        [akasa2206] Create keywords
      </div>
      <div href="#" onclick="exportprodlist2206()" target="_blank" data-options="iconCls:'icon-files'">
        [akasa2206] Export Search Product list 
      </div>
      <div href="#" onclick="exportindex2206()" target="_blank" data-options="iconCls:'icon-files'">
        [akasa2206] Export Search Index 
      </div>
      <div href="#" onclick="exportsearchlist2206()" target="_blank" data-options="iconCls:'icon-files'">
        [akasa2206] Export Search List 
      </div>
      
      
    </div>
    
  </div>
  <?php }?>
  <div>
    <span>Link</span>
    <div>
      <div href="#" onclick="OpenInNewTab('/marketing/manblogs.php?action=viewlist')" target="_blank" data-options="iconCls:'icon-display'">
        Blog
      </div>
      <div href="#" onclick="OpenInNewTab('/marketing/mankeywordlist.php?action=view')" target="_blank" data-options="iconCls:'icon-display'">
        Filter / Keywords List
      </div>
      <div href="#" onclick="OpenInNewTab('listtag.htm')" target="_blank" data-options="iconCls:'icon-display'">
        Tag List
      </div>
      <div href="#" onclick="OpenInNewTab('listfan.htm')" target="_blank" data-options="iconCls:'icon-display'">
        Fan List
      </div>
      <div href="#" onclick="OpenInNewTab('listallproducts.htm')" target="_blank"
        data-options="iconCls:'icon-display'">
        Manage All Product With Tags
      </div>
      <div href="#" onclick="OpenInNewTab('listproduct_tag.htm')" target="_blank"
        data-options="iconCls:'icon-display'">
        Manage Product With Tags
      </div>
      <div href="#" onclick="OpenInNewTab('/marketing/mannavmenu.php?action=viewlist')" target="_blank">
        Manage Navmenu
      </div>
      <div href="#" onclick="OpenInNewTab('listnavmenu.htm')" target="_blank">
        Manage Product Transition
      </div>
      <div href='/marketing/manproducts.php?action=viewlist&webmenu=new'
        data-options="iconCls:'icon-display'">
        Backend AKASA2206
      </div>
      
    </div>
    
  </div>
  <?php if ($_smarty_tpl->tpl_vars['webmenu']->value == 'new') {?>
  <div href="/marketing/manproducts.php?action=viewlist&webmenu=old" 
        data-options="iconCls:'icon-display'">
        Switch to AKASA10
      </div>
      <?php }?>
      <?php if ($_smarty_tpl->tpl_vars['webmenu']->value == 'old') {?>
      <div href='/marketing/manproducts.php?action=viewlist&webmenu=new'
        data-options="iconCls:'icon-display'">
        Switch to AKASA2206
      </div>
      <?php }?>
</div>
<!-- END function  menu --><?php }
}
