@extends('admin/adminlayout')

@section('container')


<a href="/add/menu" type="button" class="btn btn-success" style="width:170px;height:35px;padding-top:9px;">+ Thêm Món</a>


<br>

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

<?php

   
  
    $i=1;


?>
@foreach($products as $product)

<?php

                            
$total_rate=DB::table('rates')->where('product_id',$product->id)
->sum('star_value');


$total_voter=DB::table('rates')->where('product_id',$product->id)
->count();

if($total_voter>0)
{

    $per_rate=$total_rate/$total_voter;

}
else
{

    $per_rate=0;


}

$per_rate=number_format($per_rate, 1);




?>




@if($i%3==1)
<div class="card-deck" style="margin-top:20px;">
 
@endif


  <div class="card">
    <img class="card-img-top" src="{{ asset('assets/images/'.$product->image) }}" style="width:100%;height:280px;" alt="Card image cap">
    <div class="card-body">
      <h5 class="card-title">{{ $product->name }}</h5>
      <p class="card-text">{{ $product->description }}</p>
  
      <p style = "text-transform:capitalize;">Catagory : {{ $product->catagory }}</p>
      @if($product->session==0)
      <p style = "text-transform:capitalize;">Loại : Món cuốn chính</p>
      @endif
      @if($product->session==1)
      <p style = "text-transform:capitalize;">Loại : Món cuốn phụ</p>
      @endif
      @if($product->session==2)
      <p style = "text-transform:capitalize;">Loại : Đồ uống</p>
      @endif
      <p style = "text-transform:capitalize;">Giá : {{number_format($product->price * 1000, 0, ',', '.')}} VNĐ</p>
      @if($product->available =="Stock")

      <p style = "text-transform:capitalize;">Available : Stock </p>

      @endif

      @if($product->available !="Stock")

      <p style = "text-transform:capitalize;">Available : Out of Stock </p>

      @endif


      <span class="rating_avg">Rating : {{  $per_rate}}</span>

    </div>
    <div class="card-footer">
      <small class="text-muted"><a href="{{ asset('/menu/edit/'.$product->id) }}" class="btn btn-primary">Sửa</a>
      <a href="javascript:void(0)" onclick="confirmDeleteMenu({{ $product->id }}, '{{ addslashes($product->name) }}')" class="btn btn-danger" style="margin-left:10px;">Xóa</a>



      </small>
    </div>
  </div>
  

  @if($i%3==0)

</div>
@endif



<?php

   
  
    $i++;


?>


@endforeach


@if(($i-1)%3!=0)

  @if($fraction==2)


  <div class="card" style="background-color:black;"></div>




  @endif

  @if($fraction==1)


  <div class="card" style="background-color:black;"></div>
  
  <div class="card" style="background-color:black;"></div>
  



@endif




  

@endif




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

<!-- Delete Confirmation Modal for Menu -->
<div id="deleteMenuModal" class="delete-modal">
    <div class="delete-modal-content">
        <div class="delete-modal-header">
            <div class="delete-modal-icon">
                ⚠
            </div>
            <h3 class="delete-modal-title">Xác nhận xóa Món ăn</h3>
        </div>
        <div class="delete-modal-body">
            <p>Bạn có chắc chắn muốn xóa món ăn <strong id="menuName"></strong>?</p>
            <p style="margin-top: 10px; font-size: 13px; color: #999;">Hành động này không thể hoàn tác. Món ăn sẽ bị xóa vĩnh viễn khỏi hệ thống.</p>
        </div>
        <div class="delete-modal-footer">
            <button class="delete-modal-btn delete-modal-btn-cancel" onclick="closeDeleteMenuModal()">Hủy</button>
            <button id="confirmDeleteMenuBtn" class="delete-modal-btn delete-modal-btn-confirm">Xóa</button>
        </div>
    </div>
</div>