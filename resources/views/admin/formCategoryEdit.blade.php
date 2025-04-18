@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">แก้ไขหัวข้อหลัก</div>

                <div class="card-body">
                   
                    <form action="{{route('admin_CategoryUpdate',['id'=>request()->id])}}" method="post">
                        @csrf
                        @foreach ($CategoryEdit as $item)
                        <p>ชื่อฟอร์ม :: {{$item->form_name}}</p>
                        <input type="hidden" name="form_id" value="{{$item->form_id}}">
                        <div class="mb-3">
                          <label for="choiceEdit" class="form-label fw-bold">หัวข้อ</label>
                          <input type="text" class="form-control" id="category_name" name="category_name"
                          value="{{$item->category_name}}">                       
                        </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
                      </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
