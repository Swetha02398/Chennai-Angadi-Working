<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    use HasFactory;

    // Add 'image' to fillable
    protected $fillable = ['name', 'image', 'slug', 'status', 'orderby'];

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'main_category_id')
            ->orderByRaw('CASE WHEN orderby IS NULL THEN 1 ELSE 0 END, orderby ASC, id ASC');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

}

