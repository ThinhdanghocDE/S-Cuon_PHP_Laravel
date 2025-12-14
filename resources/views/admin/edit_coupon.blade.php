@extends('admin/adminlayout')

@section('container')


@foreach($coupon as $coup)

<div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Sửa Mã Giảm Giá</h4>
                    <br>

                    @if(Session::has('wrong'))
              
                        <div class="alert">
                      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                      <strong>Opps !</strong> {{Session::get('wrong')}}
                    </div>
                    <br>
                        @endif
                        @if(Session::has('success'))
                  
                        <div class="success">
                      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                      <strong>Congrats !</strong> {{Session::get('success')}}
                    </div>
                        <br>
                        @endif

                    <form class="forms-sample" action="{{  asset('/coupon-edit-process/'.$coup->id) }}" method="post" enctype="multipart/form-data" id="couponForm">

                       @csrf

                      <div class="form-group">
                        <label for="couponName">Tên coupon <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ $coup->name }}" class="form-control" id="couponName" placeholder="Nhập tên coupon">
                      </div>
                      <div class="form-group">
                        <label for="couponDetails">Chi tiết <span class="text-danger">*</span></label>
                        <input type="text" name="details" value="{{ $coup->details }}" class="form-control" id="couponDetails" placeholder="Nhập chi tiết coupon">
                      </div>
                      <div class="form-group">
                        <label for="couponCode">Mã coupon <span class="text-danger">*</span></label>
                        <input type="text" name="code" value="{{ $coup->code }}"  class="form-control" id="couponCode" placeholder="Nhập mã coupon (VD: SALE2024)" style="text-transform: uppercase;">
                      </div>
                      <div class="form-group">
                        <label for="couponDiscount">Phần trăm giảm giá <span class="text-danger">*</span></label>
                        <input type="number" name="discount_percentage" value="{{ $coup->percentage }}" class="form-control" id="couponDiscount" placeholder="Nhập phần trăm (0-100)" min="0" max="100" step="0.01">
                      </div>
                      <div class="form-group">
                        <label for="couponDate">Ngày hết hạn <span class="text-danger">*</span></label>
                        <input type="date" name="vaildation_date" value="{{ $coup->validate }}" class="form-control" id="couponDate">
                      </div>

                



    
                  
                    
                      <button type="submit" class="btn btn-primary me-2">Cập nhật</button>
                      <a href="/admin/coupon" class="btn btn-dark">Hủy</a>
                    </form>
                  </div>
                </div>

            </div>



@endsection()



@endforeach

<style>
.alert {
  padding: 20px;
  background-color: #f44336;
  color: white;
}

.success {
  padding: 20px;
  background-color: #4BB543 ;
  color: white;
}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}
</style>

@push('scripts')
<script src="{{asset('admin/assets/js/coupon-form-validation.js')}}"></script>
@endpush