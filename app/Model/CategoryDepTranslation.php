<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CategoryDepTranslation extends Model
{
    protected $fillable = ['name', 'lang', 'category_dep_id '];

    public function CategoryDep(){
    	return $this->belongsTo(CategoryDep::class);
    }
}
