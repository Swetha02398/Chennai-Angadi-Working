<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NotificationApiController extends Controller
{
    // -----------------------------------------
    // HELPER: Safely get users as array
    // -----------------------------------------
    private function getUsersArray($users)
    {
        if (is_array($users)) {
            return $users;
        }
        if (is_string($users)) {
            $decoded = json_decode($users, true);
            return is_array($decoded) ? $decoded : [];
        }
        return [];
    }

    // -----------------------------------------
    // GET ALL NOTIFICATIONS FOR USER
    // -----------------------------------------
    public function index(Request $request, $userId)
    {
        $perPage = $request->query('per_page', 15);

        $rows = NotificationUser::with('notification')
            ->whereJsonContains('users', ['id' => (int) $userId])
            ->orderByDesc('created_at')
            ->paginate($perPage)->withQueryString();

        // Format the items in the current page
        $rows->getCollection()->transform(fn ($row) => $this->formatNotification($row));

        return response()->json([
            'status' => true,
            'notifications' => $rows
        ]);
    }

    // -----------------------------------------
    // CREATE NOTIFICATION
    // -----------------------------------------
    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|string',
            'message'   => 'required|string',
            'send_to'   => 'required|in:all,user',
            'user_id'   => 'nullable|integer',
            'role'      => 'nullable|string',
            'type'      => 'nullable|in:normal,high,admin',
            'extra_data'=> 'nullable|array',
        ]);

        $notification = Notification::create([
            'type'       => $request->type ?? 'normal',
            'title'      => $request->title,
            'message'    => $request->message,
            'from_role'  => 'admin',
            'extra_data' => json_encode($request->extra_data ?? []),
        ]);

        if ($request->send_to === 'all') {
            $users = User::pluck('id')
                ->map(fn ($id) => ['id' => $id, 'status' => 'unread'])
                ->toArray();

            NotificationUser::create([
                'notification_id' => $notification->id,
                'users' => $users,
                'role' => $request->role ?? 'customer',
            ]);
            
            // Send FCM to all
            \App\Helpers\NotificationHelper::sendFirebasePush($notification->title, $notification->message, [], [
                'notification_id' => (string) $notification->id
            ]);
        }

        if ($request->send_to === 'user') {
            NotificationUser::create([
                'notification_id' => $notification->id,
                'users' => [
                    ['id' => (int) $request->user_id, 'status' => 'unread']
                ],
                'role' => $request->role ?? 'customer',
            ]);
            
            // Send FCM to specific user
            \App\Helpers\NotificationHelper::sendFirebasePush($notification->title, $notification->message, [(int) $request->user_id], [
                'notification_id' => (string) $notification->id
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Notification created'
        ]);
    }
// -----------------------------------------
// UPDATE NOTIFICATION
// -----------------------------------------
public function update(Request $request, $id)
{
    $request->validate([
        'title'      => 'nullable|string',
        'message'    => 'nullable|string',
        'type'       => 'nullable|in:normal,high,admin',
        'extra_data' => 'nullable|array',
    ]);

    $notification = Notification::findOrFail($id);

    $notification->update([
        'title'      => $request->title ?? $notification->title,
        'message'    => $request->message ?? $notification->message,
        'type'       => $request->type ?? $notification->type,
        'extra_data' => $request->has('extra_data')
                            ? json_encode($request->extra_data)
                            : $notification->extra_data,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Notification updated successfully',
        'notification' => $notification
    ]);
}

    // -----------------------------------------
    // MARK SINGLE NOTIFICATION AS READ
    // -----------------------------------------
    public function markRead($notificationUserId, $userId)
    {
        $row = NotificationUser::findOrFail($notificationUserId);

        $users = $this->getUsersArray($row->users);
        foreach ($users as &$u) {
            if (isset($u['id']) && $u['id'] == $userId) {
                $u['status'] = 'read';
            }
        }

        $row->update([
            'users' => $users,
            'is_read' => true,
            'read_at' => Carbon::now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Marked as read'
        ]);
    }


    // -----------------------------------------
    // GET UNREAD NOTIFICATIONS
    // -----------------------------------------
   public function unread(Request $request, $userId)
    {
        $perPage = $request->query('per_page', 15);

        $rows = NotificationUser::with('notification')
            ->whereJsonContains('users', ['id' => (int) $userId, 'status' => 'unread'])
            ->orderByDesc('created_at')
            ->paginate($perPage)->withQueryString();

        // Format the items in the current page
        $rows->getCollection()->transform(fn ($row) => $this->formatNotification($row));

        return response()->json([
            'status' => true,
            'notifications' => $rows
        ]);
    }
      // ------------------------------------------------------
// MARK ALL AS READ FOR A USER
// ------------------------------------------------------
public function markAllRead($userId)
{
    // Fetch only unread NotificationUser records for this user
    $rows = NotificationUser::whereJsonContains('users', ['id' => (int) $userId, 'status' => 'unread'])->get();
    $updated = false;

    foreach ($rows as $row) {
        $users = $row->users ?? [];
        if (!is_array($users)) continue;

        $changed = false;

        foreach ($users as &$u) {
            if (isset($u['id']) && $u['id'] == $userId && ($u['status'] ?? 'unread') === 'unread') {
                $u['status'] = 'read';
                $changed = true;
                $updated = true;
            }
        }

        if ($changed) {
            $row->update([
                'users'   => $users,    // no json_encode needed
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    return response()->json([
        'status'  => true,
        'message' => $updated ? 'All notifications marked as read' : 'No unread notifications found'
    ]);
}


    // -----------------------------------------
    // DELETE NOTIFICATION
    // -----------------------------------------
    public function destroy($id)
    {
        NotificationUser::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted'
        ]);
    }

    // -----------------------------------------
    // FORMAT RESPONSE
    // -----------------------------------------
    private function formatNotification(NotificationUser $row)
    {
        return [
            'notification_user_id' => $row->id,
            'role' => $row->role,
            'users' => $row->users,
            'is_read' => $row->is_read,
            'read_at' => optional($row->read_at)->toDateTimeString(),
            'notification' => [
                'id' => $row->notification->id,
                'type' => $row->notification->type,
                'title' => $row->notification->title,
                'message' => $row->notification->message,
                'extra_data' => json_decode($row->notification->extra_data, true),
            ],
            'created_at' => $row->created_at->toDateTimeString(),
        ];
    }
    public function getNotifications(Request $request)
{
    $type = $request->type; // 'customer' or 'admin'
    $id = $request->id;
    $perPage = $request->query('per_page', 15);

    if ($type === 'customer') {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json([
                'status' => false,
                'message' => 'Customer not found'
            ], 404);
        }

        $notifications = NotificationUser::with('notification')
            ->whereJsonContains('users', ['id' => (int) $id])
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage)->withQueryString();

        // Format items in current page
        $notifications->getCollection()->transform(function ($n) {
            return [
                'notification_user_id' => $n->id,
                'users' => $n->users,
                'notification' => $n->notification,
                'created_at' => $n->created_at,
            ];
        });

        return response()->json([
            'status' => true,
            'notifications' => $notifications
        ]);
    }

    if ($type === 'admin') {
        $notifications = NotificationUser::with('notification')
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage)->withQueryString();

        // Format items in current page
        $notifications->getCollection()->transform(function ($n) {
            return [
                'notification_user_id' => $n->id,
                'users' => $n->users,
                'notification' => $n->notification,
                'created_at' => $n->created_at,
            ];
        });

        return response()->json([
            'status' => true,
            'notifications' => $notifications
        ]);
    }

    return response()->json([
        'status' => false,
        'message' => 'Invalid type'
    ], 400);
    }

    // -----------------------------------------
    // UPDATE FCM TOKEN (called from Flutter app)
    // -----------------------------------------
    public function updateToken(Request $request)
    {
        $request->validate([
            'user_id'     => 'required|integer',
            'user_role'   => 'required|string|in:customer,admin',
            'fcm_token'   => 'required|string',
            'device_type' => 'required|string|in:android,ios,web',
        ]);

        if ($request->user_role === 'customer') {
            $customer = Customer::find($request->user_id);
            if (!$customer) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Customer not found'
                ], 404);
            }

            $customer->update([
                'fcm_token'   => $request->fcm_token,
                'device_type' => $request->device_type,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'FCM token updated successfully'
            ]);
        }

        if ($request->user_role === 'admin') {
            $user = User::find($request->user_id);
            if (!$user) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Admin user not found'
                ], 404);
            }

            // If admin users table has fcm_token column, uncomment:
            // $user->update([
            //     'fcm_token'   => $request->fcm_token,
            //     'device_type' => $request->device_type,
            // ]);

            return response()->json([
                'status'  => true,
                'message' => 'Admin FCM token noted (not yet stored)'
            ]);
        }

        return response()->json([
            'status'  => false,
            'message' => 'Invalid user role'
        ], 400);
    }
}
