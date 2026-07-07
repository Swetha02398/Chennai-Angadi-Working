<?php

namespace App\Http\Controllers\Web\GstHsn;
use App\Http\Controllers\Controller;
use App\Models\Gst;
use Illuminate\Http\Request;

class GstController extends Controller
{
   // ✅ List all GST settings
    public function table(Request $request)
    {
        $query = Gst::latest();
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('rounding_method', 'LIKE', '%' . $search . '%')
                  ->orWhere('notes', 'LIKE', '%' . $search . '%');
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Pagination with 10 items per page
        $gst = $query->paginate(10);

        return view('gsthsn.gst-table', [
            'gst' => $gst,
            'search' => $request->search ?? '',
            'status' => $request->status ?? ''
        ]);
    }

    // ✅ Show Add Form
    public function create()
    {
        return view('gsthsn.gst-create');
    }

    // ✅ Store New Record
    public function store(Request $request)
    {
        $request->validate([
            'default_tax_rate' => 'required|numeric|min:0|max:100',
            'enable_auto_gst'  => 'required|boolean',
            'rounding_method'  => 'nullable|string|max:50',
            'notes'            => 'nullable|string|max:500',
        ]);

        Gst::create([
            'default_tax_rate' => $request->default_tax_rate,
            'enable_auto_gst'  => $request->enable_auto_gst,
            'gst_rules'        => [],
            'rounding_method'  => $request->rounding_method ?? 'nearest',
            'last_updated_by'  => auth()->id() ?? null,
            'notes'            => $request->notes,
        ]);

        return redirect()->route('gsthsn.table')->with('success', 'GST setting added successfully!');
    }

    // ✅ Show Edit Form
    public function edit($id)
    {
        $gst = Gst::findOrFail($id);
        return view('gsthsn.gst-edit', compact('gst'));
    }

    // ✅ Update Record
    public function update(Request $request, $id)
    {
        $request->validate([
            'default_tax_rate' => 'required|numeric|min:0|max:100',
            'enable_auto_gst'  => 'required|boolean',
            'rounding_method'  => 'nullable|string|max:50',
            'notes'            => 'nullable|string|max:500',
        ]);

        $gst = Gst::findOrFail($id);
        $gst->update([
            'default_tax_rate' => $request->default_tax_rate,
            'enable_auto_gst'  => $request->enable_auto_gst,
            'rounding_method'  => $request->rounding_method,
            'notes'            => $request->notes,
            'last_updated_by'  => auth()->id() ?? null,
        ]);

        return redirect()->route('gsthsn.table')->with('success', 'GST setting updated successfully!');
    }

    // ✅ Delete Record
    public function destroy($id)
    {
        $gst = Gst::findOrFail($id);
        $gst->delete();
        return redirect()->route('gsthsn.table')->with('success', 'GST setting deleted successfully!');
    }

}