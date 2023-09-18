<?php
/* Smarty version 3.1.34-dev-7, created on 2023-08-23 15:35:13
  from '/akasa/www/marketing/templates/products/upload_files.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_64e627316e1d17_57474416',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '24ca94beff81ee2d96c6b7066a27b2115b2de0c7' => 
    array (
      0 => '/akasa/www/marketing/templates/products/upload_files.tpl',
      1 => 1692804896,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64e627316e1d17_57474416 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '134411662364e627316df9a3_76060100';
?>
<div title='Upload Files'>
  <upload-files-directive></upload-files-directive>


<?php echo '<script'; ?>
>
  // config
  const langkeys = Object.keys(aryLangs);

  function uploadFile(efid) {
    //      var selectedrow = $("#blogslist").datagrid("getSelected");
    if (efid == null) {
      alert("Please Select a file record to Export!");
    } else {
      var fd = new FormData()
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
            data: [{
                text: 'Ready to Upload',
                id: '1',
                "selected": true
              },
              {
                text: 'Pending',
                id: '0'
              },
              {
                text: 'Uploaded',
                id: '2',
                "disabled": true
              },
              {
                text: 'Failed to Upload',
                id: '3',
                "disabled": true
              },

            ],
            valueField: 'id',
            textField: 'text',
            label: 'Status :',
            labelWidth: '140px',
            labelAlign: 'right'
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
          url: backendApi + '/file_uploads/list',
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
          columns: [
            [{
                field: 'keychx',
                checkbox: true
              },
              {
                field: 'id',
                title: 'ID',
                width: '5%',
                sortable: true,
                align: 'center'
              },
              {
                field: 'filename',
                title: 'Filename (Mouseover the name to see file path)',
                width: '45%',
                sortable: true,
                formatter: function (value, row, index) {
                  var titleFilename = "LF : " + row.local_file + '\nRF : ' + row.remote_file;
                  return "<span title='" + titleFilename + "'>" + value + "</span>";
                },
              },
              {
                field: 'etype',
                title: 'File Type',
                width: '15%',
                sortable: true,
                align: 'center'
              },
              {
                field: 'created_at',
                title: 'Created at',
                width: '15%',
                sortable: true
              },
              {
                field: 'updated_at',
                title: 'Updated at',
                width: '15%',
                sortable: true
              },
            ]
          ],
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
            data: [{
                text: 'ALL',
                id: 'all',
                selected: true
              },
              <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['aryFileTypes']->value, 'filetype', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['filetype']->value) {
?> 
              {
                text: '<?php echo $_smarty_tpl->tpl_vars['filetype']->value;?>
',
                id: '<?php echo $_smarty_tpl->tpl_vars['filetype']->value;?>
'
              },
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
            url: backendApi + '/file_uploads/tasks/list',
            toolbar: '#upload_files_tasks_toolbar',
            height: '800px',
            singleSelect: false,
            pagination: true,
            pageSize: 50,
            idField: 'id',
            //   view: scrollview,
            columns: [
              [{
                  field: 'keychx',
                  checkbox: true
                },
                { field: 'id',title: 'ID',width: '5%',sortable: true,align: 'center'},
                { field: 'hostname',title: 'H',width: '5%',sortable: true,align: 'center'},
                { field: 'filename', title: 'Filename (Mouseover the name to see file path)', width: '35%', sortable: true,
                  formatter: function (value, row, index) {
                    var titleFilename = "LF : " + row.local_file + '\nRF : ' + row.remote_file;
                    return "<span title='" + titleFilename + "'>" + value + "</span>";
                  },
                },
                { field: 'etype', title: 'File Type',width: '10%',sortable: true,align: 'center' },
                { field: 'launch_datetime',title: 'Launch time',width: '13%',sortable: true },
                {
                  field: 'status', title: 'Status', width: '5%',sortable: true,align: 'center',
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
                { field: 'uploaded_at',title: 'Uploaded at',width: '13%',sortable: true},
                { field: 'created_at',title: 'Created at',width: '13%',sortable: true},
              ]
            ],
            onDblClickRow: function (index, row) {
              editTask(row.id);
            }
          });

          // define keyword type
          $('#tasktools_fileType').combobox({
              width: 210,
              data: [{
                  text: 'ALL',
                  id: 'all',
                  selected: true
                },
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['aryFileTypes']->value, 'filetype', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['filetype']->value) {
?> {
                  text: '<?php echo $_smarty_tpl->tpl_vars['filetype']->value;?>
',
                  id: '<?php echo $_smarty_tpl->tpl_vars['filetype']->value;?>
'
                },
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                ],
                valueField: 'id', textField: 'text', label: 'File Type :', labelWidth: '82px', labelAlign: 'right',
                onChange: function (value) {
                  $('#uploadFilesTasksList').datagrid('load', {
                    etype: value,
                    partno: $('#tasktools_upartno').val(),
                  });
                },
              });

            $('#tasktools_upartno').textbox({
              width: 240,
              label: 'Search :',
              labelAlign: 'right',
              labelWidth: '50px',
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
                  url: backendApi + "/file_uploads/delete",
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
            url: backendApi + "/file_uploads/schedule_tasks",
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
          $('#frmUploadNow_id').val(selectedIds.join());
          $('#frmUploadNow').form('submit', {
            //url: 'manupload_files.php?action=upload_batch_now&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
',
            url: backendApi + '/file_uploads/upload_batch_now',
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
              url: backendApi + "/file_uploads/execute_tasks",
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
                  endProgress("Failed", " Failed to upload file, Please check the local file is existed or not.",
                    'error');
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
                  url: backendApi + "/file_uploads/tasks/delete",
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
><?php }
}
