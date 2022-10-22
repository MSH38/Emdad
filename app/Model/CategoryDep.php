<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App;

class CategoryDep extends Model
{
    protected $with = ['category_dep_translations'];

    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $category_dep_translation = $this->category_dep_translations->where('lang', $lang)->first();
        return $category_dep_translation != null ? $category_dep_translation->$field : $this->$field;
    }

    public function category_dep_translations(){
    	return $this->hasMany(CategoryDepTranslation::class);
    }

    public function products(){
    	return $this->hasMany(Product::class);
    }

    public function classified_products(){
    	return $this->hasMany(CustomerProduct::class);
    }

    public function CategoriesDep()
    {
        return $this->hasMany(CategoryDep::class, 'parent_id');
    }

    public function childrenCategoriesdep()
    {
        return $this->hasMany(CategoryDep::class, 'parent_id')->with('CategoriesDep');
    }

    public function parentCategoryJob()
    {
        return $this->belongsTo(CategoryDep);
    }
    
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class);
    }
}
