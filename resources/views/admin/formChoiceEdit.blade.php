@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">แก้ไขข้อตรวจ</div>

                <div class="card-body">
                   
                    <form action="{{route('admin_ChoiceUpdate',['id'=>request()->id])}}" method="post">
                        @csrf
                        @foreach ($ChoiceEdit as $item)
                        <p class="fs-5 fw-bold">หัวข้อตรวจ :: {{$item->category_name}}</p>
                        <input type="hidden" name="cate_id" value="{{$item->category_id}}">
                        <div class="mb-3">
                          <label for="choiceEdit" class="form-label fw-bold">ข้อตรวจ</label>
                          <input type="text" class="form-control" id="choiceEdit" name="choiceEdit"
                          value="{{$item->form_choice}}">                       
                        </div>
                        <div class="mb-3">
                            <label for="choice_remark" class="form-label fw-bold">หมายเหตุ/ข้อแนะนำ</label>
                            <input type="text" class="form-control" id="choice_remark" name="choice_remark"
                            value="{{$item->choice_remark}}">                       
                          </div>
                        <div class="mb-3">
                            <label for="choiceEdit" class="form-label fw-bold">ประเภทตัวเลือก</label>
                            <select class="form-select" name="choice_type"  >
                                <option selected value="{{$item->choice_type}}">-
                                @if ($item->choice_type == '1')
                                    ข้อความ
                                @elseif($item->choice_type == '2')
                                    วันที่ (ค.ศ.)
                                @elseif($item->choice_type == '3')
                                วันที่ (พ.ศ.)
                                @elseif($item->choice_type == '4')
                                ตัวเลข
                                @elseif($item->choice_type == '5')
                                ตัวเลือก (ปกติ/ไม่ปกติ)
                                @elseif($item->choice_type == '6')
                                ตัวเลือก (น้ำมัน/NGV)
                                @elseif($item->choice_type == '7')
                                ตัวเลือก (ประเภทสินค้า ปูนผง/ปูนเม็ด/ปูงถุง)
                                @endif</option>
                                <option value="1">ข้อความ</option>
                                <option value="2">วันที่ (ค.ศ.)</option>
                                <option value="3">วันที่ (พ.ศ.)</option>
                                <option value="4">ตัวเลข</option>
                                <option value="5">ตัวเลือก (ปกติ/ไม่ปกติ)</option>
                                <option value="6">ตัวเลือก (น้ำมัน/NGV)</option>
                                <option value="7">ตัวเลือก (ประเภทสินค้า ปูนผง/ปูนเม็ด/ปูงถุง)</option>
                              </select>
                                               
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
