<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'main_category_id', 'status', 'subimage', 'orderby'];
    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class, 'main_category_id');
    }

    public function childCategories()
    {
        return $this->hasMany(ChildCategory::class, 'sub_category_id')
            ->orderByRaw('CASE WHEN orderby IS NULL THEN 1 ELSE 0 END, orderby ASC, id ASC');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'subcategory_id');
    }

}