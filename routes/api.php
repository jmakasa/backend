<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['middleware' => 'api'], function ($router) {
    Route::post('/register', [JWTController::class, 'register']);
    Route::post('/login', [JWTController::class, 'login']);
    Route::post('/logout', [JWTController::class, 'logout']);
    Route::post('/refresh', [JWTController::class, 'refresh']);
    Route::post('/profile', [JWTController::class, 'profile']);
});


// Route::group(['middleware' => 'Cors'], function($router) {
//     Route::get('/product/all', 'ProductsController@allProducts')->name('api.product.allProducts');
// });


//Route::middleware(['set_locale','jwt.verify'])
Route::middleware(['set_locale'])
    ->group(
        function ($locale) {
            Route::post('/remote_login', 'UsersController@remoteLogin')->name('api.users.remote_login');
            Route::post('/remote_logout', 'UsersController@remoteLogout')->name('api.users.remote_logout');

            Route::get('/category_list', 'CategoryController@apiCategoryList')->name('api.category.list');
            Route::get('/2022_navmenu_list/export', 'NavmenuController@exportNavmenu')->name('api.navmenu.export');
            Route::get('/2022_navmenu/get/{state?}', 'NavmenuController@jsonNavmenu2022List')->name('api.navmenu.list');
            Route::post('/2022_navmenu/update', 'NavmenuController@update')->name('api.navmenu.update');
            Route::post('/2022_navmenu/create_new', 'NavmenuController@create_new')->name('api.navmenu.create_new');
            Route::get('/2022_navmenu/backendNavmenu', 'NavmenuController@backendNavmenu')->name('api.navmenu.backendNavmenu');
            Route::post('/2022_navmenu/belong_to', 'NavmenuController@getNavmenuListByPartno')->name('api.navmenu.getNavmenuListByPartno');
            Route::post('/2022_navmenu/selected_filter', 'NavmenuController@getSeletedFilterList')->name('api.navmenu.getSeletedFilterList');
            Route::post('/2022_navmenu/selected_filter/update_seqno', 'NavmenuController@updateSelectedFilterSeqno')->name('api.navmenu.getSeletedFilterList');






            Route::get('/lists_options', 'SettingsController@apiListsOptions')->name('api.listsOptions');

            // Blogs
            Route::post('/blogs/list', 'BlogsController@getBlogsList')->name('api.blogs.list');
            Route::post('/blogs/tag_list', 'BlogsController@getBlogsTagList')->name('api.blogs.tag_list');
            
            Route::post('/blogs/getone', 'BlogsController@getBlogsById')->name('api.blogs.getone');
            Route::post('/blogs/export_list', 'BlogsController@export_list')->name('api.blogs.export_list');
            Route::post('/blogs/export_detail', 'BlogsController@export_detail')->name('api.blogs.export_detail');
            Route::post('/blogs/export_featured', 'BlogsController@export_featured')->name('api.blogs.export_featured');
            Route::post('/blogs/export_one_detail', 'BlogsController@export_one_detail')->name('api.blogs.export_one_detail');
            Route::post('/blogs/update_detail', 'BlogsController@updateDetail')->name('api.blogs.updateDetail');
            
            

            // Products
            Route::post('/product_list', 'ProductsController@apiProductLists')->name('api.product.list');
            Route::post('/product/images_list', 'ProductsController@listProductWithImage')->name('api.product.listImage');
            Route::get('/product/show_one', 'ProductsController@showOne')->name('api.product.show_one');
            Route::post('/product/generate/conf', 'ProductsController@generateSingleConf')->name('api.product.generateSingleConf');
            Route::post('/product/generate/conf_only', 'ProductsController@generateConfOnly')->name('api.product.generateConfOnly');
            
            Route::post('/product/generate/conf/by_menucat', 'ProductsController@generateConfByMenucat')->name('api.product.generateConfByMenucat');
            Route::get('/product/generate/conf/all', 'ProductsController@generateAllConf')->name('api.product.generateAllConf');
            Route::get('/product/generate/conf/all_with_files', 'ProductsController@generateAllConfWithFiles')->name('api.product.generateAllConfWithFiles');
            Route::post('/product/list/by_menucat', 'ProductsController@getProductListByMenucat')->name('api.product.getProductListByMenucat');
            Route::post('/product/list/by_partno', 'ProductsController@getProductListByPartno')->name('api.product.getProductListByPartno');
            Route::post('/product/details', 'ProductsController@getProductDetailsById')->name('api.product.getProductDetailsById');
            Route::post('/product/intro/update', 'ProductsController@updateIntro')->name('api.product.updateIntro');
            Route::post('/product/main/update', 'ProductsController@updateProductDetails')->name('api.product.updateProductDetails');
            Route::get('/product/all', 'ProductsController@allProducts')->name('api.product.allProducts');
            Route::post('/product_tags', 'ProductsController@getProductsTagList')->name('api.product.getProductsTagList');
            // 
            Route::get('/product/reseqno_box', 'ProductsController@reseqnoBox')->name('api.product.allProducts');
            

            // images
            Route::get('/images/get_data/{id}', 'ImagesController@getById')->name('api.images.getData');
            Route::get('/images/delete/{id}', 'ImagesController@delete')->name('api.images.delete');
            Route::post('/images/update', 'ImagesController@update')->name('api.images.update');

            // Download
            Route::post('/download/list/{partno}', 'DownloadController@listByPartno')->name('api.download.listByPartno');
            Route::get('/download/get_data/{id}', 'DownloadController@getById')->name('api.download.get_date');
            Route::post('/download/update', 'DownloadController@update')->name('api.download.update');
            Route::post('/download/store', 'DownloadController@store')->name('api.download.store');
            Route::post('/download/delete', 'DownloadController@delete')->name('api.download.delete');

            // prodlist box
            Route::post('/boxes/data/get', 'ProductBoxesController@apiBoxData')->name('api.boxes.get_data');
            Route::post('/boxes/data/update', 'ProductBoxesController@apiUpdateBox')->name('api.boxes.get_data');
            Route::post('/boxes/product/status/update', 'ProductBoxesController@apiUpdateProductStatus')->name('api.boxes.updateProductStatus');
            Route::post('/boxes/product/add', 'ProductBoxesController@addProductToBox')->name('api.boxes.add_product');
            Route::post('/boxes/product/remove', 'ProductBoxesController@removeProductFromBox')->name('api.boxes.remove_product');
            Route::post('/boxes/related_product/add', 'ProductBoxesController@addRelatedBoxes')->name('api.boxes.addRelatedBoxes');
            Route::post('/boxes/related_product/remove', 'ProductBoxesController@removeRelatedBoxes')->name('api.boxes.removeRelatedBoxes');
            Route::post('/boxes/is_selected/update', 'ProductBoxesController@updateBoxesIsSelected')->name('api.boxes.updateBoxesIsSelected');
            Route::post('/boxes/product_seqno/update', 'ProductBoxesController@updateSeqnoFromBox')->name('api.boxes.updateSeqnoFromBox');
            
            


            // prodlist spec
            Route::get('/spec/lhs_tree/{partno}', 'ProductSpecController@getTreeList')->name('api.spec.getTreeList');
            Route::post('/spec/child/list', 'ProductSpecController@getChild')->name('api.spec.get_child');
            Route::post('/spec/group/add', 'ProductSpecController@add_group')->name('api.spec.add_group');
            Route::get('/spec/group/get/{partno}', 'ProductSpecController@getSpecGroupByPartno')->name('api.spec.get_group');

            // keywords
            Route::get('/keyword/list', 'KeywordsController@list_all')->name('api.keyword.list');
            Route::post('/socket/partno/get', 'KeywordsController@getSocketTypeByPartno')->name('api.keyword.getSocketTypeByPartno');
            Route::post('/socket/partno/update', 'KeywordsController@updateSocketTypeByPartno')->name('api.keyword.updateSocketTypeByPartno');
            Route::post('/keyword/partno/get', 'KeywordsController@getKeywordsByPartno')->name('api.keyword.getKeywordsByPartno');

            // sftp
            Route::get('/sftp/list', 'SftpController@list')->name('api.sftp.list');

            // modify history
            Route::post('/modify/history/add', 'ModifyHistorysController@create')->name('api.modify_historys.add');

            // reviewsites
            Route::post('/reviewsites/list', 'ReviewsitesController@getList')->name('api.reviewsites.getList');
            Route::post('/reviewsites/add', 'ReviewsitesController@add')->name('api.reviewsites.add');
            Route::post('/reviewsites/edit', 'ReviewsitesController@edit')->name('api.reviewsites.edit');
            Route::post('/reviewsites/delete', 'ReviewsitesController@delete')->name('api.reviewsites.delete');
            Route::get('/reviewsites/get_name/{q}', 'ReviewsitesController@getReviewsitesName')->name('api.reviewsites.getname');
            Route::post('/reviewsites/get_by_id', 'ReviewsitesController@getReviewsitesbyId')->name('api.reviewsites.get_by_id');
            Route::post('/reviewsites/export_conf', 'ReviewsitesController@exportConf')->name('api.reviewsites.export_conf');

            // product ecommerce url
            Route::post('/product/ecom_url/add', 'ProductsController@addEcommerceUrl')->name('api.product.addEcommerceUrl');
            Route::post('/product/ecom_url/add_batch', 'ProductsController@addBatchEcommerceUrl')->name('api.product.addBatchEcommerceUrl');

            Route::post('/product/ecom_url/disable', 'ProductsController@disableEcommerceUrl')->name('api.product.disableEcommerceUrl');
            Route::post('/product/ecom_url/remove', 'ProductsController@removeEcommerceUrl')->name('api.product.removeEcommerceUrl');
            Route::post('/product/ecom_url/list', 'ProductsController@ecommerceUrlList')->name('api.product.ecommerceUrlList');
            Route::post('/product/ecom_url/update', 'ProductsController@updateEcommerceUrl')->name('api.product.updateEcommerceUrl');
            Route::get('/product/ecom_url/export', 'ProductsController@exportEcommerceUrl')->name('api.product.addEcommerceUrl');

            // prod spec
            Route::post('/product/spec/update', 'ProductSpecController@updateSpec')->name('api.prodspec.updateSpec');
            Route::post('/product/spec/is_highlight_update', 'ProductSpecController@updateIsHighlight')->name('api.prodspec.updateIsHighlight');
            
            // product change log
            Route::post('/product/change_logs/list', 'ProductsController@changeLogsList')->name('api.product.changeLogsList');
            

            // top sale qty
            Route::post('/top_sales_qty/add', 'ProductsController@addEcommerceUrl')->name('api.product.addEcommerceUrl');
            
            

            //product reviews
            Route::post('/product_reviews/add', 'ProductReviewsController@add')->name('api.product_reviews.add');
            Route::post('/product_reviews/list', 'ProductReviewsController@getList')->name('api.product_reviews.getList');
            Route::post('/product_reviews/delete', 'ProductReviewsController@delete')->name('api.product_reviews.delete');
            Route::post('/product_reviews/remove_image', 'ProductReviewsController@removeImage')->name('api.product_reviews.remove_image');
            Route::post('/product_reviews/list/by_site', 'ProductReviewsController@getListBySiteId')->name('api.product_reviews.getListBySiteId');

            // upload file file_uploads
            Route::post('/file_uploads/upload', 'FileUploadsController@uploadFile')->name('api.file_uploads.uploadFile');

            Route::post('/file_uploads/list', 'UploadFilesController@getList')->name('api.file_uploads.getList');
            Route::post('/file_uploads/tasks/list', 'UploadFilesController@getTaskList')->name('api.file_uploads.getList');
            Route::get('/file_uploads/ftp/check/{hostname}', 'UploadFilesController@checkFtpConn')->name('api.file_uploads.checkFtpConn');
            Route::post('/file_uploads/delete', 'UploadFilesController@delUploadFiles')->name('api.file_uploads.delUploadFiles');
            Route::post('/file_uploads/tasks/delete', 'UploadFilesController@delTasks')->name('api.file_uploads.delTasks');
            Route::post('/file_uploads/upload_batch_now', 'UploadFilesController@uploadBatchNow')->name('api.file_uploads.uploadBatchNow');
            Route::post('/file_uploads/schedule_tasks', 'UploadFilesController@scheduleTasks')->name('api.file_uploads.scheduleTasks');
            Route::post('/file_uploads/execute_tasks', 'UploadFilesController@executeTasks')->name('api.file_uploads.executeTasks');
            Route::get('/file_uploads/execute_scheduled_tasks', 'UploadFilesController@executeScheduledTasks')->name('api.file_uploads.executeScheduledTasks');
            Route::get('/file_uploads/show_scheduled_tasks', 'UploadFilesController@showScheduledTasks')->name('api.file_uploads.showScheduledTasks');
            Route::get('/file_uploads/list/uploaded_datetime', 'UploadFilesController@getuploadedDatetimeByPartno')->name('api.file_uploads.getuploadedDatetimeByPartno');
            Route::post('/file_uploads/remove_uploaded_file', 'UploadFilesController@removeUploadedFile')->name('api.file_uploads.removeUploadedFile');

            // sales offices
            Route::post('/sales_offices/list', 'SalesOfficesController@getList')->name('api.sales_offices.getList');
            Route::post('/sales_offices/export', 'SalesOfficesController@exportConf')->name('api.sales_offices.exportConf');
            Route::post('/sales_offices/add', 'SalesOfficesController@addSalesOffice')->name('api.sales_offices.add');
            Route::post('/sales_offices/remove_logo', 'SalesOfficesController@removeLogo')->name('api.sales_offices.removeLogo');
            Route::post('/sales_offices/delete', 'SalesOfficesController@deleteSalesOffice')->name('api.sales_offices.delete');
            Route::get('/sales_offices/name_list/{q}', 'SalesOfficesController@listName')->name('api.sales_offices.listName');
            
            // sales monthly
            Route::post('/sales_records/monthly_sales', 'SalesRecordsController@updateTopSalesQty')->name('api.sales_records.updateTopSalesQty');
            Route::post('/sales_records/sales_qty', 'SalesRecordsController@getQtyList')->name('api.sales_records.getQtyList');
            
            /** temp use */
            Route::get('/mbcheck', 'FileReadController@importMbcheckData')->name('api.mbcheck.importMbcheckData');
            Route::get('/mbcheck/export_conf', 'FileReadController@exportFanlessCaseCheckConf')->name('api.mbcheck.exportFanlessCaseCheckConf');
            Route::get('/oem_fan/read/{filename}', 'FileReadController@importOemFanlist')->name('api.oemfan.importOemFanlist');
            Route::get('/oem_fan/export_json', 'FileReadController@exportOemDcfanJson')->name('api.oemfan.exportOemDcfanJson');
        }
    );
