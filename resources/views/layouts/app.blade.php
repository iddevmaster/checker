<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>E-Checker By ID Drives</title>

    <!-- Fonts -->
    <link rel= "stylesheet"
        href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css" />
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('favicon.png') }}">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm" style="background-color: #45474B;">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                 @if (Auth::user()->role == 'company')
@php
$agent_id = Auth::user()->user_id;
$company_logo = DB::table('user_details')                            
    ->where('user_details.user_id', '=', $agent_id)
    ->get();
@endphp
@foreach ($company_logo as $data)
    @if ($data->user_logo != '0')
    <img src="{{ asset($data->user_logo) }}" alt="..." height="60px">
    @elseif ($data->user_logo == '0')
    <img src="{{ asset('images/logo_id.png') }}" alt="..." height="60px">
    @endif
@endforeach
               

                    @elseif (Auth::user()->role == 'admin')

                    <img src="{{ asset('images/logo_id.png') }}" alt="..." height="60px">

                    @elseif (Auth::user()->role == 'leader')
                    @php
                    $agent_id = Auth::user()->user_dep;
                    $company_logo = DB::table('user_details')                            
                        ->where('user_details.user_id', '=', $agent_id)
                        ->get();
                    @endphp
                    @foreach ($company_logo as $data)
                        @if ($data->user_logo != '0')
                        <img src="{{ asset($data->user_logo) }}" alt="..." height="60px">
                        @elseif ($data->user_logo == '0')
                        <img src="{{ asset('images/logo_id.png') }}" alt="..." height="60px">
                        @endif
                    @endforeach
                  

                    @elseif (Auth::user()->role == 'user')

                    <img src="{{ asset('images/logo_id.png') }}" alt="..." height="60px">
                    @endif

                    
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @if (Auth::user()->role == 'admin')
                            <li class="nav-item">
                                <a class="btn btn-sm btn-outline-secondary nav-link" aria-current="page"
                                    href="{{ route('admin_index') }}"><i class="las la-home"></i> หน้าหลัก</a>
                            </li>
                            <li class="nav-item">
                                <a class=" btn btn-sm btn-outline-secondary nav-link"
                                    href="{{ route('admin_Userlist') }}"> <i class="las la-user"></i> รายชื่อผู้ใช้</a>
                            </li>

                            <li class="nav-item">
                                <a class=" btn btn-sm btn-outline-secondary nav-link"
                                    href="{{ route('admin_ListRole') }}"><i class="las la-list-alt"></i> สิทธิ์การใช้งาน</a>
                            </li>

                            <li class="nav-item">
                                <a class="btn btn-sm btn-outline-secondary nav-link"
                                    href="{{ route('admin_form') }}"><i class="las la-file-alt"></i> ฟอร์ม</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="las la-cog"></i> 
                                    Config
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark"
                                    aria-labelledby="navbarDarkDropdownMenuLink">
                                    <li><a class="dropdown-item" href="#">Dashboard</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </li>
                        @elseif (Auth::user()->role == 'user')
                            <li class="nav-item">
                                <a class="btn btn-sm btn-outline-secondary nav-link" aria-current="page"
                                    href="{{ route('user_index') }}"> <i class="las la-home"></i> Home</a>
                            </li>

                         
                              
                        @elseif (Auth::user()->role == 'company')
                            <li class="nav-item">
                                <a class="btn btn-sm btn-outline-secondary nav-link" aria-current="page"
                                    href="{{ route('company_index') }}"> <i class="las la-home"></i> หน้าหลัก</a>
                            </li>
                            @elseif (Auth::user()->role == 'leader')
                            <li class="nav-item">
                                <a class="btn btn-sm btn-outline-secondary nav-link" aria-current="page"
                                    href="{{ route('leader_index') }}"> <i class="las la-home"></i> หน้าหลัก</a>
                            </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre> <i class="las la-user-circle"></i>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @include('layouts.footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @if (Session::has('success'))
        <script>
            Swal.fire(
                'สำเร็จ!',
                '{{ Session::get('success') }}',
                'success'
            )
        </script>
    @endif


    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script>
        $(function() {
            $("#dataTables").DataTable({
                "pageLength": 25,
                "language": {
                    "info": "แสดงผล _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                    "search": "ค้นหา:",
                    "lengthMenu": "แสดงผล _MENU_ รายการ",
                    "zeroRecords": "ไม่พบข้อมูล",
                    "paginate": {
                        "next": "ถัดไป",
                        "previous": "ก่อนหน้า"
                    }
                }
            });
        });
    </script>
 
</body>

</html>
