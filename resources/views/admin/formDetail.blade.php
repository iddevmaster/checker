@extends('layouts.app')

@section('content')
@php
    $i = '1';
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">  
         
                <div class="card-body">
                   @foreach ($formName as $row)       
                    <p style="#">ชื่อฟอร์ม :: {{$row->form_name}}</p>
                    <a href="{{route('admin_formPreview',['id'=>$row->form_id])}}" class="btn btn-sm btn-outline-success">
                        <i class="las la-clipboard-check"></i> ตัวอย่างฟอร์ม
                    </a>
                    @endforeach
                    <table class="table table-hover">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">ชื่อหมวดหมู่</th>
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
                                    
                                <a href="{{route('admin_CategoryEdit',['id'=>$item->category_id])}}" class="btn btn-warning"
                                data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                                    data-bs-title="แก้ไขหมวดหมู่"
                                ><i class="las la-pen"></i></a>
                                <a href="{{ route('admin_CategoryDelete', ['cid' => $item->category_id , 'form_id'=>$item->form_id]) }}" class="btn btn-danger" onclick="return confirm('ข้อตรวจในหมวดหมู่จะถูกลบไปด้วย ยืนยันการลบหรือไม่?')"
                                data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                                    data-bs-title="ลบหมวดหมู่" >
                                    <i class="las la-trash-alt"></i>
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
