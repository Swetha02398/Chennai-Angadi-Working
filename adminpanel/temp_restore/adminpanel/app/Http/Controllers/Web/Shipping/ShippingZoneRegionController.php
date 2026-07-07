<?php

namespace App\Http\Controllers\Web\Shipping;

use App\Http\Controllers\Controller;
use App\Models\ShippingZone;
use App\Models\ShippingZoneRegion;
use Illuminate\Http\Request;
class ShippingZoneRegionController extends Controller
{
    public function index(Request $request)
    {
    $search = $request->input('search', '');
    $status = $request->input('status', '');

    $query = ShippingZoneRegion::with('zone');

    // Search by state name OR zone name
    if (!empty($search)) {
        $query->where('state', 'like', "%$search%")
              ->orWhereHas('zone', function ($q) use ($search) {
                  $q->where('name', 'like', "%$search%");
              });
    }

    // Status filter (only if status is not empty)
    if ($status !== '' && $status !== null) {
        $query->where('is_active', (int)$status);
    }

    $state = $query->latest()->paginate(10);

        return view('shipping.state-table', compact('state','search','status'));
    }

    public function create()
    {
        $zones = ShippingZone::all();
        return view('shipping.state-create', compact('zones'));
    }

    public function store(Request $r)
    {
        ShippingZoneRegion::create($r->only('shipping_zone_id','state'));
        return redirect()->route('shipping.state.table');
    }

    public function edit($id)
    {
        $state = ShippingZoneRegion::findOrFail($id);
        $zones = ShippingZone::all();
        return view('shipping.state-edit', compact('state','zones'));
    }

    public function update(Request $r, $id)
    {
        $state = ShippingZoneRegion::findOrFail($id);
        $state->update($r->only('shipping_zone_id','state','is_active'));
        return redirect()->route('shipping.state.table');
    }

    public function destroy($id)
    {
        ShippingZoneRegion::findOrFail($id)->delete();
        return redirect()->route('shipping.state.table');
    }
   public function toggle($id)
    {
        $state = ShippingZoneRegion::findOrFail($id);
        $state->is_active = $state->is_active == 1 ? 0 : 1;
        $state->save();

        return redirect()->back()->with('success', 'State status updated');
    }
     
}
