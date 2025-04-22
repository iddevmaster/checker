<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CompanyProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:company');
    }

    public function ProductList($role,$add)
    {
        $user_id = Auth::user()->user_id;

        $role_data = DB::table('company_role')
        ->join('role_forms','company_role.company_role','=','role_forms.role_id')
        ->join('role','company_role.company_role','=','role.id')
        ->join('form_chks','role_forms.form_id','=','form_chks.form_id')
        ->select('role.role_name','form_chks.form_name','role.id','form_chks.form_id','form_chks.form_type')
        ->where('company_role.user_id','=',$user_id)
        ->where('role.id','=',$role)
        ->groupBy('company_role.company_role')
        ->first();

        return view('company.ProductList', compact('role_data'));
    }   


}
