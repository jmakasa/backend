<?php
/* Smarty version 3.1.34-dev-7, created on 2023-04-24 09:40:44
  from '/akasa/www/marketing/templates/web_traffic/list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_64464e9c2a5c42_18578707',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '26ea74bad7a93ec6ba93cb695abff7e9c195da84' => 
    array (
      0 => '/akasa/www/marketing/templates/web_traffic/list.tpl',
      1 => 1676569265,
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
function content_64464e9c2a5c42_18578707 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:layout/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
  <?php $_smarty_tpl->_subTemplateRender('file:layout/navmenu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
  <div class="container-fluid">
    <div class="row p-2">
      <div class="col">
        <input id="webViewList_year" name="type" type="text">
              <input id="webViewList_month" name="type" type="text">
              <input id="webViewList_date" name="type" type="text">
        </div>
        </div>
    <div class="row p-2">
      <div class="col-6 ">
        <!-- panel -->
        <!-- <div class="row border p-1" style="border-color:#d4a375!important;"> -->
          <div class="row">
            <div class="col-3">
              <img src="" alt="" class="img-thumbnail" id="partnoImage">
              <!-- panel -->
          <div class="panel main_panel" style="height:850px">
            <div class="panel-header">
              <div class="panel-title" id="allProductsTitle">Country Code Counter</div>
              <div class="panel-tool"></div>
            </div>
            <div class="panel-body">
              <table id="countryCodeList"></table>
            </div>
          </div>
          <!-- end panel -->
            </div>
          <div class="col-9">
            <div class="panel main_panel" style="height:850px">
              <div class="panel-header">
                <div class="panel-title" id="allProductsTitle">All Counters</div>
                <div class="panel-tool"></div>
              </div>
              <div class="panel-body">
                <table id="webViewList"></table>
                <div id='webViewList_toolbar'>
                  
                </div>
              </div>
            </div>
          </div>
          

        </div>
        
        <!-- end panel -->
      </div>
      <div class="col-4">
        <!-- panel -->
        <div class="panel main_panel" style="height:850px">
          <div class="panel-header">
            <div class="panel-title" id="allProductsTitle">Referring Url Counter</div>
            <div class="panel-tool"></div>
          </div>
          <div class="panel-body">
            <table id="refUrlList"></table>
            <table id="countryViewList"></table>
          </div>
        </div>
        <!-- end panel -->
      </div>
      <div class="col-2">
        <!-- panel -->
        <div class="panel main_panel" style="height:850px">
          <div class="panel-header">
            <div class="panel-title" id="allProductsTitle">By Month</div>
            <div class="panel-tool"></div>
          </div>
          <div class="panel-body">
            <table id="monthHistoryList"></table>
            <table id="dateOfMonthList"></table>
          </div>
        </div>
        <!-- end panel -->
      </div>

    </div>
  </div>
  </div>

  <?php echo '<script'; ?>
>
    // console.log($('#webViewList_year').combobox('getValue'));
    // var selectedYear = $('#webViewList_year').combobox('getValue');
    // var selectedMonth = $('#webViewList_month').combobox('getValue');
    // webViewList
    $('#webViewList').datagrid({
      url: 'manWebTraffic.php?action=get_view_in_month',
      // view: cardview_blog,
      toolbar: '#webViewList_toolbar',
      //       queryParams: {
      // 	year:  selectedYear,
      // 	month: selectedMonth
      // },
      height: '800px',
      singleSelect: true,
      pagination: true,
      pageSize: 50,
      idField: 'id',
      view: scrollview,
      columns: [[
        { field: 'log_month', title: 'Mon', width: '5%', sortable: true, align: 'center' },
        { field: 'partno', title: 'Partno', width: '20%', sortable: true, align: 'center' },
        // { field: 'referring_url', title: 'Referring Url', width: '30%', sortable: true, align: 'left' },
        {
          field: 'url_params', title: 'Url Params', width: '65%', sortable: true, align: 'left',
          formatter(value) {

            return "<span title='" + value + "'>" + value + "</span>";
          }
        },

        { field: 'cnt', title: 'cnt', width: '10%', sortable: true, align: 'center' },
      ]],
      onClickRow: function (rowIndex, row) {
        console.log(rowIndex);
        console.log(row);
        // check whether is partno
        var month = $('#webViewList_month').val();
        var year = $('#webViewList_year').val();
        var skey = '';
        if (row.partno) {
          // search by partno
          var stype = 'partno';
          var stype_dn = 'Partno';
          skey = row.partno;
        } else {
          // search by url_params
          var stype = 'url_params';
          var stype_dn = 'Url Params';
          skey = row.url_params;
        }
        $('#countryCodeList').datagrid({
          title: stype_dn + ': ' + skey,
          height: 800,
          singleSelect: true,
          pageSize: 100,
          view: scrollview,
          url: 'manWebTraffic.php?action=get_country_code_cnt&stype=' + stype + '&month=' + month + '&year=' + year + '&skey=' + skey,
          columns: [[
            { field: 'country_code', title: 'Country Code', width: '50%', sortable: true, },
            { field: 'cnt', title: 'Hit #', width: '50%', sortable: true, align: 'center' },
          ]],
          onLoadSuccess: function (resp) {
            console.log(resp);
            var sum = 0;
            for (i = 0; i < resp.total; i++) {
              sum += parseInt(resp.rows[i].cnt);
            }
            console.log(sum);
            var dgPanel = $('#countryCodeList').datagrid('getPanel');
            dgPanel.panel('setTitle', stype_dn + ': ' + skey + ' (' + sum + ')');
            // $('#Imponible').text(sum);
          }
        });
// get image update src partnoImage
//http://192.168.8.18/marketing/manimages.php?action=getImageByPartno&partno=A-ATX08-A1B


      }
    });

    $('#refUrlList').datagrid({
      //  title: '',
      height: 400,
      singleSelect: true,
      pageSize: 100,
      view: scrollview,
      queryParams: {
              year: $('#webViewList_year').val(),
              month:$('#webViewList_month').val()
            },
      url: 'manWebTraffic.php?action=get_most_referring_url',
      columns: [[
        {
          field: 'url', title: 'Referring Url', width: '70%', sortable: true, align: 'left',
          formatter(value) {

            return "<a href='" + value + "' target='_blank' title='" + value + "'>" + value + "</a>";
          }
        },
        { field: 'cnt', title: 'Hit #', width: '30%', sortable: true, align: 'center' },
      ]],
    });

    
    $('#countryViewList').datagrid({
      title: 'Country Views',
      height: 400,
      singleSelect: true,
      pageSize: 100,
      view: scrollview,
      queryParams: {
              year: $('#webViewList_year').val(),
              month:$('#webViewList_month').val()
            },
      url: 'manWebTraffic.php?action=get_country_code_counter',
      columns: [[
      
      {field: 'continent', title: 'Continent', width: '25%', sortable: true, align: 'left'},
      {field: 'country', title: 'Country', width: '25%', sortable: true, align: 'left'},
        {field: 'country_code', title: 'Code', width: '20%', sortable: true, align: 'center'},
        // {
        //   field: 'country_code', title: 'Code', width: '70%', sortable: true, align: 'left',
        //   formatter(value, row) {

        //     return "<span title='" + row.country + "'>" + value + "</span>";
        //   }
        // },
        { field: 'cnt', title: 'Hit #', width: '20%', sortable: true, align: 'center' },
      ]],
    });

    // define keyword type
    $('#webViewList_year').combobox({
      width: 180,
      // data: [
      //   { text: '2023', id: '2023', selected: true },
      // ],
      data: <?php echo $_smarty_tpl->tpl_vars['jsonYear']->value;?>
,
      valueField: 'id', textField: 'text',
      label: 'Year :', labelWidth: '50px', labelAlign: 'right',
      onChange: function (value) {
        var month = $('#webViewList_month').val();
        var date = $('#webViewList_date').val();
        $('#webViewList').datagrid('load', {
          year: value,
          month: month,
          date: date
          // month : $('#webViewList_month').combobox('getValue')
        });
      },
    });

    $('#webViewList_month').combobox({
      width: 180,
      data: <?php echo $_smarty_tpl->tpl_vars['jsonMonth']->value;?>
,
      valueField: 'id', textField: 'text',
      label: 'Month :', labelWidth: '50px', labelAlign: 'right',
      onChange: function (value) {
        console.log(value);
        var year = $('#webViewList_year').val();
        var date = $('#webViewList_date').val();
        reloadAllList(year,value,date);
        // $('#webViewList').datagrid('load', {
        //   month: value,
        //   year: year,
        //   date: date
        // });
      },
      });
    $('#webViewList_date').combobox({
      width: 180,
      data: <?php echo $_smarty_tpl->tpl_vars['jsonDate']->value;?>
,
      valueField: 'id', textField: 'text',
      label: 'Date :', labelWidth: '50px', labelAlign: 'right',
      onChange: function (value) {
        var year = $('#webViewList_year').val();
        var month = $('#webViewList_month').val();
        reloadAllList(year,month,value);
        // $('#webViewList').datagrid('load', {
        //   month: month,
        //   year: year,
        //   date: value
        // });
      },
      });

      function reloadAllList(year,month,date){
        $('#webViewList').datagrid('load', {
          month: month,
          year: year,
          date: date
        });
        $('#refUrlList').datagrid('load', {
          month: month,
          year: year,
          date: date
        });
        $('#countryViewList').datagrid('load', {
          month: month,
          year: year,
          date: date
        });
        // $('#countryCodeList').datagrid('load', {
        //   month: month,
        //   year: year,
        //   date: date
        // });
        

      }
  <?php echo '</script'; ?>
>

</body>
<?php $_smarty_tpl->_subTemplateRender('file:layout/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
