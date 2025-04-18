@extends('layouts.app')

@section('content')
    @php
        $i = '1';
    @endphp
    
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                 <h4 class="card-header text-center">นำเข้าฟอร์ม หมวดหมู่ :: {{ $roleName->role_name }}</h4>


                    <div class="card-body">

                        <p class="mb-4">
                            <a href="{{route('admin_roleDetail', ['id' => $roleName->id])}}" class="btn btn-warning btn-sm"><i class="las la-arrow-left"></i> ย้อนกลับ</a>
                        </p>

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ฟอร์ม</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($listform as $data)                                 
                               
                                    <tr>

                                        <th scope="row">
                                            @php
                                                echo $i++;
                                            @endphp
                                        </th>

                                        <td>
                                          {{$data->form_name}}
                                        </td>

                                        <td>
         <a href="{{ route('admin_roleaddform', ['role' => request()->role, 'form' => $data->form_id]) }}"" class="btn btn-sm btn-success"><i class="las la-download"></i> นำเข้า</a>
                                        </td>

                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
