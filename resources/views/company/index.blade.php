@extends('layouts.companyapp')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">หน่วยงาน/องค์กร</div>
                    <div class="card-body">

                        @foreach ($user_detail as $item)
                            <div class="container text-center">
                                <div class="row">
                                    <div class="col-4">
                                        @if ($item->user_logo == '0')
                                            <img src="{{ asset('upload/no_img.jpg') }}" width="80px" alt="">
                                        @else
                                            <img src="{{ asset($item->user_logo) }}" height="50px" alt="">
                                        @endif
                                    </div>
                                    <div class="col-8">
                                        <h4>{{ $item->fullname }}</h4>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="row mt-2">
                            <!--Role-->
                            @foreach ($company_role as $row)
                                <div class="col col-md-6 mt-2">
                                    <a href="{{route('company_productlist',['role' => $row->id ,'add'=>'none'])}}" class="text-decoration-none">
                                        <div class="card">
                                            <div class="card-body">
                                                <img src="{{ asset('images/checklist.png') }}"
                                                    style="width: 35px; height: 35px" />
                                                {{ $row->role_name }}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                            <!--EndRole-->
                        </div>

                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <!-------------------------------->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingTruck">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseTruck" aria-expanded="false"
                                        aria-controls="flush-collapseTruck">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('images/truck.png') }}" alt=""
                                                style="width: 45px; height: 45px" />
                                            <div class="ms-3">
                                                <p class="fw-bold mb-1">บริษัทผู้ขนส่ง/ทะเบียนรถ</p>
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="flush-collapseTruck" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingTruck" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">

                                        <ul class="list-group list-group-flush">

                                            <li class="list-group-item">
                                                <a href="{{ route('company_TransportList', ['id' => Auth::user()->user_id]) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    รายชื่อบริษัท</a>
                                                <a href="{{ route('company_TransportCreate') }}"
                                                    class="btn btn-sm btn-outline-success">
                                                    เพิ่มบริษัทใหม่</a>
                                            </li>
                                            <li class="list-group-item">
                                                <a href="{{ route('company_trucklist') }}" class="btn btn-sm btn-primary">
                                                    รายการทะเบียนรถ</a>
                                                <a href="{{ route('company_newtruck2') }}" class="btn btn-sm btn-success">
                                                    เพิ่มรถใหม่</a>
                                            </li>

                                        </ul>

                                    </div>
                                </div>
                            </div>
                            <!-------------------------------->

                            <div class="accordion-item">
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
                                                    <a href="{{ route('company_reportlist', ['form' => $item->form_id]) }}"
                                                        class="btn btn-sm btn-outline-secondary">
                                                        {{ $item->form_name }}</a>
                                                </li>
                                            @endforeach
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
                                            <img src="{{ asset('images/user.png') }}" alt=""
                                                style="width: 45px; height: 45px" />
                                            <div class="ms-3">
                                                <p class="fw-bold mb-1">บัญชีผู้ใช้</p>

                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <a href="{{ route('company_listuser', ['type' => 'user']) }}">
                                                    ผู้ใช้ทั่วไป/ผู้เรียน </a>
                                            </li>
                                            <li class="list-group-item">
                                                <a href="{{ route('company_listuser', ['type' => 'leader']) }}">
                                                    เจ้าหน้าที่/หัวหน้าฝ่าย </a>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
