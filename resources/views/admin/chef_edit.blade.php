@extends('admin/adminlayout')

@section('container')

@foreach($chefs as $chef)

<div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Sửa Đầu Bếp</h4>
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

                    <form class="forms-sample" action="{{ asset('/edit/chef/process/'.$chef->id) }}" method="post" enctype="multipart/form-data" id="chefEditForm">

                       @csrf

                      <div class="form-group">
                        <label for="chefEditName">Tên đầu bếp <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{  $chef->name }}" class="form-control" id="chefEditName" placeholder="Nhập tên đầu bếp">
                      </div>
                      <div class="form-group">
                        <label for="chefEditJobTitle">Chức danh <span class="text-danger">*</span></label>
                        <input type="text" name="job" value="{{  $chef->job_title }}" class="form-control" id="chefEditJobTitle" placeholder="Nhập chức danh">
                      </div>
                     
                    
                      <div class="form-group">
                        <label for="chefEditFacebook">Facebook Link</label>
                        <input type="text" name="fb" value="{{ $chef->facebook_link }}" class="form-control" id="chefEditFacebook" placeholder="https://facebook.com/...">
                      </div>
                      <div class="form-group">
                        <label for="chefEditTwitter">Twitter Link</label>
                        <input type="text" name="twitter" value="{{  $chef->twitter_link }}" class="form-control" id="chefEditTwitter" placeholder="https://twitter.com/...">
                      </div>
                      <div class="form-group">
                        <label for="chefEditInstagram">Instagram Link</label>
                        <input type="text" name="instagram" value="{{  $chef->instragram_link }}" class="form-control" id="chefEditInstagram" placeholder="https://instagram.com/...">
                      </div>
                    
                      <div class="form-group">
                        <label for="chefEditImage">Ảnh đầu bếp</label>
                        <div class="custom-file-input-wrapper">
                          <input type="file" name="image" class="form-control-file custom-file-input" id="chefEditImage" accept="image/jpeg,image/jpg,image/png" onchange="updateFileName(this)">
                          <label for="chefEditImage" class="custom-file-label">
                            <i class="mdi mdi-file-image"></i> Chọn file
                          </label>
                          <span class="file-name-display" id="chefEditImageFileName"></span>
                        </div>
                        <small class="form-text text-muted">Để trống nếu không muốn thay đổi ảnh. Chỉ chấp nhận file JPG, JPEG, PNG. Kích thước tối đa: 5MB</small>
                        @if($chef->image)
                        <div class="mt-2">
                            <img src="{{ asset('assets/images/'.$chef->image) }}" alt="Current image" style="max-width: 200px; max-height: 200px; border-radius: 5px;">
                        </div>
                        @endif
                    </div>
                  
                    
                      <button type="submit" class="btn btn-primary me-2">Cập nhật</button>
                      <a href="/admin/chefs" class="btn btn-dark">Hủy</a>
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
<script>
function updateFileName(input) {
    const fileName = input.files[0] ? input.files[0].name : '';
    const fileNameDisplay = document.getElementById(input.id + 'FileName');
    if (fileNameDisplay) {
        fileNameDisplay.textContent = fileName ? 'Đã chọn: ' + fileName : '';
    }
}
</script>

@push('scripts')
<script src="{{asset('admin/assets/js/chef-form-validation.js')}}"></script>
@endpush