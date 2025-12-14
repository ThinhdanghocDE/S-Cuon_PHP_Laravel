@extends('admin/adminlayout')

@section('container')


<a href="/add/coupon" type="button" class="btn btn-success" style="white-space: nowrap; min-width: auto; width: auto; height:35px; padding: 9px 20px;">+ Thêm Mã Giảm Giá</a>


<br>
<br>


<div class="row ">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Coupon Details</h4>

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
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                          
           
                            <th> ID </th>
                            <th> Name </th>
                            <th> Details </th>
                            <th>Code</th>
                            <th> Discount Percentage</th>
                        
                            <th> Validation Date </th>

                            <th> Action </th>
                          </tr>
                        </thead>
                        <tbody>

                        @foreach($coupons as $coupon)
                          <tr>
                           
                            <td>
                              <span>{{ $coupon->id }}</span>
                            </td>
                            <td> {{ $coupon->name }} </td>


                         


                            <td>  {{  $coupon->details }}</td>


                            <td>  {{  $coupon->code }}</td>
                            <td> {{ $coupon->percentage }}%</td>


                            <td> {{ $coupon->validate }} </td>
                     


                            <td>

                            <a href="{{ asset('/admin/coupon/edit/'.$coupon->id) }}" class="badge badge-outline-primary">Sửa</a>
                              <a href="javascript:void(0)" onclick="confirmDeleteCoupon({{ $coupon->id }}, '{{ addslashes($coupon->name) }}', '{{ addslashes($coupon->code) }}')" class="badge badge-outline-danger" style="margin-left:10px;">Xóa</a>
                            </td>
                          </tr>

                        @endforeach
                       
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>





@endsection()



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

<!-- Delete Confirmation Modal for Coupon -->
<div id="deleteCouponModal" class="delete-modal">
    <div class="delete-modal-content">
        <div class="delete-modal-header">
            <div class="delete-modal-icon">
                ⚠
            </div>
            <h3 class="delete-modal-title">Xác nhận xóa Coupon</h3>
        </div>
        <div class="delete-modal-body">
            <p>Bạn có chắc chắn muốn xóa coupon <strong id="couponName"></strong> (Mã: <strong id="couponCode"></strong>)?</p>
            <p style="margin-top: 10px; font-size: 13px; color: #999;">Hành động này không thể hoàn tác. Coupon sẽ bị xóa vĩnh viễn khỏi hệ thống.</p>
        </div>
        <div class="delete-modal-footer">
            <button class="delete-modal-btn delete-modal-btn-cancel" onclick="closeDeleteCouponModal()">Hủy</button>
            <button id="confirmDeleteCouponBtn" class="delete-modal-btn delete-modal-btn-confirm">Xóa</button>
        </div>
    </div>
</div>