<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
	protected $table = 'brands';

	protected $hidden = ["created_at", "updated_at"];

	protected $fillable = ['brand'];

}
