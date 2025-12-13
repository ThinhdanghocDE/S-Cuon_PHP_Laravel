@extends('admin/adminlayout')

@section('container')


@foreach($delivery_boys as $user)

<div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Edit Delivery Boy</h4>
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

                    <form class="forms-sample" action="{{ asset('/edit_delivery_boy_process/'.$user->id) }}" method="post" enctype="multipart/form-data" id="deliveryBoyForm">

                       @csrf

                      <div class="form-group">
                        <label for="deliveryBoyName">Tên <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ $user->name }}" class="form-control" id="deliveryBoyName" placeholder="Nhập tên">
                      </div>
                      <div class="form-group">
                        <label for="deliveryBoyEmail">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" value="{{ $user->email }}" class="form-control" id="deliveryBoyEmail" placeholder="example@email.com">
                      </div>
                      <div class="form-group">
                        <label for="deliveryBoyPhone">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="number" name="phone" value="{{ $user->phone }}" class="form-control" id="deliveryBoyPhone" placeholder="Nhập số điện thoại">
                      </div>

            


                      <div class="form-group">
                        <label for="deliveryBoySalary">Lương <span class="text-danger">*</span></label>
                        <input type="number" name="salary" value="{{ $user->salary }}" class="form-control" id="deliveryBoySalary" placeholder="Nhập lương" min="0">
                      </div>

                  
                      <div class="form-group">
                        <label for="deliveryBoyImage">Ảnh</label>
                        <input type="file" name="image" class="form-control-file" id="deliveryBoyImage" accept="image/jpeg,image/jpg,image/png">
                        <small class="form-text text-muted">Để trống nếu không muốn thay đổi ảnh. Chỉ chấp nhận file JPG, JPEG, PNG. Kích thước tối đa: 5MB</small>
                        @if($user->profile_photo_path)
                        <div class="mt-2">
                            <img src="{{ asset('assets/images/admin/'.$user->profile_photo_path) }}" alt="Current image" style="max-width: 200px; max-height: 200px; border-radius: 5px;">
                        </div>
                        @endif
                      </div>
                  
                    
                      <button type="submit" class="btn btn-primary me-2">Update</button>
                      <a href="/delivery-boy" class="btn btn-dark">Cancel</a>
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
<script src="{{asset('admin/assets/js/delivery-boy-form-validation.js')}}"></script>
@endpush