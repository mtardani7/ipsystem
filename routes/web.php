<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');;

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/document-owner', 'DocumentOwnerController@index')->name('document_owner');
Route::post('/document-owner/bulk', 'DocumentOwnerController@bulkUpdate')->name('document_owner.bulk');
Route::post('/document-owner/single', 'DocumentOwnerController@updateOwner')->name('document_owner.single');
Route::post('/document-owner/review', 'DocumentOwnerController@submitReview')->name('document_owner.review');
Route::get('/document-owner/reminders/preview', 'DocumentOwnerController@previewReminders')->name('document_owner.reminders.preview');
Route::post('/document-owner/reminders/send', 'DocumentOwnerController@sendReminders')->name('document_owner.reminders.send');
Route::get('/home/{div}/{cat}', 'HomeController@viewlist')->name('home-viewlist');
Route::post('/viewdoc', 'HomeController@viewdoc')->name('viewdoc');
Route::get('/viewvideo', 'HomeController@viewvideo')->name('viewvideo');
Route::post('/xls_masterlist', 'HomeController@xlsmasterlist')->name('xls_masterlist');
Route::post('/xls_masterlist_active', 'HomeController@xls_masterlist_active')->name('xls_masterlist_active');
Route::get('/doc_search', 'HomeController@docsearch')->name('doc_search');

Route::get('/notes', 'NoteController@index')->middleware('admin')->name('notes');
Route::post('/input_note', 'NoteController@add')->middleware('admin');
Route::get('/edit_note/{edit}', 'NoteController@edit')->middleware('admin');
Route::post('/input_note/{update}', 'NoteController@update')->middleware('admin');
Route::delete('/input_note/{destroy}', 'NoteController@destroy')->middleware('admin')->name('note_delete');


Route::get('/input_plant', 'PlantController@index')->middleware('admin')->name('input_plant');
Route::post('/input_plant', 'PlantController@add')->middleware('admin');
Route::get('/edit_plant/{edit}', 'PlantController@edit')->middleware('admin');
Route::post('/input_plant/{update}', 'PlantController@update')->middleware('admin');
Route::delete('/input_plant/{destroy}', 'PlantController@destroy')->middleware('admin')->name('plant_delete');

Route::get('/input_list', 'MasterListController@index')->middleware('admin')->name('input_list');
Route::post('/input_list', 'MasterListController@add')->middleware('admin');
Route::get('/edit_list', 'MasterListController@edit')->middleware('admin');
Route::post('/update_list', 'MasterListController@update')->middleware('auth');
Route::get('/search_list', 'MasterListController@search')->middleware('admin')->name('search_list');
Route::delete('/input_list', 'MasterListController@destroy')->middleware('admin')->name('list_delete');

Route::get('load_doc', function () {
    return view('master/load_doc');
})->middleware('admin')->name('load_doc');

Route::get('/input_div', 'DivController@index')->middleware('admin')->name('input_div');
Route::post('/input_div', 'DivController@add')->middleware('admin');
Route::get('/edit_div/{edit}', 'DivController@edit')->middleware('admin');
Route::post('/input_div/{update}', 'DivController@update')->middleware('admin');
Route::delete('/input_div/{destroy}', 'DivController@destroy')->middleware('admin')->name('div_delete');

Route::get('/input_dist', 'DistController@index')->middleware('admin')->name('input_dist');
Route::post('/input_dist', 'DistController@add')->middleware('admin');
Route::get('/edit_dist/{edit}', 'DistController@edit')->middleware('admin');
Route::post('/input_dist/{update}', 'DistController@update')->middleware('admin');
Route::delete('/input_dist/{destroy}', 'DistController@destroy')->middleware('admin')->name('dist_delete');

Route::get('/input_cat', 'CatController@index')->middleware('admin')->name('input_cat');
Route::post('/input_cat', 'CatController@add')->middleware('admin');
Route::get('/edit_cat/{edit}', 'CatController@edit')->middleware('admin');
Route::post('/input_cat/{update}', 'CatController@update')->middleware('admin');
Route::delete('/input_cat/{destroy}', 'CatController@destroy')->middleware('admin')->name('cat_delete');

Route::get('/input_user', 'UserController@index')->middleware('superuser')->name('user');
Route::post('/input_user', 'UserController@add')->middleware('superuser');
Route::get('/edit_user/{edit}', 'UserController@edit')->middleware('superuser');
Route::post('/input_user/{update}', 'UserController@update')->middleware('superuser');
Route::get('/resetpwd/{id}', 'UserController@resetpwd')->middleware('superuser');
Route::post('/updatepwd/{id}', 'UserController@updatepwd')->middleware('superuser');
Route::delete('/input_user/{destroy}', 'UserController@destroy')->middleware('superuser')->name('user_delete');
Route::get('/changepwd', 'UserController@changepwd')->name('changepwd');
Route::post('/updatechpwd', 'UserController@updatechpwd')->name('updatechpwd');

Route::get('/approval_hirarki', 'ApprovalHirarkiController@index')->middleware('superuser')->name('approval_hirarki');
Route::post('/input_approval_hirarki','ApprovalHirarkiController@add')->middleware('superuser');
Route::get('/edit_approval_hirarki/{edit}', 'ApprovalHirarkiController@edit')->middleware('superuser');
Route::post('/update_approval_hirarki/{update}', 'ApprovalHirarkiController@update')->middleware('superuser');
Route::delete('/approval_hirarki/{delete}', 'ApprovalHirarkiController@destroy')->middleware('superuser');
Route::get('/approval_mr', 'ApprovalHirarkiController@mrindex')->middleware('superuser')->name('approval_mr');
Route::get('/edit_approval_mr/{edit}', 'ApprovalHirarkiController@mredit')->middleware('superuser');
Route::post('/update_approval_mr/{update}', 'ApprovalHirarkiController@mrupdate')->middleware('superuser');

Route::get('/create_req', 'RequestController@create')->name('create_req');
Route::post('/create_req_form', 'RequestController@create_form')->name('create_req_form');
Route::post('/fill_req_form7', 'RequestController@fill_form7')->name('fill_req_form7');
Route::post('/fill_req_form8', 'RequestController@fill_form8')->name('fill_req_form8');
Route::post('/fill_req_form9', 'RequestController@fill_form9')->name('fill_req_form9');
Route::post('/fill_req_chfolder', 'RequestController@fill_req_chfolder')->name('fill_req_chfolder');
Route::post('/fill_req_frmit01', 'RequestController@fill_req_frmit01')->name('fill_req_frmit01');
Route::post('/update_req_form7', 'RequestController@update_form7')->name('update_req_form7');
Route::post('/update_req_form8', 'RequestController@update_form8')->name('update_req_form8');
Route::post('/update_req_chfolder', 'RequestController@update_chfolder')->name('update_req_chfolder');
Route::post('/update_req_frmit01', 'RequestController@update_req_frmit01')->name('update_req_frmit01');
//verification
Route::post('/verification_form7', 'ReqIncomingController@verification_form7')->name('verification_form7');
Route::post('/verification_frmit01', 'ReqIncomingController@verification_frmit01')->name('verification_frmit01');
//Route::post('/upload_req','RequestController@upload_req')->name('upload_req');
Route::get('/approval_req', 'ReqApprovalController@index')->middleware('level')->name('approval_req');
Route::get('/history_req', 'ReqHistoryController@index')->name('history_req');
Route::post('/history_search', 'ReqHistoryController@search')->name('history_search');
Route::get('/history_req_view/{id}', 'ReqHistoryController@view');
Route::get('/history_req_print/{id}', 'ReqHistoryController@prints');
Route::get('/history_req_edit/{id}', 'ReqHistoryController@edit');
Route::get('/history_req_verification/{id}', 'ReqHistoryController@verification');
Route::delete('/history_req/{destroy}', 'ReqHistoryController@destroy')->middleware('admin')->name('req_delete');
Route::post('/approve', 'ReqApprovalController@approve');
Route::post('/reject', 'ReqApprovalController@reject');
Route::post('/fill_reject', 'ReqApprovalController@fill_reject');
Route::get('/incoming_req', 'ReqIncomingController@index')->middleware('admin')->name('incoming_req');
Route::get('/reject_incoming_req', 'ReqIncomingController@reject')->name('reject_incoming');
Route::post('/fill_reject_in', 'ReqIncomingController@fill_reject');

Route::get('/done_req_form_p4no7', 'ReqDoneController@form_p4no7')->middleware('level')->name('done_req_form_p4no7');
Route::get('/done_req', 'ReqDoneController@index')->middleware('level')->name('done_req');

Route::get('/uploaded/{id}', 'ReqDoneController@uploaded');

//Route::get('sendbasicemail','MailController@basic_email');
//Route::get('/sendhtmlemail/{name}','MailController@html_email');
Route::get('/sendrejectemail/{name}','MailController@reject_email');
Route::get('sendattachmentemail','MailController@attachment_email');
Route::get('testmail','MailController@testmail');

//Route send email
Route::get('mail/test_send', 'MailController@test_send')->name('sendmail');
Route::get('mail/send/{name}', 'MailController@send');
Route::get('mail/send_reject/{name}', 'MailController@send_reject');
Route::get('mail/send_request/{name}', 'MailController@send_request');
Route::get('mail/send_update/{name}', 'MailController@send_update');
Route::get('mail/send_verification', 'MailController@send_verification');
Route::get('mail/send_approval_done', 'MailController@send_approval_done');
Route::get('mail/send_request_verified/{name}', 'MailController@send_request_verified');

Route::get('/report', 'PagesController@report')->name('report');

Route::get('/changelog', 'ChangelogController@index')->name('changelog');
Route::post('/changelog', 'ChangelogController@add')->middleware('admin');
Route::get('/edit_changelog/{edit}', 'ChangelogController@edit')->middleware('admin');
Route::post('/changelog/{update}', 'ChangelogController@update')->middleware('admin');
Route::delete('/changelog/{destroy}', 'ChangelogController@destroy')->middleware('admin')->name('changelog_delete');

Route::get('/file', 'File@index')->name('file');
Route::get('/file_create', 'File@create')->name('file_create');
Route::post('/file_create', 'File@store');

Route::get('/test_lfm', function() {
  return view('test_lfm');
})->name('test_lfm');

//test
Route::get('/delete_file', 'file_storage@delete')->name('delete_file');
Route::get('/form_it-01', 'test_form@form_it01')->name('form_it-01');


//data_vendor
Route::get('/data_vendor', 'DataVendorController@index')->name('data_vendor')->middleware('purchasing');
Route::post('/vendor_search', 'DataVendorController@search')->name('vendor_search')->middleware('purchasing');
Route::get('/data_vendor_view/{id}', 'DataVendorController@view')->middleware('purchasing');
Route::get('/data_vendor_edit/{id}', 'DataVendorController@edit')->middleware('purchasing');
Route::post('/update_form/{id}', 'DataVendorController@update_form')->name('update_form')->middleware('purchasing');
Route::get('/data_vendor_print/{id}', 'DataVendorController@prints')->middleware('purchasing');
Route::post('/get_xls_datavendor', 'DataVendorController@getxls')->name('get_xls_datavendor')->middleware('purchasing');
//Route::post('/delete_vendor/{id}', 'DataVendorController@delete_vendor')->name('delete_vendor')->middleware('purchasing');
Route::get('/delete_vendor/{id}', 'DataVendorController@delete_vendor')->middleware('purchasing');



/*
Route::get('/data_vendor', function()
{
    dd(App\DataVendor::all());
});
*/

//data_vendor
Route::get('/form', 'FormController@index')->name('form');
Route::get('/form_prc_31_limbah', 'FormController@form_prc_31_limbah')->name('form_prc_31_limbah');
Route::get('/form_prc_31_catering', 'FormController@form_prc_31_catering')->name('form_prc_31_catering');
Route::get('/form_prc_31_pest', 'FormController@form_prc_31_pest')->name('form_prc_31_pest');
Route::get('/form_prc_31_lab', 'FormController@form_prc_31_lab')->name('form_prc_31_lab');
Route::get('/form_prc_31_forklift', 'FormController@form_prc_31_forklift')->name('form_prc_31_forklift');
Route::get('/form_prc_31_cleaning', 'FormController@form_prc_31_cleaning')->name('form_prc_31_cleaning');
Route::post('/save_form', 'FormController@save_form')->name('save_form');

//Form report
Route::get('/purc_form_report', 'PurcFormReportController@index')->name('purc_form_report')->middleware('purchasing');
Route::get('/report_form_prc_31', 'PurcFormReportController@report_form_prc_31')->name('report_form_prc_31')->middleware('purchasing');
Route::get('/report_form_prc_31_view/{id}', 'PurcFormReportController@view')->middleware('purchasing');

Route::get('/mkt_form_report', 'MktFormReportController@index')->name('mkt_form_report')->middleware('marketing');
Route::get('/report_form_sales_9a', 'MktFormReportController@report_form_sales_9a')->name('report_form_sales_9a')->middleware('marketing');
Route::get('/report_form_sales_9b', 'MktFormReportController@report_form_sales_9b')->name('report_form_sales_9b')->middleware('marketing');
Route::get('/report_form_sales_9a_view/{id}', 'MktFormReportController@view')->middleware('marketing');
Route::post('/get_xls_FormMkt_9a', 'MktFormReportController@get_xls_FormMkt_9a')->name('get_xls_FormMkt_9a')->middleware('marketing');
Route::post('/get_xls_FormMkt_9b', 'MktFormReportController@get_xls_FormMkt_9b')->name('get_xls_FormMkt_9b')->middleware('marketing');

Route::get('/ajax_crud', 'PlantAjaxController@index')->middleware('admin')->name('ajax_crud');
Route::post ( '/links', 'PlantAjaxController@add' );
//DocumentViewer Library
/*
 Route::any('ViewerJS/{all?}', function(){

	return view('ViewerJS/pdfview');
    //return View::make('ViewerJS.index');
});


Route::any('PDFview/{all?}', function(){

	return view('home/pdfview');
    //return View::make('ViewerJS.index');
});
*/
Route::get('/{any}', function ($any) {

  // any other url, subfolders also
	return view('invalid');

})->where('any', '.*');
