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
// jwt.verify
Route::group(['middleware' => 'api'], function($router) {
    Route::post('/register', [JWTController::class, 'register']);
    Route::post('/login', [JWTController::class, 'login']);
    Route::post('/logout', [JWTController::class, 'logout']);
    Route::post('/refresh', [JWTController::class, 'refresh']);
    Route::post('/profile', [JWTController::class, 'profile']); 
    
});

Route::middleware(['set_locale','jwt.verify'])
->group(
    function ($locale) {
        Route::get('/employee/list', 'EmployeesController@viewList')->name('admin.employees.viewList');
    });

//Route::middleware(['set_locale','jwt.verify'])
//backend/index.php/en/api/xx
Route::middleware(['set_locale'])
    ->group(
        function ($locale) {
            // user 
            
            // end user
            Route::get('/category_list', 'CategoryController@apiCategoryList')->name('api.category.list');
            Route::get('/2022_navmenu_list/export', 'NavmenuController@apiNavmenu2022List')->name('api.category.list');
            Route::get('/2022_navmenu/get/{state?}', 'NavmenuController@jsonNavmenu2022List')->name('api.navmenu.list');
            Route::post('/2022_navmenu/update', 'NavmenuController@update')->name('api.navmenu.update');
            Route::post('/2022_navmenu/create_new', 'NavmenuController@create_new')->name('api.navmenu.create_new');
            Route::get('/2022_navmenu/backendNavmenu', 'NavmenuController@backendNavmenu')->name('api.navmenu.backendNavmenu');
            Route::post('/2022_navmenu/belong_to', 'NavmenuController@getNavmenuListByPartno')->name('api.navmenu.getNavmenuListByPartno');
            
            
            Route::get('/lists_options', 'SettingsController@apiListsOptions')->name('api.listsOptions');

            // Blogs
            Route::post('/blogs/list', 'BlogsController@getBlogsList')->name('api.blogs.list');
            Route::post('/blogs/getone', 'BlogsController@getBlogsById')->name('api.blogs.getone');

            // Products
            Route::post('/product_list', 'ProductsController@apiProductLists')->name('api.product.list');
            Route::post('/product/images_list', 'ProductsController@listProductWithImage')->name('api.product.listImage');
            Route::get('/product/show_one', 'ProductsController@showOne')->name('api.product.show_one');
            Route::post('/product/generate/conf', 'ProductsController@generateSingleConf')->name('api.product.generateSingleConf');
            Route::post('/product/generate/conf/by_menucat', 'ProductsController@generateConfByMenucat')->name('api.product.generateConfByMenucat');
            Route::get('/product/generate/conf/all', 'ProductsController@generateAllConf')->name('api.product.generateAllConf');
            Route::post('/product/list/by_menucat', 'ProductsController@getProductListByMenucat')->name('api.product.getProductListByMenucat');
            Route::post('/product/list/by_partno', 'ProductsController@getProductListByPartno')->name('api.product.getProductListByPartno');
            Route::post('/product/details', 'ProductsController@getProductDetailsById')->name('api.product.getProductDetailsById');
            Route::post('/product/intro/update', 'ProductsController@updateIntro')->name('api.product.updateIntro');
            Route::post('/product/main/update', 'ProductsController@updateProductDetails')->name('api.product.updateProductDetails');

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
            

             // prodlist spec
             Route::get('/spec/lhs_tree/{partno}', 'ProductSpecController@getTreeList')->name('api.spec.getTreeList');
             Route::post('/spec/child/list', 'ProductSpecController@getChild')->name('api.spec.get_child');
             Route::post('/spec/group/add', 'ProductSpecController@add_group')->name('api.spec.add_group');
             Route::get('/spec/group/get/{partno}', 'ProductSpecController@getSpecGroupByPartno')->name('api.spec.get_group');
             
             // web email contactus
            Route::post('/email_contactus/list', 'WebEmailContactusController@getList')->name('api.webEmailContactus.list');
            Route::post('/email_contactus/detail', 'WebEmailContactusController@getDetailById')->name('api.webEmailContactus.detail');
            Route::get('/email_contactus/compose', 'WebEmailContactusController@composeEmail')->name('api.webEmailContactus.compose');
            Route::get('/email_contactus/mailTest', 'WebEmailContactusController@mailTest')->name('api.webEmailContactus.mailTest');

            // customer services
            
            // employees
            Route::post('/employees/list/get', 'EmployeesController@getEmployeeList')->name('api.employees.getList');
            Route::post('/employees/detail', 'EmployeesController@getEmployeeDetail')->name('api.employees.getDetail');
            Route::post('/employees/edit', 'EmployeesController@editEmployee')->name('api.employees.edit');
            Route::post('/employees/add', 'EmployeesController@addEmployee')->name('api.employees.add');
            Route::post('/employees/del', 'EmployeesController@delEmployee')->name('api.employees.del');
            Route::post('/employee_depts/add', 'EmployeesController@addDept')->name('api.employees.addDept');
            Route::post('/employee_depts/edit', 'EmployeesController@editDept')->name('api.employees.editDept');
            Route::post('/employee_depts/del', 'EmployeesController@delDept')->name('api.employees.delDept');
            Route::post('/employees/settings', 'EmployeesController@getEmployeeSettings')->name('api.employees.settings');
            Route::get('/employee_depts/get/{state?}', 'EmployeesController@jsonDeptsList')->name('api.employee_depts.list');
            Route::post('/employee_depts/detail', 'EmployeesController@getEmployeeDeptsDetail')->name('api.employee_deps.detail');
            

            // keywords
            Route::get('/keyword/list', 'KeywordsController@list_all')->name('api.keyword.list');
            Route::get('/keyword_types/list', 'KeywordsController@list_all_types')->name('api.keyword.list_all_types');
            Route::post('/socket/partno/get', 'KeywordsController@getSocketTypeByPartno')->name('api.keyword.getSocketTypeByPartno');
            Route::post('/socket/partno/update', 'KeywordsController@updateSocketTypeByPartno')->name('api.keyword.updateSocketTypeByPartno');
            Route::post('/keyword/partno/get', 'KeywordsController@getKeywordsByPartno')->name('api.keyword.getKeywordsByPartno');
            
            // sftp
            Route::get('/sftp/list', 'SftpController@list')->name('api.sftp.list');

            // modify history
            Route::post('/modify/history/add', 'ModifyHistorysController@create')->name('api.modify_historys.add');

            // tasks
            Route::post('/tasks/list', 'TasksController@getList')->name('api.tasks.getList');
            Route::post('/tasks/detail', 'TasksController@getDetailById')->name('api.tasks.getDetailById');
            Route::get('/tasks/form/settings', 'TasksController@getFormSettings')->name('api.tasks.getFormSettings');
            Route::post('/tasks/add', 'TasksController@addNewTask')->name('api.tasks.add_new');
            Route::post('/tasks/detail/update', 'TasksController@updateDetail')->name('api.tasks.updateDetail');
            // tasks cronjob
            Route::get('/tasks/fetch_and_add', 'TasksController@fetchEmailContactus')->name('api.tasks.fetchEmailContactus');


            // thread
            Route::post('/threads/add', 'TaskThreadsController@addThread')->name('api.TaskThreads.add');
            Route::post('/threads/list_by_id', 'TaskThreadsController@getThreadsByTaskId')->name('api.TaskThreads.list_id');
            Route::post('/threads/attachment/upload', 'TaskThreadsController@uploadAttachment')->name('api.TaskThreads.uploadAttachment');
            
            // tickets
            Route::post('/tickets/list', 'TicketsController@getList')->name('api.tickets.list');
            Route::post('/tickets/recent_updated/list', 'TicketsController@getRecentUpdated')->name('api.tickets.getRecentUpdated');
            Route::post('/tickets/detail', 'TicketsController@getDetailById')->name('api.tickets.getTasksById');
            Route::get('/tickets/form/settings', 'TicketsController@getFormSettings')->name('api.tickets.status_list');
            Route::post('/tickets/add', 'TicketsController@addNewTicket')->name('api.tickets.add_new');
            Route::post('/tickets/detail/update', 'TicketsController@updateDetail')->name('api.tickets.updateDetail');
            // tickets cronjob
            Route::get('/tickets/fetch_and_add', 'TicketsController@fetchEmailContactus')->name('api.tickets.fetchEmailContactus');
            Route::get('/tickets/threads/pending/send', 'TicketThreadsController@sendingPendingThreads')->name('api.TicketThreads.sendingPendingThreads');
            // tickets thread
            Route::post('/tickets/threads/add', 'TicketThreadsController@addThread')->name('api.TicketThreads.add');
            Route::post('/tickets/threads/list_by_id', 'TicketThreadsController@getThreadsByTicketId')->name('api.TicketThreads.list_id');
            Route::post('/tickets/threads/attachment/upload', 'TicketThreadsController@uploadAttachment')->name('api.TicketThreads.uploadAttachment');
            // ticket notes
            Route::post('/tickets/notes/add', 'NotesController@addTicketNote')->name('api.TicketNotes.add');
            Route::post('/tickets/notes/delete', 'NotesController@deleteTicketNote')->name('api.TicketNotes.delete');
            Route::post('/tickets/notes/list_by_id', 'NotesController@getNotesByTicketId')->name('api.TicketNotes.list_id');
            // mentioned
            Route::post('/mentioned/list_by_employees_id', 'MentionedController@getMentionedByEmployeesId')->name('api.mentioned.list_by_employees_id');
            

            
            // reviewsites
            Route::post('/reviewsites/list', 'ReviewsitesController@getList')->name('api.reviewsites.getList');
            Route::post('/reviewsites/add', 'ReviewsitesController@add')->name('api.reviewsites.add');
            Route::post('/reviewsites/edit', 'ReviewsitesController@edit')->name('api.reviewsites.edit');
            Route::get('/reviewsites/get_name/{q}', 'ReviewsitesController@getReviewsitesName')->name('api.reviewsites.getname');
            Route::post('/reviewsites/get_by_id', 'ReviewsitesController@getReviewsitesbyId')->name('api.reviewsites.get_by_id');
            Route::post('/reviewsites/export_conf', 'ReviewsitesController@exportConf')->name('api.reviewsites.export_conf');
            

            //product reviews
            Route::post('/product_reviews/add', 'ProductReviewsController@add')->name('api.product_reviews.add');
            Route::post('/product_reviews/list', 'ProductReviewsController@getList')->name('api.product_reviews.getList');
            Route::post('/product_reviews/delete', 'ProductReviewsController@delete')->name('api.product_reviews.delete');
            Route::post('/product_reviews/remove_image', 'ProductReviewsController@removeImage')->name('api.product_reviews.remove_image');
            Route::post('/product_reviews/list/by_site', 'ProductReviewsController@getListBySiteId')->name('api.product_reviews.getListBySiteId');
            
            

            // upload file file_uploads
            Route::post('/file_uploads/upload', 'FileUploadsController@uploadFile')->name('api.file_uploads.uploadFile');
            Route::get('/file_uploads/test', 'FileUploadsController@testUploadFile')->name('api.file_uploads.testUploadFile');
            
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
            
        });



