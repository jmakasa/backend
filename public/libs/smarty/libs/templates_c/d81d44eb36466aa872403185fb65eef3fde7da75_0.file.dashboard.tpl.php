<?php
/* Smarty version 3.1.34-dev-7, created on 2023-01-30 16:19:35
  from '/akasa/www/marketing/templates/dashboard.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_63d7ee17c245d4_89806244',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd81d44eb36466aa872403185fb65eef3fde7da75' => 
    array (
      0 => '/akasa/www/marketing/templates/dashboard.tpl',
      1 => 1674816608,
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
function content_63d7ee17c245d4_89806244 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:layout/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
  <style>
    .box{
    display: none;
    width: 100%;
}

a:hover + .box,.box:hover{
    display: block;
    position: relative;
    z-index: 100;
}
  </style>
  <?php $_smarty_tpl->_subTemplateRender('file:layout/navmenu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-6">
        <!-- <h5 class="m-1">Email
          <a href="javascript:void(0);" class="btn btn-info btn-sm float-end m-1" onclick="fetchEmail();">Fetch
            Email</a>
          <a href="javascript:void(0);" class="btn btn-info btn-sm float-end m-1" onclick="fetchSearch();">Fetch
            Search</a>
          <a href="javascript:void(0);" class="btn btn-info btn-sm float-end m-1" onclick="fetchView();">Fetch View</a>
        </h5>
        <br> -->
        <table id="emailList" class="table">

        </table>

      </div>
      <div class="col-6">
        <div class="card border-orange">
          <div class="card-header">
            Email Contents
          </div>
          <div class="card-body">
            <div id="emailBox"></div>
          </div>
        </div>
      </div>

    </div>
    <div class="row mt-1">

      <div class="col-6">
        <table id="topViewPagesList" class="table">

        </table>
      </div>
      <div class="col-6">
        <table id="topViewPagesCountryList" class="table">

        </table>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col-3">
        <table id="topViewCountryList" class="table">

        </table>
      </div>
      <div class="col-3">

        <table id="topSearchPartnoList" class="table">

        </table>
      </div>
      <div class="col-3">

        <table id="topSearchPartnoCountryList" class="table">

        </table>
      </div>

    </div>


    <!-- Begin of Keywords Form Dialog -->
    <div class="easyui-dialog" id="dlgEmailContent" data-options="resizable:true"
      style="width:630px;height:570px;padding:10px 20px" closed="true" buttons="#dlg-buttons" title="Edit">
      <div id="emailBox"></div>
      <div style="text-align:center;padding:5px 0">
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="closeEmailBox()" style="width:80px">Close</a>
      </div>
    </div>
    <!-- End of Keywords Form Dialog -->
</body>

<!--- body -->

<!--- end body -->
<!-- script -->
<?php echo '<script'; ?>
>
  const emailBoxHeaderTpl = "<table class='table border-orange h6'><tr><td><b>From</b></td><td>REPLACE_FROM</td><td><b>Date</b></td><td>REPLACE_DATE</td></tr><tr><td><b>Contact Reason</b></td><td>REPLACE_REASON</td><td><b>Office Service</b></td><td>REPLACE_OFFICE</td></tr><tr><td><b>Phone</b></td><td>REPLACE_PHONE</td><td><b>IP</b></td><td>REPLACE_IP</td></tr><tr><td><b>Region</b></td><td>REPLACE_REGION</td><td></td><td></td></tr><tr><td><b>Subject</b></td><td colspan='3'>REPLACE_SUBJECT</td></tr>";
  const emailBoxContentTpl = "<tr><td colspan='4'>REPLACE_CONTENT</td></tr></table>"

  function closeEmailBox() {
    $('#dlgEmailContent').dialog('close');
    $('#emailBox').append('');
  }

  function fetchEmail() {
    $.ajax({
      url: 'api/collectdata.php?action=collect_email',
      type: 'GET',
      async: true,
      success: function (response) {
        console.log(response);
        alert(response);
      }
    });
  }
  function fetchSearch() {
    $.ajax({
      url: 'api/collectdata.php?action=collect_search',
      type: 'GET',
      async: true,
      success: function (response) {
        console.log(response);
        alert(response);
      }
    });
  }
  function fetchView() {
    $.ajax({
      url: 'api/collectdata.php?action=collect_view',
      type: 'GET',
      async: true,
      success: function (response) {
        console.log(response);
        alert(response);
      }
    });
  }

  $(function () {
    // date 
    var dateObj = new Date();
    var month = ("0" + (dateObj.getUTCMonth() + 1)).slice(-2); //months from 1-12
    var day = dateObj.getUTCDate();
    var year = dateObj.getUTCFullYear();

    /**** first row ****/
    $('#emailList').datagrid({
      title: 'Email list from contact us page',
      singleSelect: true,
      pagination: true,
      pageSize: 25,
      pageList: [25, 50, 100],
      height: 550,
      idField: 'data.id',
      url: 'manemail_contactus.php?action=get_email_contactus',
      columns: [[
        { field: 'id', title: 'ID', width: '4%', sortable: true, align: 'center' },
        { field: 'post_date', title: 'Post Date', width: '14%', sortable: true },
        { field: 'contact_reason', title: 'CR', width: '5%', sortable: true, align: 'center' },
        { field: 'firstname', title: 'Firstname, Lastname', width: '14%', sortable: true,
        formatter: function (value, row, index) {
              return row.firstname + ", "+row.lastname;
            }
      },
      { field: 'email', title: 'Email', width: '18%', sortable: true },
        { field: 'subject', title: 'Subject', width: '43%', sortable: true }
      ]],
      onDblClickRow: function (rowIndex, row) {
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
              $('#emailBox').empty();
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
         //     $('#dlgEmailContent').dialog('open');
            } else {
              console.log('error');
            }
          }
        });
        // ajax call 
      },
    });

        /**** Second row ****/
        $('#topViewPagesList').datagrid({
      title: 'Top View Pages',
      height: 400,
      singleSelect: true,
      pageSize: 50,
      view: scrollview,
      url: 'manWebTraffic.php?action=view_in_month&type=table&month=' + month + '&year=' + year,
      columns: [[
        { field: 'url_params', title: 'URL', width: '50%', sortable: true, 
        formatter: function(value, row, index){ 
          var hlink = "https://akasa.co.uk"+value;
          return '<span title=\"'+hlink+'\" class=\"easyui-tooltip\"><a href="'+hlink+'" target="_blank">' + value + '</a></span>';
        }},
                // { field: 'url_params', title: 'URL', width: '50%', sortable: true, 
        // formatter: function(value, row, index){ 
        //   var hlink = "https://akasa.co.uk"+value;
        //   return '<a href="'+hlink+'">'+value+'</a><div class="box"><iframe src="'+hlink+'" width = "100%" height = "500px"></iframe></div>' }},
        { field: 'referring_url', title: 'Referring Url', width: '25%', sortable: true, },
        { field: 'partno', title: 'Partno', width: '15%', sortable: true, align: 'center' },
        { field: 'cnt', title: 'Hit #', width: '10%', sortable: true, align: 'center' },
      ]],
    });

    $('#topViewCountryList').datagrid({
      title: 'Views In Each Country',
      height: 400,
      singleSelect: true,
      pageSize: 50,
      view: scrollview,
      url: 'manWebTraffic.php?action=view_in_month_country&type=table&month=' + month + '&year=' + year,
      columns: [[
        { field: 'country', title: 'Country', width: '40%', sortable: true, align: 'center' },
        { field: 'country_code', title: 'Country Code', width: '20%', sortable: true, align: 'center' },
        { field: 'cnt', title: 'Hit #', width: '40%', sortable: true, align: 'center' },
      ]],
    });


/**** Third row ****/
$('#topViewPagesCountryList').datagrid({
      title: 'Top View Pages In Country',
      height: 400,
      singleSelect: true,
      pageSize: 50,
      view: scrollview,
      multiSort: true,
      url: 'manWebTraffic.php?action=view_in_month_country_url&type=table&month=' + month + '&year=' + year,
      columns: [[
        { field: 'country_code', title: 'Code', width: '10%', sortable: true, align: 'center' },
        { field: 'url_params', title: 'URL', width: '50%', sortable: true, 
        formatter: function(value, row, index){ 
          var hlink = "https://akasa.co.uk"+value;
          return '<span title=\"'+hlink+'\" class=\"easyui-tooltip\"><a href="'+hlink+'" target="_blank">' + value + '</a></span>';
        }},
        { field: 'referring_url', title: 'Referring Url', width: '20%', sortable: true, },
        { field: 'partno', title: 'Partno', width: '10%', sortable: true, align: 'center' },
        { field: 'cnt', title: 'Hit #', width: '10%', sortable: true, align: 'center' },
      ]],
    });

    $('#topSearchPartnoList').datagrid({
      title: "Top Search records",
      height: 400,
      singleSelect: true,
      pageSize: 50,
      view: scrollview,
      url: 'manWebTraffic.php?action=search_in_month&type=table&month=' + month + '&year=' + year,
      columns: [[
        { field: 'partno', title: 'Partno', width: '60%', sortable: true, align: 'center' },
        { field: 'cnt', title: 'Hit #', width: '40%', sortable: true, align: 'center' },
      ]],
    });

    $('#topSearchPartnoCountryList').datagrid({
      title: "Top Search records In Each Country",
      height: 400,
      singleSelect: true,
      pageSize: 50,
      view: scrollview,
      url: 'manWebTraffic.php?action=search_in_month_country&type=table&month=' + month + '&year=' + year,
      columns: [[
        { field: 'country', title: 'Country', width: '40%', sortable: true, align: 'center' },
        { field: 'country_code', title: 'Country Code', width: '20%', sortable: true, align: 'center' },
        { field: 'cnt', title: 'Hit #', width: '40%', sortable: true, align: 'center' },
      ]],
    });

  });
  // window.onload = function () {
  //   var topSearchData = [];
  //   var topSearchChart = new CanvasJS.Chart("topSearchChartContainer", {
  //     animationEnabled: true,
  //     title: {
  // //      text: "Top 20 Searched Partno"
  //     },
  //     axisX: {
  //       interval: 1
  //     },
  //     axisY2: {
  //       interlacedColor: "#FDF2E4",
  //       gridColor: "#FEE0BD",
  //       // title: "Number of Searched Partno"
  //     },
  //     data: [{
  //       type: "bar",
  //       name: "companies",
  //       axisYType: "secondary",
  //       color: "#FF8B00",
  //       dataPoints: topSearchData,
  //     }]
  //   });
  //   $.getJSON("/marketing/manWebTraffic.php?action=search_in_month&month=01&year=2023", function (data) {

  //     $.each(data, function (key, value) {
  //       topSearchData.push({ label: value.partno, y: parseInt(value.cnt) });
  //     });
  //     topSearchChart.render();
  //   });

  //   var topSearchCountryData = [];
  //   var topSearchCountryChart = new CanvasJS.Chart("topSearchCountryChartContainer", {
  //     animationEnabled: true,
  //     title: {
  //     //  text: "Top 20 Searched Partno In Country"
  //     },
  //     axisX: {
  //       interval: 1
  //     },
  //     axisY2: {
  //       interlacedColor: "rgba(1,77,101,.2)",
  //       gridColor: "rgba(1,77,101,.1)",
  //       // title: "Number of Searched Partno"
  //     },
  //     data: [{
  //       type: "bar",
  //       name: "companies",
  //       axisYType: "secondary",
  //       color: "#014D65",
  //       dataPoints: topSearchCountryData,
  //     }]
  //   });
  //   $.getJSON("/marketing/manWebTraffic.php?action=search_in_month_country&month=01&year=2023", function (data) {

  //     $.each(data, function (key, value) {
  //       topSearchCountryData.push({ label: value.country, y: parseInt(value.cnt) });
  //     });
  //     topSearchCountryChart.render();
  //   });


  // }
<?php echo '</script'; ?>
>
</body><?php $_smarty_tpl->_subTemplateRender('file:layout/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
