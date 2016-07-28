<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class shared_notes extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
}
