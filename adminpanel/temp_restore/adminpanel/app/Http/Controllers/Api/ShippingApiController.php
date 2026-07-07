<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShippingZoneRegion;
use App\Models\ShippingRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShippingApiController extends Controller
{
    /**
     * Calculate shipping charges dynamically based on state, cart total, and weight.
     */
    public function calculateCharge(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'state'        => 'required|string',
            'cart_total'   => 'required|numeric|min:0',
            'total_weight' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $state       = $request->input('state');
        $cartTotal   = $request->input('cart_total');
        $totalWeight = $request->input('total_weight');

        // Step 1: Find active ShippingZoneRegion by state
        $region = ShippingZoneRegion::where('state', $state)
            ->where('is_active', 1)
            ->first();

        if (!$region) {
            return response()->json([
                'status'  => false,
                'message' => 'Shipping not available for this state',
            ], 200);
        }

        $shippingZoneId = $region->shipping_zone_id;

        // Step 2: Find active ShippingRule for this zone where state exists in JSON "states" column
        $rule = ShippingRule::with('slabs')
            ->where('shipping_zone_id', $shippingZoneId)
            ->where('is_active', 1)
            ->whereJsonContains('states', $state)
            ->first();

        if (!$rule) {
            return response()->json([
                'status'  => false,
                'message' => 'No shipping rule found for this state',
            ], 200);
        }

        // Step 3: Determine calculation value based on condition_type
        $conditionType   = $rule->condition_type;
        $calculatedValue = ($conditionType === 'weight') ? $totalWeight : $cartTotal;

        // Step 4: Find matching slab
        $matchingSlab = $rule->slabs
            ->where('min_slab', '<=', $calculatedValue)
            ->where('max_slab', '>=', $calculatedValue)
            ->sortBy('min_slab')
            ->first();

        if (!$matchingSlab) {
            return response()->json([
                'status'  => false,
                'message' => 'No matching shipping slab found for the given value',
            ], 404);
        }

        // Step 5: Return response
        return response()->json([
            'status'           => true,
            'state'            => $state,
            'shipping_zone_id' => $shippingZoneId,
            'shipping_rule_id' => $rule->id,
            'condition_type'   => $conditionType,
            'calculated_on'    => $calculatedValue,
            'slab'             => [
                'slab_id'  => $matchingSlab->id,
                'min_slab' => $matchingSlab->min_slab,
                'max_slab' => $matchingSlab->max_slab,
                'amount'   => $matchingSlab->shipping_amount,
            ],
            'shipping_charge'  => $matchingSlab->shipping_amount,
        ], 200);
    }
    
    /**
     * Get all active shipping zones.
     */
    public function getShippingZones()
    {
        $zones = \App\Models\ShippingZone::where('is_active', 1)->get();
        return response()->json([
            'status' => true,
            'data'   => $zones,
        ], 200);
    }
    /**
     * Get all active shipping states mapped to zones.
     */
    public function getShippingStates()
    {
        $states = ShippingZoneRegion::with('zone:id,name')
            ->where('is_active', 1)
            ->get();
        return response()->json([
            'status' => true,
            'data'   => $states,
        ], 200);
    }
/**
     * Get all active shipping rules with their slabs.
     */
    public function getShippingRules()
    {
        $rules = ShippingRule::with(['zone:id,name', 'slabs'])
            ->where('is_active', 1)
            ->get();

        return response()->json([
            'status' => true,
            'data'   => $rules,
        ], 200);
    }
}
