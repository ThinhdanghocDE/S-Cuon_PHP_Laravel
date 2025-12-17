@extends('admin/adminlayout')

@section('container')

<div class="row ">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                      <h4 class="card-title mb-2">Danh sách đặt bàn</h4>
                      <a href="{{ route('admin.reservations.add') }}" class="btn btn-primary btn-sm mb-2">Thêm đặt bàn</a>
                    </div>

                    @if(session('success'))
                      <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                      <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if ($errors->any())
                      <div class="alert alert-danger">
                        <ul class="mb-0">
                          @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                          @endforeach
                        </ul>
                      </div>
                    @endif

                    <form method="GET" action="{{ route('admin.reservations') }}" class="mb-3">
                      <div class="row">
                        <div class="col-md-5 mb-2">
                          <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Tìm theo tên / SĐT / email / ngày / giờ / ghi chú...">
                        </div>
                        <div class="col-md-3 mb-2">
                          <input type="date" name="from" value="{{ $dateFrom ?? '' }}" class="form-control" placeholder="Từ ngày">
                        </div>
                        <div class="col-md-3 mb-2">
                          <input type="date" name="to" value="{{ $dateTo ?? '' }}" class="form-control" placeholder="Đến ngày">
                        </div>
                        <div class="col-md-1 mb-2 d-flex">
                          <button type="submit" class="btn btn-success btn-sm w-100">Lọc</button>
                        </div>
                      </div>
                    </form>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                          
           
                            <th>Ngày</th>
                            <th>Giờ</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>SĐT</th>
                            <th>Số khách</th>
                            <th>Ghi chú</th>
                            <th width="160">Thao tác</th>
                          </tr>
                        </thead>
                        <tbody>

                        @forelse($reservations as $reservation)
                          <tr>
                           
                            <td>
                              <span class="ps-2">{{ $reservation->date }}</span>
                            </td>
                            <td> {{ $reservation->time }} </td>
                            <td> {{ $reservation->name }} </td>
                            <td>


                            {{ $reservation->email }}


                            </td>


                            <td>  {{  $reservation->phone }}</td>
                            <td> {{ $reservation->no_guest }} </td>
                     
                 

                            <td>

                            {{ $reservation->message }}

                              </td>
                            <td>
                              <a href="{{ route('admin.reservations.edit', $reservation->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                              <a href="{{ route('admin.reservations.delete', $reservation->id) }}" class="btn btn-danger btn-sm"
                                 onclick="return confirm('Bạn chắc chắn muốn xóa đặt bàn này?');">Xóa</a>
                            </td>
                          </tr>

                        @empty
                          <tr>
                            <td colspan="9" class="text-center text-muted">Chưa có đặt bàn nào.</td>
                          </tr>
                        @endforelse
                       
                        </tbody>
                      </table>
                      <div class="mt-3">
                        {{ $reservations->links('pagination::bootstrap-4') }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>





@endsection()