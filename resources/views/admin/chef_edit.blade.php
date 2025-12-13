@extends('admin/adminlayout')

@section('container')

@foreach($chefs as $chef)

<div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Edit Chef</h4>
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
                        <input type="file" name="image" class="form-control-file" id="chefEditImage" accept="image/jpeg,image/jpg,image/png">
                        <small class="form-text text-muted">Để trống nếu không muốn thay đổi ảnh. Chỉ chấp nhận file JPG, JPEG, PNG. Kích thước tối đa: 5MB</small>
                        @if($chef->image)
                        <div class="mt-2">
                            <img src="{{ asset('assets/images/'.$chef->image) }}" alt="Current image" style="max-width: 200px; max-height: 200px; border-radius: 5px;">
                        </div>
                        @endif
                    </div>
                  
                    
                      <button type="submit" class="btn btn-primary me-2">Update</button>
                      <a href="/admin/chefs" class="btn btn-dark">Cancel</a>
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
<script src="{{asset('admin/assets/js/chef-form-validation.js')}}"></script>
@endpush