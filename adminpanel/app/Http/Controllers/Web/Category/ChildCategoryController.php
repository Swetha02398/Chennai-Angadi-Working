<?php

namespace App\Http\Controllers\Web\Category;
use App\Http\Controllers\Controller;
use App\Models\ChildCategory;
use App\Models\SubCategory;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChildCategoryController extends Controller
{
    /* ============================================================
        1. INDEX – Show all child categories
    ============================================================ */
    public function index(Request $request)
    {
        $query = ChildCategory::with('subCategory');

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
        $childcategories = $query->paginate(10);

        return view('category.childcategory', [
            'childcategories' => $childcategories,
            'search' => $request->search ?? '',
            'status' => $request->status ?? ''
        ]);
    }

    /* ============================================================
        2. CREATE – Show create form
    ============================================================ */
    public function create()
    {
        $subcategories = SubCategory::all();
        return view('category.childcategory-create', compact('subcategories'));
    }

    /* ============================================================
        3. STORE – Save new child category
    ============================================================ */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'childimage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'orderby' => [
                'nullable',
                'integer',
                \Illuminate\Validation\Rule::unique('child_categories')->where(function ($query) use ($request) {
                    return $query->where('sub_category_id', $request->sub_category_id);
                })
            ],
        ]);

        $imagePath = null;

        if ($request->hasFile('childimage')) {

            $image = $request->file('childimage');
            $imageName = 'cc_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/childcategory'), $imageName);

            $imagePath = 'uploads/childcategory/' . $imageName;
        }


        $child = ChildCategory::create([
            'sub_category_id' => $request->sub_category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status ?? 'active',
            'childimage' => $imagePath,
            'orderby' => $request->orderby,
        ]);

        NotificationHelper::sendToAll(
            'New Child Category Added',
            'A new child category "' . $child->name . '" has been added.',
            'high',
            'admin'
        );

        return redirect()->route('childcategory.index')
            ->with('success', 'Child Category added successfully');
    }

    /* ============================================================
        4. EDIT – Show edit form
    ============================================================ */
    public function edit($id)
    {
        $child = ChildCategory::findOrFail($id);
        $subcategories = SubCategory::all();

        return view('category.childcategory-edit', compact('child', 'subcategories'));
    }

    /* ============================================================
        5. UPDATE – Update existing child category
    ============================================================ */
    public function update(Request $request, $id)
    {
        $child = ChildCategory::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'childimage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'orderby' => [
                'nullable',
                'integer',
                \Illuminate\Validation\Rule::unique('child_categories')->where(function ($query) use ($request) {
                    return $query->where('sub_category_id', $request->sub_category_id);
                })->ignore($id)
            ],
        ]);

        $imagePath = $child->childimage;

        if ($request->hasFile('childimage')) {

            // 1️⃣ Delete old image
            if (!empty($child->childimage)) {
                $oldPath = public_path($child->childimage);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            // 2️⃣ Save new image
            $image = $request->file('childimage');
            $imageName = 'cc_' . $child->id . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/childcategory'), $imageName);

            // 3️⃣ Assign new path
            $imagePath = 'uploads/childcategory/' . $imageName;
        }

        $child->update([
            'sub_category_id' => $request->sub_category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status ?? $child->status,
            'childimage' => $imagePath,
            'orderby' => $request->orderby,
        ]);

        return redirect()->route('childcategory.index')
            ->with('success', 'Child Category updated successfully');
    }

    /* ============================================================
        6. DELETE – Delete child category
    ============================================================ */
    public function destroy($id)
    {
        $child = ChildCategory::findOrFail($id);

        // Delete child image
        if ($child->childimage && file_exists(public_path($child->childimage))) {
            unlink(public_path($child->childimage));
        }

        $child->delete();

        return redirect()->route('childcategory.index')
            ->with('success', 'Child Category deleted successfully');
    }

    // AJAX: Get child categories by sub category ID
    public function getBySubCategory($subCategoryId)
    {
        $childcategories = ChildCategory::where('sub_category_id', $subCategoryId)->get(['id', 'name']);
        return response()->json($childcategories);
    }

    // Toggle Status (active/inactive)
    public function ChildtoggleStatus($id)
    {
        $child = ChildCategory::findOrFail($id);
        $child->status = $child->status == 'active' ? 'inactive' : 'active';
        $child->save();

        return redirect()->route('childcategory.index')
            ->with('success', 'Child Category status updated successfully');
    }
}
