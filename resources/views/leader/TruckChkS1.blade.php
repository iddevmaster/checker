@extends('layouts.leaderapp')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header fw-bold fs-4">ตรวจรถ ส่วนที่ 1</div>

                    <div class="card-body">
                        @foreach ($Chk_part1 as $item)
                            <table class="table table-responsive">
                                <tbody>
                                    <tr>
                                        <th scope="row" width="30%">บริษัทขนส่ง</th>
                                        <td> {{ $item->ts_name }} </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">ทะเบียนหัว</th>
                                        <td> {{ $item->plate_top }} </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">ทะเบียนหาง</th>
                                        <td> {{ $item->plate_bottom }} </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">แบบฟอร์มตรวจ</th>
                                        <td> {{ $item->form_name }} </td>
                                    </tr>
                                </tbody>
                            </table>


                            <form action="{{ route('leader_ChkPart1', ['truckid' => request()->id]) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="form_id" value="{{ $item->form_id }}">
                                <input type="hidden" name="transport_id" value="{{ $item->transport_id }}">
                        @endforeach

                        
                            <div class="mb-3">                              
                                <label class="form-label">ชื่อผู้ขับขี่<span class="text-danger">*</span> </label>
                                <div class="row">

                                <div class="col-md-4">
                                    <input class="form-control" list="datalistOptions" id="driver_prefix" name="driver_prefix" placeholder="ระบุคำนำหน้า.." required>
                                    <datalist id="datalistOptions">
                                        <option value="นาย" selected>
                                        <option value="นางสาว">
                                        <option value="นาง">
                                    </datalist>
                                </div>

                                <div class="col-md-4">
                                    <input class="form-control" type="text" name="driver_name" required placeholder="ชื่อจริง">
                                </div>

                                <div class="col-md-4">
                                  <input class="form-control" type="text" name="driver_lastname" required placeholder="นามสกุล">
                              </div>

                            </div>
                        </div>  


                        <div class="mb-3">
                            <label class="form-label">เบอร์โทรศัพท์ผู้ขับขี่ </label>
                            <input class="form-control" type="text" name="driver_phone" maxlength="10">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">เลขที่ใบขับขี่ </label>
                            <input class="form-control" type="text" name="driver_id">
                        </div>



                        <div class="mb-3">
                            <label class="form-label">ชื่อบริษัทประกัน </label>
                            <input class="form-control" type="text" name="insure_name">
                        </div>
                        <hr>

                        <div class="mb-3">
                            <label class="form-label">รูปถ่ายรถ ภาพที่ 1<span class="text-danger">*</span> </label>
                            <input class="form-control" type="file" name="img_1" id="formFile" accept="image/*"
                                required>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">รูปถ่ายรถ ภาพที่ 2<span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="img_2" id="formFile" accept="image/*"
                                required>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">รูปถ่ายรถ ภาพที่ 3<span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="img_3" id="formFile" accept="image/*"
                                required>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">รูปถ่ายรถ ภาพที่ 4<span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="img_4" id="formFile" accept="image/*"
                                required>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">รูปถ่ายรถ ภาพที่ 5</label>
                            <input class="form-control" type="file" name="img_5" id="formFile" accept="image/*">
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">รูปถ่ายรถ ภาพที่ 6</label>
                            <input class="form-control" type="file" name="img_6" id="formFile" accept="image/*">
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">รูปถ่ายรถ ภาพที่ 7</label>
                            <input class="form-control" type="file" name="img_7" id="formFile" accept="image/*">
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">รูปถ่ายรถ ภาพที่ 8</label>
                            <input class="form-control" type="file" name="img_8" id="formFile" accept="image/*">
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-success">บันทึก</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
