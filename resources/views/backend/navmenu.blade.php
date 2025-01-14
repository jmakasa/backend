<nav class="navbar navbar navbar-default navbar-fixed-top navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="mandashboard.php?action=view"><img src="{{ asset('public/img/akasa_logo.png') }}" /></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item me-2">
          <a class="nav-link" href="manproducts.php?action=viewlist&webmenu=new"><i
              class="bi bi-fan"></i>&nbsp;Products</a>
        </li>
        <li class="nav-item me-2">
          <a class="nav-link" href="manemail_contactus.php?action=list"><i class="bi bi-envelope"></i>&nbsp;Email From
            Web</a>
        </li>
        <li class="nav-item me-2">
          <a class="nav-link" href="mankeywordlist.php?action=view"><i class="bi bi-key"></i>&nbsp;Keywords</a>
        </li>
        <li class="nav-item me-2">
          <a class="nav-link" href="mannavmenu.php?action=viewlist"><i class="bi bi-menu-app"></i>&nbsp;Navmenu</a>
        </li>
        <li class="nav-item me-2">
          <a class="nav-link" href="manblogs.php?action=viewlist"><i class="bi bi-collection"></i>&nbsp;Blog</a>
        </li>
        <li class="nav-item me-2">
          <a class="nav-link" href="manupload_files.php?action=viewlist"><i class="bi bi-file-arrow-up"></i>&nbsp;Upload
            list</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-file-arrow-down"></i>&nbsp;Export File
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" onclick="exportAllMenucat()">
                [akasa2206] Export All Lists
              </a></li>
            <li><a class="dropdown-item" href="#" onclick="exportalldetail()">
                [akasa2206] Export All Product Details
              </a></li>
            <li><a class="dropdown-item" href="#" onclick="exportLegacyProduct()">
                [akasa2206] Export Legacy Product
              </a></li>

            <li><a class="dropdown-item" href="#" onclick="createkeyword2206()">
                [akasa2206] Create keywords
              </a></li>
            <li><a class="dropdown-item" href="#" onclick="exportprodlist2206()">
                [akasa2206] Export Search Product list
              </a></li>
            <li><a class="dropdown-item" href="#" onclick="exportindex2206()">
                [akasa2206] Export Search Index
              </a></li>
            <li><a class="dropdown-item" href="#" onclick="exportsearchlist2206()">
                [akasa2206] Export Search List
              </a></li>
          </ul>
        </li>

        <!--
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
      -->
      </ul>
      <div class="collapse navbar-collapse flex-grow-1 text-right" id="myNavbar7">
        <ul class="navbar-nav ms-auto flex-nowrap">
          <li class="nav-item mt-2">
            <select class="easyui-combobox" id="main_lang"></select>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php"><i class="bi bi-lightbulb-off"></i>&nbsp;Logout</a>
          </li>

        </ul>
      </div>
    </div>
  </div>
  </div>
</nav>
<script>
  $(document).ready(function () {
    $('#main_lang').combobox({
      width: 140,
      data: optLangs,
      valueField: 'id',
      textField: 'text',
      label: '<i class="bi bi-translate"></i>',
      labelWidth: '30px',
      onChange:function(newVal,oldVal){
        console.log(" change lang to " + newVal);
        setSessionLang(newVal);
        pageReloadDatagrid(newVal);
        backendApi = "../marketing/backend/server.php/"+getSessionLang()+"/api";
      }
    });
    $('#main_lang').textbox('initValue', getSessionLang()).combobox('setValue', getSessionLang());
   // $('#main_lang').combobox('setValue',getSessionLang());
  });
  

  // function changeLang(record) {
  //   console.log(record);
  //   console.log(record.value);
  //   setSessionLang(record.value);
  //   //  console.log(getSessionLang());
  //   pageReloadDatagrid(record.value);
  //   //   getListProduct();
  //   //     reloadBoxes(); // function to reload #boxes
  //   //     reloadBoxesGrid();
  //   //setPanelTitleWithLang(getSessionLang(), getSessionMenucatTitle());
  // }

</script>