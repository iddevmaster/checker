@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">สร้างฟอร์มใหม่</div>

                    <div class="card-body">
                   

    <form method="POST" action="{{ route('admin_insert_form') }}">
                            @csrf
                            @foreach ($data_form as $data)
                                <div class="mb-2 mt-2">
                                    <label for="form_name" class="fw-bold form-label">ชื่อฟอร์ม : {{ $data->form_name }}</label>
                                </div>
                            @endforeach
                            <div class="mb-3">
                                <label for="form_name" class="fw-bold form-label">สิทธิ์การใช้งาน </label>
                                <ul>
                                    @foreach ($data_role as $store)
                                        <li> {{ $store->role_name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <input type="hidden" name="form_id" id="form_id" value="{{ request()->id }}">
                            <div class="mb-3">
                              <label for="form_category" class="fw-bold form-label">รหัสฟอร์ม (ถ้ามี)</label>
                              <input type="text" class="form-control" id="form_code" name="form_code" >
                              <div class="form-text">เช่น ID-TZ-IN-001 (20-04-2022)</div>
                          </div>

                            <div class="mb-3">
                                <label for="form_category" class="fw-bold form-label">จำนวนหมวดหมู่</label>
                                <input type="number" class="form-control" id="form_category" name="form_category" required>
                                <div class="form-text">ระบุเป็นตัวเลขเท่านั้น</div>
                            </div>

                            <div class="mb-3">
                                <label for="form_type" class="fw-bold form-label">ประเภทฟอร์ม</label>
                                <select class="form-select" name="form_type">
                                    <option selected disabled>-เลือกประเภทฟอร์ม</option>
                                    @foreach ($data_type as $row)
                                        <option value="{{ $row->id }}"> {{ $row->form_type_name }} </option>
                                    @endforeach
                                </select>
                            </div>



                            <table class="table table-bordered" id="dynamicTable">
                                <thead>
                                    <tr>
                                        <th scope="col">ชื่อหมวดหมู่</th>
                                        <th scope="col">เพิ่ม/ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" name="category_name[0]" placeholder="ระบุหมวดหมู่"
                                                class="form-control form-control-sm" /></td>
                                        <td><button type="button" name="add" id="add"
                                                class="btn btn-primary btn-sm">เพิ่มหมวดหมู่</button></td>
                                    </tr>
                                </tbody>
                            </table>
<hr>
<div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">บันทึก</button>
                          </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var i = 0;
        $("#add").click(function() {
            ++i;
            $("#dynamicTable").append('<tr><td><input type="text" name="category_name[' + i +
                ']" placeholder="ระบุหมวดหมู่" class="form-control form-control-sm" /></td><td><button type="button" class="btn btn-danger btn-sm remove-tr">ลบ</button></td></tr>'
                );
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });
    </script>
@endsection
