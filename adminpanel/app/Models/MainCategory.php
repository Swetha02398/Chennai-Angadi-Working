<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    use HasFactory;

    // Add 'image' to fillable
    protected $fillable = ['name', 'image', 'slug', 'status', 'orderby'];
    
    protected $appends = [];

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'main_category_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
