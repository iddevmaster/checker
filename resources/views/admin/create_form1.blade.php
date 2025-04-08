@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">สร้างฟอร์มใหม่</div>

                    <div class="card-body">

                     

                        <form method="POST" action="{{route('admin_insert_form_part1')}}">
                            @csrf
                            <div class="mb-3 mt-2">
                                <label for="form_name" class="fw-bold form-label">ชื่อฟอร์ม</label>
                                @error('form_name')
                                <p class="text-danger fw-bold"> {{ $message }}</p>
                                @enderror
                                <input type="text" class="form-control" id="form_name" name="form_name">
                            </div>


                            <div class="mb-3">
                                <label for="form_type" class="fw-bold form-label">สิทธิ์ใช้งาน</label>

                                @error('roles')
                                <p class="text-danger fw-bold"> {{ $message }}</p>
                                @enderror
                                   
                               

                                @foreach ($data_role as $row)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="role_{{ $row->id }}"
                                            name="roles[]" value="{{ $row->id }}">
                                        <label class="form-check-label"
                                            for="role_{{ $row->id }}">{{ $row->role_name }}</label>

                                    </div>
                                @endforeach
                            </div>

                            <hr>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">ถัดไป <i
                                        class="las la-arrow-right"></i></button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
