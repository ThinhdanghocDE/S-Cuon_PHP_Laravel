@extends('admin/adminlayout')

@section('container')


@foreach($admin as $user)

<div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Sửa Admin</h4>
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

                    <form class="forms-sample" action="{{ asset('/admin-edit-process/'.$user->id) }}" method="post" enctype="multipart/form-data" id="adminForm">

                       @csrf

                      <div class="form-group">
                        <label for="adminName">Tên <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ $user->name }}" class="form-control" id="adminName" placeholder="Nhập tên">
                      </div>
                      <div class="form-group">
                        <label for="adminEmail">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" value="{{ $user->email }}" class="form-control" id="adminEmail" placeholder="example@email.com">
                      </div>
                      <div class="form-group">
                        <label for="adminPhone">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="number" name="phone" value="{{ $user->phone }}" class="form-control" id="adminPhone" placeholder="Nhập số điện thoại">
                      </div>

                

                      <div class="form-group">
                        <label for="adminType">Loại <span class="text-danger">*</span></label>
                        <select class="form-control" name="type" id="adminType">
                          <option value="1" @php if($user->usertype=="1"){ echo"selected"; } @endphp>Super Admin</option>
                          <option value="3"  @php if($user->usertype=="3"){ echo"selected"; } @endphp>Sub Admin</option>
                        </select>
                      </div>


                      <div class="form-group">
                        <label for="adminSalary">Lương <span class="text-danger">*</span></label>
                        <input type="number" value="{{ $user->salary }}" name="salary" class="form-control" id="adminSalary" placeholder="Nhập lương" min="0">
                      </div>

                  
                      <div class="form-group">
                        <label for="adminImage">Ảnh</label>
                        <div class="custom-file-input-wrapper">
                          <input type="file" name="image" class="form-control-file custom-file-input" id="adminImage" accept="image/jpeg,image/jpg,image/png" onchange="updateFileName(this)">
                          <label for="adminImage" class="custom-file-label">
                            <i class="mdi mdi-file-image"></i> Chọn file
                          </label>
                          <span class="file-name-display" id="adminImageFileName"></span>
                        </div>
                        <small class="form-text text-muted">Để trống nếu không muốn thay đổi ảnh. Chỉ chấp nhận file JPG, JPEG, PNG. Kích thước tối đa: 5MB</small>
                        @if($user->profile_photo_path)
                        <div class="mt-2">
                            <img src="{{ asset('assets/images/admin/'.$user->profile_photo_path) }}" alt="Current image" style="max-width: 200px; max-height: 200px; border-radius: 5px;">
                        </div>
                        @endif
                      </div>
                  
                    
                      <button type="submit" class="btn btn-primary me-2">Cập nhật</button>
                      <a href="/admin/show" class="btn btn-dark">Hủy</a>
                    </form>
                  </div>
                </div>

            </div>


@endforeach

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
<script>
function updateFileName(input, labelId) {
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