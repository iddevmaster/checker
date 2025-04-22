<p class="fs-4 fw-bold text-center">เพิ่มข้อมูลรถ</p>
<form action="" method="POST">
    <div class="mb-3 row">
        <label for="staticEmail" class="col-sm-2 col-form-label">ทะเบียนรถ<span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input class="form-control" type="text" maxlength="10" autofocus>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">จังหวัด<span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input class="form-control" type="text">
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">ยี่ห้อ<span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input class="form-control" type="text">
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">รุ่น<span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input class="form-control" type="text">
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">วันที่จดทะเบียน<span class="text-danger">*</span></label>
        <div class="col-sm-2">
            <input class="form-control" type="text" maxlength="2" placeholder="วันที่" required>
        </div>
        <div class="col-sm-4">
            <input class="form-control" type="text">
        </div>
        <div class="col-sm-2">
            <input class="form-control" type="text" maxlength="4" placeholder="ปี พ.ศ." required>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>

</form>
