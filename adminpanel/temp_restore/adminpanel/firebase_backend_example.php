<?php

namespace App\Services;

use Google_Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Service to handle Firebase Cloud Messaging (FCM) via the HTTP v1 API.
 * 
 * SETUP INSTRUCTIONS:
 * 1. Go to Firebase Console -> Project Settings -> Service Accounts
 * 2. Click "Generate new private key".
 * 3. Save the JSON file into your Laravel project (e.g., storage/app/firebase-credentials.json)
 * 4. Install the Google API PHP Client via Composer if you haven't:
 *    composer require google/apiclient
 */
class FirebaseNotificationService
{
    /**
     * Path to the Firebase service account JSON key file.
     */
    private $credentialsFilePath;

    /**
     * The Firebase Project ID (found in Firebase Console -> Project Settings)
     */
    private $projectId = 'edumed360-e550d'; // Based on your previous logs

    public function __construct()
    {
        // Adjust this path to wherever you save your downloaded JSON key file.
        $this->credentialsFilePath = storage_path('app/firebase-credentials.json');
    }

    /**
     * Get a short-lived OAuth 2.0 access token to authenticate with the FCM HTTP v1 API.
     */
    private function getAccessToken()
    {
        $client = new Google_Client();
        $client->setAuthConfig($this->credentialsFilePath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->useApplicationDefaultCredentials();

        $token = $client->fetchAccessTokenWithAssertion();
        
        return $token['access_token'];
    }

    /**
     * Sends a push notification using the Firebase HTTP v1 API.
     *
     * @param string $fcmToken The device FCM token (saved from the Flutter app)
     * @param string $title    The title of the notification
     * @param string $body     The body message of the notification
     * @param array  $data     Optional extra data payload (e.g., notification_id)
     * @return bool            True if successful, false otherwise
     */
    public function sendNotification($fcmToken, $title, $body, $data = [])
    {
        if (empty($fcmToken)) {
            Log::warning('FCM Token is empty. Cannot send notification.');
            return false;
        }

        try {
            $accessToken = $this->getAccessToken();
            $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

            // The payload structure required by FCM HTTP v1
            $payload = [
                'message' => [
                    'token' => $fcmToken,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                    'data' => empty($data) ? null : $data,
                ]
            ];

            // Send POST request
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post($url, $payload);

            if ($response->successful()) {
                Log::info("Push notification sent successfully to {$fcmToken}");
                return true;
            } else {
                Log::error("Failed to send push notification: " . $response->body());
                return false;
            }

        } catch (\Exception $e) {
            Log::error("Exception while sending push notification: " . $e->getMessage());
            return false;
        }
    }
}

// ------------------------------------------------------------------------------------------
// HOW TO USE THIS IN YOUR CONTROLLER (e.g., when saving a new announcement):
// ------------------------------------------------------------------------------------------
/*
use App\Services\FirebaseNotificationService;

class AnnouncementController extends Controller 
{
    protected $firebaseService;

    public function __construct(FirebaseNotificationService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function store(Request $request) 
    {
        // 1. Save announcement to your database
        $announcement = Announcement::create([
            'title' => $request->title,
            'message' => $request->message,
            // ... other fields
        ]);

        // 2. Get the target user(s) FCM token(s) from your database
        // Example: getting token for user ID 36 (the student in the logs)
        $user = User::find(36);
        $fcmToken = $user->fcm_token; 

        // 3. Trigger the Push Notification!
        if ($fcmToken) {
            $this->firebaseService->sendNotification(
                $fcmToken, 
                $announcement->title, 
                $announcement->message, 
                ['notification_id' => (string) $announcement->id] // Extra data the app receives in background
            );
        }

        return response()->json(['success' => true]);
    }
}
*/
