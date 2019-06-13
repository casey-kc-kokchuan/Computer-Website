<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderList extends Model
{
	protected $table = 'order_list';

	protected $fillable = ['name','contact','email','address','total_price'];

}
