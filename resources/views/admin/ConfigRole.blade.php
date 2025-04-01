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
                                    <th colspan="3">สิทธิ์การใช้งาน</th>
                                </tr>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">สิทธิ์</th>
                                    <th scope="col">ตั้งค่า</th>
                                </tr>
                            </thead>
                            <tbody>
                               <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                               </tr>
                            </tbody>
                        </table>


                        <hr>
                        <h5>เลือกสิทธิ์</h5>
                        <form action="#" method="POST">
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
