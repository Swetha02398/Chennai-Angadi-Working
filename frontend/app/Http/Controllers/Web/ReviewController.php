<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

public function store(Request $request)
{

    
    // ✅ validation here
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string',
    ]);
    Review::create([
        'product_id' => $request->product_id,
        'user_id' => auth()->id(), // nullable if guest
        'name' => $request->name,
        'email' => $request->email,
        'website' => $request->website,
        'comment' => $request->comment,
        'rating' => $request->rating,
    ]);

    return back()->with('success', 'Review submitted successfully');
}

}