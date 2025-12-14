@extends('admin/adminlayout')

@section('container')


@foreach($products as $product)

<div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Sửa Món</h4>
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

                    <form class="forms-sample" action="{{ asset('/menu/edit/process/'.$product->id) }}" method="post" enctype="multipart/form-data" id="menuForm">

                       @csrf

                      <div class="form-group">
                        <label for="menuName">Tên món <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ $product->name }}" class="form-control" id="menuName" placeholder="Nhập tên món">
                      </div>
                      <div class="form-group">
                        <label for="menuDescription">Mô tả <span class="text-danger">*</span></label>
                        <textarea class="form-control" value="{{ $product->description }}" name="description" id="menuDescription" rows="5" placeholder="Nhập mô tả món ăn">{{ $product->description }}</textarea>
                      </div>
                    
                      <div class="form-group">
                        <label for="menuPrice">Giá <span class="text-danger">*</span></label>
                        <input type="number" name="price" value="{{ $product->price }}" class="form-control" id="menuPrice" placeholder="Nhập giá" min="0">
                      </div>
                      <div class="form-group">
                        <label for="menuCategory">Danh mục <span class="text-danger">*</span></label>
                        <select class="form-control" name="catagory" id="menuCategory">
                          <option value="regular" @php if($product->catagory=="regular"){ echo"selected"; }   @endphp>Regular</option>
                          <option value="special" @php if($product->catagory=="special"){ echo"selected"; }   @endphp>Special</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="menuSession">Loại <span class="text-danger">*</span></label>
                        <select class="form-control" name="session" id="menuSession">
                          <option value="0" @php if($product->session=="0"){ echo"selected"; }   @endphp>Món cuốn chính</option>
                          <option value="1" @php if($product->session=="1"){ echo"selected"; }   @endphp>Món cuốn phụ</option>
                          <option value="2" @php if($product->session=="2"){ echo"selected"; }   @endphp>Đồ uống</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="menuAvailable">Tình trạng <span class="text-danger">*</span></label>
                        <select class="form-control" name="available" id="menuAvailable">
                          <option @php if($product->available=="Stock"){ echo"selected"; }   @endphp>Stock</option>
                          <option @php if($product->available=="Out Of Stock"){ echo"selected"; }   @endphp>Out of Stock</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="menuImage">Ảnh</label>
                        <div class="custom-file-input-wrapper">
                          <input type="file" name="image" class="form-control-file custom-file-input" id="menuImage" accept="image/jpeg,image/jpg,image/png" onchange="updateFileName(this)">
                          <label for="menuImage" class="custom-file-label">
                            <i class="mdi mdi-file-image"></i> Chọn file
                          </label>
                          <span class="file-name-display" id="menuImageFileName"></span>
                        </div>
                        <small class="form-text text-muted">Để trống nếu không muốn thay đổi ảnh. Chỉ chấp nhận file JPG, JPEG, PNG. Kích thước tối đa: 5MB</small>
                        @if($product->image)
                        <div class="mt-2">
                            <img src="{{ asset('assets/images/'.$product->image) }}" alt="Current image" style="max-width: 200px; max-height: 200px; border-radius: 5px;">
                        </div>
                        @endif
                    </div>
                  
                    
                      <button type="submit" class="btn btn-primary me-2">Cập nhật</button>
                      <a href="/admin/food-menu" class="btn btn-dark">Hủy</a>
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
<script src="{{asset('admin/assets/js/menu-form-validation.js')}}"></script>
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