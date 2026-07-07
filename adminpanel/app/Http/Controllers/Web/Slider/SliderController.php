<?php

namespace App\Http\Controllers\Web\Slider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
    // Show all sliders
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $status = $request->get('status', '');

        $query = Slider::orderBy('slider_position')->orderBy('sort_order');

        // Filter by search term
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title_text', 'like', "%{$search}%")
                  ->orWhere('slider_position', 'like', "%{$search}%");
            });
        }

        // Filter by status - only if status is not empty
        if ($status !== '' && $status !== null) {
            $query->where('status', (int)$status);
        }

        $sliders = $query->paginate(6);

        return view('slider.slider-table', compact('sliders', 'search', 'status'));
    }

    // Show create form
    public function create()
    {
        $counts = [
            'top' => Slider::where('slider_position', 'top')->count(),
            'middle' => Slider::where('slider_position', 'middle')->count(),
            'bottom' => Slider::where('slider_position', 'bottom')->count(),
        ];
        return view('slider.slider-create', compact('counts'));
    }

    // Store multiple sliders
    public function store(Request $request)
    {
        $request->validate([
            'slider_position' => 'required|in:top,middle,bottom',
            'image.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'title_text' => 'nullable|string|max:255',
        ]);

        $limits = ['top' => 5, 'middle' => 3, 'bottom' => 1];
        $position = strtolower($request->slider_position);
        $currentCount = Slider::where('slider_position', $request->slider_position)->count();
        $newCount = count($request->file('image') ?? []);

        if (($currentCount + $newCount) > $limits[$position]) {
            return redirect()->back()->with('error', "Limit exceeded! Maximum {$limits[$position]} sliders allowed for {$position} position (Current: {$currentCount}).");
        }

        $images = $request->file('image');

        foreach ($images as $img) {
            $lastOrder = Slider::where('slider_position', $request->slider_position)->max('sort_order');
            $newOrder = $lastOrder ? $lastOrder + 1 : 1;

            $folderPath = public_path('uploads/Sliders');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $filename = "{$position}_{$newOrder}_" . time() . '.' . $img->getClientOriginalExtension();
            $img->move($folderPath, $filename);

            Slider::create([
                'slider_position' => $request->slider_position,
                'title_text' => $request->title_text,
                'image' => 'uploads/Sliders/' . $filename,
                'sort_order' => $newOrder,
                'status' => $request->status ?? 1,
            ]);
        }

        return redirect()->route('slider.table')->with('success', 'Sliders added successfully!');
    }

    // Edit form
    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('slider.slider-edit', compact('slider'));
    }

    // Update single slider
    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        $request->validate([
            'slider_position' => 'required|in:top,middle,bottom',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'title_text' => 'nullable|string|max:255',
        ]);

        $limits = ['top' => 5, 'middle' => 3, 'bottom' => 1];
        $newPosition = strtolower($request->slider_position);

        if (strtolower($slider->slider_position) !== $newPosition) {
            $targetCount = Slider::where('slider_position', $request->slider_position)->count();
            if ($targetCount >= $limits[$newPosition]) {
                return redirect()->back()->with('error', "Limit exceeded! Cannot move to {$newPosition} as it already has {$limits[$newPosition]} sliders.");
            }
        }

        $data = [
            'slider_position' => $request->slider_position,
            'title_text' => $request->title_text,
            'status' => $request->status ?? 1,
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            $oldPath = public_path($slider->image);
            if (file_exists($oldPath)) unlink($oldPath);

            // New image store
            $folderPath = public_path('uploads/Sliders');
            $position = strtolower($request->slider_position);
            $filename = "{$position}_{$slider->sort_order}_" . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($folderPath, $filename);

            $data['image'] = 'uploads/Sliders/' . $filename;
        }

        $slider->update($data);

        return redirect()->route('slider.table')->with('success', 'Slider updated successfully!');
    }

    // Delete
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        $oldPath = public_path($slider->image);
        if (file_exists($oldPath)) unlink($oldPath);
        $slider->delete();

        return redirect()->route('slider.table')->with('success', 'Slider deleted successfully!');
    }

    // toggle
    public function toggleStatus($id)
    {
     $slider = Slider::findOrFail($id);

     // Toggle 1 ↔ 0
     $slider->status = $slider->status == 1 ? 0 : 1;
     $slider->save();
     return redirect()->route('slider.table')->with('success', 'Slider status updated successfully!');

    }   

}
