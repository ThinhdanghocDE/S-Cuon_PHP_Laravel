@extends('admin/adminlayout')

@section('container')


<div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Add Chef</h4>
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

                    <form class="forms-sample" action="/chef/add/process" method="post" enctype="multipart/form-data" id="chefForm">

                       @csrf

                      <div class="form-group">
                        <label for="chefName">Tên đầu bếp <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" id="chefName" placeholder="Nhập tên đầu bếp">
                      </div>
                      <div class="form-group">
                        <label for="chefJobTitle">Chức danh <span class="text-danger">*</span></label>
                        <input type="text" name="job" class="form-control" id="chefJobTitle" placeholder="Nhập chức danh">
                      </div>
                     
                    
                      <div class="form-group">
                        <label for="chefFacebook">Facebook Link</label>
                        <input type="text" name="fb" class="form-control" id="chefFacebook" placeholder="https://facebook.com/...">
                      </div>
                      <div class="form-group">
                        <label for="chefTwitter">Twitter Link</label>
                        <input type="text" name="twitter" class="form-control" id="chefTwitter" placeholder="https://twitter.com/...">
                      </div>
                      <div class="form-group">
                        <label for="chefInstagram">Instagram Link</label>
                        <input type="text" name="instagram" class="form-control" id="chefInstagram" placeholder="https://instagram.com/...">
                      </div>
                    
                      <div class="form-group">
                        <label for="chefImage">Ảnh đầu bếp <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control-file" id="chefImage" accept="image/jpeg,image/jpg,image/png">
                        <small class="form-text text-muted">Chỉ chấp nhận file JPG, JPEG, PNG. Kích thước tối đa: 5MB</small>
                    </div>
                  
                    
                      <button type="submit" class="btn btn-primary me-2">Submit</button>
                      <a href="/admin/chefs" class="btn btn-dark">Cancel</a>
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
<script src="{{asset('admin/assets/js/chef-form-validation.js')}}"></script>
@endpush