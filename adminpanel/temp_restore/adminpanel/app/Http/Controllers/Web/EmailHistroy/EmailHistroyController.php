<?php

namespace App\Http\Controllers\Web\EmailHistroy;

use App\Http\Controllers\Controller;
use App\Models\EmailHistory;
use Illuminate\Http\Request;

class EmailHistroyController extends Controller
{
    /**
     * Display email history table
     */
    public function index(Request $request)
    {
        $query = EmailHistory::query()->orderBy('sent_at', 'desc');

        // Search by order number or recipient email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'LIKE', "%{$search}%")
                    ->orWhere('recipient_email', 'LIKE', "%{$search}%")
                    ->orWhere('recipient_name', 'LIKE', "%{$search}%");
            });
        }

        // Filter by email type
        if ($request->filled('type')) {
            $query->where('email_type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $emails = $query->paginate(15)->withQueryString();

        return view('email-history.email-history', [
            'emails' => $emails,
            'search' => $request->search,
            'type' => $request->type,
            'status' => $request->status,
        ]);
    }

    /**
     * Delete email history record
     */
    public function destroy($id)
    {
        try {
            $email = EmailHistory::findOrFail($id);
            $email->delete();

            return redirect()->route('email-history.table')
                ->with('success', 'Email history record deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('email-history.table')
                ->with('error', 'Failed to delete email history: ' . $e->getMessage());
        }
    }
}
