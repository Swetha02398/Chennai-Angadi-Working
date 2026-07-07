<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Product;
use App\Models\MainCategory;
use Illuminate\Http\Request;
class OfferApiController extends Controller
{
    // GET: all offers
    public function index(Request $request)
    {
        $offers = Offer::active()
            ->orderBy('priority', 'asc')
            ->get();

        // Add full URL to banner images
        $offers->transform(function ($offer) {
            if ($offer->banner_image) {
                $offer->banner_image_url = asset('uploads/offers/' . $offer->banner_image);
            } else {
                $offer->banner_image_url = null;
            }
            return $offer;
        });
        
        return response()->json([
            'status' => true,
            'success' => true,
            'count' => $offers->count(),
            'data' => $offers
        ]);
    }

    // GET: offer by id
    public function show($id)
    {
        $offer = Offer::find($id);

        if (!$offer) {
            return response()->json([
                'status' => false,
                'message' => 'Offer not found'
            ], 404);
        }

        if ($offer->banner_image) {
            $offer->banner_image_url = asset('uploads/offers/' . $offer->banner_image);
        }

        return response()->json([
            'status' => true,
            'data' => $offer
        ]);
    }

    // DELETE: offer by id
    public function destroy($id)
    {
        $offer = Offer::find($id);

        if (!$offer) {
            return response()->json([
                'status' => false,
                'message' => 'Offer not found'
            ], 404);
        }

        $offer->delete();

        return response()->json([
            'status' => true,
            'message' => 'Offer deleted successfully'
        ]);
    }
}
