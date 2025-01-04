<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class CompanyConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:company');
    }
    
    //Transport
    public function TransportCreate() {
        return view('company.TransportCreate');
    }

    public function TransportList($id){
     
        $ts_detail = DB::table('tran_sport_data')
        ->where('ts_agent', '=', $id)
        ->orderBy('created_at', 'DESC')
        ->get();

        return view('company.TransportList', compact('ts_detail'));
    }

    public function TransportInsert(Request $request)
    {
        $agent_id = Auth::user()->user_id;
        DB::table('tran_sport_data')->insert([
            'ts_agent' => $agent_id,
            'ts_name' => $request->ts_name,
           'ts_address' => $request->ts_address,
           'ts_province' => $request->ts_province,
           'ts_amphur' => $request->ts_amphur,
           'ts_tambon' => $request->ts_tambon,
           'ts_zipcode' => $request->ts_zipcode,
           'ts_phone' => $request->ts_phone,
           'created_at' => Carbon::now()
        ]);

        return redirect()->route('company_TransportList', ['id' => $agent_id])
        ->with('success', 'บันทึกข้อมูลสำเร็จ');
    }

    public function TransportEdit($id){

        $ts_detail = DB::table('tran_sport_data')
        ->where('id', '=', $id)
        ->get();

        return view('company.TransportEdit',['id'=>$id], compact('ts_detail'));

    }

    public function TransportUpdate(Request $request, $id){

        $agent_id = Auth::user()->user_id;

        DB::table('tran_sport_data')
        ->where('id', '=', $id)
        ->update([
            'ts_name' => $request->ts_name,
           'ts_address' => $request->ts_address,
           'ts_province' => $request->ts_province,
           'ts_amphur' => $request->ts_amphur,
           'ts_tambon' => $request->ts_tambon,
           'ts_zipcode' => $request->ts_zipcode,
           'ts_phone' => $request->ts_phone,
           'updated_at' => Carbon::now()
        ]);

        return redirect()->route('company_TransportList', ['id' => $agent_id])
        ->with('success', 'บันทึกข้อมูลสำเร็จ');
    }

    public function ListPlate ($id)
    {

        $ts_detail = DB::table('tran_sport_data')
        ->select('ts_name','ts_province','plate_top','plate_bottom','form_type_name','truck_data.created_at','truck_data.truck_id')
        ->leftJoin('truck_data', 'tran_sport_data.id' ,'=','truck_data.transport_id')
        ->leftJoin('form_types','truck_data.truck_type', '=','form_types.id')
        ->where('tran_sport_data.id', '=', $id)
        ->get();

        return view('company.TransportPlateList',['id'=>$id], compact('ts_detail'));
    }

    public function TypeChk ($id,$ts)
    {
        
        $form_list = DB::table('agent_form_lists')
        ->join('form_chks','agent_form_lists.form_id','=','form_chks.form_id')
        ->where('agent_form_lists.agent_id', '=', $id)
        ->get();

        return view('company.TransportTypeChk',['id'=>$id,'ts'=>$ts], compact('form_list'));
    }

    //ข้อมูลรถลงบริษัทขนส่ง
    public function NewTruck($id)
    {

        $transport_company = DB::table('tran_sport_data')
        ->where('id','=',$id)
        ->get();

        $truck_type = DB::table('form_types')
        ->orderBy('form_type_name','ASC')
        ->get();

        return view('company.TC_Create',['id'=>$id],compact('transport_company','truck_type'));

    }

    public function NewTruck2()
    {

        $transport_company = DB::table('tran_sport_data')
        ->orderBy('ts_name','ASC')
        ->get();

        $truck_type = DB::table('form_types')
        ->orderBy('form_type_name','ASC')
        ->get();

        return view('company.TC_Create2',compact('transport_company','truck_type'));

    }

    public function InsertTruck(Request $request,$ts)
    {

        if($request->plate_bottom == "")
        {
            $plate_bottom = '-';
        }else
        {
            $plate_bottom = $request->plate_bottom;
        }

        DB::table('truck_data')
        ->insert([
        'truck_id' => $request->truck_id,
        'transport_id' => $request->transport_id,
        'plate_top' => $request->plate_top,
        'plate_bottom' => $plate_bottom,
        'truck_type' => $request->truck_type,
        'date_truck_enroll' => $request->date_truck_enroll,
        'weight_max' => $request->weight_max,
        'weight_all' => $request->weight_all,
        'truck_insure_expired' => $request->truck_insure_expired,
        'truck_tax_expired' => $request->truck_tax_expired,
        'truck_product' => $request->truck_product,
        'truck_fuel' => $request->truck_fuel,
        'status_truck' => '1',
        'created_at' => Carbon::now()
        ]);

        return redirect()->route('company_ListPlate',['id'=>$ts])->with('success','บันทึกเรียบร้อยแล้ว');

    }
    
    public function DetailTruck($id)
    {
        $detail_truck = DB::table('truck_data')
        ->select('plate_top','plate_bottom','date_truck_enroll','weight_all','weight_max','truck_tax_expired','truck_insure_expired','truck_fuel','ts_name','form_type_name','truck_product.truck_product')
        ->join('tran_sport_data','truck_data.transport_id','=','tran_sport_data.id')
        ->join('form_types','truck_data.truck_type','=','form_types.id')
        ->join('truck_product','truck_data.truck_product','=','truck_product.rec_id')
        ->where('truck_data.truck_id','=',$id)
        ->get();

        return view('company.ViewTruck',['id'=>$id],compact('detail_truck'));
    }


 public function InsertTruck2(Request $request)
    {
        $ts = $request->transport_id;

        if($request->plate_bottom == "")
        {
            $plate_bottom = '-';
        }else
        {
            $plate_bottom = $request->plate_bottom;
        }

        DB::table('truck_data')
        ->insert([
        'truck_id' => $request->truck_id,
        'transport_id' => $request->transport_id,
        'plate_top' => $request->plate_top,
        'plate_bottom' => $plate_bottom,
        'truck_type' => $request->truck_type,
        'date_truck_enroll' => $request->date_truck_enroll,
        'weight_max' => $request->weight_max,
        'weight_all' => $request->weight_all,
        'truck_insure_expired' => $request->truck_insure_expired,
        'truck_tax_expired' => $request->truck_tax_expired,
        'truck_product' => $request->truck_product,
        'truck_fuel' => $request->truck_fuel,
        'status_truck' => '1',
        'created_at' => Carbon::now()
        ]);

        return redirect()->route('company_ListPlate',['id'=>$ts])->with('success','บันทึกเรียบร้อยแล้ว');

    }

    public function TruckList()
    {
        $truck_data = DB::table('truck_data')
        ->join('tran_sport_data','truck_data.transport_id','=','tran_sport_data.id')
        ->orderBy('truck_data.plate_top','ASC')
        ->get();

        return view('company.TruckList',compact('truck_data'));
    }
    
    
    
}
