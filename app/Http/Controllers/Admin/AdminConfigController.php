<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\formChk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Laravel\Facades\Image;

class AdminConfigController extends Controller
{
    public function ConfigDashboard($id){
        $Userdetail = DB::table('user_details')
        ->where('user_id','=',$id)
        ->get();
        return view('admin.ConfigDashboard',['id'=>$id],compact('Userdetail'));
    }

    public function InsertConfig(Request $request,$id){

      
        if ($request->hasFile('file_brochure')) {
            $file_input_bc = $request->file('file_brochure');
            $imageName = 'BC_'.time().'-'.$file_input_bc->getClientOriginalName();
            $upload_location = 'upload/';
            $full_path_bc = $upload_location . $imageName;
            $file_input_bc->move($upload_location, $imageName);
        }else{
            $full_path_bc = '0';
        }

        

        DB::table('setting_agents')
        ->insert([
            'user_id'=>$id,
            'vid_company'=>$request->vid_company,
            'vid_um'=>$request->vid_um,
            'file_brochure'=>$full_path_bc,
            'created_at' => Carbon::now()
        ]);
        return redirect()->route('admin_UserDetail',['id'=>$id])->with('success','บันทึกเรียบร้อยแล้ว');
    }

    public function ConfigForm($id){
        $agent = DB::table('user_details')
        ->where('user_id','=',$id)
        ->get();

         $agent_form = DB::table('agent_form_lists')->select('form_id')->where('agent_id','=',$id);

        $form_list = DB::table('form_chks')
        ->whereNotIn('form_id', $agent_form)
        ->get();

        $form_agent_list = DB::table('form_chks')
        ->leftJoin('agent_form_lists','form_chks.form_id','=','agent_form_lists.form_id')
        ->select('form_chks.form_name','agent_form_lists.*')
        ->where('agent_form_lists.agent_id','=',$id)
        ->get();

        return view('admin.ConfigForm',['id'=>$id],compact('form_list','agent','form_agent_list'));
    }

    public function InsertConfigForm(Request $request,$id){

        foreach ($request->form_chk as $key => $value) {
            DB::table('agent_form_lists')->insert([
                'agent_id'=>$id,
                'form_id'=>$value,
                'agentform_status'=>'1',   
                'created_at' => Carbon::now()
            ]);
        } 

        return redirect()->route('admin_ConfigForm',['id'=>$id])->with('success','บันทึกเรียบร้อยแล้ว');      
    }

    public function UnlistForm(Request $request)
    {
        $form_id = $request->form_id;
        $agent_id = $request->agent_id;
        DB::table('agent_form_lists')->where('form_id','=',$form_id)
        ->where('agent_id','=',$agent_id)
        ->delete();

        DB::table('agent_form_pers')->where('form_id','=',$form_id)
        ->where('agent_id','=',$agent_id)
        ->delete();

        return redirect()->route('admin_ConfigForm',['id'=>$agent_id])->with('success','ดำเนินการสำเร็จ');      
    }

    public function ListRole()
    {
        $listrole = DB::table('role')  
        ->orderBy('role.role_name','ASC')
        ->get();

        return view('admin.ListRole',compact('listrole'));
    }

    public function RoleDetail($id)
    {
        $roleDetail = DB::table('role')
        ->join('role_forms','role.id','=','role_forms.role_id')
        ->join('form_chks','role_forms.form_id','=','form_chks.form_id')
        ->where('role.id', '=', $id)
        ->orderBy('role_forms.created_at','ASC')
        ->get();

        $roleName = DB::table('role')
        ->where('role.id','=',$id)
        ->first();

    return view('admin.roleDetail', ['id' => $id], compact('roleDetail','roleName'));
    }

    //เพิ่มฟอร์มในหมวดหมู่
    public function add_form ($role)
    {

        $form_selected = DB::table('form_chks')
        ->join('role_forms','form_chks.form_id','=','role_forms.form_id')
        ->select('role_forms.form_id')
        ->where('role_forms.role_id',$role)->groupBy('role_forms.form_id');

        $listform = DB::table('form_chks') 
        ->whereNotIn('form_chks.form_id',$form_selected)      
        ->get();

        $roleName = DB::table('role')
        ->where('role.id','=',$role)
        ->first();

        return view('admin.add_form',compact('listform','roleName'));
    }

    public function RoleAddForm ($role,$form)
    {
        DB::table('role_forms')->insert([
            'role_id' => $role,
            'form_id' => $form,
            'created_at' => Carbon::now()
        ]);

        return redirect()->route('admin_roleDetail',['id'=>$role])->with('success','บันทึกเรียบร้อยแล้ว');
    }

    public function RoleUnlist ($role,$form)
    {
        DB::table('role_forms')->where('form_id', '=', $form)
        ->delete();

        return redirect()->route('admin_roleDetail', ['id' => $role])->with('success', 'ลบข้อมูลเรียบร้อยแล้ว');
    }

    public function InsertNewRole(Request $request)
    {
        $role_name = $request->role_name;

        DB::table('role')->insert([
            'role_name' => $role_name,
            'created_at' => Carbon::now()
        ]);
        return redirect()->route('admin_ListRole')->with('success','บันทึกเรียบร้อยแล้ว');
    }

    public function ConfigRole ($id) {
        $agent = DB::table('user_details')
        ->where('user_id','=',$id)
        ->get();

        $agent_role = DB::table('company_role')->select('company_role')
        ->where('user_id','=',$id);
      
        $role_list = DB::table('role')
        ->whereNotIn('id', $agent_role)
        ->get();

        $role_agent_list = DB::table('role')
        ->leftJoin('company_role','role.id','=','company_role.company_role')
        ->select('role.role_name','company_role.*')
        ->where('company_role.company_role','=',$id)
        ->get();

        return view('admin.ConfigRole',['id'=>$id],compact('role_list','agent','role_agent_list'));
    }

    //public function InsertConfigRole ($id,Request $request) 
   // {
   //}

}
