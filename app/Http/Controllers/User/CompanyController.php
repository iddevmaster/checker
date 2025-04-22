<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:company');
    }

    public function index()
    {
        $agent_id = Auth::user()->user_id;

        $user_detail = DB::table('user_details')
            ->where('user_id', '=', $agent_id)
            ->get();

            $company_role = DB::table('company_role')
            ->join('role','company_role.company_role','=','role.id')
            ->where('company_role.user_id','=',$agent_id)
            ->where('company_role.active_status','=','1')
            ->get();

        $form_list = DB::table('agent_form_lists')
            ->join('form_chks', 'agent_form_lists.form_id', '=', 'form_chks.form_id')
            ->select('form_chks.form_name', 'form_chks.form_category', 'agent_form_lists.*')
            ->where('agent_form_lists.agent_id', '=', $agent_id)
            ->get();

        return view('company.index', compact('user_detail', 'form_list','company_role'));
    }

    public function ListForm()
    {
        $agent_id = Auth::user()->user_id;

        $form_list = DB::table('agent_form_lists')
            ->select('agent_form_lists.agent_id', 'agent_form_lists.form_id', 'agent_form_lists.agentform_status', 'form_chks.form_name', 'form_chks.form_type')
            ->join('form_chks', 'agent_form_lists.form_id', '=', 'form_chks.form_id')
            ->where('agent_form_lists.agent_id', '=', $agent_id)
            ->where('agent_form_lists.agentform_status', '=', 1)
            ->get();

        return view('company.listform', compact('form_list'));
    }

    public function SettingForm($form_id)
    {

        $agent_id = Auth::user()->user_id;

        $form_name = DB::table('form_chks')
            ->where('form_id', '=', $form_id)
            ->get();

        $province_th = DB::table('province_list')
            ->orderBy('name_th', 'ASC')
            ->get();

        $car_data = DB::table('form_car_datas')
            ->where('form_id', '=', $form_id)
            ->where('user_id', '=', $agent_id)
            ->get();

        return view('company.SettingForm', compact('form_name', 'province_th', 'car_data'));
    }

    public function InsertCarData(Request $request, $form_id)
    {
        $agent_id = Auth::user()->user_id;

        DB::table('form_car_datas')->insert([
            'user_id' => $agent_id,
            'form_id' => $form_id,
            'car_plate' => $request->car_plate,
            'car_province' => $request->car_province,
            'car_status' => 1,
            'car_type' => $request->car_type,
            'created_at' => Carbon::now()
        ]);

        return redirect()->route('company_setform', ['form_id' => $form_id])
            ->with('success', 'บันทึกข้อมูลสำเร็จ');
    }

    public function UpdateStatusCar($form_id, $id, $status)
    {
        if ($status == 'close') {
            DB::table('form_car_datas')
                ->where('id', '=', $id)
                ->update([
                    'car_status' => '0',
                    'updated_at' => Carbon::now()
                ]);
        } elseif ($status == 'open') {
            DB::table('form_car_datas')
                ->where('id', '=', $id)
                ->update([
                    'car_status' => '1',
                    'updated_at' => Carbon::now()
                ]);
        }
        return redirect()->route('company_setform', ['form_id' => $form_id])
            ->with('success', 'บันทึกข้อมูลสำเร็จ');
    }

    public function DeleteCar($form_id, $id)
    {

        DB::table('form_car_datas')
            ->where('id', '=', $id)
            ->delete();

        return redirect()->route('company_setform', ['form_id' => $form_id])
            ->with('success', 'ลบข้อมูลสำเร็จ');
    }

    public function EditCar($id)
    {
        $edit_data = DB::table('form_car_datas')
            ->select('form_chks.form_type', 'form_car_datas.car_plate', 'form_car_datas.car_province', 'form_car_datas.car_type', 'form_car_datas.form_id')
            ->join('form_chks', 'form_chks.form_id', '=', 'form_car_datas.form_id')
            ->where('form_car_datas.id', '=', $id)
            ->get();

        $province_th = DB::table('province_list')
            ->orderBy('name_th', 'ASC')
            ->get();

        return view('company.EditCar', compact('edit_data', 'province_th'));
    }

    public function UpdateCar(Request $request, $id, $form_id)
    {
        DB::table('form_car_datas')->where('id', '=', $id)
            ->update([
                'car_plate' => $request->car_plate,
                'car_province' => $request->car_province,
                'car_type' => $request->car_type,
                'updated_at' => Carbon::now()
            ]);
        return redirect()->route('company_setform', ['form_id' => $form_id])
            ->with('success', 'แก้ไขข้อมูลสำเร็จ');
    }

    public function FormPer($form_id)
    {

        $agent_id = Auth::user()->user_id;

        $form_per = DB::table('agent_form_lists')
            ->select('agent_form_lists.agent_id', 'agent_form_lists.form_id', 'agent_form_lists.agentform_status', 'form_chks.form_name', 'form_chks.form_type', 'agent_form_lists.leader_role', 'agent_form_lists.user_role')
            ->join('form_chks', 'agent_form_lists.form_id', '=', 'form_chks.form_id')
            ->where('agent_form_lists.form_id', '=', $form_id)
            ->where('agent_form_lists.agent_id', '=', $agent_id)
            ->where('agent_form_lists.agentform_status', '=', 1)
            ->get();

        return view('company.FormPer', compact('form_per'));
    }
    public function InsertPer(Request $request)
    {
        $agent_id = Auth::user()->user_id;
        $form_id = $request->form_id;

        DB::table('agent_form_lists')
            ->where('form_id', $form_id)
            ->where('agent_id', $agent_id)
            ->update([
                'user_role' => $request->user_role,
                'leader_role' => $request->leader_role,
                'updated_at' => Carbon::now()
            ]);

        return redirect()->route('company_listform')
            ->with('success', 'บันทึกข้อมูลสำเร็จ');
    }

    public function GroupUser()
    {
        return view('company.GroupUser');
    }

    public function ListChk($form_id)
    {
        $agent_id = Auth::user()->user_id;

        $formName = DB::table('form_chks')
        ->where('form_id', '=', $form_id)
        ->get();

        $record_data = DB::table('chk_records')
            ->join('form_chks', 'chk_records.form_id', '=', 'form_chks.form_id')
            ->join('user_details', 'chk_records.user_id', '=', 'user_details.user_id')
            ->select('chk_records.round_chk', 'form_chks.form_name','form_chks.form_type', 'user_details.fullname', 'chk_records.created_at')
            ->where('chk_records.form_id', '=', $form_id)
            ->where('chk_records.agent_id', '=', $agent_id)
            ->groupBy('chk_records.round_chk')
            ->get();

        return view('company.ListChkForm', compact('record_data','formName'));
    }

    public function ChkFormDetail($round,$type)
    {

        $formview = DB::table('chk_records')
        ->join('form_choices', 'chk_records.choice_id', '=', 'form_choices.id')
        ->select('chk_records.choice_id', 'chk_records.choice_remark', 'chk_records.user_chk', 'chk_records.created_at', 'form_choices.form_choice', 'form_choices.choice_img')
        ->where('chk_records.round_chk', '=', $round)
        ->get();

    $formchk_date = DB::table('chk_records')
        ->select('chk_records.created_at', 'chk_records.round_chk')
        ->where('chk_records.round_chk', '=', $round)
        ->orderBy('id', 'asc')
        ->limit(1)
        ->get();
      
        if($type == '4')
        {
            $form_id = DB::table('detail_records')
            ->where('round_chk', '=', $round)
            ->value('form_id_chk');

            $formName = DB::table('form_chks')
            ->where('form_id', '=', $form_id)
            ->get();

            $car_data = DB::table('detail_records')
            ->join('user_details', 'detail_records.std_id', '=', 'user_details.user_id')
            ->join('users', 'detail_records.user_id', '=', 'users.user_id')
            ->join('branch_names','detail_records.user_dep','=','branch_names.id_branch')
            ->where('detail_records.round_chk', '=', $round)
            ->get();
        }else
        {
         
        $car_data = DB::table('chk_record_forms')
            ->join('form_car_datas', 'chk_record_forms.car_id', '=', 'form_car_datas.id')
            ->join('form_chks', 'form_car_datas.form_id', '=', 'form_chks.form_id')
            ->select('form_car_datas.car_plate', 'form_car_datas.car_province', 'form_car_datas.car_type', 'form_chks.form_name', 'chk_record_forms.car_mileage')
            ->where('chk_record_forms.round_chk', '=', $round)
            ->get();

        }

       
        return view('company.ChkFormDetail', ['round' => $round], compact('formview', 'formchk_date', 'car_data'));
    }

    public function CompanyChk($form_id,$ts)
    {
        $formPreview = DB::table('form_chks')
            ->select('form_chks.form_id', 'form_chks.form_name', 'form_categories.category_id', 'form_categories.category_name', 'form_chks.form_type')
            ->join('form_categories', 'form_chks.form_id', '=', 'form_categories.form_id')
            ->where('form_chks.form_id', '=', $form_id)
            ->get();

        $formName = DB::table('form_chks')
            ->where('form_id', '=', $form_id)
            ->get();

        return view('company.CheckPage', ['form_id' => $form_id], compact('formPreview', 'formName'));
    }

    public function NewUser($type)
    {
        return view('company.NewUser');
    }

    public function ListUser($type)
    {
        $agent_id = Auth::user()->user_id;
        if ($type == 'leader') {
            $listuser = DB::table('users')
                ->where('role', '=', 'leader')
                ->where('user_dep', '=', $agent_id)
                ->get();
        } elseif ($type == 'user') {
            $listuser = DB::table('users')
                ->where('role', '=', 'user')
                ->where('user_dep', '=', $agent_id)
                ->get();
        }

        return view('company.ListUser', ['type' => $type], compact('listuser'));
    }

    public function CreateUser(Request $request, $type)
    {
        $agent_id = Auth::user()->user_id;
        $user_id = Str::upper(Str::random(12));
        if ($type == 'leader') {
            DB::table('user_details')->insert([
                'user_id' => $user_id,
                'fullname' => $request->name,
                'user_logo' => '0',
                'user_status' => '1',
                'user_dep' => $agent_id,
                'created_at' => Carbon::now()
            ]);

            DB::table('users')->insert([
                'user_id' => $user_id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'password_2' => $request->password,
                'remember_token' => Str::random(30),
                'role' => 'leader',
                'user_dep' => $agent_id,
                'created_at' => Carbon::now()
            ]);
        } elseif ($type == 'user') {
            DB::table('user_details')->insert([
                'user_id' => $user_id,
                'fullname' => $request->name,
                'user_logo' => '0',
                'user_status' => '1',
                'user_dep' => $agent_id,
                'created_at' => Carbon::now()
            ]);

            DB::table('users')->insert([
                'user_id' => $user_id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'password_2' => $request->password,
                'remember_token' => Str::random(30),
                'role' => 'user',
                'user_dep' => $agent_id,
                'created_at' => Carbon::now()
            ]);
        }
        return redirect()->route('company_listuser', ['type' => $type])->with('success', 'สร้างบัญชีผู้ใช้สำเร็จ');
    }

    public function EditUser($id)
    {
        $edituser = DB::table('users')
            ->where('user_id', '=', $id)
            ->get();

        return view('company.EditUser', ['id' => $id], compact('edituser'));
    }

    public function UpdateUser(Request $request, $id)
    {
        $newpass = $request->password;
        if ($newpass == "") {
            DB::table('users')
                ->where('user_id', '=', $id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'updated_at' => Carbon::now()
                ]);
                
        }else
        {
            DB::table('users')
            ->where('user_id', '=', $id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'password_2' => $request->password,
                'updated_at' => Carbon::now()
            ]);
        }

        DB::table('user_details')
        ->where('user_id','=',$id)
        ->update([
            'fullname'=>$request->name,
            'updated_at' => Carbon::now()
        ]);

        $type = $request->role;

        return redirect()->route('company_listuser', ['type' => $type])->with('success', 'บันทึกเรียบร้อยแล้ว');
    }

    public function DeleteUser($id,$type){
        DB::table('users')->where('user_id','=',$id)->delete();
        DB::table('user_details')->where('user_id','=',$id)->delete();        
        DB::table('chk_record_forms')->where('user_id','=',$id)->delete();
        DB::table('chk_records')->where('user_id','=',$id)->delete();

        return redirect()->route('company_listuser', ['type' => $type])->with('success', 'ดำเนินการเรียบร้อยแล้ว');
    }
}
