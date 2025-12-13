@extends('admin/adminlayout')

@section('container')


<div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Add Admin</h4>
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

                    <form class="forms-sample" action="/admin-add-process" method="post" enctype="multipart/form-data" id="adminForm">

                       @csrf

                      <div class="form-group">
                        <label for="adminName">Tên <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" id="adminName" placeholder="Nhập tên">
                      </div>
                      <div class="form-group">
                        <label for="adminEmail">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" id="adminEmail" placeholder="example@email.com">
                      </div>
                      <div class="form-group">
                        <label for="adminPhone">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="number" name="phone" class="form-control" id="adminPhone" placeholder="Nhập số điện thoại">
                      </div>

                

                      <div class="form-group">
                        <label for="adminType">Loại <span class="text-danger">*</span></label>
                        <select class="form-control" name="type" id="adminType">
                          <option value="1">Super Admin</option>
                          <option value="3">Sub Admin</option>
                        </select>
                      </div>


                      <div class="form-group">
                        <label for="adminSalary">Lương <span class="text-danger">*</span></label>
                        <input type="number" name="salary" class="form-control" id="adminSalary" placeholder="Nhập lương" min="0">
                      </div>


                      <div class="form-group">
                        <label for="adminPassword">Mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" id="adminPassword" placeholder="Tối thiểu 8 ký tự">
                      </div>


                      <div class="form-group">
                        <label for="adminConfirmPassword">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" name="confirm_password" class="form-control" id="adminConfirmPassword" placeholder="Nhập lại mật khẩu">
                      </div>

                  
                      <div class="form-group">
                        <label for="adminImage">Ảnh <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control-file" id="adminImage" accept="image/jpeg,image/jpg,image/png">
                        <small class="form-text text-muted">Chỉ chấp nhận file JPG, JPEG, PNG. Kích thước tối đa: 5MB</small>
                      </div>
                  
                    
                      <button type="submit" class="btn btn-primary me-2">Submit</button>
                      <a href="/admin/show" class="btn btn-dark">Cancel</a>
                    </form>
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

@push('scripts')
<script src="{{asset('admin/assets/js/admin-form-validation.js')}}"></script>
@endpush