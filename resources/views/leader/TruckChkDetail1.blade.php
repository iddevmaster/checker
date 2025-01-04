@extends('layouts.leaderapp')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-body">
                        <p class="fw-bold fs-4 text-center">สรุปรายงาน {{ $detail_part1->form_name }}</p>


                        <table class="table">
                            <tbody>


                                <tr>
                                    <td scope="row" width="50%"><strong>ทะเบียนหัว </strong>: {{ $detail_part1->plate_top }}
                                        /<strong> ทะเบียนหาง</strong> : {{ $detail_part1->plate_bottom }}

                                    </td>
                                    <td><strong>ประเภทรถ</strong> : {{ $detail_part1->form_type_name }}</td>

                                </tr>
                                <tr>
                                    <td scope="row" width="50%"><strong>ชื่อผู้ขับขี่ </strong>: {{ $detail_part1->driver_prefix }} {{ $detail_part1->driver_name }} {{ $detail_part1->driver_lastname }}

                                    </td>
                                    <td><strong>เบอร์โทรศัพท์</strong> : {{ $detail_part1->driver_phone }}</td>

                                </tr>
                                <tr>
                                    <td><strong>เลขที่ใบขับขี่</strong> : {{ $detail_part1->driver_id }}</td>
                                    <td scope="row" width="50%"><strong>บริษัทประกัน </strong>: {{ $detail_part1->insure_name }}

                                    </td>
                                 

                                </tr>
                                <tr>
                                    <td scope="row"><strong>ตรวจรถโดย</strong> : {{ Auth::user()->name }} </td>
                                    <td><strong>ตรวจครั้งที่</strong> : {{ $detail_part1->chk_round }}</td>

                                </tr>
                                <tr>
                                    <td scope="row"><strong>บริษัทขนส่ง</strong> : {{ $detail_part1->ts_name }}</td>
                                    <td><strong>วันที่ตรวจ</strong></td>

                                </tr>

                            </tbody>
                        </table>
                        <p class="fs-5 fw-bold">ภาพถ่ายรถ</p>


    <table class="table table-responsive">
        <tbody>


            <tr>
                <td>ภาพที่ 1
                    <br>
                    @if ($detail_part1->img_1 == '0')
                        <img class="img-thumbnail" src="{{ asset('upload/no_img.jpg') }}" width="100px" height="100px">
                    @else
                    <a href="{{ asset('upload/truckchk/' . $detail_part1->img_1)}}" data-lightbox="{{$detail_part1->img_1}}" >
                        <img class="img-thumbnail" src="{{ asset('upload/truckchk/' . $detail_part1->img_1) }}" width="100%">
                    </a>
                    @endif

                </td>
                <td>ภาพที่ 2
                    <br>
                    @if ($detail_part1->img_2 == '0')
                        <img class="img-thumbnail" src="{{ asset('upload/no_img.jpg') }}" width="100px" height="100px">
                    @else
                    <a href="{{ asset('upload/truckchk/' . $detail_part1->img_2)}}" data-lightbox="{{$detail_part1->img_2}}" >
                        <img class="img-thumbnail" src="{{ asset('upload/truckchk/' . $detail_part1->img_2) }}" width="100%">
                    </a>
                    @endif
                </td>
                <td>ภาพที่ 3
                    <br>
                    @if ($detail_part1->img_3 == '0')
                        <img class="img-thumbnail" src="{{ asset('upload/no_img.jpg') }}" width="100px" height="100px">
                    @else
                    <a href="{{ asset('upload/truckchk/' . $detail_part1->img_3)}}" data-lightbox="{{$detail_part1->img_3}}" >
                        <img class="img-thumbnail" src="{{ asset('upload/truckchk/' . $detail_part1->img_3) }}" width="100%">
                    </a>
                    @endif
                </td>
                <td>ภาพที่ 4
                    <br>
                    @if ($detail_part1->img_4 == '0')
                        <img class="img-thumbnail" src="{{ asset('upload/no_img.jpg') }}" width="100px" height="100px">
                    @else
                    <a href="{{ asset('upload/truckchk/' . $detail_part1->img_4)}}" data-lightbox="{{$detail_part1->img_4}}" >
                        <img class="img-thumbnail" src="{{ asset('upload/truckchk/' . $detail_part1->img_4) }}" width="100%">
                    </a>
                    @endif
                </td>
            </tr>

            <tr>
                <td>ภาพที่ 5
                    <br>
                    @if ($detail_part1->img_5 == '0')
                        <img class="img-thumbnail" src="{{ asset('upload/no_img.jpg') }}" width="100px" height="100px">
                    @else
                    <a href="{{ asset('upload/truckchk/' . $detail_part1->img_5)}}" data-lightbox="{{$detail_part1->img_5}}" >
                        <img class="img-thumbnail" src="{{ asset('upload/truckchk/' . $detail_part1->img_5) }}" width="100%">
                    </a>
                    @endif
                </td>
                <td>ภาพที่ 6
                    <br>
                    @if ($detail_part1->img_6 == '0')
                        <img class="img-thumbnail" src="{{ asset('upload/no_img.jpg') }}" width="100px" height="100px">
                    @else
                    <a href="{{ asset('upload/truckchk/' . $detail_part1->img_6)}}" data-lightbox="{{$detail_part1->img_6}}" >
                        <img class="img-thumbnail" src="{{ asset('upload/truckchk/' . $detail_part1->img_6) }}" width="100%">
                    </a>
                    @endif
                </td>
                <td>ภาพที่ 7
                    <br>
                    @if ($detail_part1->img_7 == '0')
                        <img class="img-thumbnail" src="{{ asset('upload/no_img.jpg') }}" width="100px" height="100px">
                    @else
                    <a href="{{ asset('upload/truckchk/' . $detail_part1->img_7)}}" data-lightbox="{{$detail_part1->img_7}}" >
                        <img class="img-thumbnail" src="{{ asset('upload/truckchk/' . $detail_part1->img_7) }}" width="100%">
                    </a>
                    @endif
                </td>
                <td>ภาพที่ 8
                    <br>
                    @if ($detail_part1->img_8 == '0')
                        <img class="img-thumbnail" src="{{ asset('upload/no_img.jpg') }}" width="100px" height="100px">
                    @else
                    <a href="{{ asset('upload/truckchk/' . $detail_part1->img_8)}}" data-lightbox="{{$detail_part1->img_8}}" >
                        <img class="img-thumbnail" src="{{ asset('upload/truckchk/' . $detail_part1->img_8) }}" width="100%">
                    </a>
                    @endif
                </td>
            </tr>


        </tbody>
    </table>
    <div class="d-grid gap-2 col-6 mx-auto">
    <a href="{{route('leader_TruckChkDetail2',['round'=>request()->round,'truck'=>request()->truck])}}" class="btn btn-success">ถัดไป <i class="las la-angle-double-right"></i></a>
    </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <script>
        $('a.printPage').click(function() {
            $('#report-summary').show();
            window.print();
            return false;
        });
    </script>
@endsection
