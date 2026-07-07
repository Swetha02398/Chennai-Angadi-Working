<?php

namespace App\Http\Controllers\Web\Category;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Models\MainCategory;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    // Show all subcategories
    public function index(Request $request)
    {
        $query = SubCategory::with('mainCategory');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('slug', 'LIKE', '%' . $search . '%');
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Order by 'id' field
        $query->orderBy('id', 'asc');

        // Pagination with 10 items per page
        $subcategories = $query->paginate(10);

        return view('category.subcategory', [
            'subcategories' => $subcategories,
            'search' => $request->search ?? '',
            'status' => $request->status ?? ''
        ]);
    }

    // Create form
    public function create()
    {
        $maincategories = MainCategory::all();
        return view('category.subcategory-create', compact('maincategories'));
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'main_category_id' => 'required|exists:main_categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:sub_categories,slug',
            'status' => 'required|in:active,inactive',
            'subimage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'orderby' => [
                'nullable',
                'integer',
                \Illuminate\Validation\Rule::unique('sub_categories')->where(function ($query) use ($request) {
                    return $query->where('main_category_id', $request->main_category_id);
                })
            ],
        ]);
        $imagePath = null;
        if ($request->hasFile('subimage')) {
            $image = $request->file('subimage');
            $imageName = 'sc_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/subcategory'), $imageName);
            $imagePath = 'uploads/subcategory/' . $imageName;
        }

        $subcategory = SubCategory::create([
            'main_category_id' => $request->main_category_id,
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
            'subimage' => $imagePath,
            'orderby' => $request->orderby,
        ]);


        NotificationHelper::sendToAll(
            'New Sub Category Added',
            'A new sub category "' . $subcategory->name . '" has been added.',
            'high',
            'admin'
        );

        return redirect()->route('subcategory.index')->with('success', 'Sub Category added successfully');
    }

    // Edit
    public function edit($id)
    {
        $sub = SubCategory::findOrFail($id);
        $maincategories = MainCategory::all();
        return view('category.subcategory-edit', compact('sub', 'maincategories'));
    }

    // Update
    public function update(Request $request, $id)
    {
        $sub = SubCategory::findOrFail($id);

        $request->validate([
            'main_category_id' => 'required|exists:main_categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:sub_categories,slug,' . $id,
            'status' => 'required|in:active,inactive',
            'subimage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'orderby' => [
                'nullable',
                'integer',
                \Illuminate\Validation\Rule::unique('sub_categories')->where(function ($query) use ($request) {
                    return $query->where('main_category_id', $request->main_category_id);
                })->ignore($id)
            ],
        ]);

        $imagePath = $sub->subimage;

        if ($request->hasFile('subimage')) {

            // 1️⃣ Delete old image
            if (!empty($sub->subimage)) {
                $oldPath = public_path($sub->subimage);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            // 2️⃣ Save new image
            $image = $request->file('subimage');
            $imageName = 'sc_' . $sub->id . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/subcategory'), $imageName);

            // 3️⃣ Assign new path
            $imagePath = 'uploads/subcategory/' . $imageName;
        }


        $sub->update([
            'main_category_id' => $request->main_category_id,
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
            'subimage' => $imagePath,
            'orderby' => $request->orderby,
        ]);

        return redirect()->route('subcategory.index')->with('success', 'Sub Category updated successfully');
    }

    // Delete
    public function destroy($id)
    {
        $sub = SubCategory::findOrFail($id);

        if ($sub->subimage && file_exists(public_path($sub->subimage))) {
            unlink(public_path($sub->subimage));
        }

        $sub->delete();

        return redirect()->route('subcategory.index')
            ->with('success', 'Sub Category deleted successfully');
    }

    // AJAX: Get subcategories by main category ID
    public function getByMainCategory($mainCategoryId)
    {
        $subcategories = SubCategory::where('main_category_id', $mainCategoryId)->get(['id', 'name']);
        return response()->json($subcategories);
    }

    // Toggle Status (active/inactive)
    public function SubtoggleStatus($id)
    {
        $sub = SubCategory::findOrFail($id);
        $sub->status = $sub->status == 'active' ? 'inactive' : 'active';
        $sub->save();

        return redirect()->route('subcategory.index')
            ->with('success', 'Sub Category status updated successfully');
    }
}
