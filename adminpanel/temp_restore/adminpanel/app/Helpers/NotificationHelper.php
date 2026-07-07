<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\Product;
use App\Models\User;
use App\Models\Customer;
use App\Services\FirebaseNotificationService;
use Illuminate\Support\Facades\Log;

class NotificationHelper
{
    // ------------------------------------------------------
    // Create Notification record
    // ------------------------------------------------------
    public static function create(string $title, string $message, string $type = 'high', string $fromRole = 'admin', array $extra = [])
    {
        return Notification::create([
            'title'     => $title,
            'message'   => $message,
            'type'      => $type,
            'from_role' => $fromRole,
            'extra'     => $extra,
        ]);
    }

    // ------------------------------------------------------
    // Attach users list (JSON) to notification_users table
    // ------------------------------------------------------
    public static function attachUsers(int $notificationId, $users, string $role = 'customer')
    {
        $userList = [];

        foreach ($users as $user) {
            $userList[] = [
                'id'    => $user->id,
                'name'  => $user->name ?? $user->username ?? '',
                'email' => $user->email,
            ];
        }

        return NotificationUser::create([
            'notification_id' => $notificationId,
            'role'            => $role,
            'users'           => $userList,
        ]);
    }

    // ------------------------------------------------------
    // Send Firebase push to a list of customers
    // ------------------------------------------------------
    public static function sendFirebasePush(string $title, string $message, $userIds = [], array $extraData = [])
    {
        try {
            $firebaseService = app(FirebaseNotificationService::class);

            // Get FCM tokens for the given customer IDs
            $query = Customer::whereNotNull('fcm_token')->where('fcm_token', '!=', '');

            if (!empty($userIds)) {
                $query->whereIn('id', $userIds);
            }

            $tokens = $query->pluck('fcm_token')->toArray();

            if (empty($tokens)) {
                Log::info('No FCM tokens found for push notification.');
                return;
            }

            $firebaseService->sendToMultiple($tokens, $title, $message, $extraData);

        } catch (\Exception $e) {
            // Don't let Firebase errors break the notification flow
            Log::error('Firebase push notification error: ' . $e->getMessage());
        }
    }

    // ------------------------------------------------------
    // Send to single user
    // ------------------------------------------------------
    public static function sendToUser(int $userId, string $title, string $message, string $type = 'high', string $fromRole = 'admin', array $extra = [])
    {
        $user = User::find($userId);
        if (!$user) return false;

        $notification = self::create($title, $message, $type, $fromRole, $extra);
        self::attachUsers($notification->id, [$user], $user->role_type ?? 'customer');

        // Send Firebase push notification
        self::sendFirebasePush($title, $message, [$userId], [
            'notification_id' => (string) $notification->id,
        ]);

        return true;
    }

    // ------------------------------------------------------
    // Send to all users of same role
    // ------------------------------------------------------
    public static function sendToRole(string $role, string $title, string $message, string $type = 'high', string $fromRole = 'admin', array $extra = [])
    {
        $users = User::where('role_type', $role)->get();
        if ($users->isEmpty()) return false;

        $notification = self::create($title, $message, $type, $fromRole, $extra);
        self::attachUsers($notification->id, $users, $role);

        // Send Firebase push notification to all users of this role
        $userIds = $users->pluck('id')->toArray();
        self::sendFirebasePush($title, $message, $userIds, [
            'notification_id' => (string) $notification->id,
        ]);

        return true;
    }

    // ------------------------------------------------------
    // Send to all users in the system
    // ------------------------------------------------------
    public static function sendToAll(string $title, string $message, string $type = 'high', string $fromRole = 'admin', array $extra = [])
    {
        $users = User::all();
        if ($users->isEmpty()) return false;

        $notification = self::create($title, $message, $type, $fromRole, $extra);
        self::attachUsers($notification->id, $users, 'all');

        // Send Firebase push to ALL customers with tokens (no user ID filter)
        self::sendFirebasePush($title, $message, [], [
            'notification_id' => (string) $notification->id,
        ]);

        return true;
    }

    // ------------------------------------------------------
    // Low Stock Alert (admin only, no push needed)
    // ------------------------------------------------------
    public static function lowStock($productId, $stock)
    {
        $product = Product::find($productId);

        Notification::create([
            'type'    => 'LOW_STOCK',
            'title'   => 'Low Stock Alert',
            'message' => $product->name . ' stock is low (' . $stock . ')',
            'for'     => 'ADMIN',
            'is_read' => 0
        ]);
    }
}
