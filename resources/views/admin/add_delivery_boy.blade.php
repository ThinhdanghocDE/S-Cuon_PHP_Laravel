@extends('admin/adminlayout')

@section('container')


<div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Thêm Nhân Viên Giao Hàng</h4>
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

                    <form class="forms-sample" action="/add-delivery-boy-process" method="post" enctype="multipart/form-data" id="deliveryBoyForm">

                       @csrf

                      <div class="form-group">
                        <label for="deliveryBoyName">Tên <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" id="deliveryBoyName" placeholder="Nhập tên">
                      </div>
                      <div class="form-group">
                        <label for="deliveryBoyEmail">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" id="deliveryBoyEmail" placeholder="example@email.com">
                      </div>
                      <div class="form-group">
                        <label for="deliveryBoyPhone">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="number" name="phone" class="form-control" id="deliveryBoyPhone" placeholder="Nhập số điện thoại">
                      </div>

            


                      <div class="form-group">
                        <label for="deliveryBoySalary">Lương <span class="text-danger">*</span></label>
                        <input type="number" name="salary" class="form-control" id="deliveryBoySalary" placeholder="Nhập lương" min="0">
                      </div>


                      <div class="form-group">
                        <label for="deliveryBoyPassword">Mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" id="deliveryBoyPassword" placeholder="Tối thiểu 8 ký tự">
                      </div>


                      <div class="form-group">
                        <label for="deliveryBoyConfirmPassword">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" name="confirm_password" class="form-control" id="deliveryBoyConfirmPassword" placeholder="Nhập lại mật khẩu">
                      </div>

                  
                      <div class="form-group">
                        <label for="deliveryBoyImage">Ảnh <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control-file" id="deliveryBoyImage" accept="image/jpeg,image/jpg,image/png">
                        <small class="form-text text-muted">Chỉ chấp nhận file JPG, JPEG, PNG. Kích thước tối đa: 5MB</small>
                      </div>
                  
                    
                      <button type="submit" class="btn btn-primary me-2">Xác nhận</button>
                      <a href="/delivery-boy" class="btn btn-dark">Hủy</a>
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
<script src="{{asset('admin/assets/js/delivery-boy-form-validation.js')}}"></script>
<script>
function updateFileName(input) {
    const fileName = input.files[0] ? input.files[0].name : '';
    const fileNameDisplay = document.getElementById(input.id + 'FileName');
    if (fileNameDisplay) {
        fileNameDisplay.textContent = fileName ? 'Đã chọn: ' + fileName : '';
    }
}
</script>
<style>
.custom-file-input-wrapper {
    position: relative;
    display: inline-block;
    width: 100%;
}
.custom-file-input {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}
.custom-file-label {
    display: inline-block;
    padding: 10px 20px;
    background: #007bff;
    color: white;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s;
    font-weight: 500;
}
.custom-file-label:hover {
    background: #0056b3;
}
.custom-file-label i {
    margin-right: 5px;
}
.file-name-display {
    margin-left: 10px;
    color: #28a745;
    font-weight: 500;
}
</style>
@endpush