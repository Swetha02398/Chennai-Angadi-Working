<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderApiController extends Controller
{
    // 1. Get ALL sliders (optionally by position)
    public function index(Request $request)
    {
        $position = $request->query('position'); // top | middle | bottom

        $query = Slider::where('status', 1)
            ->orderBy('sort_order');

        if ($position) {
            $query->where('slider_position', $position);
        }

        $sliders = $query->get()->map(function ($slider) {
            $slider->image_url = asset($slider->image);
            return $slider;
        });

        return response()->json([
            'success' => true,
            'count' => $sliders->count(),
            'data' => $sliders,
        ]);
    }

    // 2. Get SINGLE slider by ID
    public function show($id)
    {
        $slider = Slider::where('status', 1)->find($id);

        if (!$slider) {
            return response()->json([
                'success' => false,
                'message' => 'Slider not found',
            ], 404);
        }

        $slider->image_url = asset($slider->image);

        return response()->json([
            'success' => true,
            'data' => $slider,
        ]);
    }

    // 3. Get ALL sliders grouped by position (top, middle, bottom)
    public function grouped()
    {
        $sliders = Slider::where('status', 1)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($slider) {
                $slider->image_url = asset($slider->image);
                return $slider;
            });

        return response()->json([
            'success' => true,
            'data' => [
                'top' => $sliders->where('slider_position', 'top')->values(),
                'middle' => $sliders->where('slider_position', 'middle')->values(),
                'bottom' => $sliders->where('slider_position', 'bottom')->values(),
            ],
        ]);
    }
}
