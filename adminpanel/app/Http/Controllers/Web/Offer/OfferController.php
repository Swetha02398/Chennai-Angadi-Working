<?php

namespace App\Http\Controllers\Web\Offer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Product;
use App\Models\MainCategory;

class OfferController extends Controller
{
    public function table(Request $request)
    {
        // Auto-deactivate expired offers
        Offer::where('status', 1)
            ->where('end_date', '<', now()->toDateString())
            ->update(['status' => 0]);

        $query = Offer::orderBy('priority', 'asc');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('description', 'LIKE', '%' . $search . '%');
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Pagination with 10 items per page
        $offers = $query->paginate(10);

        return view('offer.offer-table', [
            'offers' => $offers,
            'search' => $request->search ?? '',
            'status' => $request->status ?? ''
        ]);
    }

    public function create()
    {
        $products = Product::where('status', 1)->get();
        $categories = MainCategory::where('status', 1)->get();
        return view('offer.offer-create', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'priority' => 'required|integer|unique:offers,priority',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'product_ids' => 'required|array|min:1',
            'banner_image' => 'required|image|max:2048',
        ]);

        $data = $validated;
        $data['description'] = $request->description ?? null;
        $data['status'] = 1;
        $data['product_ids'] = json_encode($request->product_ids);

        if ($request->hasFile('banner_image')) {
            $image = $request->file('banner_image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/offers'), $filename);
            $data['banner_image'] = $filename;
        }

        Offer::create($data);

        return redirect()->route('offer.table')->with('success', 'Offer created successfully!');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $offer = Offer::findOrFail($id);
        $products = Product::where('status', 1)->get();
        $categories = MainCategory::where('status', 1)->get();
        return view('offer.offer-create', compact('offer', 'products', 'categories'));
    }

    /**
     * Update offer
     */
    public function update(Request $request, $id)
    {
        $offer = Offer::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'priority' => 'required|integer|unique:offers,priority,' . $id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'product_ids' => 'required|array|min:1',
            'banner_image' => 'nullable|image|max:2048',
        ]);

        $data = $validated;
        $data['description'] = $request->description;
        $data['priority'] = $request->priority ?? 0;
        $data['status'] = $request->status ?? 1;
        $data['product_ids'] = $request->product_ids ?? [];
        $data['category_ids'] = $request->category_ids ?? [];

        // ✅ If new banner uploaded → replace old one
        if ($request->hasFile('banner_image')) {
            $image = $request->file('banner_image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/offers'), $filename);

            // Delete old banner if exists
            if ($offer->banner_image && file_exists(public_path('uploads/offers/' . $offer->banner_image))) {
                unlink(public_path('uploads/offers/' . $offer->banner_image));
            }

            $data['banner_image'] = $filename;
        } else {
            $data['banner_image'] = $offer->banner_image;
        }

        $offer->update($data);

        return redirect()->route('offer.table')->with('success', 'Offer updated successfully!');
    }

    public function toggleStatus($id)
    {
        $offer = Offer::findOrFail($id);

        // Toggle 1 ↔ 0
        $offer->status = $offer->status == 1 ? 0 : 1;
        $offer->save();
        return redirect()->route('offer.table')->with('success', 'Offer status updated successfully!');

    }

    public function destroy($id)
    {
        $offer = Offer::find($id);
        if ($offer) {
            $offer->delete();
            return back()->with('success', 'Offer deleted successfully!');
        }
        return back()->with('error', 'Offer not found!');
    }

    public function show($id)
    {
        $offer = Offer::findOrFail($id);

        // Safely get product IDs (array or string)
        $productIds = $offer->product_ids;

        if (is_string($productIds)) {
            $productIds = json_decode($productIds, true) ?? [];
        }

        if (!is_array($productIds)) {
            $productIds = [];
        }

        $productNames = \App\Models\Product::whereIn('id', $productIds)->pluck('productname')->toArray();

        return view('offer.offer-view', compact('offer', 'productNames'));
    }

    public function checkPriority(Request $request)
    {
        $priority = $request->input('priority');
        $id = $request->input('id');

        $query = Offer::where('priority', $priority);
        if ($id) {
            $query->where('id', '!=', $id);
        }

        $exists = $query->exists();

        return response()->json([
            'unique' => !$exists
        ]);
    }

}