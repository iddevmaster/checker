@extends('layouts.app')

@section('content')
@php
    $i = '1';
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">  
                @foreach ($formName as $row) 
                <h4 class="card-header text-center">ชื่อฟอร์ม :: {{$row->form_name}}</h4>

                <div class="card-body">
                        
                    <a href="{{route('admin_formPreview',['id'=>$row->form_id])}}" class="btn  btn-outline-success">
                        <i class="las la-clipboard-check"></i> ตัวอย่างฟอร์ม
                    </a>
                    @endforeach
                    <table class="table table-hover mt-2">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">ชื่อหัวข้อ</th>
                            <th scope="col">ตั้งค่า</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($formDetail as $item)
                          <tr>
                            <th scope="row">@php
                                echo $i++;
                            @endphp</th>
                            <td><a class="text-decoration-none" href="{{route('admin_formDetailChoice',['id'=>$item->category_id])}}">{{$item->category_name}}</a></td>
                            <td>  
                                 <div class="btn-group btn-group-sm" role="group" >
                                    <a href="{{route('admin_formDetailChoice',['id'=>$item->category_id])}}" class="btn btn-success" >เพิ่มข้อตรวจ</a>
                                <a href="{{route('admin_CategoryEdit',['id'=>$item->category_id])}}" class="btn btn-warning"                             
                                >แก้ไขชื่อหัวข้อ</a>
                                <a href="{{ route('admin_CategoryDelete', ['cid' => $item->category_id , 'form_id'=>$item->form_id]) }}" class="btn btn-danger" onclick="return confirm('ข้อตรวจในหัวข้อหลักจะถูกลบไปด้วย ยืนยันการลบหรือไม่?')"
                                >ลบหัวข้อ</i>
                                </a>
                            </div>
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
