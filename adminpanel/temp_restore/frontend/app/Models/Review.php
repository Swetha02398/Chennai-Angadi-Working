<?php
namespace App\Models;
use App\Models\Product;
use App\Models\User;
use App\Models\MainCategory;   // ✅ Correct
use App\Models\SubCategory;    // ✅ Correct
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'reviews'; 
    protected $fillable = [
        'product_id',
        'user_id',
        'name',
        'email',
        'website',
        'comment',
        'rating',
        'approved'
    ];

    // ---- Relationships ----

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
