@extends('layouts.app')

@section('content')
    @php
        $i = '1';
    @endphp
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">

                 <h4 class="card-header text-center">สิทธิ์การใช้งาน :: {{ $roleName->role_name }} </h4>

                    <div class="card-body">

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ฟอร์ม</th>
                                    <th scope="col">ตั้งค่า</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roleDetail as $item)
                                    <tr>

                                        <th scope="row">
                                            @php
                                                echo $i++;
                                            @endphp
                                        </th>

                                        <td>
                                            <a href="{{ route('admin_formDetail', ['id' => $item->form_id]) }}"
                                            class="text-decoration-none"> 
                                                {{ $item->form_name }}
                                            </a>
                                        </td>

                                        <td>
                                            <a class="btn btn-sm btn-danger" href="#" role="button">
                                                นำออก
                                            </a>
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
