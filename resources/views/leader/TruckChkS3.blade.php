@extends('layouts.leaderapp')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
@php
$months = array(
'01' => 'มกราคม',
'02' => 'กุมภาพันธ์',
'03' => 'มีนาคม',
'04' => 'เมษายน',
'05' => 'พฤษภาคม',
'06' => 'มิถุนายน',
'07' => 'กรกฎาคม',
'08' => 'สิงหาคม',
'09' => 'กันยายน',
'10' => 'ตุลาคม',
'11' => 'พฤศจิกายน',
'12' => 'ธันวาคม'
);
$yearthai_start = 2563;
$yearthai_end = 2570;
$start_date = 1;
$end_date   = 31;
@endphp
                    <div class="card-header">สรุปผลการตรวจ</div>

                    <div class="card-body">
                             @foreach ($chk_detail as $item)                                
                               
                        <table class="table table-responsive">                           
                            <tbody>
                                <tr>
                                    <th scope="row" width="30%">บริษัทขนส่ง</th>
                                    <td> {{$item->ts_name}} </td>                                   
                                  </tr>
                                  <tr>
                                    <th scope="row">ประเภทรถ</th>
                                    <td> {{$item->form_type_name}} </td>
                                  </tr>
                              <tr>
                                <th scope="row">ทะเบียนหัว</th>
                                <td> {{$item->plate_top}} </td>
                              </tr>
                              <tr>
                                <th scope="row">ทะเบียนหาง</th>
                                <td> {{$item->plate_bottom}} </td>
                              </tr>
                              <tr>
                                <th scope="row">แบบฟอร์มตรวจ</th>
                                <td> {{$item->form_name}} </td>
                              </tr>
                              <tr>
                                <th class="text-primary"> สรุปผลการตรวจ </th>
                                <td >
<form action="{{route('leader_TruckInsert3')}}" method="POST">
            @csrf
<input type="hidden" name="round_id" value="{{request()->round}}">
<input type="hidden" name="tran_id" value="{{$item->transport_id}}">
<input type="hidden" name="truck_id" value="{{$item->truck_id}}">
<input type="hidden" name="form_id" value="{{$item->form_id}}">


                                    <select name="final_chk"  class="form-select " >
                                         <option value="1" class="text-success" selected>☑ ปกติ อนุญาตให้ใช้งานได้
                                         </option>
                                         <option value="2" class="text-secondary">☐ ไม่ปกติ แต่สามารถปฏิบัติงานได้</option>  
                                         <option value="0" class="text-danger">☒ ไม่ปกติ ไม่อนุญาตให้ใช้งาน</option>    
                                     </select>

                                </td>
                            </tr>

                            <tr>
                                <th>วันที่ตรวจ</th>
                                <td>
                                    <div class="row">
                                        <div class="col">
                                            <select name="date_chk" class="form-select">
                                                <option selected disabled>--วันที่</option>
                                                @for ($i = $start_date; $i <= $end_date; $i++)
                                                <option value="{{str_pad($i,2,0,STR_PAD_LEFT)}}">{{str_pad($i,2,0,STR_PAD_LEFT)}}</option>
                                                @endfor
                                              </select>
                                        </div>
                                        <div class="col">
                                            <select name="month_chk" class="form-select">
                                                <option selected disabled>--เดือน</option>
                                                @foreach ($months as $key => $value)
                                                <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                              </select>
                                        </div>
                                        <div class="col">
                                            <select class="form-select" name="yearth">
                                                <option selected disabled>--พ.ศ.</option>
                                                @for ($j = $yearthai_start; $j <= $yearthai_end; $j++)
                                                <option value="{{$j}}">{{$j}}</option>
                                                @endfor
                                              </select>
                                          </div>
                                      </div>
                                </td>
                            </tr>

                            <tr>
                                <td><strong>กำหนดระยะเวลาตรวจสภาพใหม่ วันที่</strong>
                                </td>
                                <td> 
                                    <input type="date" class="form-control" name="renew_chk_date">
                                </td>
                              </tr>

                            <tr>
                                <th>ผู้ตรวจ</th>
                                <td>
                                    {{Auth::user()->name}}
                                </td>
                            </tr>

                            <tr>
                               <td colspan="2" align="center">

                                <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
                            </form>
                               </td>
                            </tr>


                            </tbody>
                          </table>
                          @endforeach  




                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
