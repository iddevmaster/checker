@extends('layouts.leaderapp')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">รายการทะเบียนรถทั้งหมด</div>
                    <div class="card-body">
                        <p class="fw-bold">สถานะผลการตรวจ</p>
                        <div class="btn-group btn-group-sm mb-3" role="group" >
                            <a href="{{route('leader_reportall',['id'=>'all'])}}" class="btn btn-outline-success">ทั้งหมด</a>
                            <a href="{{route('leader_reportall',['id'=>'1'])}}" class="btn btn-outline-primary">ปกติ</a>
                            <a href="{{route('leader_reportall',['id'=>'2'])}}" class="btn btn-outline-secondary">ไม่ปกติ แต่สามารถใช้งานได้</a>
                            <a href="{{route('leader_reportall',['id'=>'0'])}}" class="btn btn-outline-danger">ไม่ปกติ ไม่อนุญาตให้ใช้งาน</a>
                          </div>
                       
                        <table class="table table-responsive cell-border" id="dataTables">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th width="20%">ทะเบียนหัว</th>
                                    <th>ทะเบียนหาง</th>
                                    <th scope="col">สรุปผลการตรวจ</th>
                                    <th>วันที่ตรวจ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($chk_truck as $item)    
                               <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a href="{{route('leader_TruckChkDetail1',['round'=>$item->round_id,'truck'=>$item->truck_id])}}" class="text-decoration-none">
                                    {{$item->plate_top}}
                                    </a>
                                </td>
                                <td>{{$item->plate_bottom}}</td>
                                <td>
                                    @if ($item->chk_result == '1')
                                    <span class="text-success">  ปกติ อนุญาตให้ใช้งานได้ </span>
                                    @elseif ($item->chk_result == '2')
                                    <span class="text-secondary"> ไม่ปกติ แต่สามารถปฏิบัติงานได้ </span>
                                    @elseif ($item->chk_result == '0')
                                  <span class="text-danger">  ไม่ปกติ ไม่อนุญาตให้ใช้งาน </span>
                                    @endif
                                </td>
                                <td>{{$item->date_chk}}</td>
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
