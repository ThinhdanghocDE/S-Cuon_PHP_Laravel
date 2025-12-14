@extends('admin/adminlayout')

@section('container')

<br>

@if(Session::has('wrong'))

    <div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong>Lỗi!</strong> {{Session::get('wrong')}}
</div>
<br>
    @endif
    @if(Session::has('success'))

    <div class="success">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong>Thành công!</strong> {{Session::get('success')}}
</div>
    <br>
    @endif


@foreach($products as $product)
<div class="card">
  <h5 class="card-header">Thông Tin Khách Hàng</h5>
  <div class="card-body">
    <h5 class="card-text">Mã Hóa Đơn : {{  $product->invoice_no }}</h5>
    <br>
    <?php


        $user=DB::table('users')->where('id',$product->user_id)->first();

    ?>
    <p class="card-text">Tên Khách Hàng : {{ $user->name }}</p>
    <p class="card-text">Số Điện Thoại : {{ $user->phone }}</p>
    <p class="card-text">Email : {{ $user->email }}</p>
    <p class="card-text">Địa Chỉ Giao Hàng : {{ $product->shipping_address }}</p>
    <a href="/customer" class="btn btn-primary"><b>Chi Tiết</a>
  </div>
</div>

@break;




@endforeach


<br>




<div class="row ">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Chi Tiết Sản Phẩm</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                          
           
                            <th> Tên Sản Phẩm </th>
                            <th> Giá </th>
                            <th> Số Lượng </th>
                            <th> Thành Tiền </th>
                          
                          </tr>
                        </thead>
                        <tbody>

                        @foreach($products as $product)
                          <tr>
                           
                      
                            <td> {{ $product->name }} </td>
                            <td> {{number_format($product->price * 1000, 0, ',', '.')}} VNĐ</td>
                            <td>


                            {{ $product->quantity }}


                            </td>


                            <td>  {{number_format($product->subtotal * 1000, 0, ',', '.')}} VNĐ</td>
                      
                          </tr>

                        @endforeach

                        @foreach($extra_charge as $charge)
                          <tr>
                           
                      
                            <td> {{ $charge->name }} </td>
                      
                           <td>

                           </td>
                           <td></td>


                            <td>  {{number_format($charge->price * 1000, 0, ',', '.')}} VNĐ</td>
                      
                          </tr>

                        @endforeach

                        <tr>
                            <td></td>
                            <td></td>
                            <td>Tổng Tiền </td>
                            <td class="">  {{number_format($wihout_discount_price * 1000, 0, ',', '.')}} VNĐ</td>                   
                    
                    
                        </tr>

                        <tr>
                            <td></td>
                            <td></td>
                            <td>Giảm Giá </td>
                            <td class="">  {{number_format($discount_price * 1000, 0, ',', '.')}} VNĐ</td>                   
                    
                    
                        </tr>

                        <tr>
                            <td></td>
                            <td></td>
                            <td><h3>Tổng Cộng (Sau Giảm Giá)</h3> </td>
                            <td class=""><h3>  {{number_format($total_price * 1000, 0, ',', '.')}} VNĐ </h3></td>                   
                    
                    
                        </tr>
                       
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              @foreach($products as $product)
              @if($product->product_order=="approve")
<div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Cập Nhật Thời Gian Giao Hàng</h4>
                  
                    
          

                    <form class="forms-sample" action="{{ asset('/invoice/approve/'.$product->invoice_no) }}" method="post" enctype="multipart/form-data">

                       @csrf

                       <div class="form-group">
                        <label for="exampleInputName1">Thời Gian Giao Hàng Trước Đó</label>
                        <input type="text" style="background-color:black !important;" name="" value="{{ $product->delivery_time }}" class="form-control" id="exampleInputName1" readonly>

                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Thời Gian Giao Hàng (Hiện Tại)</label>
                        <input type="datetime-local" name="time" value="{{ $product->delivery_time }}" class="form-control" id="exampleInputName1">

                      </div>
                 
                    
                      <button type="submit" class="btn btn-primary me-2">Cập Nhật Đơn Hàng</button>
                      <a href="{{  asset('/invoice/cancel-order/'.$product->invoice_no) }}" class="btn btn-danger">Hủy Đơn Hàng</a>
                    </form>

                    @break;

   

                  </div>
                </div>

            </div>
           



            @endif
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