<?php

namespace CodePress\CodeDatabase\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

	protected $table = "codepress_categories";

	protected $fillable = [
		"name",
        "description"
	];

   
}