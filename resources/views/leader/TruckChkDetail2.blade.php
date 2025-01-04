@extends('layouts.leaderapp')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
           @php
           $truck_id = request()->truck;
               $plate_car = DB::table('truck_data')
               ->where('truck_id','=',$truck_id)
               ->value('plate_top');
           @endphp
             <a class="btn btn-sm btn-primary mb-2 printPage" id="printPage" href="#" target="_blank"><i class="las la-print"></i>
              พิมพ์</a>
                        @foreach ($form_data as $row)
                        <table class="table table-borderless">
                            
                            <tbody>
                              <tr>
                                <td align="center" width="15%">
                                    <img src="{{asset('images/tz_logo.png')}}" width="50%">
                                </td>
                                <td align="center" width="60%"><p class="fs-5"><strong>หน่วยงาน</strong> : {{$row->ts_name}} </p>
                                    <p class="fs-6"><strong> บันทึก (Record Form)</strong> : {{$row->form_name}} </p>
                                </td>
                                <td width="20%" align="center">
                                    <span style="font-size:12px">
                                    {{$row->form_code}}
                                </span>
                                </td>
                            
                              </tr>
                              
                            </tbody>
                          </table>
                          
                          <p><strong>ส่วนที่ 1 ข้อมูลเบื้องต้น</strong> (ครั้งที่ )</p>
                        <table class="table table-bordered">
                                                  
                            <tbody style="font-size: 14px">
                              <tr>
                                <td>ชื่อผู้ขับขี่ : {{$row->driver_prefix}}{{$row->driver_name}} {{$row->driver_lastname}} </td>
                                <td>วันที่ตรวจ :  {{ Carbon\Carbon::parse($row->created_at)->thaidate('d M Y') }}</td>
                                <td>บริษัทประกัน : {{$row->insure_name}} </td>
                                <td>เบอร์โทรศัพท์ : {{$row->driver_phone}} </td>
                              </tr>
                              <tr>
                              <td>ทะเบียน : {{$row->plate_top}} </td>
                              <td>ทะเบียนหาง : {{$row->plate_bottom}} </td>
                              <td>วันที่ประกันหมดอายุ : {{ Carbon\Carbon::parse($row->truck_insure_expired)->thaidate('d M Y') }}</td>
                              <td>ภาษีหมดอายุ : {{ Carbon\Carbon::parse($row->truck_tax_expired)->thaidate('d M Y') }} </td>
                              </tr>
                              <tr>
                                <td>บริษัท : {{$row->ts_name}} </td>
                                <td>วันที่จดทะเบียน : {{$row->date_truck_enroll}} </td>
                                <td>น้ำรถรวม : {{$row->weight_max}} </td>
                                <td>ชนิดเชื้อเพลิง: {{$row->truck_fuel}} </td>
                                </tr>
                            </tbody>
                          </table>

                          @endforeach
<p><strong>ส่วนที่ 2 รายการตรวจสมรรถนะของรถบรรทุก</strong></p>
@php
    $round_chk = request()->round;
@endphp
@foreach ($cate_data as $item)  
<table class="table table-bordered caption-top">
   <thead>
    <tr>
      <td width="50%" ><strong>{{ $loop->iteration }}. {{$item->category_name}} </strong>({{$plate_car}})</td>
      <td width="20%" style="font-weight: bold;" align="center" >ปกติ</td>
      <td width="10%" style="font-weight: bold;" align="center" >ไม่ปกติ</td>
      <td width="20%" style="font-weight: bold;" align="center" >สิ่งที่ตรวจพบ</td>
    </tr>
  </thead>
  <tbody>
@php
$cate_id = $item->category_id;
    $choice_name = DB::table('form_choices')    
    ->select('form_choice','chk_records.choice_img','user_chk','choice_remark')
    ->join('chk_records','form_choices.id','=','chk_records.choice_id')
    ->where('form_choices.category_id','=',$cate_id)
    ->where('chk_records.round_chk','=',$round_chk)
    ->get();
@endphp
@foreach ($choice_name as $row)
    <tr style="font-size: 14px">
      <td>{{$row->form_choice}}</td>
      <td align="center">
        @if ($row->user_chk == '1')
            /
        @elseif ($row->user_chk != '1' AND $row->user_chk != '0')
       อ่านค่าได้ <u>{{$row->user_chk}}</u> Kg/cm2 หรือ*100 kPa 
        @endif
      </td>
      <td align="center">
        @if ($row->user_chk == '0')
          /
        @endif
      </td>
      <td>
        @if ($row->choice_img != '0')
        <img src="{{ asset($row->choice_img) }}" width="100%">  <br>       
        @endif
       <span class="text-danger"> {{$row->choice_remark}} </span>
      </td>
    </tr>  
    @endforeach
  </tbody>
</table>
@endforeach

<div class="row">
  <div class="col-auto">
    <img src="{{asset('images/17248.png')}}" class="img-thumbnail" width="60%">
  </div>
</div>
<hr>
                          <!----ส่วนที่3----->
                          <p>({{$plate_car}}) <strong>ส่วนที่ 3 ผลการตรวจสอบสมรรถนะของรถบรรทุก </strong> </p>
                          <table class="table table-bordered caption-top">
                         
                           
                            <tbody>

                              @foreach ($chk_result as $item)   
                              <tr>
                                <td>                                   
                                  @if ($item->chk_result == '1')
                                  <span>  ปกติ อนุญาตให้ใช้งานได้ </span>
                                  @elseif ($item->chk_result == '2')
                                  <span class="text-primary"> ไม่ปกติ แต่สามารถปฏิบัติงานได้ </span>
                                  @elseif ($item->chk_result == '0')
                                <span class="text-danger">  ไม่ปกติ ไม่อนุญาตให้ใช้งาน </span>
                                  @endif
                                </td>                                
                              </tr>
                              
                              <tr style="font-size: 14px">
                                @if ($item->chk_result == '2')
                                <td>ผู้รับเหมาต้องนำรถบรรทุกไปซ่อมแซมและนำรถบรรทุกกลับมาตรวจสภาพ
                                ใหม่ ภายใน 7 วัน </td>
                                @elseif ($item->chk_result == '0' OR $item->chk_result == '1')
                                <td></td>
                                @endif
                              </tr>

                              <tr style="font-size: 14px">
                                @if ($item->chk_result == '0' OR $item->chk_result == '2')
                                <td>กำหนดระยะเวลาการตรวจใหม่ในวันที่ {{ Carbon\Carbon::parse($item->renew_chk_date)->thaidate('d M Y') }}</td>
                                @elseif ($item->chk_result == '1' )
                                <td>กำหนดระยะเวลาการตรวจใหม่ในวันที่ -</td>
                                @endif
                              
                              </tr>
                            
                            </tbody>
                            @endforeach

                          </table>
<hr>
 <!----ส่วนที่4----->
 <p>({{$plate_car}}) <strong>ส่วนที่ 4 ผู้ตรวจสภาพรถบรรทุก/พนักงานขับรถ </strong> </p>
 <table class="table table-borderless caption-top">   
    <tbody style="font-size: 14px">
      @foreach ($person_chk as $row)    
      <tr>
        <td width="50%">ผู้ตรวจ : {{$row->fullname}}</td>     
        <td width="50%">ลงชื่อผู้รับการตรวจ : ..............................................</td>  
      </tr>
      <tr>
        <td width="50%">วันที่ตรวจ : {{$row->date_chk}}</td>    
        <td width="50%">วันที่รับการตรวจ : ...................................................</td>   
      </tr>
      @endforeach
    </tbody>
  </table>
                   
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
