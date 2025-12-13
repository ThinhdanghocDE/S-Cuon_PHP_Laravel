@extends('admin/adminlayout')

@section('container')


<div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Add Banner</h4>
                    
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
                    <br>

                    <form class="forms-sample" runat="server" action="/banner/add/process" method="post" enctype="multipart/form-data" id="bannerForm">

                       @csrf

    

                      <div class="form-group">
                        <label for="bannerImage">Ảnh <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control-file" id="bannerImage" accept="image/jpeg,image/jpg,image/png">
                        <small class="form-text text-muted">Chỉ chấp nhận file JPG, JPEG, PNG. Kích thước tối đa: 5MB</small>
                    </div>
                  
                    
                      <button type="submit" class="btn btn-primary me-2">Submit</button>
                      <a href="/admin/banner/all" class="btn btn-dark">Cancel</a>

                    </form>
                  </div>
                </div>

            </div>






<script>




</script>




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
<script src="{{asset('admin/assets/js/banner-form-validation.js')}}"></script>
@endpush