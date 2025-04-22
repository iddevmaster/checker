@extends('layouts.companyapp')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <h4 class="card-header text-center">หมวดหมู่ ::
                       
                            {{ $role_data->role_name }}
                       
                    </h4>
                    <div class="card-body">
                        @if(request()->add == 'none')

                        <a class="btn btn-outline-secondary mb-2" 
                        href="{{  route('company_productlist',['role' => request()->role ,
                        'add'=>$role_data->form_type])}}" role="button">เพิ่มข้อมูล</a>
                       
                                <table class="table table-responsive cell-border" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th>รหัสอุปกรณ์</th>
                                            <th>ชื่อ</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>*</td>
                                            <td>**</td>
                                            <td>***</td>
                                            <td>****</td>
        
                                        </tr>
                                    </tbody>
                                </table>
                                
                                @elseif (request()->add == '15')
                                
                                    @include('company.NewProduct')

                                @endif                                                        
                                           
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
