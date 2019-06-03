<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
	protected $table = 'products';
  protected $fillable = ['name', 'type', 'price'];
}

class Types extends Model
{
	protected $fillable = ['type'];
}
