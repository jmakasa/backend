<?php
/* Smarty version 3.1.34-dev-7, created on 2023-02-03 09:37:43
  from '/akasa/www/marketing/templates/blogs/listblogs.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_63dcd5e735f034_73500122',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a0920ec54f537c9b1884bdad4cb9a0810306bd1e' => 
    array (
      0 => '/akasa/www/marketing/templates/blogs/listblogs.tpl',
      1 => 1675094279,
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
function content_63dcd5e735f034_73500122 (Smarty_Internal_Template $_smarty_tpl) {
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

  .datagrid-header {
    display: none;
  }

  .combobox-item-selected {
    font-weight: bold;
    color: rgb(0, 2, 105);
    margin:3px;
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
      <div class="col">
        <div class="panel main_panel" style="height:850px">
          <div class="panel-header">
            <div class="panel-title" id="allProductsTitle">All Blogs</div>
            <div class="panel-tool"></div>
          </div>
          <div class="panel-body">
            <table id="blogslist"></table>
            <div id='blogs_toolbar'>
              <a href="javascript:void(0)" class="btn btn-sm btn-orange m-1" onclick="addBlog()"><i
                  class="bi bi-plus-circle"></i>&nbsp;Add Blog</a>
              <a href="javascript:void(0)" class="btn btn-sm btn-orange m-1" onclick="editBlog()"><i
                  class="bi bi-pencil"></i>&nbsp;Edit Blog</a>
              <a href="javascript:void(0)" class="btn btn-sm btn-orange m-1" onclick="delBlog()"><i
                  class="bi bi-trash"></i>&nbsp;Delete Blog</a>
                  <a href="javascript:void(0)" class="btn btn-sm btn-orange m-1" onclick="exportBlog()"><i
                    class="bi bi-file-arrow-down"></i>&nbsp;Export Selected Blog</a>
              <div class="float-end">
                <a href="javascript:void(0)" class="btn btn-sm btn-orange m-1" onclick="exportBloglist()"><i
                    class="bi bi-file-arrow-down"></i>&nbsp;Export Blog list</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-orange m-1" onclick="exportBlogdetails()"><i
                    class="bi bi-file-arrow-down"></i>&nbsp;Export All Blog Details</a>
                <!--a href="javascript:void(0)" class="btn btn-sm btn-orange m-1" onclick="exportBlogfeatured()"><i
                    class="bi bi-file-arrow-down"></i>&nbsp;Export Featured Blog</a-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php echo '<script'; ?>
>
    // config
    const langkeys = Object.keys(aryLangs);
    const jsonbtype = '<?php echo $_smarty_tpl->tpl_vars['jsonbtype']->value;?>
';
    const jsonstatus = '<?php echo $_smarty_tpl->tpl_vars['jsonstatus']->value;?>
';

    function exportBlog() {
      var selectedrow = $("#blogslist").datagrid("getSelected");
      if (selectedrow == null) {
        alert("Please Select a blog record to Edit!");
      } else {
        var fd = new FormData();
        fd.append('id', selectedrow.id);
      $.ajax({
        url: "exportblogs.php?action=single_detail&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
",
        type: 'post',
              data: fd,
              async: true,
              contentType: false,
              processData: false,
              dataType: 'json',
        success: function (resp) {
          if (resp.result) {
            alert(" Export Blog succssfully.");
          }
        }
      });
    }
  }

    function editBlog() {
      var selectedrow = $("#blogslist").datagrid("getSelected");
      if (selectedrow == null) {
        alert("Please Select a blog record to Edit!");
      } else {
        $.ajax({
          url: "manblogs.php?action=single_detail&id=" + selectedrow.id,
          type: "GET",
          dataType: "json",
          success: function (resp) {
          if (resp.result) {
            alert(" Export Blog succssfully.");
          }
        }
    });
      }
    }

    function exportBloglist() {
      $.ajax({
        url: "exportblogs.php?action=list&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
",
        type: "GET",
        dataType: "json",
        success: function (resp) {
          if (resp.result) {
            alert(" Export Blog list succssfully.");
          }
        }
      });
    }

    function exportBlogdetails() {
      $.ajax({
        url: "exportblogs.php?action=details&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
",
        type: "GET",
        dataType: "json",
        success: function (resp) {
          if (resp.result) {
            alert(" Export Blog all details succssfully.");
          }
        }
      });
    }

    function exportBlogfeatured() {
      $.ajax({
        url: "exportblogs.php?action=featured&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
",
        type: "GET",
        dataType: "json",
        success: function (resp) {
          if (resp.result) {
            alert(" Export Featured Blogs succssfully.");
          }
        }
      });
    }

    function addBlog() {
      setForm('add');
      $('#dlgAddBlog').dialog('open');
    }

    function editBlog() {
      var selectedrow = $("#blogslist").datagrid("getSelected");
      if (selectedrow == null) {
        alert("Please Select a blog record to Edit!");
      } else {
        $.ajax({
          url: "manblogs.php?action=getblog&id=" + selectedrow.id,
          type: "GET",
          dataType: "json",
          success: function (resp) {
            console.log(resp);
            if (resp.result) {
              setForm('edit');
              $('#frmBlogs').form('load', resp.data);
              if (resp.data.featured_blog){
                const featured =  resp.data.featured_blog.split(",");
              $("#frmBlogs_featured_blog").tagbox('setValues',featured);
              }

              console.log(resp.data.contents);
              $("#blog_contents").summernote('code', resp.data.contents);

              


          if (resp.data.topimage) {
            $("#topimageSrc").attr("src", '/docs/blog/' + resp.data.id + "/" + resp.data.topimage);
            $("#topimageSrc").show();
          }
          $('#dlgAddBlog').dialog('open');
        } else {
          console.log(" No Record ");
        }

      }
    });
      }
    }
    function delBlog() {
      var selectedrow = $("#blogslist").datagrid("getSelected");
      if (!selectedrow) {
        alert("Please select one of blog to DELETE.");
      } else {
        $.messager.confirm('Confirm', 'Are you sure? 確認刪除?', function (r) {
          if (r) {
            $('#frmDelBlogId').val(selectedrow.id);
            $('#delBlog').form('submit', {
              url: 'manblogs.php?action=delete&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
',
              success: function (resp) {
                $("#blogslist").datagrid("reload");
              } // end of if confirm
            }); // end of confirm messager
          }
        })
      }
    }

    function submitBlogForm() {
      $('#frmBlogs').form('submit', {
        url: 'manblogs.php?action=save&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
',
        success: function (data) {
          $('#dlgAddBlog').dialog('close');
          $("#blogslist").datagrid("reload");
        }
      });
    }
    function cancelBlogForm() {
      $('#dlgAddBlog').dialog('close');
      $('#frmBlogs').form('clear');
    }

    function setForm(action) {
      $('#frmBlogs').form('clear');
      $("#frmBlogs_editmode").val(action);
      $("#blog_contents").summernote({
        'toolbar': [
          ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
          ['color', ['recent', 'more', 'background']],
          ['para', ['ul', 'ol', 'paragraph', 'reset']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']],
          ['history', ['undo', 'redo']],
        ],
        'height': 580,
        imageAttributes: {
          icon: '<i class="note-icon-pencil"/>',
          figureClass: 'figureClass',
          figcaptionClass: 'blog_image_caption',
          captionText: 'Caption Goes Here.',
          manageAspectRatio: true // true = Lock the Image Width/Height, Default to true
        },
        lang: 'en-US',
        popover: {
          image: [
            ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
            ['float', ['floatLeft', 'floatRight', 'floatNone']],
            ['remove', ['removeMedia']],
            ['custom', ['imageAttributes']],
          ],
        },
      });
      $("#blog_contents").summernote('fontName', 'ElisarDT');

        $('#frmBlogs_btype').combobox({
          width: 318,
          data: <?php echo $_smarty_tpl->tpl_vars['jsonbtype']->value;?>
,
          valueField: 'id', textField: 'text',
          label: 'Blog Type :', labelWidth: '140px', labelAlign: 'right'
        });

      $('#frmBlogs_status').combobox({
        width: 318,
        data: [
          { text: 'Top', id: '2' },
          { text: 'Active', id: '1' },
          { text: 'Inactive', id: '0' },
        ],
        valueField: 'id', textField: 'text',
        label: 'Status :', labelWidth: '140px', labelAlign: 'right'
      });
      $('#frmBlogs_featured_blog').tagbox({
        width: 640,
        url: 'manblogs.php?action=getall&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
',
        valueField: 'id', textField: 'title',
        limitToList: true,
        hasDownArrow: true,
        prompt: 'Select a blog',
        label: 'Featured Blog :', labelWidth: '140px', labelAlign: 'right'
      });
    }

    function findById(source, id) {
      for (var i = 0; i < source.length; i++) {
        if (source[i].id == id) {
          return source[i];
        }
      }
      throw "Couldn't find object with id: " + id;
    }
    $(document).ready(function () {
      setSessionLang('<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
');
      setSessionRows('50');
      setSessionPageNo('1');

      $('#blogslist').datagrid({
        url: 'manblogs.php?action=getall&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
',
        view: cardview_blog,
        toolbar: '#blogs_toolbar',
        height: '850px',
        singleSelect: true,
        pagination: true,
        pageSize: 10,
        pageList: [10, 20, 40],
        idField: 'id',
        columns: [[
          { field: 'id', title: 'ID', width: 40, sortable: true, align: 'center', hidden: true },
          { field: 'title', title: 'Title', width: 150, sortable: true, align: 'center', hidden: true },
          { field: 'subtitle', title: 'Sub Title', width: 380, sortable: true, hidden: true },
          { field: 'btype', title: 'Type', width: 520, sortable: true, hidden: true },
        ]],
      });

      $("#main_lang").combobox({
        editable: false,
        onClick: function (record) {
          setSessionLang(record.value);
          getListProduct();
          reloadBoxes(); // function to reload #boxes
          reloadBoxesGrid();
          setPanelTitleWithLang(getSessionLang(), getSessionMenucatTitle());
        }
      });

    });

    var cardview_blog = $.extend({}, $.fn.datagrid.defaults.view, {
      renderRow: function (target, fields, frozen, rowIndex, rowData) {
        var cc = [];
        cc.push('<td colspan="2" class="blog_td">');
        var img = rowData.topimage;
        cc.push('<img src="/docs/blog/' + rowData.id + '/' + img + '" class="blog_thumbnail">');
        cc.push('</td><td class="blog_td">');
        var btypeval = findById(JSON.parse(jsonbtype), rowData.btype);
        cc.push('<b>Type : </b>' + btypeval.text + '<br>');
        cc.push('<b>Seqno : </b>' + rowData.seqno + '<br>');
        var statusval = findById(JSON.parse(jsonstatus), rowData.status);
        cc.push('<b>status : </b>' + statusval.text + '<br>');
        cc.push('</td><td colspan="4" class="blog_td"><p>');
        cc.push('<td colspan="4" class="blog_td"><p>');
        cc.push('<b>Title : </b>' + rowData.title + '<br>');
        cc.push('<b>Sub Title : </b>' + rowData.subtitle + '<br>');
        cc.push('</p></td>');
        return cc.join('');
      }
    });
  <?php echo '</script'; ?>
>
  <form id="delBlog" enctype="multipart/form-data" method="post">
    <input type="text" id="frmDelBlogId" name="id" value="" hidden=true>
  </form>

  <!-- Begin of review Form Dialog JM-->
  <div class="easyui-dialog" id="dlgAddBlog" data-options="resizable:true"
    style="width:850px;height:870px;padding:10px 20px" closed="true" buttons="#dlg-buttons" title="Add Blog">
    <form id="frmBlogs" enctype="multipart/form-data" method="post">
      <input type="text" id="frmBlogs_editmode" name="editmode" value="" hidden=true>
      <input type="text" id="frmBlogs_id" name="id" value="" hidden=true>
      <input type="text" id="frmBlogs_lang" name="lang" value="<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
" hidden=true>
      <div id="tt" class="easyui-tabs" style="width:800px;height:750px;">
        <div title="Basic" style="padding:20px;display:none;">
          <p>
            <b>
              <input class="easyui-textbox" name="title" style="width:640px;"
                data-options="label:'Title:',labelWidth:'140px',labelAlign:'right'">
            </b>
          </p>
          <p>
            <b>
              <input class="easyui-textbox" name="subtitle" style="width:640px;"
                data-options="label:'Sub Title:',labelWidth:'140px',labelAlign:'right'">
            </b>
          </p>
          <p><input class="easyui-textbox" name="related_products" style="width:640px;"
              data-options="label:'Related Products:',labelAlign:'right',labelWidth:'140px'">
          </p>
          <div>
            <p><input class="easyui-textbox" name="seqno" style="width:318px;"
                data-options="label:'Seqno:',labelAlign:'right',labelWidth:'140px'">

              <input class="easyui-datebox" name="releasedate" id="frmBlogs_releasedate" style="width:318px;"
                data-options="label:'Release Date:',labelWidth:'140px',labelAlign:'right'">
            </p>
          </div>
          <div>
            <p>
              <input id="frmBlogs_btype" name="btype" type="text">
              <input id="frmBlogs_status" name="status" type="text">
            </p>

          </div>
          <div>
            <input id="frmBlogs_featured_blog" name="featured_blog[]">
          </div>
        </div>
        <div title="Content" style="padding:20px;display:none;">
          <textarea class="summernote" name="contents" id="blog_contents" rows="10"
            cols="80"></textarea>
        </div>
        <div title="Image" style="padding:20px;display:none;">
          <div><b>List Image:</b></div>
          <div id="product_review_file">
            <input class="easyui-filebox" name="topimage" style="width:640px;"
              data-options="prompt:'Choose a file...',label:'Image File',labelWidth:'140px',labelAlign:'right'">
            <p>
          </div>
          <img src="" id="topimageSrc" style="display: hidden; margin: auto;">
        </div>
      </div>


    </form>

    <div style="text-align:center;padding:5px 0">
      <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitBlogForm()" style="width:80px">Save</a>
      <a href="javascript:void(0)" class="easyui-linkbutton" onclick="cancelBlogForm()" style="width:80px">Cancel</a>
    </div>
  </div>
  <!-- End of review Form Dialog -->
</body>
<?php $_smarty_tpl->_subTemplateRender('file:layout/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
