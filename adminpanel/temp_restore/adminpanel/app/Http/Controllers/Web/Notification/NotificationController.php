<?php

namespace App\Http\Controllers\Web\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // =====================
    // Normal User Index
    // =====================
   public function index(Request $request)
{
    // Exclude 'admin' type notifications - they only go to admin notifications page
    $query = Notification::with(['recipients'])
        ->where('type', '!=', 'admin')
        ->orderBy('id', 'desc');
    
    // Search functionality
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where('title', 'LIKE', '%' . $search . '%')
              ->orWhere('message', 'LIKE', '%' . $search . '%')
              ->orWhere('type', 'LIKE', '%' . $search . '%');
    }

    // Filter by status
    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    // Pagination with 10 items per page
    $notifications = $query->paginate(10);

    return view('notifications.notifications-table', [
        'notifications' => $notifications,
        'search' => $request->search ?? '',
        'status' => $request->status ?? ''
    ]);
}

    // =====================
    // Admin Notifications Index
    // =====================
 public function adminIndex(Request $request)
{
    // Show only admin type notifications with role=admin
    $query = Notification::where('type', 'admin')
        ->with(['recipients'])
        ->orderBy('id', 'desc');

    // Search functionality
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where('title', 'LIKE', '%' . $search . '%')
              ->orWhere('message', 'LIKE', '%' . $search . '%');
    }

    // Filter by status (1 for active/read, 0 for inactive/unread)
    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    $notifications = $query->paginate(10);

    return view('notifications.notifications-admin', [
        'notifications' => $notifications,
        'status' => $request->status ?? '',
        'search' => $request->search ?? '',
    ]);
}


    // Alias for adminIndex to match route name
    public function adminNotifications(Request $request)
    {
        return $this->adminIndex($request);
    }

    // =====================
    // Create Form (admin)
    // =====================
    public function create()
    {
        $admins = User::whereIn('role_type', ['admin',])->get();
       // Customers from customers table
        $customers = Customer::select('id', 'username as name', 'email')->get();
   
        // If no customers, show all non-admin users
        if ($customers->isEmpty()) {
            $customers = User::whereNotIn('role_type', ['superadmin'])->get();
        }
        
        // Fetch guest customers from orders table
        $guestsRaw = \App\Models\Order::where('customer_type', 'guest')
            ->whereNotNull('guest_details')
            ->select('guest_details')
            ->get();
            
        $guests = collect();
        $seenEmails = [];
        foreach ($guestsRaw as $order) {
            $guest = $order->guest_details;
            if (is_array($guest) && isset($guest['email']) && !in_array($guest['email'], $seenEmails)) {
                $seenEmails[] = $guest['email'];
                $name = $guest['name'] ?? 'Guest';
                $idString = 'guest|' . $guest['email'] . '|' . $name;
                $guests->push([
                    'id' => $idString,
                    'name' => $name,
                    'email' => $guest['email'],
                ]);
            }
        }

        return view('notifications.notifications-create', compact('admins', 'customers', 'guests'));
    }

    // =====================
    // Store Notification
    // =====================
   public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string',
        'message' => 'required|string',
        'type' => 'required|in:normal,high,admin',
        'role' => 'required|string',
    ]);

    $fromRole = Auth::user()->role_type === 'customer' ? 'customer' : 'admin';

    // Set default status - always 'unread' for new notifications
    $notification = Notification::create([
        'title' => $request->title,
        'message' => $request->message,
        'type' => $request->type,
        'from_id' => Auth::id(),
        'from_role' => $fromRole,
        'ref_id' => $request->ref_id ?? null,
        'extra_data' => $request->extra_data ? json_encode($request->extra_data) : null,
        'status' => 'unread',
    ]);

    $users = [];
    if (in_array($request->role, ['customer', 'guest', 'all_customers']) && !empty($request->user_id)) {
        foreach ($request->user_id as $id) {
            if (str_starts_with($id, 'guest|')) {
                $parts = explode('|', $id, 3);
                if (count($parts) >= 2) {
                    $users[] = [
                        'id' => null, // Guest users don't have a database ID in the users/customers table
                        'name' => $parts[2] ?? 'Guest',
                        'email' => $parts[1],
                        'status' => 'unread',
                        'read_at' => null,
                    ];
                }
            } else {
                $customer = Customer::find($id);
                if ($customer) {
                    $users[] = [
                        'id' => $customer->id,
                        'name' => $customer->username,
                        'email' => $customer->email,
                        'status' => 'unread',
                        'read_at' => null,
                    ];
                }
            }
        }
    } else {
        // For admins/managers/staff, fetch from users table
        if (!empty($request->user_id)) {
            foreach ($request->user_id as $uid) {
                $user = User::find($uid);
                if ($user) {
                    $users[] = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'status' => 'unread',
                        'read_at' => null,
                    ];
                }
            }
        }
    }

    if (!empty($users)) {
        NotificationUser::create([
            'notification_id' => $notification->id,
            'users' => $users,
            'role' => $request->role,
        ]);

        // Trigger FCM push
        $userIds = [];
        foreach ($users as $u) {
            if (!empty($u['id'])) {
                $userIds[] = $u['id'];
            }
        }
        if (!empty($userIds)) {
            \App\Helpers\NotificationHelper::sendFirebasePush($notification->title, $notification->message, $userIds, [
                'notification_id' => (string) $notification->id
            ]);
        }
    }

    // Redirect based on notification type
    if ($request->type === 'admin') {
        return redirect()->route('notifications.admin')->with('success', 'Admin notification created successfully.');
    } else {
        return redirect()->route('notifications.table')->with('success', 'Notification created successfully.');
    }
}

    // =====================
    // Edit Form (admin)
    // =====================
    public function edit(Notification $notification)
    {
        $admins = User::whereIn('role_type', ['admin', 'superadmin', 'manager', 'staff'])->get();
        $customers = User::whereIn('role_type', ['customer', 'user'])->get();
        if ($customers->isEmpty()) {
            $customers = User::whereNotIn('role_type', ['superadmin'])->get();
        }
        
        // Get selected users from notification_users
        $notifUser = NotificationUser::where('notification_id', $notification->id)->first();
        $recipients = [];
        $selectedRole = '';
        if ($notifUser) {
            $selectedRole = $notifUser->role;
            $users = $notifUser->users;
            if (is_string($users)) {
                $users = json_decode($users, true);
            }
            if (is_array($users)) {
                if ($selectedRole === 'guest') {
                    $recipients = collect($users)->map(function ($u) {
                        return 'guest|' . ($u['email'] ?? '') . '|' . ($u['name'] ?? 'Guest');
                    })->toArray();
                } else {
                    $recipients = collect($users)->pluck('id')->toArray();
                }
            }
        }
        
        // Fetch guest customers from orders table
        $guestsRaw = \App\Models\Order::where('customer_type', 'guest')
            ->whereNotNull('guest_details')
            ->select('guest_details')
            ->get();
            
        $guests = collect();
        $seenEmails = [];
        foreach ($guestsRaw as $order) {
            $guest = $order->guest_details;
            if (is_array($guest) && isset($guest['email']) && !in_array($guest['email'], $seenEmails)) {
                $seenEmails[] = $guest['email'];
                $name = $guest['name'] ?? 'Guest';
                $idString = 'guest|' . $guest['email'] . '|' . $name;
                $guests->push([
                    'id' => $idString,
                    'name' => $name,
                    'email' => $guest['email'],
                ]);
            }
        }
        
        return view('notifications.notifications-edit', compact('notification', 'admins', 'customers', 'guests', 'recipients', 'selectedRole'));
    }
    // =====================
    // Update Notification
    // =====================
    public function update(Request $request, Notification $notification)
    {
        $request->validate([
            'title' => 'required|string',
            'message' => 'required|string',
            'type' => 'required|in:normal,high,admin',
            'user_id' => 'required|array',
        ]);

        $notification->update([
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type,
            'ref_id' => $request->ref_id,
            'extra_data' => $request->extra_data ? json_encode($request->extra_data) : null,
            'status' => $request->status ?? 'unread',
        ]);

        // Build users array with user details
        $users = [];
        $role = $request->role ?? 'customer';
        
        if (in_array($role, ['customer', 'guest', 'all_customers']) && !empty($request->user_id)) {
            foreach ($request->user_id as $id) {
                if (str_starts_with($id, 'guest|')) {
                    $parts = explode('|', $id, 3);
                    if (count($parts) >= 2) {
                        $users[] = [
                            'id' => null,
                            'name' => $parts[2] ?? 'Guest',
                            'email' => $parts[1],
                            'status' => 'unread',
                            'read_at' => null,
                        ];
                    }
                } else {
                    $customer = Customer::find($id);
                    if ($customer) {
                        $users[] = [
                            'id' => $customer->id,
                            'name' => $customer->username,
                            'email' => $customer->email,
                            'status' => 'unread',
                            'read_at' => null,
                        ];
                    }
                }
            }
        } else if (!empty($request->user_id)) {
            foreach ($request->user_id as $uid) {
                $user = User::find($uid);
                if ($user) {
                    $users[] = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'status' => 'unread',
                        'read_at' => null,
                    ];
                }
            }
        }

        // Delete old notification_user and insert new one
        NotificationUser::where('notification_id', $notification->id)->delete();
        if (!empty($users)) {
            NotificationUser::create([
                'notification_id' => $notification->id,
                'users' => $users,
                'role' => $request->role ?? 'customer',
            ]);
        }

        // Redirect based on notification type
        if ($notification->type === 'admin') {
            return redirect()->route('notifications.admin')->with('success', 'Admin notification updated.');
        } else {
            return redirect()->route('notifications.table')->with('success', 'Notification updated.');
        }
    }

    // =====================
    // Delete Notification
    // =====================
    public function destroy(Notification $notification)
    {
        // Delete associated notification_users records first
        NotificationUser::where('notification_id', $notification->id)->delete();
        
        // Then delete the notification
        $notification->delete();
        
        return redirect()->route('notifications.table')->with('success', 'Notification deleted.');
    }

    // =====================
    // Mark as Read (AJAX)
    // =====================
  public function markAsRead(Request $request)
{
    $record = NotificationUser::findOrFail($request->notification_user_id);

    $users = is_string($record->users)
        ? json_decode($record->users, true)
        : $record->users;

    foreach ($users as &$user) {
        if ($user['id'] == Auth::id()) {
            $user['status'] = 'read';
            $user['read_at'] = now()->toDateTimeString();
        }
    }

    $record->update(['users' => $users]);

    return response()->json(['status' => 'success']);
}

    public function show($id)
    {
        // Fetch the notification along with the users it was sent to
        $notification = Notification::with('recipients')->findOrFail($id);

        // Pass to the view
        return view('notifications.notifications-view', compact('notification'));
    }
public function toggleStatus($id)
{
    $notification = Notification::findOrFail($id);
    $notification->status = $notification->status === 'read' ? 'unread' : 'read';
    $notification->save();

    return back()->with('success', 'Notification status updated');
}


}
