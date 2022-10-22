<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App;

class CategoryJob extends Model
{
    protected $with = ['categoryjob_translations'];

    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $categoryjob_translation = $this->categoryjob_translations->where('lang', $lang)->first();
        return $categoryjob_translation != null ? $categoryjob_translation->$field : $this->$field;
    }

    public function categoryjob_translations(){
    	return $this->hasMany(CategoryJobTranslation::class);
    }

    public function products(){
    	return $this->hasMany(Product::class);
    }

    public function classified_products(){
    	return $this->hasMany(CustomerProduct::class);
    }

    public function categoriesjob()
    {
        return $this->hasMany(CategoryJob::class, 'parent_id');
    }

    public function childrenCategoriesjob()
    {
        return $this->hasMany(CategoryJob::class, 'parent_id')->with('categoriesjob');
    }

    public function parentCategoryJob()
    {
        return $this->belongsTo(CategoryJob);
    }
    
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class);
    }
}
