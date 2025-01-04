<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use function Laravel\Prompts\select;

class LeaderConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:leader');
    }

    public function TransportList($id){
     
        $ts_detail = DB::table('tran_sport_data')
        ->where('ts_agent', '=', $id)
        ->orderBy('created_at', 'DESC')
        ->get();

        return view('leader.TSCList', compact('ts_detail'));
    }

    public function ListPlate ($id)
    {

        $ts_detail = DB::table('tran_sport_data')
        ->where('id', '=', $id)
        ->get();

        $id_max = DB::table('truck_data_chks')->select(DB::raw('MAX(id)'))
        ->groupBy('plate_top');

        $chk_truck = DB::table('truck_data_chks')
        ->orderBy('id', 'DESC')
        ->where('ts_agent','=',$id)
        ->whereIn('id',$id_max)
        ->get();

        return view('leader.TSCPlate',['id'=>$id], compact('ts_detail','chk_truck'));
    }

    public function TypeChk ($id,$ts)
    {
        
        $form_list = DB::table('agent_form_lists')
        ->join('form_chks','agent_form_lists.form_id','=','form_chks.form_id')
        ->where('agent_form_lists.agent_id', '=', $id)
        ->get();

        return view('leader.TSCTypeChk',['id'=>$id,'ts'=>$ts], compact('form_list'));
    }
//ตรวจครั้งที่1
    public function TSCChk($form_id)
    {
        $formPreview = DB::table('form_chks')
            ->select('form_chks.form_id', 'form_chks.form_name', 'form_categories.category_id', 'form_categories.category_name', 'form_chks.form_type')
            ->join('form_categories', 'form_chks.form_id', '=', 'form_categories.form_id')
            ->where('form_chks.form_id', '=', $form_id)
            ->get();

        $formName = DB::table('form_chks')
            ->where('form_id', '=', $form_id)
            ->get();

        return view('leader.TSCCheck', ['form_id' => $form_id], compact('formPreview', 'formName'));
    }

    //ตรวจครั้งที่ 2

    public function TSCChk2($form_id,$ts,$round,$num)
    {
        $zero_chk = '0';
        $formPreview = DB::table('truck_data_chks')   
            ->join('chk_records' , 'truck_data_chks.round_chk', '=' ,'chk_records.round_chk')
            ->join('form_choices' ,'chk_records.choice_id' ,'=' ,'form_choices.id')
            ->join('form_types', 'truck_data_chks.form_types', '=' ,'form_types.id')
            ->join('form_categories', 'form_choices.category_id', '=', 'form_categories.category_id')
            ->select('form_choice','choice_remark','form_types','plate_top','form_type_name','category_name','form_categories.category_id','choice_type','chk_records.choice_img','chk_records.choice_remark','form_choices.id')
            ->where('chk_records.user_chk','=',$zero_chk)
            ->where('truck_data_chks.round_chk', '=', $round)            
            ->get();
            
        $formName = DB::table('form_chks')
            ->where('form_id', '=', $form_id)
            ->get();

        return view('leader.TSCCheck2', ['form_id' => $form_id,'ts'=>$ts,'round'=>$round,'num'=>$num], compact('formPreview', 'formName'));
    }

    public function TSCDetail ($round)
    {

        $form_detail = DB::table('truck_data_chks')
        ->join('form_chks','truck_data_chks.form_chk','=','form_chks.form_id')
        ->join('form_types','form_chks.form_type','=','form_types.id')
        ->join('tran_sport_data','truck_data_chks.ts_agent','=','tran_sport_data.id')
        ->select('truck_data_chks.plate_top','truck_data_chks.plate_bottom','truck_data_chks.created_at','form_chks.form_name','form_types.form_type_name','tran_sport_data.ts_name','truck_data_chks.chk_num','truck_data_chks.created_at')
        ->where('truck_data_chks.round_chk', '=', $round)
        ->get();

        $formview = DB::table('chk_records')
        ->join('form_choices','chk_records.choice_id','=','form_choices.id')
        ->select('chk_records.choice_id','chk_records.choice_remark','chk_records.user_chk','chk_records.created_at','form_choices.form_choice','form_choices.choice_img as ch_img','chk_records.choice_img as up_img')   
        ->where('chk_records.round_chk','=',$round)   
        ->get();

        $status_chk = DB::table('truck_data_chks')
        ->select('truck_data_chks.status_chk')
        ->where('truck_data_chks.round_chk', '=', $round)
        ->get();

        return view('leader.TSCDetail', ['round' => $round],compact('form_detail','formview','status_chk'));
    }

    public function chkinsert2(Request $request, $form_id, $ts)
    {
        $input = request()->all();
        $condition = $input['choice'];
        $agent_id = Auth::user()->user_dep;
        $user_id =  Auth::user()->user_id;
        $round = Str::upper(Str::random(11));

        DB::table('truck_data_chks')->insert([
            'emp_id' => $user_id,
            'ts_agent' => $ts,
            'form_chk' => $form_id,
            'plate_top' => $request->plate_top,
            'plate_bottom' => $request->plate_bottom,
            'chk_num' => '2',
            'form_types' => $request->form_type,
            'status_chk' => $request->final_chk,
            'round_chk' => $round,
            'created_at' => Carbon::now()
        ]);
       
        foreach ($condition as $key => $condition) {

            $choice_img = $input['choice_img'][$key];
            $choice_id = $input['choice'][$key];
            $fileOriginalName = $choice_img->getClientOriginalExtension();
            $fileNewName = $form_id.'_'.$choice_id.'_'.time() .'.'. $fileOriginalName;
            $upload_location = 'upload/truckchk/';
            $full_path = $upload_location . $fileNewName;

            $choice_img->move($upload_location, $fileNewName);

            DB::table('chk_records')->insert([
                'agent_id' => $agent_id,
                'user_id' => $user_id,
                'form_id' => $form_id,
                'choice_id' => $input['choice'][$key],
                'user_chk' => $input['user_chk'][$key],
                'round_chk' => $round,
                'choice_remark' => $input['user_remark'][$key],
                'choice_img' => $full_path,
                'created_at' => Carbon::now()
            ]);
        }
        return redirect()->route('leader_Plate', ['id'=>$ts])->with('success', 'บันทึกข้อมูลสำเร็จ');
    }

    public function ListPlate_all ($plate,$id)
    {
        $chk_truck = DB::table('truck_data_chks')
        ->where('plate_top', '=', $plate)
        ->orderBy('id', 'ASC')
        ->get();
             
        $ts_detail = DB::table('tran_sport_data')
        ->where('id', '=', $id)
        ->get();
 
      return view('leader.TSCChkNum', ['plate' => $plate],compact('chk_truck','ts_detail'));
    }

    public function ListPlateTotal ()
    {
        $truck_data = DB::table('truck_data')
        ->join('tran_sport_data','truck_data.transport_id','=','tran_sport_data.id')
        ->orderBy('truck_data.plate_top','ASC')
        ->get();

        return view('leader.ListPlate',compact('truck_data'));
    }

    public function TruckChkS1 ($id,$no)
    {
        $Chk_part1 = DB::table('truck_data')
        ->select('plate_top','ts_name','plate_bottom','form_name','form_id','truck_data.transport_id')
        ->join('tran_sport_data','truck_data.transport_id','=','tran_sport_data.id')
        ->join('form_chks','truck_data.truck_type','form_chks.form_type')
        ->where('truck_data.truck_id','=',$id)
        ->get();

        return view('leader.TruckChkS1',compact('Chk_part1'));
    }

    public function ChkPart1 (Request $request,$truckid)
    {
        $user_id =  Auth::user()->user_id;
        $round_id = Str::upper(Str::random(12));

        $upload_location = 'upload/truckchk/';

        if($request->hasFile('img_1'))
        {
            $rename_file1 = time().'_1'.'.'.$request->file('img_1')->getClientOriginalExtension();
            $request->file('img_1')->move($upload_location,$rename_file1);
        }

        if($request->hasFile('img_2'))
        {
            $rename_file2 = time().'_2'.'.'.$request->file('img_2')->getClientOriginalExtension();
            $request->file('img_2')->move($upload_location,$rename_file2);
        }

        if($request->hasFile('img_3'))
        {
            $rename_file3 = time().'_3'.'.'.$request->file('img_3')->getClientOriginalExtension();
            $request->file('img_3')->move($upload_location,$rename_file3);
        }

        if($request->hasFile('img_4'))
        {
            $rename_file4 = time().'_4'.'.'.$request->file('img_4')->getClientOriginalExtension();
            $request->file('img_4')->move($upload_location,$rename_file4);
        }

        if($request->hasFile('img_5'))
        {
            $rename_file5 = time().'_5'.'.'.$request->file('img_5')->getClientOriginalExtension();
            $request->file('img_5')->move($upload_location,$rename_file5);
        }else
        {
            $rename_file5 = '0';
        }

        if($request->hasFile('img_6'))
        {
            $rename_file6 = time().'_6'.'.'.$request->file('img_6')->getClientOriginalExtension();
            $request->file('img_6')->move($upload_location,$rename_file6);
        }else
        {
            $rename_file6 = '0';
        }

        if($request->hasFile('img_7'))
        {
            $rename_file7 = time().'_7'.'.'.$request->file('img_7')->getClientOriginalExtension();
            $request->file('img_7')->move($upload_location,$rename_file7);
        }else
        {
            $rename_file7 = '0';
        }

        if($request->hasFile('img_8'))
        {
            $rename_file8 = time().'_8'.'.'.$request->file('img_8')->getClientOriginalExtension();
            $request->file('img_8')->move($upload_location,$rename_file8);
        }else
        {
            $rename_file8 = '0';
        }

        DB::table('chk_truck_part1s')->insert([           							
            'user_id' => $user_id ,
            'transport_id' =>  $request->transport_id,
            'truck_id' => $truckid,
            'form_id' =>  $request->form_id,
            'driver_prefix' => $request->driver_prefix,
            'driver_name' => $request->driver_name,
            'driver_lastname' => $request->driver_lastname,
            'driver_phone' => $request->driver_phone,
            'driver_id' => $request->driver_id,
            'insure_name' => $request->insure_name,
            'chk_round' =>  '1',
            'img_1' =>  $rename_file1,
            'img_2' =>  $rename_file2,
            'img_3' =>  $rename_file3,
            'img_4' =>  $rename_file4,
            'img_5' =>  $rename_file5,
            'img_6' =>  $rename_file6,
            'img_7' =>  $rename_file7,
            'img_8' =>  $rename_file8,
            'round_id' => $round_id,
            'created_at' => Carbon::now()
        ]);

        $form_id = $request->form_id;

        $category1 = DB::table('form_categories')    
        ->where('form_id','=',$form_id)
        ->orderBy('id','ASC')
        ->limit('1')
        ->value('category_id');


        return redirect()->route('leader_truckchks2', ['id'=>$truckid,'round'=>$round_id,'form'=>$form_id,'category_id'=>$category1,'num'=>'1'])->with('success', 'บันทึกข้อมูลสำเร็จ ต่อไปแบบตรวจขั้นตอนที่ 2');
    }


    public function TruckChkS2 ($id,$round,$form,$category_id,$num)
    {
   
        $category1 = DB::table('form_choices')    
        ->where('category_id','=',$category_id)
        ->orderBy('id','ASC')
        ->get();

        return view('leader.TruckChkS2',['id'=>$id,'round'=>$round,'form'=>$form,'category_id'=>$category_id,'num'=>$num],compact('category1'));
    }

    public function TruckInsert2 (Request $request)
    {
        $input = request()->all();
        $user_id =  Auth::user()->user_id;
        $condition = $input['choice'];
        $form_id = $request->form_id;
        $round = $request->round;
        $agent_id = Auth::user()->user_dep;
        $num = $request->num;
        $category = $request->category_id;
        $truckid = $request->truckid;

        foreach ($condition as $key => $condition) {
            
            $choice_id = $input['choice'][$key];
            if(empty($input['choice_img'][$key]))
            {               
                $full_path = '0';
            }else
            {
                $choice_img = $input['choice_img'][$key];
                $fileOriginalName = $choice_img->getClientOriginalExtension();
                $fileNewName = $form_id.'_'.$choice_id.'_'.time() .'.'. $fileOriginalName;
                $upload_location = 'upload/truckchk/';
                $full_path = $upload_location . $fileNewName;
                $choice_img->move($upload_location, $fileNewName);
            }
        

            DB::table('chk_records')->insert([
                'agent_id' => $agent_id,
                'user_id' => $user_id,
                'form_id' => $form_id,
                'choice_id' => $input['choice'][$key],
                'user_chk' => $input['user_chk'][$key],
                'round_chk' => $round,
                'choice_remark' => $input['user_remark'][$key],
                'choice_img' => $full_path,
                'created_at' => Carbon::now()
            ]);
        }

        $category_count = DB::table('form_categories')
        ->where('form_id','=',$form_id)
        ->count();

        if($num > $category_count)
        {
        return redirect()->route('leader_truckchks3',['round'=>$round])->with('success', 'บันทึกสำเร็จ กรุณาสรุปผลการตรวจ');
        }else{
        return redirect()->route('leader_truckchks2', ['id'=>$truckid,'round'=>$round,'form'=>$form_id,'category_id'=>$category,'num'=>$num])->with('success', 'บันทึกข้อมูลสำเร็จ');
        }
    }

    public function TruckChkS3 ($round)
    {
        $chk_detail = DB::table('chk_truck_part1s')
        ->select('chk_truck_part1s.transport_id','chk_truck_part1s.truck_id','chk_truck_part1s.form_id','plate_top','plate_bottom','form_name','ts_name','form_type_name')
        ->join('tran_sport_data', 'chk_truck_part1s.transport_id', '=', 'tran_sport_data.id')
        ->join('truck_data' , 'chk_truck_part1s.truck_id', '=', 'truck_data.truck_id')
        ->join('form_chks' , 'chk_truck_part1s.form_id', '=', 'form_chks.form_id')
        ->join('form_types' , 'truck_data.truck_type', '=', 'form_types.id')
        ->where('chk_truck_part1s.round_id','=',$round)
        ->get();

        return view('leader.TruckChkS3',['round'=>$round],compact('chk_detail'));
    }

    public function TruckInsert3 (Request $request)
    {

        $date_chk = $request->date_chk;
        $month_chk = $request->month_chk;
        $year_th = $request->yearth;

        $date_all_chk = $date_chk.'/'.$month_chk.'/'.$year_th;

        DB::table('chk_truck_part2s')
        ->insert([
            'transport_id' =>$request->tran_id,
            'truck_id' =>$request->truck_id,
            'user_id' =>Auth::user()->user_id,
            'form_id' =>$request->form_id,
            'round_id' =>$request->round_id,
            'date_chk' => $date_all_chk,
            'chk_result' => $request->final_chk,
            'renew_chk_date' => $request->renew_chk_date,
            'created_at' => Carbon::now()
        ]);

        return redirect()->route('leader_listplatetotal')->with('success', 'ตรวจรถสำเร็จ');
    }
 

}
