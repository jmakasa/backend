app.controller('ProductDetailCtrl', [
    '$scope', 'dataFactory', '$window', '$sce', '$filter', 'constFactory', 'fileUploadService',
    function ProductDetailCtrl($scope, dataFactory, $window, $sce, $filter, fileUploadService, constFactory) {
        const $ctrl = this;
        $scope.message = '';
        $scope.productDetails = [];
        $scope.publishedList = [];
        $scope.socketTypeList = [];
        $scope.belongToNavmenu = [];
        $scope.boxIsSelected = {};
        $scope.addProdReviewsData = {};
        $scope.addSpecGroupData = {};
        $scope.iconData = {};
        $scope.addProdReviewsData.sitelogosrc = '';
        $scope.selectedProdReviews = '';
        $scope.uploadFileData = {};
        var hostname = "//" + $window.location.hostname;

        var rsListUrl = dataFactory.getBackendApi() + '/reviewsites/list';
        var prListUrl = dataFactory.getBackendApi() + '/product_reviews/list';
        var deletePrUrl = dataFactory.getBackendApi() + '/product_reviews/delete';
        $scope.date = new Date();


        $scope.config = _config;
        console.log($scope.config);
        $scope.config.iconpath = hostname + '/marketing/img/product/common/review/';
        $scope.config.imgpath = hostname + '/docs/products/' + $scope.config.partno + '/Web_Library/Reviews/';
        $scope.prodReviewsTypes = ['Video', 'Award', 'Blog'];
        $scope.hostnames = [
            {'name':'UK web [2206]','host':'akasa2206_uk'},
            {'name':'TW web [2206]','host':'akasa2206_tw'},
            
        ];

        // load init
        $ctrl.$onInit = () => {
            // get lang
            if ($window.sessionStorage.lang) {
                $scope.lang = $window.sessionStorage.lang;
            } else {
                $scope.lang = document.documentElement.getAttribute("lang");
            }
            dataFactory.getProductDetailsById($scope.config.id).then(function (resp) {
                //   $scope.listsOptions = response.data;
console.log(resp.data);
                if (resp.data) {
                    $scope.productDetails = resp.data;
                    if ($scope.productDetails.active == 1) {
                        $scope.productDetails.active = true;
                    }
                    if ($scope.productDetails.iscooler == 1) {
                        $scope.productDetails.iscooler = true;
                    }
                    if ($scope.productDetails.newproduct == 1) {
                        $scope.productDetails.newproduct = true;
                    }

                }
                //   $scope.bindSelectedCategory($scope.selectedCategoryData);
            }, function (error) {
                $scope.status = 'Unable to load lists of options data: ' + error.message;
                console.log(" getListsOptions : Unable to load lists of options data:  " + error.message)
            });

            // list of socket type
            dataFactory.getSocketTypeByPartno($scope.config.partno).then(function (resp) {
                $scope.socketTypeList = resp.data;
                $scope.productDetails.cpuSockets = $scope.socketTypeList.display_name;
            });

            // list of category
            dataFactory.getNavmenuListByPartno($scope.config.partno).then(function (resp) {
                $scope.belongToNavmenu = resp.data;
                angular.forEach($scope.belongToNavmenu, function (navmenu, key) {
                    if (navmenu.is_selected) {
                        $scope.boxIsSelected = navmenu;
                        console.log($scope.boxIsSelected);
                    }
                });

            });
            // list product review
            dataFactory.getProductReviews("").then(function (resp) {
                $scope.reviewsites = resp.data;

            });

            // list reviewsites
            dataFactory.getReviewsites("").then(function (resp) {
                $scope.productReviews = resp.data;

            });

        } // end init


        // tab selection
        $('#tt').tabs({
            border: false,
            onSelect: function (title) {
                // check title to load tab content
                // Specification, Reviews (NEW), Related Products

                console.log(title + ' is selected - in angularjs');
                if (title == 'Simply') {
                    dispmainform();
                }
                if (title == 'Specification') {
                    $('#divContentList').hide();
                    $('#divSpecHtml').hide();
                    $('#divSpecList').show();
                    $('#specList').datagrid({
                        title: 'Product Specification',
                        toolbar: '#spectoolbar',
                        width: 1200,
                        height: 650,
                        singleSelect: true,
                        pagination: true,
                        pageSize: 20,
                        pageList: [20, 40],
                        idField: 'id',
                        //list_group
                        url: "manprodspec.php?action=list_group",
                        //url: backendApi + "/spec/child/list",
                        queryParams: {
                            partno: $scope.config.partno,
                            group_id: 'all',
                            lang: $scope.lang
                        },
                        columns: [[
                            { field: 'id', title: 'ID', width: 60, sortable: true, align: 'center' },
                            { field: 'seqno', title: 'Seqno', width: 70, sortable: true, align: 'center', editor: 'textbox' },
                            {
                                field: 'group_id', title: 'Group', width: 200, sortable: true, editor: 'textbox',
                                formatter: function (value, row) {
                                    // for (var i = 0; i <products.length; i ++) {
                                    // 	if (products [i] .productid == value) return products [i] .name;
                                    // }
                                    if (row.group_id == 0) {
                                        return 'All';
                                    } else {
                                        return row.group_name;
                                    }
                                },
                                editor: {
                                    type: 'combobox',
                                    options: {
                                        valueField: 'group_id',
                                        textField: 'group_name',
                                        method: "GET",
                                        url: "manprodspec.php?action=active_spec_group_list&lang=" + $scope.lang,
                                        required: false
                                    }
                                }
                            },
                            { field: 'specname', title: 'Name', width: 200, sortable: true, editor: 'textbox' },
                            { field: 'specdesc', title: 'Content', width: 380, sortable: true, editor: { type: 'textbox', options: { height: 200, multiline: true } } },
                            { field: 'is_highlight', title: 'Highlight', width: 80, editor: 'textbox',halign:'center',align:'center',
                                    formatter: function (value, row, index) {
                                        if (value == 1){
                                            return '<input type="checkbox" id="is_highlight" name="is_highlight" value="1"  onclick="changeSpecHightlight('+row.id+',0)" checked>';
                                        } else {
                                            return '<input type="checkbox" id="is_highlight" name="is_highlight" value="1"  onclick="changeSpecHightlight('+row.id+',1)">';
                                        }

                                    },
                            },
                            {
                                field: 'action', title: 'Action', width: 70, align: 'center',
                                formatter: function (value, row, index) {
                                    if (row.editing) {
                                        var s = '<a href="javascript:void(0)" onclick="spsaverow(this)"><img src="/easyui/themes/icons/ok.png"></a> ';
                                        var c = '<a href="javascript:void(0)" onclick="spcancelrow(this)"><img src="/easyui/themes/icons/cancel.png"></a>';
                                        return s + '&nbsp;' + c;
                                    } else {
                                        var e = '<a href="javascript:void(0)" onclick="speditrow(this)"><img src="/easyui/themes/icons/pencil.png"></a> ';
                                        //            var d = '<a href="javascript:void(0)" onclick="spdeleterow(this)">Delete</a>';
                                        return e;
                                    }
                                }
                            }
                        ]],
                        onBeforeEdit: function (idx, row) {
                            if (!row.group_id) {
                                row.group_id = 1;
                                row.group_name = "General Information";
                            }
                            row.editing = true;
                            $(this).datagrid('refreshRow', idx);
                        },
                        onAfterEdit: function (index, row) {
                            row.editing = false;
                            $('#LHS_menu').tree('reload');
                            $(this).datagrid('refreshRow', index);
                        },
                        onCancelEdit: function (index, row) {
                            row.editing = false;
                            $(this).datagrid('refreshRow', index);
                        },
                        onEndEdit: function (index, row, changes) {
                            $.post('manprodspec.php?action=save', { partno: partno, editmode: speditmode, lang: lang, items: row },
                                function (r) {
                                    $('#LHS_menu').tree('reload');
                                    $("#specList").datagrid("reload");
                                }
                            );
                            speditmode = '0';
                        }
                    });
                    // call tree
                    // tree
                    $('#spec_group_list').tree({
                        method: "GET",
                        url: "manprodspec.php?action=spec_group_list&lang=" + $scope.lang,
                        title: 'Spec Group List',
                        formatter: function (node) {
                            if (node.status == 1) {
                                return node.group_name + "&nbsp;&nbsp;<a href='#' onclick='inactiveGroup(" + node.id + ")' title='Click to disable this group'><img src='/icons-main/icons/x.svg'></a>";
                            } else {
                                return "<s>" + node.group_name + "&nbsp;&nbsp;<a href='#' onclick='activeGroup(" + node.id + ")' title='Click to enable this group'><img src='/icons-main/icons/arrow-clockwise.svg'></a></s>";
                            }

                        },
                        onClick: function (node) {
                            selectedGroup = node;
                            console.log(node);
                        }
                    });
                    $('#LHS_menu').tree({
                        method: "GET",
                        url: "manprodspec.php?action=LHS_menu&partno=" + $scope.config.partno + "&lang=" + $scope.lang,
                        //url: backendApi + "/spec/lhs_tree/{|$partno|}",
                        formatter: function (node) {
                            if (node.text == null) {
                                return 'ALL';
                            } else {
                                return node.text;
                            }
                        },
                        onClick: function (node) {
                            switch (node.text) {
                                case 'Content':
                                    $('#divContentList').show();
                                    $('#divSpecHtml').hide();
                                    $('#divSpecList').hide();
                                    var url = 'manimages.php?action=list&partno=' + $scope.config.partno + '&imgtype=Specification&lang=' + $scope.lang;
                                    $('#contentList').datagrid({
                                        title: 'Content/Package',
                                        toolbar: '#specImageToolbar',
                                        view: cardview_specImage,
                                        url: url,
                                        width: 1200,
                                        height: 650,
                                        singleSelect: true,
                                        pagination: true,
                                        pageSize: 20,
                                        pageList: [20, 40],
                                        idField: 'id',
                                        columns: [[
                                            { field: 'id', title: 'ID', width: 35, sortable: true, align: 'center', hidden: true },
                                            { field: 'docname', title: 'File Name', width: 250, sortable: true },
                                            { field: 'seqno', title: 'Seqno', width: 150 },
                                            { field: 'caption', title: 'Caption', width: 150 },
                                            { field: 'comment', title: 'Comment', width: 150 },
                                        ]],
                                        onDblClickRow(index, row) {
                                            $("#viewImageSrc").attr("src", '/docs/products/' + $scope.config.partno + '/Web_Library/Specification/' + row.docname);
                                            $('#dlgViewImage').dialog('open');
                                        },
                                        onLoadSuccess: function () {
                                        }
                                    });
                                    break;
                                case 'Spec Html':
                                    $('#divContentList').hide();
                                    $('#divSpecHtml').show();
                                    $('#divSpecList').hide();
                                    break;
                                default:
                                    if (node.id == null) {
                                        node.id = 'all';
                                    }
                                    console.log(node);
                                    $('#divContentList').hide();
                                    $('#divSpecHtml').hide();
                                    $('#divSpecList').show();
                                    $('#specList').datagrid({
                                        title: 'Product Specification - ' + node.text,
                                        url: "manprodspec.php?action=list_group",
                                        queryParams: {
                                            partno: $scope.config.partno,
                                            group_id: node.id,
                                            lang: $scope.lang
                                        }
                                    });
                                    break;


                            }

                        }
                    });
                    // END tree

                    $('#specImageList').datagrid({
                        title: 'Content/Package',
                        toolbar: '#specImageToolbar',
                        //    view: cardview_specImage,
                        width: 200,
                        height: 650,
                        singleSelect: true,
                        pagination: true,
                        pageSize: 10,
                        pageList: [10, 20, 40],
                        idField: 'id',
                        columns: [[
                            { field: 'id', title: 'ID', width: 35, sortable: true, align: 'center', hidden: true },
                            { field: 'docname', title: 'File Name', width: 150, sortable: true },
                            { field: 'seqno', title: 'Seqno', width: 150 },
                            { field: 'caption', title: 'Caption', width: 150 },
                            { field: 'comment', title: 'Comment', width: 150 },
                        ]],
                        onDblClickRow(index, row) {
                            $("#viewImageSrc").attr("src", '/docs/products/' + $scope.config.partno + '/Web_Library/Specification/' + row.docname);
                            $('#dlgViewImage').dialog('open');
                        }
                    });

                    var url = 'manimages.php?action=list&partno=' + $scope.config.partno + '&imgtype=Specification&lang=' + $scope.lang;
                    $("#specImageList").datagrid({ url: url });

                    $('#p_spechtml').panel({
                        href: 'manprodspec.php?action=showspechtml&id=' + $scope.config.id,
                    });
                } else if (title == 'Related Products') {
                    $('#related_boxes').datalist('reload');
                } else if (title == 'Product Reviews' || title == 'Reviews') {
                    $('#rs_iconpanel').panel({
                        width: '530px',
                        height: '200px',
                        title: 'Preview Icon'
                    });
                    $('#rf_panel').panel({
                        width: '530px',
                        height: '800px',
                        title: 'Add Product Review'
                    });
                    $('#sitelist').datagrid({
                        view: cardview_reviewsitesList,
                        title: 'Review Site Award Icon List',
                        width: 300,
                        height: 800,
                        toolbar: '#rs_toolbar',
                        singleSelect: true,
                        pagination: true,
                        pageSize: 20,
                        pageList: [20, 40, 80],
                        idField: 'id',
                        url: rsListUrl,
                        columns: [[
                            { field: 'id', title: 'ID', width: 40, hidden: true },
                            { field: 'sitename', title: 'Name', width: 100, sortable: true },
                            { field: 'sitelogo', title: 'icon name', width: 50, hidden: true },
                            { field: 'product_reviews_count', title: 'Cnt', width: 100, sortable: true },

                        ]],
                        onSelect: function (index, row) {
                            console.log(row);
                            $scope.$apply(function () {
                                // icon form data
                                $scope.iconData = row;
                                console.log($scope.iconData);
                                $scope.iconData.formname = "Edit Review Site";
                                // product review form data
                                $scope.addProdReviewsData.addBtnEnabled = true;
                                $scope.addProdReviewsData.siteidx = index;

                                $scope.updateSelectedLogo(row.id,row.sitelogo,row.sitename,row.siteurl);
                                // $scope.addProdReviewsData.reviewsites_id = row.id;
                                // $scope.addProdReviewsData.sitelogo = row.sitelogo;
                                // $scope.addProdReviewsData.sitelogosrc = hostname + '/marketing/img/product/common/review/icon/' + row.sitelogo;
                                // $scope.addProdReviewsData.sitename = row.sitename;
                                // $scope.addProdReviewsData.siteurl = row.siteurl;
                            });


                        },
                        onDblClickRow :function (idx, row){
                            
                            dataFactory.getProductReviewsBySites({ 'reviewsites_id': row.id }).then(function (resp) {
                                $scope.listProdReviewBySites = resp.data;
                                $scope.listProdReviewBySites.sitename = row.sitename;
                                console.log($scope.listProdReviewBySites);
                            
                                $('#listProdReviewBySiteModal').modal('show');

                            });
                        }
                    });

                    $('#sitenamekey').combobox({
                        prompt: 'Type site name here...',
                        onSelect: function (record) {
                            console.log(record);
                            var url = dataFactory.getBackendApi() + "/reviewsites/list/";
                            $('#sitelist').datagrid({
                                url: url,
                                queryParams: {
                                    sitename: record.name,
                                }
                            });
                            //$('#sitelist').datagrid('reload');
                        }
                    });


                    $('#productReviewsList').datagrid({
                        view: cardview_productReviewsList,
                        width: '900px',
                        height: '800px',
                        idField: 'id',
                        singleSelect: true,
                        // url: 'man_product_reviews.php?action=list&lang='+$scope.config.lang+'&partno='+$scope.config.partno,
                        url: prListUrl,
                        queryParams: {
                            partno: $scope.config.partno,
                        },
                        onSelect: function (index, row) {

                            $scope.$apply(function () {
                                $scope.selectedProdReviews = row.id;
                                $scope.addProdReviewsData = row;
                                $('#rf_panel').panel({
                                    title: 'Edit Product Review'
                                });
                                // btn text
                                $scope.addProdReviewsData.pridx = index;
                                $scope.addProdReviewsData.btntext = 'Edit';
                                // image
                                if ($filter('isEmptyData')($scope.addProdReviewsData, 'images')) {
                                    $scope.addProdReviewsData.imgsrc = $scope.config.imgpath + $scope.addProdReviewsData.images.docname;
                                    $scope.addProdReviewsData.caption = $scope.addProdReviewsData.images.caption;
                                    $scope.addProdReviewsData.comment = $scope.addProdReviewsData.images.comment;
                                }
                                // icon
                                $scope.updateSelectedLogo($scope.addProdReviewsData.reviewsites.id,$scope.addProdReviewsData.reviewsites.sitelogo,$scope.addProdReviewsData.reviewsites.sitename,$scope.addProdReviewsData.reviewsites.siteurl);
                                if ($scope.addProdReviewsData.is_hide_icon == 1) {
                                    $scope.addProdReviewsData.is_hide_icon = true;
                                }
                                // $scope.addProdReviewsData.reviewsites_id = $scope.addProdReviewsData.reviewsites.id;
                                // $scope.addProdReviewsData.sitelogo = $scope.addProdReviewsData.reviewsites.sitelogo;
                                // $scope.addProdReviewsData.sitelogosrc = $scope.config.iconpath + $scope.addProdReviewsData.reviewsites.sitelogo;
                                // $scope.addProdReviewsData.sitename = $scope.addProdReviewsData.reviewsites.sitename;
                                // $scope.addProdReviewsData.siteurl = $scope.addProdReviewsData.reviewsites.siteurl;
                            });
                        },
                        onDblClickRow(index, row) {// make it popup and TODO ::  edit 
                            console.log(row);

                            $("#viewImageSrc").attr("src", '/docs/products/' + $scope.config.partno + '/Web_Library/Reviews/' + row.docname);
                            $('#dlgViewImage').dialog('open');
                        },
                        toolbar: '#productReviewsList_toolbar',
                        showHeader: false,
                        columns: [[
                            { field: 'id', title: 'ID', width: 35, sortable: true, align: 'center', hidden: true },
                            { field: 'title', title: 'Title', width: 35, hidden: true },
                            { field: 'web_link', title: 'Link', width: 35, hidden: true },
                            { field: 'type', title: 'Type', width: 35, hidden: true },
                            { field: 'docname', title: 'File Name', width: 35, sortable: true, hidden: true },
                            { field: 'seqno', title: 'Seqno', width: 35, hidden: true },
                            { field: 'caption', title: 'Caption', width: 35, hidden: true },
                            { field: 'comment', title: 'Comment', width: 35, hidden: true },
                            { field: 'status', title: 'Status', width: 35, hidden: true },
                        ]]
                    });
                } else if (title == 'Upload Files') {

                    $('#uploadfileslist').datagrid({
                        url: dataFactory.getBackendApi() +'/file_uploads/list',
                       // method:'GET',
                        toolbar: '#upload_files_toolbar',
                        height: '750px',
                        singleSelect: false,
                        pagination: true,
                        pageSize: 50,
                        idField: 'id',
                        //view: scrollview,
                        view: groupview,
                        queryParams: {
                            partno: $scope.config.partno,
                            lang: $scope.lang
                        },
                        groupField: 'partno',
                        groupFormatter: function (value, rows, index) {
                          var txt = value + ' - ' + rows.length + ' Item(s)';
                          txt = '<input type="checkbox" onclick="groupCheck(\'' + value + '\',event)">&nbsp;' + txt;
                          return txt;
                        },
                        columns: [[
                          { field: 'keychx', checkbox: true },
                          { field: 'id', title: 'ID', width: '5%', sortable: true, align: 'center' },
                          { field: 'filename', title: 'Filename (Mouseover the name to see file path)', width: '45%', sortable: true,
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

                      
                    $('#uploadFilesTasksList').datagrid({
                        //url: 'manupload_files.php?action=getAllTasks',
                        url:dataFactory.getBackendApi()+'/file_uploads/tasks/list',
                        toolbar: '#upload_files_tasks_toolbar',
                        height: '750px',
                        singleSelect: false,
                        pagination: true,
                        pageSize: 50,
                        idField: 'id',
                        queryParams: {
                            partno: $scope.config.partno,
                            lang: $scope.lang
                        },
                        columns: [[
                            { field: 'keychx', checkbox: true },
                            { field: 'id', title: 'ID', width: '5%', sortable: true, align: 'center' },
                            { field: 'hostname', title: 'H', width: '5%', sortable: true, align: 'center' },
                            { field: 'filename', title: 'Filename (Mouseover the name to see file path)', width: '35%', sortable: true,
                                formatter: function (value, row, index) {
                                var titleFilename = "LF : " + row.local_file + '\nRF : ' + row.remote_file;
                                return "<span title='" + titleFilename + "'>" + value + "</span>";
                                },
                            },
                            { field: 'etype', title: 'File Type', width: '10%', sortable: true, align: 'center' },
                            { field: 'launch_datetime', title: 'Launch time', width: '13%', sortable: true },
                            { field: 'status', title: 'Status', width: '5%', sortable: true, align: 'center',
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
                            {id: 'all', text: 'ALL',  selected: true},
                            {id: 'product',   text: 'product'},
                            {id: 'gallery',   text: 'gallery'},
                            {id: 'feature',   text: 'feature'},
                            {id: 'content',   text: 'content'},
                            {id: 'Reviews',   text: 'Reviews'},
                            {id: 'software',  text: 'software'},
                            {id: 'reviewsitelogo',  text: 'reviewsitelogo'},
                            {id: 'reviewsite',  text: 'reviewsite'},
                        ],
                        valueField: 'id', textField: 'text', label: 'File Type :', labelWidth: '82px', labelAlign: 'right',
                        onChange: function (value) {
                            console.log(value);
                            $('#uploadFilesTasksList').datagrid('load', {
                            etype: value,
                            partno: $scope.config.partno,
                            lang: $scope.lang
                            });
                        },
                    });

                    // $('#publishedList').datagrid({
                    //     title: 'Published List',
                    //     width: 1200,
                    //     height: 650,
                    //     singleSelect: true,
                    //     pagination: true,
                    //     pageSize: 20,
                    //     pageList: [20, 40],
                    //     idField: 'id',
                    //     //list_group
                    //     url: getPublishedListUrl,
                    //     //url: backendApi + "/spec/child/list",
                    //     queryParams: {
                    //         partno: $scope.config.partno,
                    //         lang: $scope.lang
                    //     },
                    //     columns: [[
                    //         { field: 'id', title: 'ID', width: 60, sortable: true, align: 'center' },
                    //         { field: 'filename', title: 'Filename', width: 100, sortable: true, align: 'center', editor: 'textbox' },
                    //         { field: 'uploaded_datetime', title: 'Published Datetime', width: 100, sortable: true, editor: 'textbox' },
                           
                    //     ]],
                    // });
                }

            }
        });

        // prod spec
        $scope.submitNewSpecGroup = function () {
            console.log($scope.addSpecGroupData);
        }



        // END prod spec




        // click function
        // main info tab
        $scope.editMain = function (id) {
            dataFactory.getProductDetailsById(id).then(function (resp) {
                if (resp.data) {
                    $scope.productDetails = resp.data;
                    if ($scope.productDetails.active == 1) {
                        $scope.productDetails.active = true;
                    }
                    if ($scope.productDetails.iscooler == 1) {
                        $scope.productDetails.iscooler = true;
                    }
                    if ($scope.productDetails.newproduct == 1) {
                        $scope.productDetails.newproduct = true;
                    }
                    $("#mf_longDesc").summernote({
                        'code': $scope.productDetails.longdesc,
                        callbacks: {
                            onChange: function (contents, $editable) {
                                $scope.productDetails.longdesc = contents;
                            }
                        }
                    });
                    $('#mainFormModal').modal('show');
                }
                //   $scope.bindSelectedCategory($scope.selectedCategoryData);
            }, function (error) {
                $scope.status = 'Unable to load lists of options data: ' + error.message;
                console.log(" getListsOptions : Unable to load lists of options data:  " + error.message)
            });
        }

        $scope.editSocketType = function (partno) {
            dataFactory.getSocketTypeByPartno(partno).then(function (resp) {
                $scope.socketTypeList = resp.data;
                $scope.productDetails.cpuSockets = $scope.socketTypeList.display_name;
            });

            $('#socketTypeFormModal').modal('show');
        }
        // END main info tab

        $scope.updateBoxIsSelected = function () {
            $scope.updateBoxIsSelected.disabled = true;
            console.log($scope.boxIsSelected);
            $scope.boxIsSelected.productcode = $scope.config.partno;
            dataFactory.updateBoxesIsSelected($scope.boxIsSelected).then(function (resp) {
                if (resp.data.result) {
                    angular.forEach($scope.belongToNavmenu, function (navmenu, key) {
                        if ($scope.boxIsSelected.pb_id == navmenu.pb_id) {

                            $scope.belongToNavmenu[key]['is_selected'] = 1;
                        } else {
                            $scope.belongToNavmenu[key]['is_selected'] = 0;
                        }
                    });
                    $scope.updateBoxIsSelected.disabled = false;
                }
            });

        }

        // overview tab
        $scope.editintro = function () {
            $("#ovfm_intro").summernote({
                'code': $scope.productDetails.introduction,
                callbacks: {
                    onChange: function (contents, $editable) {
                        // $scope.$apply(function () {
                        $scope.productDetails.introduction = contents;
                        // });
                    },
                }
            });
            //$("#ovfm_intro").summernote('height', 500);
            $('#introFormModal').modal('show');
        }
        $scope.updateIntro = function () {
            if ($('#ovfm_intro').summernote('codeview.isActivated')) {
                $('#ovfm_intro').summernote('codeview.deactivate');
            }
            //   exit;
            dataFactory.updateIntro($scope.productDetails).then(function (resp) {
                console.log(resp);
                $('#introFormModal').modal('hide');
            });
        }

        $scope.updateProductDetails = function () {
            $scope.changeProductStatus();
            dataFactory.updateProductDetails($scope.productDetails).then(function (resp) {
                if (resp.data) {
                    $('#mainFormModal').modal('hide');
                }

            });
        }
        $scope.changeProductStatus = function () {
            if ($scope.productDetails.pstatus == 8 || $scope.productDetails.pstatus == 6) {
                $scope.productDetails.active = false;
                $scope.productDetails.newproduct = false;
            } else if ($scope.productDetails.pstatus == 2) {
                $scope.productDetails.active = true;
                $scope.productDetails.newproduct = true;
            } else {
                $scope.productDetails.active = true;
                $scope.productDetails.newproduct = false;
            }
        }

        $scope.updateSocketType = function () {
            dataFactory.updateSocketTypeByPartno($scope.config.partno, $scope.socketTypeList).then(function (resp) {
                // console.log(resp);
                if (resp.data) {
                    $scope.socketTypeList = resp.data.original;
                    $scope.productDetails.cpuSockets = $scope.socketTypeList.display_name;
                    $('#socketTypeFormModal').modal('hide');
                }
            });
        }
        // end overview tab
        // product review tab
        // product review  & reviewsites
        $scope.submitNewProdReviews = function () {
            /** data $scope.addProdReviewsData */
            $scope.addProdReviewsData.submitted = true;
            // console.log($scope.addProdReviewsData);
            var validation = $scope.validationNewProdReview($scope.addProdReviewsData);

            // done validation
            if (validation) {
                $scope.addProdReviewsData.lang = $scope.lang;
                $scope.addProdReviewsData.ctype = 'Reviews';
                $scope.addProdReviewsData.partno = $scope.config.partno;

                if ($filter('isEmptyData')($scope.addProdReviewsData, 'prImage')) {
                    var uploadFiles = $scope.addProdReviewsData.prImage;
                    angular.forEach(uploadFiles, function (file, key) {
                        $scope.addProdReviewsData.filetype = file.type;
                        $scope.addProdReviewsData.filesize = file.size;
                        $scope.addProdReviewsData.docname = file.name;
                        var folderPath = $scope.config.partno + "/Web_Library/Reviews/";
                        var uploadUrl = dataFactory.getUploadFileUrl(), //Url of webservice/api/server
                            promise = dataFactory.uploadFile(file, uploadUrl, 'product_docs',folderPath);
                        promise.then(function (response) {
                            $scope.serverResponse = response;
                            dataFactory.addProductReviews($scope.addProdReviewsData).then(function (resp) {
                                if (resp.statusText == 'OK') {
                                    $("#productReviewsList").datagrid("reload");
                                    $scope.resetProdReviewForm();
                                    $scope.addProdReviewsData.prImage ='';
                                } else {
                                    $scope.errContent = "Failed to add Product Review.";
                                    $('#noSelectionModal').modal('show');
                                }
                            });
                        }, function () {
                            $scope.serverResponse = 'An error has occurred';
                        });
                    });
    
                } else { // image no change . 
                    console.log(" image no change");
                    dataFactory.addProductReviews($scope.addProdReviewsData).then(function (resp) {
                        if (resp.statusText == 'OK') {
                            $("#productReviewsList").datagrid("reload");
                            $scope.resetProdReviewForm();
                        } else {
                            $scope.errContent = "Failed to add Product Review.";
                            $('#noSelectionModal').modal('show');
                        }
                    });
                }

                
            } else {
                $scope.errContent = "Failed to edit Product Review.";
                    $('#noSelectionModal').modal('show');
            }

        }
        $scope.closeModal = function (ID) {
            console.log(ID);
        }

        $scope.deleteProductReviews = function () {
            if ($filter('isEmptyData')($scope.addProdReviewsData, 'id')) {
                $('#deleteProdReviewModal').modal('show');
            } else {

                $scope.errContent = "Please Select a product review to Delete.";
                $('#noSelectionModal').modal('show');
            }
        }

        $scope.submitDelProdReviews = function () {
            dataFactory.deleteProductReviews($scope.addProdReviewsData).then(function (resp) {
                console.log('getReviewsitesById');
                console.log(resp);
                if (resp.statusText == 'OK') {
                    $("#productReviewsList").datagrid("reload");
                    $('#deleteProdReviewModal').modal('hide');
                } else {
                    $scope.errContent = "Failed to add Product Review.";
                    $('#noSelectionModal').modal('show');
                }
            });
        }
        $scope.removeProdReviews = function () {
            if ($filter('isEmptyData')($scope.addProdReviewsData, 'id')) {

                dataFactory.removeImageProductReviews($scope.addProdReviewsData).then(function (resp) {
                    if (resp.statusText == 'OK') {
                        $scope.addProdReviewsData.images.docname = "";
                        $("#productReviewsList").datagrid("reload");
                    } else {
                        $scope.errContent = "Failed to add Product Review.";
                        $('#noSelectionModal').modal('show');
                    }
                });
            } else {

                $scope.errContent = "Please Select a product review to Delete.";
                $('#noSelectionModal').modal('show');
            }
        }

        $scope.reloadProdReviewList = function () {
            $("#productReviewsList").datagrid("reload");
        }

        // reset product review form
        $scope.resetProdReviewForm = function () {
            $('#sitelist').datagrid('unselectRow', $scope.addProdReviewsData.siteidx);
            $('#productReviewsList').datagrid('unselectRow', $scope.addProdReviewsData.pridx);
            $scope.addProdReviewsData = {};
        }

        $scope.refreshReviewsites = function () {
            $('#sitelist').datagrid({
                url: rsListUrl,
                queryParams: {}
            });
        }
        $scope.searchReviewsites = function () {
            var key = $("#sitenamekey").combobox('getValue');
            $('#sitelist').datagrid({
                url: rsListUrl,
                queryParams: {
                    sitename: key,
                }
            });
        }
        $scope.editreviewicon = function (editmode) {

            if (editmode == '-1') {
                $("#rif_id").val(editmode);
                $scope.iconData = {};
                $scope.iconData.id = -1;
                $scope.iconData.formname = "Add Review Site";
                $scope.iconData.editmode = 'add';
                $('#reviewiconformModal').modal('show');

                //$('#reviewiconformdlg').dialog('open');
            } else {
                var selectedrow = $("#sitelist").datagrid("getSelected");
                if (selectedrow == null) {
                    $scope.errContent = "Please Select a row to Edit!";
                    $('#noSelectionModal').modal('show');
                } else {
                    $scope.iconData.editmode = 'edit';
                    dataFactory.getReviewsitesById({ 'id': selectedrow.id }).then(function (resp) {

                        $('#reviewiconform').form('load', resp.data);
                        $('#reviewiconformModal').modal('show');
                    });
                }
            }
        }

        $scope.submitReviewIconForm = function (editmode) {
            //  $scope.iconsData
            $scope.iconData.lang = $scope.lang;
            if ($scope.iconData.editmode == 'edit') {
                
                var validation = $scope.validationEditReviewsite($scope.iconData);
                // done validation
                if (validation) {
                    if ($filter('isEmptyData')($scope.iconData, 'myIcon')) {
                        var uploadFiles = $scope.iconData.myIcon;

                        angular.forEach(uploadFiles, function (file, key) {
                            var thisfile = [];
                            $scope.iconData.filetype = file.type;
                            $scope.iconData.filesize = file.size;
                            $scope.iconData.sitelogo = file.name;
                            var uploadUrl = dataFactory.getUploadFileUrl(), //Url of webservice/api/server
                                promise = dataFactory.uploadFile(file, uploadUrl, 'marketing_reviewsite', 'icon');
                            promise.then(function (response) {
                                $scope.serverResponse = response;
                                dataFactory.editReviewsites($scope.iconData).then(function (resp) {
                                    if (resp.statusText == 'OK') {
                                        // update 
                                        $("#sitelist").datagrid("reload");
                                        $scope.updateSelectedLogo(resp.data.id,resp.data.sitelogo,resp.data.sitename,resp.data.siteurl);
                                        $('#reviewiconformModal').modal('hide');
                                    } else {
                                        $scope.errContent = "Failed to edit reviewsites";
                                        $('#noSelectionModal').modal('show');
                                    }
                                });
                            }, function () {
                                $scope.serverResponse = 'An error has occurred';
                            });
                        });
                    } else {
                        dataFactory.editReviewsites($scope.iconData).then(function (resp) {
                            console.log(resp);
                            if (resp.statusText == 'OK') {
                                $("#sitelist").datagrid("reload");
                                //sitelogo,sitename,siteurl){
                                $scope.updateSelectedLogo(resp.data.id,resp.data.sitelogo,resp.data.sitename,resp.data.siteurl);
                                $('#reviewiconformModal').modal('hide');
                            } else {
                                $scope.errContent = "Failed to edit reviewsites";
                                $('#noSelectionModal').modal('show');
                            }
                        });
                    }
                }

            } else {
                var validation = $scope.validationNewReviewsite($scope.iconData);
                // done validation
                if (validation) {
                    // angular.element("input[type='file']").val(null);
                    if ($filter('isEmptyData')($scope.iconData, 'myIcon')) {
                        var uploadFiles = $scope.iconData.myIcon;

                        angular.forEach(uploadFiles, function (file, key) {
                            var thisfile = [];
                            $scope.iconData.filetype = file.type;
                            $scope.iconData.filesize = file.size;
                            $scope.iconData.sitelogo = file.name;
                            var uploadUrl = dataFactory.getUploadFileUrl(), //Url of webservice/api/server
                                promise = dataFactory.uploadFile(file, uploadUrl, 'marketing_reviewsite', 'icon');
                            promise.then(function (response) {
                                $scope.serverResponse = response;
                                dataFactory.addReviewsites($scope.iconData).then(function (resp) {
                                    if (resp.statusText == 'OK') {
                                        $("#sitelist").datagrid("reload");
                                        $('#reviewiconformModal').modal('hide');
                                    } else {
                                        $scope.errContent = "Failed to add reviewsites";
                                        $('#noSelectionModal').modal('show');
                                    }
                                });
                            }, function () {
                                $scope.serverResponse = 'An error has occurred';
                            });
                        });
                    }
                }
            }
        }
        $scope.deleteReviewsite = function () {

            if ($filter('isEmptyData')($scope.addProdReviewsData, 'reviewsites_id')) {
                $('#deleteReviewsiteModal').modal('show');
            } else {

                $scope.errContent = "Please Select a reviewsite to Delete.";
                        $('#noSelectionModal').modal('show');
            }
        }

        
        $scope.submitDelReviewsite = function (){
            console.log("submitDelReviewsite");
                dataFactory.deleteReviewsites($scope.addProdReviewsData).then(function (resp) {
                    console.log(resp);
                    if (resp.statusText == 'OK') {
                        $scope.resetProdReviewForm();
                        $("#sitelist").datagrid("reload");
                        $('#deleteReviewsiteModal').modal('hide');
                    } else {
                        $scope.errContent = "Failed to delete Reviewsite";
                        $('#noSelectionModal').modal('show');
                    }
                });
        }

        $scope.exportReviewsiteConf = function (){
                dataFactory.exportReviewsiteConf().then(function (resp) {
                    if (resp.statusText == 'OK') {
                        $scope.msgContent = "Exported reviewsite config file.";
                        $scope.msgTitle = "Success";
                        $('#msgModal').modal('show');
                    } else {
                        $scope.errContent = "Failed to export Reviewsite conf.";
                        $('#noSelectionModal').modal('show');
                    }
                });
        }

        $scope.updateSelectedLogo = function (reviewsites_id,sitelogo,sitename,siteurl){
            $scope.addProdReviewsData.reviewsites_id = reviewsites_id;
            $scope.addProdReviewsData.sitelogo = sitelogo;
            $scope.addProdReviewsData.sitelogosrc = hostname + '/marketing/img/product/common/review/icon/' + sitelogo;
            $scope.addProdReviewsData.sitename = sitename;
            $scope.addProdReviewsData.siteurl = siteurl;
            return $scope.addProdReviewsData;
        }
    


        // end product review

        // upload files list
        
        $scope.uploadFileNowBtn = false;
        $scope.removeFileNowBtn = false;
        $scope.assignUploadTasks = function () {
            $('#frmUploadFiles_launch_datetime').datetimebox({
                required: true, showSeconds: false,
                value: $filter('date')($scope.date, 'yyyy-MM-dd HH:mm:ss')
            });
            var selectedrow = $("#uploadfileslist").datagrid("getSelected");
            if (!selectedrow) {
              alert("Please select one of records to UPLOAD.");
            } else {
                $scope.uploadFileNowBtn = false;
                $scope.removeFileNowBtn = false;
              //frmUploadFiles_hostname
                var selectedIds = [];
                var dg = $('#uploadfileslist');
                $.map(dg.datagrid('getChecked'), function (row) {
                    selectedIds.push(row.id);
                });
                $scope.uploadFileData.id = selectedIds;
                $('#uploadHostingModal').modal('show');
            }
          }

        $scope.submitAssignUploadTasks= function(){
            $scope.uploadFileData.launch_datetime = $("#frmUploadFiles_launch_datetime").val();
            var selectedHostnames = [];
            $scope.hostnames.forEach(function (v) {
                if (v.selected){
                    selectedHostnames.push(v.host);
                }
            });
            $scope.uploadFileData.hostname = selectedHostnames;
            // check hosting
            if ($scope.uploadFileData.hostname.length > 0){
                dataFactory.assignScheduleTasks($scope.uploadFileData).then(function (resp) {
                    if (resp.statusText == 'OK') {
                        $("#uploadFilesTasksList").datagrid("reload");
                        $("#uploadfileslist").datagrid("reload");
                        $('#uploadHostingModal').modal('hide');
                        $scope.msgTitle = "Upload File";
                        $scope.msgContent = "Uploaded file successfully.";
                        $('#msgModal').modal('show');
                    } else {
                        $scope.errContent = "Failed to upload file now.";
                        $('#noSelectionModal').modal('show');
                    }
                });
            } else {console.log(" no host ");}
        }
        
        $scope.uploadFileNow = function () {
            $('#frmUploadFiles_launch_datetime').datetimebox({
                required: true, showSeconds: false, disabled:true,
                value: $filter('date')($scope.date, 'yyyy-MM-dd HH:mm:ss')
            });
            var selectedrow = $("#uploadfileslist").datagrid("getSelected");
            if (!selectedrow) {
              alert("Please select one of records to UPLOAD.");
            } else {
                $scope.uploadFileNowBtn = true;
                $scope.removeFileNowBtn = false;
              //frmUploadFiles_hostname
                var selectedIds = [];
                var dg = $('#uploadfileslist');
                $.map(dg.datagrid('getChecked'), function (row) {
                    selectedIds.push(row.id);
                });
                $scope.uploadFileData.id = selectedIds;
                $('#uploadHostingModal').modal('show');
            }
          }

        $scope.submitUploadFileNow= function(){
            $scope.uploadFileData.launch_datetime = $("#frmUploadFiles_launch_datetime").val();
            var selectedHostnames = [];
            $scope.hostnames.forEach(function (v) {
                if (v.selected){
                    selectedHostnames.push(v.host);
                }
            });
            $scope.uploadFileData.hostname = selectedHostnames;
            // check hosting
            if ($scope.uploadFileData.hostname.length > 0){
                dataFactory.uploadFileNow($scope.uploadFileData).then(function (resp) {
                    if (resp.statusText == 'OK') {
                        $("#uploadFilesTasksList").datagrid("reload");
                        $("#uploadfileslist").datagrid("reload");
                        $('#uploadHostingModal').modal('hide');
                        $scope.msgTitle = "Upload File";
                        $scope.msgContent = "Uploaded file successfully.";
                        $scope.uploadFileNowBtn = false;
                        $scope.removeFileNowBtn = false;
                        $('#msgModal').modal('show');
                    } else {
                        $scope.errContent = "Failed to upload file now.";
                        $('#noSelectionModal').modal('show');
                    }
                });
            } else {console.log(" no host ");}
        }

        $scope.removeUploadedFile = function (){
           $('#frmUploadFiles_launch_datetime').datetimebox({
               required: true, showSeconds: false,
               value: $filter('date')($scope.date, 'yyyy-MM-dd HH:mm:ss')
           });
           var selectedrow = $("#uploadfileslist").datagrid("getSelected");
           if (!selectedrow) {
             alert("Please select one of records to UPLOAD.");
           } else {
               $scope.uploadFileNowBtn = false;
               $scope.removeFileNowBtn = true;
             //frmUploadFiles_hostname
               var selectedIds = [];
               var dg = $('#uploadfileslist');
               $.map(dg.datagrid('getChecked'), function (row) {
                   selectedIds.push(row.id);
               });
               $scope.uploadFileData.id = selectedIds;
               $('#uploadHostingModal').modal('show');
           }
        }
        $scope.submitRemoveUploadedFileNow= function(){
           $scope.uploadFileData.launch_datetime = $("#frmUploadFiles_launch_datetime").val();
           var selectedHostnames = [];
           $scope.hostnames.forEach(function (v) {
               if (v.selected){
                   selectedHostnames.push(v.host);
               }
           });
           $scope.uploadFileData.hostname = selectedHostnames;
           // check hosting
           if ($scope.uploadFileData.hostname.length > 0){
               dataFactory.removeUploadedFile($scope.uploadFileData).then(function (resp) {
                   if (resp.statusText == 'OK') {
                       $("#uploadFilesTasksList").datagrid("reload");
                       $("#uploadfileslist").datagrid("reload");
                       $('#uploadHostingModal').modal('hide');
                       $scope.msgTitle = "Upload File";
                       $scope.msgContent = "Uploaded file successfully.";
                       $scope.uploadFileNowBtn = false;
                       $scope.removeFileNowBtn = false;
                       $('#msgModal').modal('show');
                   } else {
                       $scope.errContent = "Failed to upload file now.";
                       $('#noSelectionModal').modal('show');
                   }
               });
           } else {console.log(" no host ");}
       }


        // end upload files list

        // watch
        $scope.$watch('productDetails.introduction', function () {
            if ($filter('isEmptyData')($scope.productDetails, 'introduction') && $scope.productDetails.introduction) {
            }
        });
        $scope.$watch('addProdReviewsData.seqno', function () {
            if ($filter('isEmptyData')($scope.addProdReviewsData, 'submitting') && $scope.addProdReviewsData.submitting) {
                if ($filter('isEmptyData')($scope.addProdReviewsData, 'seqno')) {
                    $scope.addProdReviewsData.invalid_seqno = false;

                } else {
                    $scope.addProdReviewsData.invalid_seqno = true;

                }
            }
        });
        $scope.$watch('addProdReviewsData.reviewsites_id', function () {
            if ($filter('isEmptyData')($scope.addProdReviewsData, 'submitting') && $scope.addProdReviewsData.submitting) {
                if ($filter('isEmptyData')($scope.addProdReviewsData, 'reviewsites_id')) {
                    $scope.addProdReviewsData.invalid_reviewsites_id = false;

                } else {
                    $scope.addProdReviewsData.invalid_reviewsites_id = true;

                }
            }
        });
        $scope.$watch('addProdReviewsData.title', function () {
            if ($filter('isEmptyData')($scope.addProdReviewsData, 'submitting') && $scope.addProdReviewsData.submitting) {
                if ($filter('isEmptyData')($scope.addProdReviewsData, 'title')) {
                    $scope.addProdReviewsData.invalid_title = false;
                } else {
                    $scope.addProdReviewsData.invalid_title = true;
                }
            }
        });
        $scope.$watch('addProdReviewsData.type', function () {
            if ($filter('isEmptyData')($scope.addProdReviewsData, 'submitting') && $scope.addProdReviewsData.submitting) {
                if ($filter('isEmptyData')($scope.addProdReviewsData, 'type')) {
                    $scope.addProdReviewsData.invalid_type = false;
                } else {
                    $scope.addProdReviewsData.invalid_type = true;
                }
            }
            if ($filter('isEmptyData')($scope.addProdReviewsData, 'type')) {
                if ($scope.addProdReviewsData.type == 'Video') {
                    $scope.addProdReviewsData.is_highlight = true;
                } else {
                    $scope.addProdReviewsData.is_highlight = false;
                }
            }
        });
        $scope.$watch('addProdReviewsData.web_link', function () {
            if ($filter('isEmptyData')($scope.addProdReviewsData, 'submitting') && $scope.addProdReviewsData.submitting) {
                if ($filter('isEmptyData')($scope.addProdReviewsData, 'web_link')) {
                    $scope.addProdReviewsData.invalid_web_link = false;
                } else {
                    $scope.addProdReviewsData.invalid_web_link = true;
                }
            }
        });
        $scope.$watch('addProdReviewsData.short_desc', function () {
            if ($filter('isEmptyData')($scope.addProdReviewsData, 'submitting') && $scope.addProdReviewsData.submitting) {
                if ($filter('isEmptyData')($scope.addProdReviewsData, 'short_desc')) {
                    $scope.addProdReviewsData.invalid_short_desc = false;
                } else {
                    $scope.addProdReviewsData.invalid_short_desc = true;
                }
            }
        });
        $scope.$watch('iconData.sitename', function () {
            if ($filter('isEmptyData')($scope.iconData, 'submitting') && $scope.iconData.submitting) {
                if ($filter('isEmptyData')($scope.iconData, 'sitename')) {
                    $scope.iconData.invalid_sitename = false;
                } else {
                    $scope.iconData.invalid_sitename = true;
                }
            }
        });
        $scope.$watch('iconData.myIcon', function () {
            if ($filter('isEmptyData')($scope.iconData, 'submitting') && $scope.iconData.submitting) {
                if ($filter('isEmptyData')($scope.iconData, 'myIcon')) {
                    $scope.iconData.invalid_myIcon = false;
                } else {
                    $scope.iconData.invalid_myIcon = true;
                }
            }
        });

        // end watch 

        // product review validation
        $scope.validationNewReviewsite = function (iconData) {
            $scope.iconData.submitting = true;
            // check title
            if ($filter('isEmptyData')(iconData, 'sitename')) {
                $scope.iconData.invalid_sitename = false;
            } else {
                $scope.iconData.invalid_sitename = true;
            }

            // check myIcon
            if ($filter('isEmptyData')(iconData, 'myIcon')) {
                $scope.iconData.invalid_myIcon = false;

            } else {
                $scope.iconData.invalid_myIcon = true;

            }

            if ($scope.iconData.invalid_sitename
                || $scope.iconData.invalid_myIcon
            ) {
                return false;
            } else {
                $scope.iconData.submitting = false;
                return true;
            }
        }

        $scope.validationEditReviewsite = function (iconData) {
            $scope.iconData.submitting = true;
            // check title
            if ($filter('isEmptyData')(iconData, 'sitename')) {
                $scope.iconData.invalid_sitename = false;
            } else {
                $scope.iconData.invalid_sitename = true;
            }

            if ($scope.iconData.invalid_sitename
            ) {
                return false;
            } else {
                $scope.iconData.submitting = false;
                return true;
            }
        }

        // product review validation
        $scope.validationNewProdReview = function (addProdReviewsData) {
            $scope.addProdReviewsData.submitting = true;
            // check title
            if ($filter('isEmptyData')(addProdReviewsData, 'title')) {
                $scope.addProdReviewsData.invalid_title = false;
            } else {
                $scope.addProdReviewsData.invalid_title = true;
            }

            // check seqno
            if ($filter('isEmptyData')(addProdReviewsData, 'seqno')) {
                $scope.addProdReviewsData.invalid_seqno = false;

                if ($scope.addProdReviewsData.seqno.length > 4) {
                    $scope.addProdReviewsData.invalid_seqno = true;
                    $scope.addProdReviewsData.submitting = false;
                }
            }
            // check type
            if ($filter('isEmptyData')(addProdReviewsData, 'type')) {
                $scope.addProdReviewsData.invalid_type = false;

            } else {
                $scope.addProdReviewsData.invalid_type = true;

            }

            // check web_link
            if ($filter('isEmptyData')(addProdReviewsData, 'web_link')) {
                $scope.addProdReviewsData.invalid_web_link = false;

            } else {
                $scope.addProdReviewsData.invalid_web_link = true;

            }

            // check short_desc
            if ($filter('isEmptyData')(addProdReviewsData, 'short_desc')) {
                $scope.addProdReviewsData.invalid_short_desc = false;

            } else {
                $scope.addProdReviewsData.invalid_short_desc = true;

            }

            // check short_desc
            if ($filter('isEmptyData')(addProdReviewsData, 'reviewsites_id')) {
                $scope.addProdReviewsData.invalid_reviewsites_id = false;

            } else {
                $scope.addProdReviewsData.invalid_reviewsites_id = true;

            }

            if ($scope.addProdReviewsData.invalid_title
                || $scope.addProdReviewsData.invalid_seqno
                || $scope.addProdReviewsData.invalid_type
                || $scope.addProdReviewsData.invalid_web_link
                || $scope.addProdReviewsData.invalid_short_desc
                || $scope.addProdReviewsData.invalid_reviewsites_id
            ) {
                return false;
            } else {
                $scope.addProdReviewsData.submitting = false;
                return true;
            }
        }

        // end product review tab

        $scope.displayTypes = [
            {
                value: 1,
                name: 'Fix width (1366px)'
            },
            {
                value: 2,
                name: 'Center'
            },
            {
                value: 3,
                name: 'Full width'
            },
        ];

        $scope.pstatusOpts = [
            {
                value: 1,
                name: 'Upcoming'
            },
            {
                value: 2,
                name: 'New'
            },
            {
                value: 3,
                name: 'Current'
            },
            {
                value: 5,
                name: 'Legacy'
            },
            {
                value: 6,
                name: 'EOL'
            },
            {
                value: 7,
                name: 'Pre-Order'
            },
            {
                value: 8,
                name: 'Hidden'
            },

        ];
    }
]).directive('mainInfoDirective', ['$compile', '$templateCache', function ($compile, $templateCache) {
    return {
        templateUrl: 'libs/angularJs-1.8.2/src/htmlTpl/productDetail/ngMain.html',
        scope: true,
        restrict: 'E',
        link: function (scope, element, attrs) {
            var template = $templateCache.get('mainInfoDirective');
            element.html(template);
            $compile(element.contents())(scope);
        }
    };
}]).directive('categoryDirective', ['$compile', '$templateCache', function ($compile, $templateCache) {
    return {
        templateUrl: 'libs/angularJs-1.8.2/src/htmlTpl/productDetail/ngMain.html',
        transclude: true,
        restrict: 'E',
        link: function (scope, element, attrs) {
            var template = $templateCache.get('categoryDirective');
            element.html(template);
            $compile(element.contents())(scope);
        }
    };
}]).directive('overviewContentDirective', ['$compile', '$templateCache', function ($compile, $templateCache) {

    // var getTemplate = function(data) {
    //     // use data to determine which template to use
    //     var templateid = '1';
    //     var template = $templateCache.get(data);
    //     return template;
    // }
    return {
        templateUrl: 'libs/angularJs-1.8.2/src/htmlTpl/productDetail/ngMain.html',
        scope: true,
        restrict: 'E',
        link: function (scope, element, attrs) {
            var template = $templateCache.get('overviewContentDirective');
            element.html(template);
            $compile(element.contents())(scope);
        }
    };
}]).directive('reviewsitesDirective', ['$compile', '$templateCache', function ($compile, $templateCache) {
    return {
        templateUrl: 'libs/angularJs-1.8.2/src/htmlTpl/productDetail/ngProdReviews.html',
        scope: true,
        restrict: 'E',
        link: function (scope, element, attrs) {
            var template = $templateCache.get('reviewsitesDirective');
            element.html(template);
            $compile(element.contents())(scope);
        }
    };
}]).directive('prodReviewsDirective', ['$compile', '$templateCache', function ($compile, $templateCache) {
    return {
        templateUrl: 'libs/angularJs-1.8.2/src/htmlTpl/productDetail/ngProdReviews.html',
        scope: true,
        restrict: 'E',
        link: function (scope, element, attrs) {
            var template = $templateCache.get('prodReviewsDirective');
            element.html(template);
            $compile(element.contents())(scope);

        }
    };
}]).directive('reviewsitesModalDirective', ['$compile', '$templateCache', function ($compile, $templateCache) {
    return {
        templateUrl: 'libs/angularJs-1.8.2/src/htmlTpl/productDetail/ngProdReviews.html',
        scope: true,
        restrict: 'E',
        link: function (scope, element, attrs) {
            var template = $templateCache.get('reviewsitesModalDirective');
            element.html(template);
            $compile(element.contents())(scope);

        }
    };
}]).directive('productReviewsDirective', ['$compile', '$templateCache', function ($compile, $templateCache) {
    return {
        templateUrl: 'libs/angularJs-1.8.2/src/htmlTpl/productDetail/ngProdReviews.html',
        scope: true,
        restrict: 'E',
        link: function (scope, element, attrs) {
            var template = $templateCache.get('productReviewsDirective');
            element.html(template);
            $compile(element.contents())(scope);

        }
    };
}]).directive('specLeftDirective', ['$compile', '$templateCache', function ($compile, $templateCache) {
    return {
        templateUrl: 'libs/angularJs-1.8.2/src/htmlTpl/productDetail/ngProdSpec.html',
        scope: true,
        restrict: 'E',
        link: function (scope, element, attrs) {
            var template = $templateCache.get('specLeftDirective');
            console.log(template);
            element.html(template);
            $compile(element.contents())(scope);
        }
    };
}]).directive('specListDirective', ['$compile', '$templateCache', function ($compile, $templateCache) {
    return {
        templateUrl: 'libs/angularJs-1.8.2/src/htmlTpl/productDetail/ngProdSpec.html',
        scope: true,
        restrict: 'E',
        link: function (scope, element, attrs) {
            console.log('specListDirective');
            var template = $templateCache.get('specListDirective');
            element.html(template);
            $compile(element.contents())(scope);

        }
    };
}]).directive('uploadFilesDirective', ['$compile', '$templateCache', function ($compile, $templateCache) {
    //upload-files-directive
    return {
        templateUrl: 'libs/angularJs-1.8.2/src/htmlTpl/productDetail/ngUploadFiles.html',
        scope: true,
        restrict: 'E',
        link: function (scope, element, attrs) {
            console.log('uploadFilesDirective');
            var template = $templateCache.get('uploadFilesDirective');
            element.html(template);
            $compile(element.contents())(scope);

        }
    };
}]);
