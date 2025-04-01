@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-primary mb-3">
                <div class="card-header">สร้างบัญชีผู้ใช้ใหม่</div>

                <div class="card-body text-primary">
                    <form method="POST" action="{{ route('admin_InsertUser') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="formFileSm" class="col-md-4 col-form-label text-md-end">Logo หน่วยงาน (ถ้ามี)</label>
                            <div class="col-md-6">
                            <input class="form-control form-control-sm" name="user_logo" id="formFileSm" type="file" accept="image/*">
                            </div>
                          </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">ชื่อ-นามสกุล</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" required autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Username</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="email" required >

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="text" class="form-control" name="password" required >

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Role" class="col-md-4 col-form-label text-md-end">Role</label>
                            <div class="col-md-6">
                            <select class="form-select" id="role" name="user_role">
                                <option selected disabled>--เลือก--</option>
                                <option value="company">หน่วยงาน</option>
                                <option value="leader">เจ้าหน้าที่</option>
                              </select>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <label for="Role" class="col-md-4 col-form-label text-md-end">สิทธิ์การใช้งาน</label>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="chk_type" value="1">
                                    <label class="form-check-label" for="inlineCheckbox1">แบบตรวจสภาพรถ(ปูน) </label>
                                  </div>

                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox4" name="chk_type" value="4">
                                    <label class="form-check-label" for="inlineCheckbox4">แบบตรวจสภาพรถยนต์</label>
                                  </div>

                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="chk_type" value="2">
                                    <label class="form-check-label" for="inlineCheckbox2">แบบตรวจเอกสาร</label>
                                  </div>

                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="chk_type" value="3">
                                    <label class="form-check-label" for="inlineCheckbox3">แบบตรวจสต๊อกสินค้า</label>
                                  </div>
                                 
                            </div>
                        </div>


                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                   บันทึก
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
