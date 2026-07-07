<?php
namespace App\Http\Controllers\Web\Shipping;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingZone;
class ShippingZoneController extends Controller
{
    public function index(Request $request) {
    $search = $request->input('search', '');
    $status = $request->input('status', '');

    $query = ShippingZone::query();

    // Search by zone name
    if (!empty($search)) {
        $query->where('name', 'like', '%' . $search . '%');
    }

    // Filter by active / inactive (only if status is not empty)
    if ($status !== '' && $status !== null) {
        $query->where('is_active', (int)$status);
    }

    $zones = $query->latest()->paginate(10);
        return view('shipping.zone-table',compact('zones','search','status'));
    }

    public function create() {
        return view('shipping.zone-create');
    }

    public function store(Request $r) {
        $r->validate([
            'name' => 'required|string|max:255',
            'priority' => 'required|integer|min:1|unique:shipping_zones,priority'
        ]);
        ShippingZone::create($r->only('name','priority'));
        return redirect()->route('shipping.zone.table')->with('success', 'Zone created successfully');
    }
      public function edit($id){
        $zone = ShippingZone::findOrFail($id);
        return view('shipping.zone-edit', compact('zone'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'priority' => 'required|integer|min:1|unique:shipping_zones,priority,' . $id
        ]);

        $zone = ShippingZone::findOrFail($id);
        $zone->update([
            'name' => $request->name,
            'priority' => $request->priority,
        ]);

        return redirect()->route('shipping.zone.table')->with('success','Zone updated successfully');
    }
    public function destroy($id){
    $zone = ShippingZone::findOrFail($id);

    // Optional: check if states/rules exist before delete
    if($zone->regions()->count() > 0 || $zone->rules()->count() > 0){
        return redirect()->route('shipping.zone.table')
                         ->with('error', 'Cannot delete zone with assigned states or rules.');
    }

    $zone->delete();

    return redirect()->route('shipping.zone.table')
                     ->with('success', 'Zone deleted successfully.');
}
 public function toggle($id)
    {
        $zone = ShippingZone::findOrFail($id);

        $zone->is_active = $zone->is_active == 1 ? 0 : 1;
        $zone->save();

        return redirect()->back()->with('success', 'Zone status updated');
    }
    

}
