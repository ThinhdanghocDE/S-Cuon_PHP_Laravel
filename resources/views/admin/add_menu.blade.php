@extends('admin/adminlayout')

@section('container')


<div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Add Menu</h4>
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
                        <label for="menuSession">Combo <span class="text-danger">*</span></label>
                        <select class="form-control" name="session" id="menuSession">
                          <option value="0">Combo 1-2 người</option>
                          <option value="1">Combo 3-4 người</option>
                          <option value="2">Combo 5-6 người</option>
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
                        <input type="file" name="image" class="form-control-file" id="menuImage" accept="image/jpeg,image/jpg,image/png">
                        <small class="form-text text-muted">Chỉ chấp nhận file JPG, JPEG, PNG. Kích thước tối đa: 5MB</small>
                    </div>
                  
                    
                      <button type="submit" class="btn btn-primary me-2">Submit</button>
                      <a href="/admin/food-menu" class="btn btn-dark">Cancel</a>
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
@endpush