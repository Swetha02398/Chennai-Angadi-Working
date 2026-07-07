<?php

namespace App\Http\Controllers\Web\Category;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MainCategoryController extends Controller
{
    // Show all main categories
    public function index(Request $request)
    {
        $query = MainCategory::query();

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
        $maincategories = $query->paginate(10);

        return view('category.maincategory', [
            'maincategories' => $maincategories,
            'search' => $request->search ?? '',
            'status' => $request->status ?? ''
        ]);
    }

    // Show create form
    public function create()
    {
        return view('category.maincategory-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:main_categories,slug',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'orderby' => 'nullable|integer|unique:main_categories,orderby',
        ]);

        $imagePath = null;

        // Code-1 style logic (save only)
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $imageName = 'mc_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/maincategory'), $imageName);

            $imagePath = 'uploads/maincategory/' . $imageName;
        }

        $category = MainCategory::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
            'image' => $imagePath,
            'orderby' => $request->orderby,
        ]);

        NotificationHelper::sendToAll(
            'New Main Category Added',
            'A new main category "' . $category->name . '" has been added.',
            'high',
            'admin'
        );

        return redirect()->route('maincategory.index')
            ->with('success', 'Main Category created successfully');
    }

    // Show edit
    public function edit($id)
    {
        $main = MainCategory::findOrFail($id);
        return view('category.maincategory-edit', compact('main'));
    }

    public function update(Request $request, $id)
    {
        $main = MainCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:main_categories,slug,' . $id,
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'orderby' => 'nullable|integer|unique:main_categories,orderby,' . $id,
        ]);

        // Default → keep old image
        $imagePath = $main->image;

        // Code-1 style logic
        if ($request->hasFile('image')) {

            // 1️⃣ Delete old image
            if (!empty($main->image)) {
                $oldImagePath = public_path($main->image);
                if (file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
            }

            // 2️⃣ Save new image
            $image = $request->file('image');
            $imageName = 'mc_' . $main->id . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/maincategory'), $imageName);

            // 3️⃣ Set new path
            $imagePath = 'uploads/maincategory/' . $imageName;
        }

        // Update record
        $main->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
            'image' => $imagePath,
            'orderby' => $request->orderby,
        ]);

        return redirect()->route('maincategory.index')
            ->with('success', 'Main Category updated successfully');
    }
    // Delete
    public function destroy($id)
    {
        $main = MainCategory::findOrFail($id);

        if ($main->image && file_exists(public_path($main->image))) {
            unlink(public_path($main->image));
        }

        $main->delete();

        return redirect()->route('maincategory.index')
            ->with('success', 'Main Category deleted successfully');
    }

    // Toggle Status (active/inactive)
    public function toggleStatus($id)
    {
        $main = MainCategory::findOrFail($id);
        $main->status = $main->status == 'active' ? 'inactive' : 'active';
        $main->save();

        return redirect()->route('maincategory.index')
            ->with('success', 'Main Category status updated successfully');
    }
}
