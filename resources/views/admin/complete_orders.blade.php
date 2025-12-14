@extends('admin/adminlayout')

@section('container')





<div class="row ">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Chi Tiết Đơn Hàng Đã Hoàn Thành</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                          
           
                            <th> Ngày & Giờ Giao Hàng </th>
                            <th> Mã Hóa Đơn </th>
                            <th> Tên Khách Hàng </th>
                            <th> Số Điện Thoại</th>
                        
                            <th> Địa Chỉ Giao Hàng </th>
              
                  
                            <th> Phương Thức Thanh Toán </th>
                            <th> Thao Tác </th>
                          </tr>
                        </thead>
                        <tbody>

                        @foreach($orders as $order)
                          <tr>
                           
                            <td>
                              <span class="ps-2">{{ $order->delivery_time }}</span>
                            </td>
                            <td> {{ $order->invoice_no }} </td>
                            <td>


                            @php

                              $user=DB::table('users')->where('id',$order->user_id)->first();

                            @endphp


                            {{  $user->name }}



                            </td>


                            <td>  {{  $user->phone }}</td>
                            <td> {{ $order->shipping_address }} </td>
                     
                            <td> {{ $order->pay_method }} </td>

                            <td>

                            <a href="{{ asset('/invoice/details/'.$order->invoice_no) }}" class="badge badge-outline-primary">Chi Tiết</a>
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