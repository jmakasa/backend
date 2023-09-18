<?php
/* Smarty version 3.1.34-dev-7, created on 2023-09-05 10:26:15
  from '/akasa/www/marketing/templates/upload_files/list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_64f70247c92f07_70217135',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5840324398c269658edeeceae48f52ef11e4135f' => 
    array (
      0 => '/akasa/www/marketing/templates/upload_files/list.tpl',
      1 => 1693323844,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/header.tpl' => 1,
    'file:layout/navmenu.tpl' => 1,
    'file:layout/footer.tpl' => 1,
  ),
),false)) {
function content_64f70247c92f07_70217135 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/akasa/www/marketing/libs/smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
$_smarty_tpl->_subTemplateRender('file:layout/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<style>
  .blog_td {
    padding: 10px 5px;
    border: 0;
  }

  .blog_thumbnail {
    width: 150px;
    float: left;
  }


  .combobox-item-selected {
    font-weight: bold;
    color: rgb(0, 2, 105);
    margin: 3px;
  }

  .tagbox-label {
    background-color: coral;
    color: #fff;
  }
</style>
</head>

<body>
  <?php $_smarty_tpl->_subTemplateRender('file:layout/navmenu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
  <div class="container-fluid">
    <div class="row p-2">
      <div class="col-6">
        <div class="panel main_panel" style="height:850px">
          <div class="panel-header">
            <div class="panel-title" id="allProductsTitle">Upload Files List</div>
            <div class="panel-tool"></div>
          </div>
          <div class="panel-body">
            <table id="uploadfileslist"></table>
            <div id='upload_files_toolbar'>
              <input id="tools_upartno" name="type" type="text"><input id="tools_fileType" name="type" type="text">
              <a href="javascript:void(0)" class="btn btn-sm btn-orange m-1" onclick="assignUploadTasks()"><i
                  class="bi bi-fast-forward-btn"></i>&nbsp;Assign Tasks</a>
              <a href="javascript:void(0)" class="btn btn-sm btn-orange m-1" onclick="uploadSelectedFilesNow()"><i
                  class="bi bi-file-arrow-up"></i>&nbsp;Upload Now</a>
              <a href="javascript:void(0)" class="btn btn-sm btn-orange m-1" onclick="delUploadFiles()"><i
                  class="bi bi-trash"></i>&nbsp;Del</a>

              <a href="javascript:void(0)" class="btn btn-sm btn-outline-primary"
                onclick="clearSelections('uploadfileslist')"><i class="bi bi-arrow-clockwise"></i>&nbsp;Clear</a>

              <div class="float-end">

              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="panel main_panel" style="height:850px">
          <div class="panel-header">
            <div class="panel-title" id="allProductsTitle">Upload Files Tasks List</div>
            <div class="panel-tool"></div>
          </div>
          <div class="panel-body">
            <table id="uploadFilesTasksList"></table>
            <div id='upload_files_tasks_toolbar'>
              <input id="tasktools_upartno" name="type" type="text">
              <input id="tasktools_fileType" name="type" type="text">
              <!-- <a href="javascript:void(0)" class="btn btn-sm btn-orange m-1" onclick="editTask()"><i
                  class="bi bi-pencil"></i>&nbsp;Task</a> -->
              <a href="javascript:void(0)" class="btn btn-sm btn-orange m-1" onclick="executeTasks()"><i
                  class="bi bi-file-arrow-up"></i>&nbsp;Execute Tasks</a>
              <a href="javascript:void(0)" class="btn btn-sm btn-orange m-1" onclick="delTasks()"><i
                  class="bi bi-trash"></i>&nbsp;Del Task</a>
              <a href="javascript:void(0)" class="btn btn-sm btn-outline-primary"
                onclick="clearSelections('uploadFilesTasksList')"><i class="bi bi-arrow-clockwise"></i>&nbsp;Clear</a>



              <!-- <div class="float-end">
                <p>* double click to edit task <br>** Status : Pending > Ready to Upload > Uploaded or Failed to Upload
                </p>
              </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- dialog or form-->

    <form id="delUploadFiles" enctype="multipart/form-data" method="post">
      <input type="text" id="frmDelUploadFilesId" name="id" value="" hidden=true>
    </form>

    <!-- Begin of assign task Form Dialog JM-->
    <div class="easyui-dialog" id="dlgUpdate" data-options="resizable:true"
      style="width:550px;height:400px;padding:10px 20px" closed="true" buttons="#dlg-buttons"
      title="Assign Upload Tasks">
      <form id="frmUploadFiles" enctype="multipart/form-data" method="post">
        <input type="text" id="frmUploadFiles_id" name="id" value="" hidden=true>
        <div>
          <input class="easyui-datetimebox" name="launch_datetime" id="frmUploadFiles_launch_datetime"
            style="width:440px;" data-options="label:'Launch Datetime:',labelWidth:'140px',labelAlign:'right'"
            value="<?php echo smarty_modifier_date_format(time(),'%Y-%m-%d %H:%M:00');?>
">
          </p>
        </div>
        <div>
          <div style="margin-bottom:20px">
            <input class="easyui-checkbox" data-options="label:'Release Date:',labelWidth:'140px',labelAlign:'right'"
              name="hostname[]" value="akasa2206_uk" label="UK Web [2206]">
            <input class="easyui-checkbox" data-options="label:'Release Date:',labelWidth:'140px',labelAlign:'right'"
              name="hostname[]" value="akasa2206_tw" label="TW Web [2206]">
          </div>
          <div style="margin-bottom:20px">&nbsp;</div>
        </div>
      </form>
      <div style="text-align:center;padding:5px 0">
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitUploadForm()" style="width:80px">Upload</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="cancelDlgFrm('dlgUpdate','frmUploadFiles')"
          style="width:80px">Cancel</a>
      </div>
    </div>
    <!-- End of assign task Form Dialog -->
    <!-- Begin of upload now Form Dialog JM-->
    <div class="easyui-dialog" id="dlgUploadNow" data-options="resizable:true"
      style="width:550px;height:300px;padding:10px 20px" closed="true" buttons="#dlg-buttons" title="Upload File Now">
      <form id="frmUploadNow" enctype="multipart/form-data" method="post">
        <input type="text" id="frmUploadNow_id" name="id" value="" hidden=true>
        <input type="text" id="frmUploadNow_id" name="launch_datetime"
          value="<?php echo smarty_modifier_date_format(time(),'%Y-%m-%d %H:%M:00');?>
" hidden=true>
        <div>
          <h6>&nbsp;&nbsp;&nbsp;Select one of hosts at below : </h6>
          <div style="margin-bottom:20px">
            <div class="easyui-checkgroup" id="uploadNowHost"></div>
            <input class="easyui-checkbox" data-options="label:'Release Date:',labelWidth:'140px',labelAlign:'right'"
              name="hostname[]" value="akasa2206_uk" label="UK Web [2206]">
            <input class="easyui-checkbox" data-options="label:'Release Date:',labelWidth:'140px',labelAlign:'right'"
              name="hostname[]" value="akasa2206_tw" label="TW Web [2206]">
          </div>
          <div style="margin-bottom:20px">&nbsp;</div>
        </div>
      </form>
      <div style="text-align:center;padding:5px 0">
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitUploadNowForm()"
          style="width:80px">Save</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="cancelDlgFrm('dlgUploadNow','frmUploadNow')"
          style="width:80px">Cancel</a>
      </div>
    </div>
    <!-- End of upload now Form Dialog -->
    <!-- Begin of edit task Form Dialog JM-->
    <div class="easyui-dialog" id="dlgEditTasks" data-options="resizable:true"
      style="width:550px;height:400px;padding:10px 20px" closed="true" buttons="#dlg-buttons" title="Edit tasks">
      <form id="frmEditTask" enctype="multipart/form-data" method="post">
        <input type="text" id="frmEditTask_id" name="id" value="" hidden=true>
        <div>
          <p>
            <input class="easyui-datetimebox" name="launch_datetime" id="frmEditTask_launch_datetime"
              style="width:440px;" data-options="label:'Launch Datetime:',labelWidth:'140px',labelAlign:'right'">
          </p>
        </div>
        <div>
          <div style="margin-bottom:20px">
            <input class="easyui-radiobutton" data-options="label:'Release Date:',labelWidth:'140px',labelAlign:'right'"
              name="hostname" value="akasa2206_uk" label="UK Web [2206]">
            <input class="easyui-radiobutton" data-options="label:'Release Date:',labelWidth:'140px',labelAlign:'right'"
              name="hostname" value="akasa2206_tw" label="TW Web [2206]">
          </div>
          <div style="margin-bottom:20px">
            <p><b><input id="frmEditTask_status" name="status" type="text"></b></p>
          </div>
        </div>
      </form>
      <div style="text-align:center;padding:5px 0">
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitEditTasksForm()"
          style="width:80px">Save</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="cancelDlgFrm('dlgEditTasks','frmEditTask')"
          style="width:80px">Cancel</a>
      </div>
    </div>
    <!-- End of edit task Form Dialog -->
    <!-- END dialog or form-->
  </div>

  <?php echo '<script'; ?>
>
    // config
    const langkeys = Object.keys(aryLangs);

    function uploadFile(efid) {
      //      var selectedrow = $("#blogslist").datagrid("getSelected");
      if (efid == null) {
        alert("Please Select a file record to Export!");
      } else {
        var fd = new FormData();
        fd.append('id', efid);
        $.ajax({
          url: "manupload_files.php?action=upload_single",
          type: 'post',
          data: fd,
          async: true,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function (resp) {
            if (resp.result) {
              $("#uploadfileslist").datagrid("reload");
              $("#uploadFilesTasksList").datagrid("reload");
              alert(" Export File (" + resp.data + ") succssfully.");
            }
          }
        });
      }
    }
    function assignUploadTasks() {
      var selectedrow = $("#uploadfileslist").datagrid("getSelected");
      if (!selectedrow) {
        alert("Please select one of records to UPLOAD.");
      } else {
        //frmUploadFiles_hostname
        $('#dlgUpdate').dialog('open');
      }
    }


    function uploadSelectedFilesNow() {
      var selectedrow = $("#uploadfileslist").datagrid("getSelected");
      if (!selectedrow) {
        alert("Please select one of records to UPLOAD.");
      } else {
        $('#dlgUploadNow').dialog('open');
      }
    }


    function editTask(id) {
      if (!id) {
        alert("Please select one of records to UPLOAD.");
      } else {
        //frmUploadFiles_hostname
        var fd = new FormData();
        fd.append('id', id);
        $.ajax({
          url: "manupload_files.php?action=getOneTask",
          type: 'POST',
          data: fd,
          async: true,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function (resp) {
            console.log(resp.data.launch_datetime);
            var data = JSON.parse(resp.data);
            $('#frmEditTask_status').combobox({
              width: 450,
              data: [
                { text: 'Ready to Upload', id: '1', "selected": true },
                { text: 'Pending', id: '0' },
                { text: 'Uploaded', id: '2', "disabled": true },
                { text: 'Failed to Upload', id: '3', "disabled": true },

              ],
              valueField: 'id', textField: 'text',
              label: 'Status :', labelWidth: '140px', labelAlign: 'right'
            });
            $('#frmEditTask').form('load', data);
            if (resp.result) {
              $('#dlgEditTasks').dialog('open');
            }
          }
        });

      }
    }

    function uploadSelectedFiles() {
      var selectedrow = $("#uploadfileslist").datagrid("getSelected");
      if (!selectedrow) {
        alert("Please select one of records to UPLOAD.");
      } else {
        var selectedIds = [];
        var dg = $('#uploadfileslist');
        $.map(dg.datagrid('getChecked'), function (row) {
          selectedIds.push(row.id);
        });
        var fd = new FormData();
        fd.append('id', selectedIds.join());
        $.ajax({
          url: "manupload_files.php?action=upload_batch",
          type: 'post',
          data: fd,
          async: true,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function (resp) {
            if (resp.result) {
              $("#uploadfileslist").datagrid("reload");
              $("#uploadFilesTasksList").datagrid("reload");
              alert(" Export Files succssfully.");
            }
          }
        });
      }

    }

    $(document).ready(function () {
      setSessionLang('<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
');
      setSessionRows('50');
      setSessionPageNo('1');

      $('#uploadfileslist').datagrid({
        url: backendApi+'/file_uploads/list',
        //url: 'manupload_files.php?action=getall',
        // view: cardview_blog,
       // method:'GET',
        toolbar: '#upload_files_toolbar',
        height: '800px',
        singleSelect: false,
        pagination: true,
        pageSize: 50,
        idField: 'id',
        //view: scrollview,
        view: groupview,
        groupField: 'partno',
        groupFormatter: function (value, rows, index) {
          var txt = value + ' - ' + rows.length + ' Item(s)';
          txt = '<input type="checkbox" onclick="groupCheck(\'' + value + '\',event)">&nbsp;' + txt;
          return txt;
        },
        columns: [[
          { field: 'keychx', checkbox: true },
          { field: 'id', title: 'ID', width: '5%', sortable: true, align: 'center' },
          {
            field: 'filename', title: 'Filename (Mouseover the name to see file path)', width: '45%', sortable: true,
            formatter: function (value, row, index) {
              var titleFilename = "LF : " + row.local_file + '\nRF : ' + row.remote_file;
              return "<span title='" + titleFilename + "'>" + value + "</span>";
            },
          },
          { field: 'etype', title: 'File Type', width: '15%', sortable: true, align: 'center' },
          { field: 'created_at', title: 'Created at', width: '15%', sortable: true },
          { field: 'updated_at', title: 'Updated at', width: '15%', sortable: true },
        ]],
        onLoadSuccess: function () {
          var gcount = $(this).datagrid('options').view.groups.length;
          for (var i = 1; i < gcount; i++) {
            $(this).datagrid('collapseGroup', i);
          }
        }
      });

      // define keyword type
      $('#tools_upartno').textbox({
        width: 240,
        label: 'Search :',
        labelAlign: 'right',
        labelWidth: '50px',
        onKeyup: function (value) {
          $('#uploadfileslist').datagrid('load', {
            etype: $('#tools_fileType').combobox('getValue'),
            partno: value
          });
        },
        onChange: function (value) {
          $('#uploadfileslist').datagrid('load', {
            etype: $('#tools_fileType').combobox('getValue'),
            partno: value
          });
        },
      });
      $('#tools_fileType').combobox({
        width: 210,
        data: [
          { text: 'ALL', id: 'all', selected: true },
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['aryFileTypes']->value, 'filetype', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['filetype']->value) {
?>
        { text: '<?php echo $_smarty_tpl->tpl_vars['filetype']->value;?>
', id: '<?php echo $_smarty_tpl->tpl_vars['filetype']->value;?>
' },
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        ],
        valueField: 'id', textField: 'text',
        label: 'File Type :', labelWidth: '82px', labelAlign: 'right',
        onChange: function (value) {
          $('#uploadfileslist').datagrid('load', {
            etype: value,
            partno: $('#tools_upartno').textbox('getValue'),
          });
        },
      });

    $('#uploadFilesTasksList').datagrid({
      //url: 'manupload_files.php?action=getAllTasks',
      url:backendApi+'/file_uploads/tasks/list',
      toolbar: '#upload_files_tasks_toolbar',
      height: '800px',
      singleSelect: false,
      pagination: true,
      pageSize: 50,
      idField: 'id',
   //   view: scrollview,
      columns: [[
        { field: 'keychx', checkbox: true },
        { field: 'id', title: 'ID', width: '5%', sortable: true, align: 'center' },
        { field: 'hostname', title: 'H', width: '5%', sortable: true, align: 'center' },
        {
          field: 'filename', title: 'Filename (Mouseover the name to see file path)', width: '35%', sortable: true,
          formatter: function (value, row, index) {
            var titleFilename = "LF : " + row.local_file + '\nRF : ' + row.remote_file;
            return "<span title='" + titleFilename + "'>" + value + "</span>";
          },
        },
        { field: 'etype', title: 'File Type', width: '10%', sortable: true, align: 'center' },
        { field: 'launch_datetime', title: 'Launch time', width: '13%', sortable: true },
        {
          field: 'status', title: 'Status', width: '5%', sortable: true, align: 'center',
          formatter: function (value, row, index) {

            if (value == 1) {
              return '<i class="bi bi-toggle-on icon-green icon-fs-md"></i>';
            } else if (value == 2) {
              return '<i class="bi bi-check-circle-fill icon-blue icon-fs-md"></i>';
            } else if (value == 3) {
              return '<i class="bi bi- icon-red icon-fs-md"></i>';
            } else {
              return '<i class="bi bi-toggle-off  icon-grey icon-fs-md"></i>';
            }
          },
        },
        { field: 'uploaded_at', title: 'Uploaded at', width: '13%', sortable: true },
        { field: 'created_at', title: 'Created at', width: '13%', sortable: true },

      ]],
      onDblClickRow: function (index, row) {

        editTask(row.id);
      }
    });

    // define keyword type
    $('#tasktools_fileType').combobox({
      width: 210,
      data: [
        { text: 'ALL', id: 'all', selected: true },
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['aryFileTypes']->value, 'filetype', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['filetype']->value) {
?>
        { text: '<?php echo $_smarty_tpl->tpl_vars['filetype']->value;?>
', id: '<?php echo $_smarty_tpl->tpl_vars['filetype']->value;?>
' },
      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        ],
      valueField: 'id', textField: 'text', label: 'File Type :', labelWidth: '82px', labelAlign: 'right',
      onChange: function (value) {
        $('#uploadFilesTasksList').datagrid('load', {
          etype: value,
          partno:$('#tasktools_upartno').val(),
        });
      },
    });

      $('#tasktools_upartno').textbox({
        width: 240, label: 'Search :',labelAlign: 'right',labelWidth: '50px',
        onKeyup: function (value) {
          $('#uploadFilesTasksList').datagrid('load', {
            etype: $('#tasktools_fileType').combobox('getValue'),
            partno: value,
          });
        },
        onChange: function (value) {
          $('#uploadFilesTasksList').datagrid('load', {
            etype: $('#tasktools_fileType').combobox('getValue'),
            partno: value,
          });
        },
      });


    });



    function delUploadFiles() {
      var selectedrow = $("#uploadfileslist").datagrid("getSelected");
      if (!selectedrow) {
        alert("Please select one of records to DELETE.");
      } else {
        $.messager.confirm('Confirm', 'Are you sure? 確認刪除?', function (r) {
          if (r) {

            var selectedIds = [];
            var dg = $('#uploadfileslist');
            $.map(dg.datagrid('getChecked'), function (row) {
              selectedIds.push(row.id);
            });

            $('#frmDelUploadFilesId').val(selectedIds.join());
            $('#delUploadFiles').form('submit', {
              url: backendApi+"/file_uploads/delete",
             // url: 'manupload_files.php?action=delete&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
',
              success: function (resp) {
                $("#uploadfileslist").datagrid("reload");
                $("#uploadFilesTasksList").datagrid("reload");
              } // end of if confirm
            }); // end of confirm messager
          }
        })
      }
    }

    function submitUploadForm() {
      inProgress();
      var selectedIds = [];
      var dg = $('#uploadfileslist');
      $.map(dg.datagrid('getChecked'), function (row) {
        selectedIds.push(row.id);
      });
      $('#frmUploadFiles_id').val(selectedIds.join());
      $('#frmUploadFiles').form('submit', {
        //url: 'manupload_files.php?action=update_datetime_hostname&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
',
        url:backendApi+"/file_uploads/schedule_tasks",
        success: function (data) {
          if (data) {
            $("#uploadfileslist").datagrid("reload");
            $("#uploadFilesTasksList").datagrid("reload");
            endProgress("Uploaded", "Files has been uploaded successfully!", '');
          } else {
            endProgress("Failed", "Failed to upload ", 'error');
          }
          $('#dlgUpdate').dialog('close');

        }
      });
    }

    function uploadFilesTasksList() {
      $('#frmUploadFiles').form('submit', {
        url: 'manupload_files.php?action=update_datetime_hostname&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
',
        success: function (data) {
          $('#dlgUpdate').dialog('close');
          $("#uploadfileslist").datagrid("reload");
          $("#uploadFilesTasksList").datagrid("reload");
        }
      });
    }

    function cancelUploadForm() {
      $('#dlgUpdate').dialog('close');
      $('#frmUploadFiles').form('clear');
    }

    /*****      Upload now        ********/
    function submitUploadNowForm() {
      inProgress();
      var selectedIds = [];
      var dg = $('#uploadfileslist');
      $.map(dg.datagrid('getChecked'), function (row) {
        selectedIds.push(row.id);
      });
      $('#frmUploadNow_id').val(selectedIds);
      $('#frmUploadNow').form('submit', {
        //url: 'manupload_files.php?action=upload_batch_now&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
',
        url:backendApi+ '/file_uploads/upload_batch_now',
        success: function (resp) {
          console.log(resp);
          if (resp) {
            $("#uploadfileslist").datagrid("reload");
            $("#uploadFilesTasksList").datagrid("reload");
            endProgress("Uploaded", "Files has been uploaded successfully!", '');
          } else {
            endProgress("Failed", "Failed to upload ", 'error');
          }
          $('#dlgUploadNow').dialog('close');
        }
      });
    }
    function cancelUploadNowForm() {
      $('#dlgUploadNow').dialog('close');
      $('#frmUploadNow').form('clear');
    }
    /*****      edit task        ********/
    function submitEditTasksForm() {
      inProgress();
      $('#frmEditTask').form('submit', {
        url: 'manupload_files.php?action=edit_single_task&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
',
        success: function (data) {
          if (resp) {
            $("#uploadFilesTasksList").datagrid("reload");
            endProgress("Uploaded", "Upload job has been assigned successfully!", '');
          } else {
            endProgress("Failed", "Failed to assign ", 'error');
          }
          cancelDlgFrm('dlgEditTasks', 'frmEditTask')
        }
      });
    }
    /*****      execute task        ********/
    function executeTasks() {
      var selectedrow = $("#uploadFilesTasksList").datagrid("getSelected");
      if (!selectedrow) {
        alert("Please select one of Tasks");
      } else {

        inProgress();
        var selectedIds = [];
        var dg = $('#uploadFilesTasksList');
        $.map(dg.datagrid('getChecked'), function (row) {
          selectedIds.push(row.id);
        });

        var fd = new FormData();
        fd.append('id', selectedIds.join());
        $.ajax({
         // url: "manupload_files.php?action=execute_task",
         url:backendApi+"/file_uploads/execute_tasks",
          type: 'post',
          data: fd,
          async: true,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function (resp) {
            if (resp.result) {
              $("#uploadfileslist").datagrid("reload");
              $("#uploadFilesTasksList").datagrid("reload");
              endProgress("Uploaded", " Files uploaded succssfully.", '');
            } else {
              endProgress("Failed", " Failed to upload file, Please check the local file is existed or not.", 'error');
            }
          }
        });

      }
    }
    /*****      delete task        ********/
    function delTasks() {
      var selectedrow = $("#uploadFilesTasksList").datagrid("getSelected");
      if (!selectedrow) {
        alert("Please select one of records to DELETE.");
      } else {
        $.messager.confirm('Confirm', 'Are you sure? 確認刪除?', function (r) {
          if (r) {
            var selectedIds = [];
            var dg = $('#uploadFilesTasksList');
            $.map(dg.datagrid('getChecked'), function (row) {
              selectedIds.push(row.id);
            });
            $('#frmDelUploadFilesId').val(selectedIds.join());
            $('#delUploadFiles').form('submit', {
              //url: 'manupload_files.php?action=del_tasks&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
',
              url:backendApi+"/file_uploads/tasks/delete",
              success: function (resp) {
                $("#uploadFilesTasksList").datagrid("reload");
              } // end of if confirm
            }); // end of confirm messager
          }
        })
      }
    }

    function groupCheck(value, event) {
      value = $.trim(value);
      var dg = $('#uploadfileslist');
      var groups = dg.datagrid('groups');
      var group = null;
      for (var i = 0; i < groups.length; i++) {
        if (groups[i].value == value) {
          group = groups[i];
          break;
        }
      }
      var checked = $(event.target).is(':checked');
      for (var i = group.startIndex; i < group.startIndex + group.rows.length; i++) {
        dg.datagrid(checked ? 'checkRow' : 'uncheckRow', i)
      }
    }

  <?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 type="text/javascript">
    $.extend($.fn.textbox.defaults.inputEvents, {
      keyup: function (e) {
        var t = $(e.data.target);
        t.textbox('setValue', t.textbox('getText'));
      }
    });
  <?php echo '</script'; ?>
>
</body>
<?php $_smarty_tpl->_subTemplateRender('file:layout/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
