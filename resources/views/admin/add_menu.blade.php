@extends('admin/adminlayout')

@section('container')


<div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Thêm Món</h4>
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

                    <form class="forms-sample" action="/menu/add/process" method="post" enctype="multipart/form-data" id="menuForm">

                       @csrf

                      <div class="form-group">
                        <label for="menuName">Tên món <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" id="menuName" placeholder="Nhập tên món">
                      </div>
                      <div class="form-group">
                        <label for="menuDescription">Mô tả <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="description" id="menuDescription" rows="5" placeholder="Nhập mô tả món ăn"></textarea>
                      </div>
                    
                      <div class="form-group">
                        <label for="menuPrice">Giá <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" id="menuPrice" placeholder="Nhập giá" min="0">
                      </div>
                      <div class="form-group">
                        <label for="menuCategory">Danh mục <span class="text-danger">*</span></label>
                        <select class="form-control" name="catagory" id="menuCategory">
                          <option value="regular">Regular</option>
                          <option value="special">Special</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="menuSession">Loại <span class="text-danger">*</span></label>
                        <select class="form-control" name="session" id="menuSession">
                          <option value="0">Món cuốn chính</option>
                          <option value="1">Món cuốn phụ</option>
                          <option value="2">Đồ uống</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="menuAvailable">Tình trạng <span class="text-danger">*</span></label>
                        <select class="form-control" name="available" id="menuAvailable">
                          <option>Stock</option>
                          <option>Out of Stock</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="menuImage">Ảnh <span class="text-danger">*</span></label>
                        <div class="custom-file-input-wrapper">
                          <input type="file" name="image" class="custom-file-input" id="menuImage" accept="image/jpeg,image/jpg,image/png" onchange="updateFileName(this, 'menuImageLabel')">
                          <label for="menuImage" class="custom-file-label" id="menuImageLabel">
                            <i class="mdi mdi-file-image"></i> Chọn file
                          </label>
                          <span class="file-name-display" id="menuImageFileName"></span>
                        </div>
                        <small class="form-text text-muted">Chỉ chấp nhận file JPG, JPEG, PNG. Kích thước tối đa: 5MB</small>
                    </div>
                  
                    
                      <button type="submit" class="btn btn-primary me-2">Xác nhận</button>
                      <a href="/admin/food-menu" class="btn btn-dark">Hủy</a>
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
<script src="{{asset('admin/assets/js/menu-form-validation.js')}}"></script>
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
    display: block;
    width: 100%;
    margin-bottom: 0;
}
.custom-file-input-wrapper input[type="file"] {
    position: absolute !important;
    left: -9999px !important;
    opacity: 0 !important;
    width: 0 !important;
    height: 0 !important;
    overflow: hidden !important;
    z-index: -1 !important;
    pointer-events: none !important;
    visibility: hidden !important;
}
.custom-file-input-wrapper .custom-file-input {
    position: absolute !important;
    left: -9999px !important;
    opacity: 0 !important;
    width: 0 !important;
    height: 0 !important;
    overflow: hidden !important;
    z-index: -1 !important;
    pointer-events: none !important;
    visibility: hidden !important;
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
    margin: 0;
    position: relative;
    z-index: 1;
    border: none;
}
.custom-file-label:hover {
    background: #0056b3;
}
.custom-file-label i {
    margin-right: 5px;
}
.file-name-display {
    display: block;
    margin-top: 10px;
    color: #28a745;
    font-weight: 500;
}
</style>
@endpush