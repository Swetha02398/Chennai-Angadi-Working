<?php

namespace App\Http\Controllers\Web\Contact;

use App\Http\Controllers\Controller;
use App\Models\ContactEnquiry;
use Illuminate\Http\Request;

class ContactEnquiryController extends Controller
{
    /**
     * Display a listing of the enquiries.
     */
    public function index(Request $request)
    {
        $query = ContactEnquiry::orderBy('created_at', 'desc');

        // SEARCH
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('telephone', 'LIKE', "%{$search}%")
                  ->orWhere('subject', 'LIKE', "%{$search}%");
            });
        }

        // STATUS FILTER
        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->whereIn('status', ['unread', 'pending']);
            } else {
                $query->where('status', $request->status);
            }
        }

        $enquiries = $query->paginate(10)->withQueryString();

        return view('admin.contact.index', compact('enquiries'))
            ->with([
                'search' => $request->search,
                'status' => $request->status,
            ]);
    }

    /**
     * Display the specified enquiry.
     */
    public function show($id)
    {
        $enquiry = ContactEnquiry::findOrFail($id);
        
        // Mark as read if it was unread or pending
        if (in_array($enquiry->status, ['unread', 'pending'])) {
            $enquiry->update(['status' => 'read']);
        }
        
        return view('admin.contact.show', compact('enquiry'));
    }

    /**
     * Remove the specified enquiry from storage.
     */
    public function destroy($id)
    {
        $enquiry = ContactEnquiry::findOrFail($id);
        $enquiry->delete();

        return redirect()->route('admin.contact.index')->with('success', 'Enquiry deleted successfully.');
    }
}
