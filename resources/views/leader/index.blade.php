@extends('layouts.leaderapp')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">เจ้าหน้าที่</div>
                    <div class="card-body">

                        @foreach ($user_detail as $item)
                            <div class="container text-center">

                                <div class="row">
                                    <div class="col-4">
                                        @if ($item->user_logo == '0')
                                            <img src="{{ asset('upload/no_img.jpg') }}" width="80px" alt="">
                                        @else
                                            <img src="{{ asset($item->user_logo) }}" width="80px" alt="">
                                        @endif
                                    </div>
                                    <div class="col-8">
                                        <h4>{{ $item->fullname }}</h4>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <hr>

                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingthree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapsethree" aria-expanded="false"
                                        aria-controls="flush-collapsethree">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('images/truck.png') }}" alt=""
                                                style="width: 45px; height: 45px" />
                                            <div class="ms-3">
                                                <p class="fw-bold mb-1">บริษัทขนส่ง</p>
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="flush-collapsethree" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingthree" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                              
                                            <li class="list-group-item">
                                                <a href="{{route('leader_TransportList',['id'=>Auth::user()->user_dep])}}" class="btn btn-sm btn-outline-primary">
                                                รายชื่อบริษัท</a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>


                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                        aria-controls="flush-collapseTwo">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('images/plate.png') }}" alt=""
                                                style="width: 45px; height: 45px" />
                                            <div class="ms-3">
                                                <p class="fw-bold mb-1">รายการทะเบียนรถ</p>
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                      <ul class="list-group list-group-flush">
                                       
                                      <li class="list-group-item">
                                        <a href="{{route('leader_listplatetotal')}}" class="btn btn-sm btn-outline-secondary">
                                        ทะเบียนรถทั้งหมด</a>
                                      </li>  
                                      
                                      <li class="list-group-item">
                                        <a href="{{route('leader_reportall',['id'=>'all'])}}" class="btn btn-sm btn-outline-primary">
                                        สรุปรายการตรวจเช็ค</a>
                                      </li>    
                                      
                                        </ul>
                                    </div>
                                </div>
                            </div>

                           <!-- <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseOne" aria-expanded="false"
                                        aria-controls="flush-collapseOne">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('images/checked.png') }}" alt=""
                                                style="width: 45px; height: 45px" />
                                            <div class="ms-3">
                                                <p class="fw-bold mb-1">รายงานการตรวจเช็ค</p>

                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                        @foreach ($form_list as $item)
                                        
                                      <li class="list-group-item">
                                        <a href="{{route('leader_listform',['form_id'=>$item->form_id,'type'=>$item->form_type])}}" class="btn btn-sm btn-outline-secondary">
                                        {{$item->form_name}}</a>
                                    </li>
                                           
                                        @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>-->
                           
                           
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
