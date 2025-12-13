@extends('admin/adminlayout')

@section('container')


<div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Add Charge</h4>
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

                    <form class="forms-sample" action="/charge-add-process" method="post" enctype="multipart/form-data" id="chargeForm">

                       @csrf

                      <div class="form-group">
                        <label for="chargeName">Tên phí <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" id="chargeName" placeholder="Nhập tên phí">
                      </div>
                      <div class="form-group">
                        <label for="chargePrice">Giá <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" id="chargePrice" placeholder="Nhập giá" min="0" step="0.01">
                      </div>
                    
                    
                      <button type="submit" class="btn btn-primary me-2">Submit</button>
                      <a href="/admin/charge" class="btn btn-dark">Cancel</a>
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
<script src="{{asset('admin/assets/js/charge-form-validation.js')}}"></script>
@endpush