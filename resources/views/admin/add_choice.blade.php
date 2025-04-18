@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">เพิ่มข้อตรวจ</div>

                <div class="card-body">
                   
                   
                        @foreach ($form_chk as $row)      
                        <div class="mb-3">
                          <label for="form_name" class="form-label">ชื่อฟอร์ม :: {{$row->form_name}}</label>
                        </div>
                    
                          <div class="mb-3">
                            <label for="form_name" class="form-label">ชื่อหัวข้อ :: {{$row->category_name}}</label>
                          </div>
                          

            <form method="POST" action="{{route('admin_InsertChoice',['id'=>request()->id])}}">
             @csrf
                    
                        <input type="hidden" name="form_id" value="{{$row->form_id}}">
                        <table class="table table-bordered" id="dynamicTable">
                            <thead>
                              <tr>
                                <th>ที่</th>
                                <th scope="col" width="50%">ข้อตรวจ</th>
                                <th width="30%">ประเภทตัวเลือก</th>
                                <th scope="col">เพิ่ม/ลบ</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td><input type="text" name="addmore[0]" placeholder="ระบุข้อตรวจ" class="form-control form-control-sm" /></td>
                                <td>
                                  <select class="form-select" name="choice_type[0]"  >
                                    <option disabled>-เลือก</option>
                                    <option value="1">ข้อความ</option>
                                    <option value="2">วันที่ (ค.ศ.)</option>
                                    <option value="3">วันที่ (พ.ศ.)</option>
                                    <option value="4">ตัวเลข</option>
                                    <option value="5" selected>ตัวเลือก (ผ่าน/ไม่ผ่าน)</option>
                                    <option value="6">ตัวเลือก (น้ำมัน/NGV)</option>
                                    <option value="7">ตัวเลือก (ประเภทสินค้า ปูนผง/ปูนเม็ด/ปูงถุง)</option>
                                  </select>
                                
                                </td>
                                <td><button type="button" name="add" id="add" class="btn btn-primary btn-sm">เพิ่มข้อตรวจ</button></td>
                              </tr>                              
                            </tbody>
                          </table>
                          @endforeach
                          <hr>
                          <div class="d-grid gap-2 col-6 mx-auto">
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
    var n = 1;
    $("#add").click(function(){   
        ++i;   
        ++n;
        $("#dynamicTable").append('<tr><td>'+n+'</td><td><input type="text" name="addmore['+i+']" placeholder="ระบุข้อตรวจ" class="form-control form-control-sm" /></td><td>  <select class="form-select" name="choice_type['+i+']"><option disabled>-เลือก</option><option value="1">ข้อความ</option><option value="2">วันที่ (ค.ศ.)</option><option value="3">วันที่ (พ.ศ.)</option><option value="4">ตัวเลข</option><option value="5" selected >ตัวเลือก (ผ่าน/ไม่ผ่าน)</option><option value="6">ตัวเลือก (น้ำมัน/NGV)</option><option value="7">ตัวเลือก (ประเภทสินค้า ปูนผง/ปูนเม็ด/ปูงถุง)</option></select></td><td><button type="button" class="btn btn-danger btn-sm remove-tr">ลบ</button></td></tr>');
    });
   
    $(document).on('click', '.remove-tr', function(){  
         $(this).parents('tr').remove();
    });  
   
</script>

@endsection
