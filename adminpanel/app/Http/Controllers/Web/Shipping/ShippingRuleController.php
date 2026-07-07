<?php

namespace App\Http\Controllers\Web\Shipping;

use App\Http\Controllers\Controller;
use App\Models\ShippingRule;
use App\Models\ShippingRuleSlab;
use App\Models\ShippingZone;
use App\Models\ShippingZoneRegion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShippingRuleController extends Controller
{
    // LIST
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $query = ShippingRule::with('zone');

        if ($search) {
            $query->where('condition_type', 'like', "%$search%")
                  ->orWhereHas('zone', fn($q) =>
                      $q->where('name', 'like', "%$search%")
                  );
        }

        if ($status !== null && $status !== '') {
            $query->where('is_active', (int)$status);
        }

        $rules = $query->latest()->paginate(10);

        return view('shipping.rules-table', compact('rules','search','status'));
    }

    // CREATE
    public function create()
    {
        $zones  = ShippingZone::where('is_active',1)->get();
        $states = [];

        return view('shipping.rules-create', compact('zones','states'));
    }

    // STORE
    public function store(Request $r)
    {
        $r->validate([
            'shipping_zone_id' => 'required',
            'states'           => 'required|array|min:1',
            'condition_type'   => 'required|in:weight,final_amount',
            'slabs'            => 'required|array|min:1',
        ]);

        // Validate that states belong to the selected zone
        $zoneRegions = ShippingZoneRegion::where('shipping_zone_id', $r->shipping_zone_id)
            ->where('is_active', 1)
            ->get();
            
        $validStates = [];
        foreach ($zoneRegions as $region) {
            $parts = explode(',', $region->state);
            foreach ($parts as $part) {
                $trimmed = trim($part);
                if ($trimmed !== '') {
                    $validStates[] = $trimmed;
                }
            }
        }
        $validStates = array_unique($validStates);

        foreach ($r->states as $state) {
            if (!in_array($state, $validStates)) {
                return back()->withErrors("The state '$state' does not belong to the selected shipping zone.")->withInput();
            }
        }

        // ❌ State conflict check
        $exists = ShippingRule::where('shipping_zone_id',$r->shipping_zone_id)
            ->where('is_active',1)
            ->where(function($q) use ($r){
                foreach($r->states as $state){
                    $q->orWhereJsonContains('states',$state);
                }
            })->exists();

        if ($exists) {
            return back()->withErrors('One or more states already assigned to another rule.');
        }

        DB::transaction(function() use ($r){

            $rule = ShippingRule::create([
                'shipping_zone_id' => $r->shipping_zone_id,
                'states'           => $r->states,
                'condition_type'   => $r->condition_type,
                'is_active'        => 1,
            ]);

            foreach ($r->slabs as $slab) {
                $rule->slabs()->create([
                    'min_slab'        => $slab['min'],
                    'max_slab'        => $slab['max'],
                    'shipping_amount' => $slab['amount'],
                ]);
            }
        });

        return redirect()->route('shipping.rules.table')
            ->with('success','Shipping rule added successfully.');
    }

    // EDIT
    public function edit($id)
    {
        $rule   = ShippingRule::with('slabs')->findOrFail($id);
        $zones  = ShippingZone::where('is_active',1)->get();
        
        $regions = ShippingZoneRegion::where('shipping_zone_id', $rule->shipping_zone_id)
            ->where('is_active', 1)
            ->get();
            
        $statesList = [];
        foreach ($regions as $region) {
            $parts = explode(',', $region->state);
            foreach ($parts as $part) {
                $trimmed = trim($part);
                if ($trimmed !== '') {
                    $statesList[] = $trimmed;
                }
            }
        }
        $statesList = array_values(array_unique($statesList));
        sort($statesList);

        $states = array_map(function($stateName) {
            return (object)['state' => $stateName];
        }, $statesList);

        return view('shipping.rules-edit', compact('rule','zones','states'));
    }

    // UPDATE
    public function update(Request $r, $id)
    {
        $rule = ShippingRule::with('slabs')->findOrFail($id);

        $r->validate([
            'shipping_zone_id' => 'required',
            'states'           => 'required|array|min:1',
            'condition_type'   => 'required|in:weight,final_amount',
            'slabs'            => 'required|array|min:1',
        ]);

        // Validate that states belong to the selected zone
        $zoneRegions = ShippingZoneRegion::where('shipping_zone_id', $r->shipping_zone_id)
            ->where('is_active', 1)
            ->get();
            
        $validStates = [];
        foreach ($zoneRegions as $region) {
            $parts = explode(',', $region->state);
            foreach ($parts as $part) {
                $trimmed = trim($part);
                if ($trimmed !== '') {
                    $validStates[] = $trimmed;
                }
            }
        }
        $validStates = array_unique($validStates);

        foreach ($r->states as $state) {
            if (!in_array($state, $validStates)) {
                return back()->withErrors("The state '$state' does not belong to the selected shipping zone.")->withInput();
            }
        }

        // State conflict check for update (excluding the current rule)
        $exists = ShippingRule::where('shipping_zone_id',$r->shipping_zone_id)
            ->where('id', '!=', $id)
            ->where('is_active',1)
            ->where(function($q) use ($r){
                foreach($r->states as $state){
                    $q->orWhereJsonContains('states',$state);
                }
            })->exists();

        if ($exists) {
            return back()->withErrors('One or more states already assigned to another rule.');
        }

        DB::transaction(function() use ($r,$rule){

            $rule->update([
                'shipping_zone_id' => $r->shipping_zone_id,
                'states'           => $r->states,
                'condition_type'   => $r->condition_type,
            ]);

            // 🔥 Simplest + safest approach
            $rule->slabs()->delete();

            foreach ($r->slabs as $slab) {
                $rule->slabs()->create([
                    'min_slab'        => $slab['min'],
                    'max_slab'        => $slab['max'],
                    'shipping_amount' => $slab['amount'],
                ]);
            }
        });

        return redirect()->route('shipping.rules.table')
            ->with('success','Shipping rule updated successfully.');
    }

    // DELETE
    public function destroy($id)
    {
        ShippingRule::findOrFail($id)->delete();
        return redirect()->back()->with('success','Shipping rule deleted.');
    }

    // TOGGLE STATUS
    public function toggle($id)
    {
        $rule = ShippingRule::findOrFail($id);
        $rule->update(['is_active' => !$rule->is_active]);

        return redirect()->back()->with('success','Status updated.');
    }
    // Show single Shipping Rule
    public function show($id)
    {
        // Load rule with its zone and slabs
        $rule = ShippingRule::with(['zone', 'slabs'])->findOrFail($id);

        return view('shipping.rules-view', compact('rule'));
    }

    public function getStatesByZone($zone_id)
    {
        $regions = ShippingZoneRegion::where('shipping_zone_id', $zone_id)
            ->where('is_active', 1)
            ->get();
            
        $states = [];
        foreach ($regions as $region) {
            $parts = explode(',', $region->state);
            foreach ($parts as $part) {
                $trimmed = trim($part);
                if ($trimmed !== '') {
                    $states[] = $trimmed;
                }
            }
        }
        
        $states = array_values(array_unique($states));
        sort($states);
        
        return response()->json($states);
    }
}