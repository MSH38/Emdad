<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App;

class DepartmentTyp extends Model
{

    public function categoriesdep()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenCategoriesdep()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('categoriesdep');
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
