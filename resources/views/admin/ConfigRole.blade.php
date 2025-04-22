@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-body">

                        @foreach ($agent as $row)
                            <h3>หน่วยงาน : {{ $row->fullname }}</h3>
                        @endforeach
                        <hr>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="3">หมวดหมู่การใช้งาน</th>
                                </tr>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">หมวดหมู่</th>
                                    <th scope="col">ตั้งค่า</th>
                                </tr>
                            </thead>
                            <tbody>  
                                <form action="{{route('admin_UnlistRole')}}" method="POST">
                                @csrf
                                @foreach ($role_agent_list as $data)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $data->role_name }}</td>
                                    <td>
                                    @method('DELETE')
                            <input type="hidden" name="user_id" value="{{ $data->user_id }}">
                            <input type="hidden" name="company_role" value="{{ $data->company_role }}">
                            <button class="btn btn-sm btn-outline-danger" 
                            onclick="return confirm('ต้องการนำหมวดหมู่ออก ใช่หรือไม่?');"
                            type="submit">นำออก</button>                        
                                    </td>
                                </tr>
                            @endforeach
                        </form>
                            </tbody>
                        </table>
                        
                        <hr>
                        <h5>เลือกสิทธิ์</h5>

                        <form action="{{ route('admin_InsertConfigRole', ['id' => request()->id]) }}" method="POST">
                            @csrf
                            @foreach ($role_list as $item)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="{{ $item->id }}"
                                        name="role_chk[]" value="{{ $item->id }}">
                                    <label class="form-check-label" for="{{ $item->id }}">
                                        {{ $item->role_name }}
                                    </label>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-success">บันทึก</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
