@extends('admin/adminlayout')

@section('container')


<a href="/admin-add" type="button" class="btn btn-success" style="width:170px;height:35px;padding-top:9px;">+ Thêm Admin</a>


<br>
<br>


<div class="row ">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Admin Details</h4>

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
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                          
           
                            <th> ID </th>
                            <th> Name </th>
                            <th> Email </th>
                            <th> Phone</th>
                          

                            <th>Type</th>
                            <th>Salary</th>
                        


                            <th> Action </th>
                          </tr>
                        </thead>
                        <tbody>

                        @foreach($admins as $admin)
                          <tr>
                           
                            <td>
                              <span>{{ $admin->id }}</span>
                            </td>
                            <td> {{ $admin->name }} </td>



                            
                         
                         




                            <td> {{ $admin->email }}</td>


                            <td> {{ $admin->phone }} </td>


                            <td>


                            @if($admin->usertype=="1")


                                  Super Admin

                            @endif                     
                            @if($admin->usertype=="3")


                                  Sub Admin

                            @endif



                            </td>


                            
                     <td>{{ $admin->salary }} Tk</td>


                            <td>

                            <a href="{{ asset('/admin/edit/'.$admin->id) }}" class="badge badge-outline-primary">Sửa</a>
                              <a href="javascript:void(0)" onclick="confirmDeleteAdmin({{ $admin->id }}, '{{ $admin->name }}')" class="badge badge-outline-danger" style="margin-left:10px;">Xóa</a>
                            </td>
                          </tr>

                        @endforeach
                       
                        </tbody>
                      </table>
                    </div>
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

<!-- Delete Confirmation Modal for Admin -->
<div id="deleteAdminModal" class="delete-modal">
    <div class="delete-modal-content">
        <div class="delete-modal-header">
            <div class="delete-modal-icon">
                ⚠
            </div>
            <h3 class="delete-modal-title">Xác nhận xóa Admin</h3>
        </div>
        <div class="delete-modal-body">
            <p>Bạn có chắc chắn muốn xóa admin <strong id="adminName"></strong>?</p>
            <p style="margin-top: 10px; font-size: 13px; color: #999;">Hành động này không thể hoàn tác. Tài khoản admin sẽ bị xóa vĩnh viễn.</p>
        </div>
        <div class="delete-modal-footer">
            <button class="delete-modal-btn delete-modal-btn-cancel" onclick="closeDeleteAdminModal()">Hủy</button>
            <button id="confirmDeleteAdminBtn" class="delete-modal-btn delete-modal-btn-confirm">Xóa</button>
        </div>
    </div>
</div>