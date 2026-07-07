<?php
namespace App\Http\Controllers\Web\Review;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{

public function index(Request $request)
{
    $search = $request->input('search', ''); // default to empty string if not set
    $status = $request->input('status', ''); // also define status for dropdown

    $reviews = Review::query()
        ->when($search, function($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('product', function($q) use ($search) {
                      $q->where('productname', 'like', "%{$search}%");
                  });
        })
        ->when($status !== '', function($query) use ($status) {
            $query->where('approved', $status);
        })
        ->paginate(10);

    return view('review.review-table', compact('reviews', 'search', 'status'));
}


    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'comment' => 'required',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Review::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->id(),
            'name' => auth()->check() ? auth()->user()->name : $request->name,
            'email' => auth()->check() ? auth()->user()->email : $request->email,
            'website' => $request->website,
            'comment' => $request->comment,
            'rating' => $request->rating,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Review added successfully, waiting for approval'
        ]);
    }

    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->approved = true;
        $review->save();

        return redirect()->back()->with('success', 'Review Approved');
    }

    public function destroy($id)
    {
        Review::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Review Deleted');
    }

public function show($id)
{
    $review = Review::with('product')->findOrFail($id);

    return view('review.review-view', compact('review'));
}

}