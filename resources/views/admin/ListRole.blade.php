@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">สิทธิ์การใช้งานทั้งหมด</div>

                    <div class="card-body">
                        <p class="mb-4">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary">เพิ่มสิทธิ์ใหม่</button>
                        </p>


                        <table class="table table-bordered" id="dataTables">
                            <thead class="table-success">
                                <tr>
                                    <th scope="col" class="text-center">#</th>
                                    <th scope="col">ชื่อสิทธิ์</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = '1';
                                @endphp
                                @foreach ($listrole as $item)
                                    <tr>
                                        <th scope="row" class="text-center">
                                            @php
                                                echo $i++;
                                            @endphp</th>
                                        <td><a href="{{ route('admin_roleDetail', ['id' => $item->id]) }}" class="text-decoration-none">{{$item->role_name }}</a> </td>
                                        <td>
                                            @if ($item->role_status == '1')
                                                <span class="badge text-bg-success">ใช้งาน</span>
                                            @elseif ($item->role_status == '0')
                                                <span class="badge text-bg-warning">ปิด</span>
                                            @endif
                                        </td>
                                

                                    </tr>
                                @endforeach


                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">เพิ่มสิทธิ์ใหม่</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('admin_insertnewrole')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">ชื่อสิทธิ์</label>
                <input type="text" class="form-control" id="role_name" name="role_name">
              </div>                       
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
          <button type="submit" class="btn btn-success">บันทึก</button>
        </div>
    </form>
      </div>
    </div>
  </div>

    </div>
@endsection
