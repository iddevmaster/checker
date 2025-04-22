@extends('layouts.app')

@section('content')
    @php
        $n = '1';
    @endphp
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @foreach ($formName as $row)
                        <div class="card-header fs-5 fw-bold">ตัวอย่างฟอร์ม :: {{ $row->form_name }}</div>
                    @endforeach
                    <div class="card-body">


                        <!----------------------------------->
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            @foreach ($formPreview as $row)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-heading{{ $loop->iteration }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#flush-collapse{{ $loop->iteration }}" aria-expanded="false"
                                            aria-controls="flush-collapse{{ $loop->iteration }}">
                                            @php
                                                echo 'หมวดหมู่ ' . $n++;
                                            @endphp
                                            {{ $row->category_name }}
                                        </button>
                                    </h2>

                                    @php
                                        $i = '1';
                                        $cate_id = $row->category_id;
                                        $sql2 = DB::table('form_choices')->where('category_id', '=', $cate_id)->get();
                                    @endphp

    <div id="flush-collapse{{ $loop->iteration }}" class="accordion-collapse collapse"
        aria-labelledby="flush-heading{{ $loop->iteration }}"
        data-bs-parent="#accordionFlushExample">
        <div class="accordion-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ข้อตรวจ</th>
                        <th>ภาพ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sql2 as $row2)
                        <tr>
                            <td>
                                @php
                                    echo $i++;
                                @endphp</td>
                            <td>{{ $row2->form_choice }}
                                @if ($row2->choice_remark != '')
                                    <br> ({{ $row2->choice_remark }})
                                @endif
                            </td>
                            <td>
                                @if ($row2->choice_img == '0')
                                    <img src="{{ asset('upload/no_img.jpg') }}"
                                        width="70px" alt="">
                                @else
                                    <img src="{{ asset('file/' . $row2->choice_img) }}"
                                        width="120px" alt="">
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!--------------------------------------------->



                      
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
