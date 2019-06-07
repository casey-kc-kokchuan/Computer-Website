<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Types extends Model
{

	protected $table = 'types';
	protected $hidden = ["created_at", "updated_at"];

	protected $fillable = ['type'];

}
