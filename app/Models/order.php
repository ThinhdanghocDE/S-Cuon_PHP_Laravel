<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    
    protected $fillable = ['name','email','phone','amount','address','status','transaction_id','currency'];

}
