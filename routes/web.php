<?php

use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminConfigController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\CompanyController;
use App\Http\Controllers\User\CompanyReportController;
use App\Http\Controllers\CompanyConfigController;
use App\Http\Controllers\User\LeaderController;
use App\Http\Controllers\User\LeaderConfigController;
use App\Http\Controllers\QRcodeGenerateController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function(){
    Route::get('/dashboard',[AdminHomeController::class, 'index'])->name('admin_index');
    
    //role_หมวดหมู่การใช้งาน
    Route::get('/listrole',[AdminConfigController::class, 'ListRole'])->name('admin_ListRole');
    Route::post('/insertnewrole',[AdminConfigController::class, 'InsertNewRole'])->name('admin_insertnewrole');
    Route::get('/ConfigRole/{id}',[AdminConfigController::class, 'ConfigRole'])->name('admin_ConfigRole');
    Route::get('/roleDetail/{id}',[AdminConfigController::class, 'RoleDetail'])->name('admin_roleDetail');
    Route::get('/roleUnlist/{role}/{form}',[AdminConfigController::class, 'RoleUnlist'])->name('admin_roleUnlist');
    Route::get('/addform/{role}',[AdminConfigController::class, 'add_form'])->name('admin_add_form');
    Route::get('/roleaddform/{role}/{form}',[AdminConfigController::class, 'RoleAddForm'])->name('admin_roleaddform');
    
    //ฟอร์มเช็ค     
    Route::get('/form',[AdminHomeController::class, 'list_form'])->name('admin_form');
    Route::get('/create_form_part1',[AdminHomeController::class, 'create_form1'])->name('admin_create_form1');
    Route::post('/insert_form_part1',[AdminHomeController::class, 'insert_form_part1'])->name('admin_insert_form_part1');

    Route::get('/create_form/{id}',[AdminHomeController::class, 'create_form'])->name('admin_create_form');
    Route::post('/insert_form',[AdminHomeController::class, 'insert_form'])->name('admin_insert_form');
    Route::get('/frmDetail/{id}',[AdminHomeController::class, 'formDetail'])->name('admin_formDetail');
    Route::get('/frmPreview/{id}',[AdminHomeController::class, 'formPreview'])->name('admin_formPreview');

    //ข้อตรวจ
    Route::get('/frmDetailChoice/{id}',[AdminHomeController::class, 'formDetailChoice'])->name('admin_formDetailChoice');
    Route::get('/add_choice/{id}',[AdminHomeController::class, 'add_chk_choice'])->name('admin_AddChoice');
    Route::post('/insert_choice/{id}',[AdminHomeController::class, 'insert_choice'])->name('admin_InsertChoice');
    route::get('frmChoiceEdit/{id}',[AdminHomeController::class, 'formChoiceEdit'])->name('admin_ChoiceEdit');
    route::get('frmChoiceEditPic/{id}',[AdminHomeController::class, 'formChoiceEditPic'])->name('admin_ChoiceEditPic');
    Route::post('/frmChoiceUpdate/{id}',[AdminHomeController::class, 'formChoiceUpdate'])->name('admin_ChoiceUpdate');
    Route::post('/frmChoiceUpdatePic/{id}',[AdminHomeController::class, 'formChoiceUpdatePic'])->name('admin_ChoiceUpdatePic');
    Route::get('/frmChoiceDelete/{id}/{cid}',[AdminHomeController::class, 'formChoiceDelete'])->name('admin_ChoiceDelete');

    //หมวดหมู่
    route::get('frmCategoryEdit/{id}',[AdminHomeController::class, 'formCategoryEdit'])->name('admin_CategoryEdit');
    Route::post('/frmCategoryUpdate/{id}',[AdminHomeController::class, 'formCategoryUpdate'])->name('admin_CategoryUpdate');
    Route::get('/frmCategoryDelete/{cid}/{form_id}',[AdminHomeController::class, 'formCategoryDelete'])->name('admin_CategoryDelete');

    //User
    Route::get('/user',[AdminUserController::class, 'UserList'])->name('admin_Userlist');
    Route::get('/CreateUser',[AdminUserController::class, 'CreateUser'])->name('admin_CreateUser');
    Route::post('/InsertUser',[AdminUserController::class, 'InsertUser'])->name('admin_InsertUser');
    Route::get('/UserDetail/{id}',[AdminUserController::class, 'UserDetail'])->name('admin_UserDetail');
    Route::get('/UserEdit/{id}',[AdminUserController::class, 'UserEdit'])->name('admin_UserEdit');
    Route::POST('/UserUpdate/{id}',[AdminUserController::class, 'UserUpdate'])->name('admin_UserUpdate');

    Route::get('/AgentCreateUser/{id}',[AdminUserController::class, 'CreateAgentUser'])->name('admin_CreateAgentUser');
    Route::post('/AgentInsertUser/{id}',[AdminUserController::class, 'AgentInsertUser'])->name('admin_AgentInsertUser');

    Route::get('/AgentEdit/{id}',[AdminUserController::class, 'AgentEdit'])->name('admin_AgentEdit');

    Route::post('/AgentUpdate/{id}',[AdminUserController::class, 'AgentUpdate'])->name('admin_AgentUpdate');

    Route::delete('/AgentDeleteUser/{agent}',[AdminUserController::class, 'AgentDeleteUser'])->name('admin_AgentDeleteUser');


    //Config
    Route::get('/ConfigDashboard/{id}',[AdminConfigController::class, 'ConfigDashboard'])->name('admin_ConfigDashboard');
    Route::post('/InsertConfig/{id}',[AdminConfigController::class, 'InsertConfig'])->name('admin_InsertConfig');
    Route::get('/ConfigForm/{id}',[AdminConfigController::class, 'ConfigForm'])->name('admin_ConfigForm');
    Route::post('/InsertConfigForm/{id}',[AdminConfigController::class, 'InsertConfigForm'])->name('admin_InsertConfigForm');
    Route::delete('/UnlistForm',[AdminConfigController::class, 'UnlistForm'])->name('admin_UnlistForm');


})->middleware(['auth','role:admin']);

//role_User
Route::prefix('user')->group(function(){

    Route::get('/front',[UserController::class, 'index'])->name('user_index'); 
    Route::get('/frmchk',[UserController::class, 'FormChk'])->name('user_FormChk');
   
    Route::get('/newchk/{form_id}',[UserController::class, 'NewFormChk'])->name('user_NewFormChk');
    Route::post('/chkinsert/{form_id}',[UserController::class, 'UserChkInsert'])->name('user_ChkInsert');

    Route::get('/list_chk',[UserController::class, 'ListChk'])->name('user_ListChk');  
    Route::get('/formview/{round}',[UserController::class, 'FormView'])->name('user_FormView'); 
    Route::get('/printpreview/{round}',[UserController::class, 'preview_print'])->name('user_printpreview');  

})->middleware(['auth','role:user']);

//role_Company
Route::prefix('company')->group(function(){

    Route::get('/home',[CompanyController::class, 'index'])->name('company_index'); 
    Route::get('/listform',[CompanyController::class, 'ListForm'])->name('company_listform'); 

    Route::get('/groupuser',[CompanyController::class, 'GroupUser'])->name('company_groupuser'); 
 

    Route::get('/setform/{form_id}',[CompanyController::class, 'SettingForm'])->name('company_setform'); 
    Route::post('/insertcar/{form_id}',[CompanyController::class, 'InsertCarData'])->name('company_insertcar');
    Route::get('/updatestatuscar/{form_id}/{id}/{status}',[CompanyController::class, 'UpdateStatusCar'])->name('company_updatestatuscar'); 
    Route::get('/DelCar/{form_id}/{id}',[CompanyController::class, 'DeleteCar'])->name('company_DeleteCar'); 
    Route::get('/editcar/{id}',[CompanyController::class, 'EditCar'])->name('company_editcar'); 
    Route::post('/updatecar/{id}/{form_id}',[CompanyController::class, 'UpdateCar'])->name('company_updatecar');
    Route::get('/formper/{form_id}',[CompanyController::class, 'FormPer'])->name('company_formper');
    
    Route::post('/insertper',[CompanyController::class, 'InsertPer'])->name('company_InsertPer');
    Route::get('/listchkform/{form_id}',[CompanyController::class, 'ListChk'])->name('company_listchkform');
    Route::get('/chkdetail/{round}/{type}',[CompanyController::class, 'ChkFormDetail'])->name('company_chkdetail');

    Route::get('/compchk/{form_id}/{ts}',[CompanyController::class, 'CompanyChk'])->name('company_chk'); 

    //CreateUser
    Route::get('/listuser/{type}',[CompanyController::class, 'ListUser'])->name('company_listuser');
    Route::get('/newuser/{type}',[CompanyController::class, 'NewUser'])->name('company_newuser');
    Route::post('/createuser/{type}',[CompanyController::class, 'CreateUser'])->name('company_createuser');
    Route::get('/edituser/{id}',[CompanyController::class, 'EditUser'])->name('company_edituser'); Route::post('/update/{id}',[CompanyController::class, 'UpdateUser'])->name('company_updateuser');
    Route::get('/deleteuser/{id}/{type}',[CompanyController::class, 'DeleteUser'])->name('company_deleteuser');
   
        //Transport_บริษัทขนส่ง
   Route::get('/TransportCreate',[CompanyConfigController::class, 'TransportCreate'])->name('company_TransportCreate');
   Route::post('/TransportInsert',[CompanyConfigController::class, 'TransportInsert'])->name('company_TransportInsert');
   Route::get('/TransportList/{id}',[CompanyConfigController::class, 'TransportList'])->name('company_TransportList');
   Route::get('/TransportEdit/{id}',[CompanyConfigController::class, 'TransportEdit'])->name('company_TransportEdit');


   Route::get('/ListPlate/{id}',[CompanyConfigController::class, 'ListPlate'])->name('company_ListPlate');

   Route::get('/TransportTypeChk/{id}/{ts}',[CompanyConfigController::class, 'TypeChk'])->name('company_TypeChk');

   //รถขนส่ง
   Route::get('/newtruck/{id}',[CompanyConfigController::class, 'NewTruck'])->name('company_newtruck');
   Route::post('/inserttruck/{ts}',[CompanyConfigController::class, 'InsertTruck'])->name('company_inserttruck');
   Route::get('/detailtruck/{id}',[CompanyConfigController::class, 'DetailTruck'])->name('company_detailtruck');

   Route::get('/newtruck2',[CompanyConfigController::class, 'NewTruck2'])->name('company_newtruck2');

   Route::post('/inserttruck2',[CompanyConfigController::class, 'InsertTruck2'])->name('company_inserttruck2');

   Route::get('/trucklist',[CompanyConfigController::class, 'TruckList'])->name('company_trucklist');
   
   //สรุปรายงาน
   Route::get('/reportlist/{form}',[CompanyReportController::class, 'ReportList'])->name('company_reportlist');
  

})->middleware(['auth','role:company']);


//role_leader
Route::prefix('leader')->group(function(){

    Route::get('/lead',[LeaderController::class, 'index'])->name('leader_index'); 
    Route::get('/frmchk/{form_id}/{type}',[LeaderController::class, 'NewChk'])->name('leader_FormChk');
    Route::post('/chkinsert/{form_id}/{ts}',[LeaderController::class, 'ChkInsert'])->name('leader_ChkInsert');
    Route::get('/listform/{form_id}/{type}',[LeaderController::class, 'ListForm'])->name('leader_listform');

    Route::get('/chkdetail/{round}/{type}',[LeaderController::class, 'DetailChk'])->name('leader_detailchk');

   //Transport_บริษัทขนส่ง
   Route::get('/TSCList/{id}',[LeaderConfigController::class, 'TransportList'])->name('leader_TransportList');
   Route::get('/TSCPlate/{id}',[LeaderConfigController::class, 'ListPlate'])->name('leader_Plate');

   Route::get('/TSCTypeChk/{id}/{ts}',[LeaderConfigController::class, 'TypeChk'])->name('leader_TypeChk');

   Route::get('/tscchk/{form_id}/{ts}',[LeaderConfigController::class, 'TSCChk'])->name('leader_TSCChk');

   Route::get('/TSCDetail/{round}',[LeaderConfigController::class, 'TSCDetail'])->name('leader_TSCDetail');

   //ตรวจครั้งที่ 2
   Route::get('/tscchk2/{form_id}/{ts}/{round}/{num}',[LeaderConfigController::class, 'TSCChk2'])->name('leader_TSCChk2');
   Route::post('/chkinsert2/{form_id}/{ts}',[LeaderConfigController::class, 'chkinsert2'])->name('leader_chkinsert2');

   Route::get('/TSCCheckNum/{plate}/{id}',[LeaderConfigController::class, 'ListPlate_all'])->name('leader_PlateAll');

   //ตรวจรถ v.2 เลือกทะเบียนก่อน
   Route::get('/platetotal',[LeaderConfigController::class, 'ListPlateTotal'])->name('leader_listplatetotal');
   Route::get('/TruckChkS1/{id}/{no}',[LeaderConfigController::class, 'TruckChkS1'])->name('leader_truckchks1');

   Route::POST('/ChkPart1/{truckid}',[LeaderConfigController::class, 'ChkPart1'])->name('leader_ChkPart1');

   Route::get('/TruckChkS2/{id}/{round}/{form}/{category_id}/{num}',[LeaderConfigController::class, 'TruckChkS2'])->name('leader_truckchks2');

   Route::POST('/TruckInsert2',[LeaderConfigController::class, 'TruckInsert2'])->name('leader_TruckInsert2');

   Route::get('/TruckChkS3/{round}/',[LeaderConfigController::class, 'TruckChkS3'])->name('leader_truckchks3');

   Route::POST('/TruckInsert3',[LeaderConfigController::class, 'TruckInsert3'])->name('leader_TruckInsert3');

   //รายงานตรวจรถ
   Route::get('/reportall/{id}',[LeaderController::class, 'ReportAllPlate'])->name('leader_reportall');

   Route::get('/truckdetail1/{round}/{truck}',[LeaderController::class, 'TruckChkDetail1'])->name('leader_TruckChkDetail1');

   Route::get('/truckdetail2/{round}/{truck}',[LeaderController::class, 'TruckChkDetail2'])->name('leader_TruckChkDetail2');


   //qrcode
   Route::get('/qrcode/{round}', [QRcodeGenerateController::class,'qrcode'])->name('leader_qrcode');

})->middleware(['auth','role:leader']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/printpreview/{round}/{type}',[App\Http\Controllers\HomeController::class, 'preview_print'])->name('printpreview'); 



