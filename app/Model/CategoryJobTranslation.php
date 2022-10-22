<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CategoryJobTranslation extends Model
{
    protected $fillable = ['name', 'lang', 'category_job_id'];

    public function CategoryJob(){
    	return $this->belongsTo(CategoryJob::class);
    }
}
