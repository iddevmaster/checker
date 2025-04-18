@extends('layouts.app')

@section('content')
    @php
        $i = '1';
    @endphp
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    @foreach ($categoryName as $row)
                        <div class="card-header">หัวข้อ :: {{ $row->category_name }}</div>
                    @endforeach


                    <div class="card-body">
                        <p><a href="{{ route('admin_AddChoice', ['id' => request()->id]) }}"
                                class="btn btn-sm btn-info">เพิ่มข้อตรวจ</a></p>

                        <table class="table table-bordered table-hover">
                            <thead>
                                <th>ที่</th>
                                <th>ภาพ</th>
                                <th width="30%">ข้อตรวจ</th>
                                <th width="30%">ประเภทตัวเลือก</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($category_choice as $item)
                                    <tr>
                                        <td>@php
                                            echo $i++;
                                        @endphp</td>
                                        <td>  
                                              @if ($item->choice_img == '0')
                                            <img src="{{ asset('upload/no_img.jpg') }}" width="70px" alt="">
                                        @else
                                            <img src="{{ asset('file/'.$item->choice_img) }}" width="120px" alt="">
                                        @endif
                                    </td>
                                        <td>{{ $item->form_choice }}</td>
                                        <td>
                                            @if ($item->choice_type == '1')
                                    ข้อความ
                                @elseif($item->choice_type == '2')
                                    วันที่ (ค.ศ.)
                                @elseif($item->choice_type == '3')
                                วันที่ (พ.ศ.)
                                @elseif($item->choice_type == '4')
                                ตัวเลข
                                @elseif($item->choice_type == '5')
                                ตัวเลือก (ผ่าน/ไม่ผ่าน)
                                @elseif($item->choice_type == '6')
                                ตัวเลือก (น้ำมัน/NGV)
                                @elseif($item->choice_type == '7')
                                ตัวเลือก (ประเภทสินค้า ปูนผง/ปูนเม็ด/ปูงถุง)
                                @endif
                                        </td>
                                        <td>
                                           
                                                <a href="{{ route('admin_ChoiceEdit', ['id' => $item->id]) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="las la-pen"></i>
                                                </a>

                                                <a href="{{ route('admin_ChoiceEditPic', ['id' => $item->id]) }}"
                                                    class="btn btn-sm btn-success">
                                                    <i class="las la-image"></i>
                                                </a>

                                                <a href="{{ route('admin_ChoiceDelete', ['id' => $item->id , 'cid'=>$item->category_id]) }}" class="btn btn-sm btn-danger" onclick="return confirm('ยืนยันการลบหรือไม่?')">
                                                    <i class="las la-trash-alt"></i>
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

