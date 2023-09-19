<?php
/* Smarty version 3.1.34-dev-7, created on 2023-02-03 09:37:47
  from '/akasa/www/marketing/templates/email_contactus/list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_63dcd5eb5527d9_60886902',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5d0305195794e0ec416abb32462e4d92f3e497b3' => 
    array (
      0 => '/akasa/www/marketing/templates/email_contactus/list.tpl',
      1 => 1671729830,
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
function content_63dcd5eb5527d9_60886902 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:layout/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
  <?php $_smarty_tpl->_subTemplateRender('file:layout/navmenu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
  <div class="container-fluid">
    <div class="row ">
      <div class="col col-lg-5 p-2">
        <h6><i class="bi bi-envelope"></i>&nbsp;Email Listing</h6>
        <table id="emailList" class="table  table-striped">

        </table>
      </div>
      <div class="col col-lg-5">
        <h6><i class="bi bi-envelope"></i>&nbsp;Email Content</h6>
        <div id="emailBox"></div>
      </div>
      <div class="col col-lg-2">
        <h6><i class="bi bi-file"></i>&nbsp;Attachments</h6>
        <div id="attachmentsBox"></div>
      </div>
    </div>

  </div>



</body>

<!--- body -->

<!--- end body -->
<!-- script -->
<?php echo '<script'; ?>
>
  const emailBoxHeaderTpl = "<table class='table table-striped'><tr><td>From</td><td>REPLACE_FROM</td></tr><tr><td>Date</td><td>REPLACE_DATE</td></tr><tr><td>Subject</td><td>REPLACE_SUBJECT</td></tr><tr><td>Contact Reason</td><td>REPLACE_REASON</td></tr><tr><td>Office Service</td><td>REPLACE_OFFICE</td></tr><tr><td>Phone</td><td>REPLACE_PHONE</td></tr><tr><td>IP</td><td>REPLACE_IP</td></tr><tr><td>Region</td><td>REPLACE_REGION</td></tr>";
  const emailBoxContentTpl = "<tr><td colspan='2'>Content</td></tr><tr><td colspan='2'>REPLACE_CONTENT</td></tr></table>"
  const attachmentBox = "<table class='table table-striped'>REPLACE_DATA</table>";
  const attachmentBoxRow = "<tr><td><a href='REPLACE_LINK' target='_blank'>REPLACE_FILENAME</a></td></tr>";
  function closeEmailBox() {
    $('#dlgEmailContent').dialog('close');
    $('#emailBox').html("");
  }

  $(function () {
    $('#emailList').datagrid({
      singleSelect: true,
      pagination: true,
      pageSize: 10,
      pageList: [10, 20, 40],
      height: 800,
      idField: 'data.id',
      url: 'manemail_contactus.php?action=get_email_contactus',
      columns: [[
        { field: 'id', title: 'ID', width: '5%', sortable: true, align: 'center' },
        { field: 'contact_reason', title: 'Contact Reason', width: '15%', sortable: true, align: 'center' },
        { field: 'firstname', title: 'Firstname', width: '10%', sortable: true },
        { field: 'lastname', title: 'Lastname', width: '10%', sortable: true },
        { field: 'subject', title: 'Subject', width: '50%', sortable: true },
        { field: 'region', title: 'Region', width: '10%', sortable: true }
      ]],

      onClickRow: function (rowIndex, row) {
        $('#emailBox').html("");
        $('#attachmentsBox').html("");
        var fd = new FormData();
        fd.append('id', row.id);
        $.ajax({
          url: 'manemail_contactus.php?action=get_email_by_id',
          type: 'post',
          data: fd,
          async: true,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function (response) {
            if (response.result) {
              let email = response.email;
              let boxContentHeader = emailBoxHeaderTpl;
              boxContentHeader = boxContentHeader.replace(/REPLACE_FROM/g, email.email);
              boxContentHeader = boxContentHeader.replace(/REPLACE_DATE/g, email.created_at);
              boxContentHeader = boxContentHeader.replace(/REPLACE_SUBJECT/g, email.subject);
              boxContentHeader = boxContentHeader.replace(/REPLACE_REASON/g, email.contact_reason);
              let name = email.firstname + " " + email.lastname
              boxContentHeader = boxContentHeader.replace(/REPLACE_NAME/g, name);
              boxContentHeader = boxContentHeader.replace(/REPLACE_PHONE/g, email.phone);
              boxContentHeader = boxContentHeader.replace(/REPLACE_OFFICE/g, email.office_service);
              boxContentHeader = boxContentHeader.replace(/REPLACE_IP/g, email.ip);
              boxContentHeader = boxContentHeader.replace(/REPLACE_REGION/g, email.region);
              let boxContentContent = emailBoxContentTpl;
              boxContentContent = boxContentContent.replace(/REPLACE_CONTENT/g, email.description);

              boxContentHeader += boxContentContent;
              console.log(boxContentHeader);
              $("#emailBox").append(boxContentHeader);
              //    $('#dlgEmailContent').dialog('open');

              if (email.attachments) {
                let attBoxRow = attachmentBoxRow;
                attBoxRow = attBoxRow.replace(/REPLACE_LINK/g, email.attachments);
                attBoxRow = attBoxRow.replace(/REPLACE_FILENAME/g, email.contact_reason);
                let attBox = attachmentBox;
                attBox = attBox.replace(/REPLACE_DATA/g, attBoxRow);
                $("#attachmentsBox").append(attBox);
              } else {
                $("#attachmentsBox").append('No Attachments');
              }

            } else {
              console.log('error');
            }

          }
        });

        // ajax call 
      },
    });

  });
<?php echo '</script'; ?>
>
<?php $_smarty_tpl->_subTemplateRender('file:layout/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
