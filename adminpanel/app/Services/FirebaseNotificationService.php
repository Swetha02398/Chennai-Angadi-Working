<?php

namespace App\Services;

use Google_Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Service to handle Firebase Cloud Messaging (FCM) via the HTTP v1 API.
 *
 * SETUP:
 * 1. Firebase Console -> Project Settings -> Service Accounts
 * 2. Click "Generate new private key"
 * 3. Save JSON to storage/app/firebase-credentials.json
 * 4. composer require google/apiclient
 */
class FirebaseNotificationService
{
    private $credentialsFilePath;
    private $projectId = 'chennai-angadi-b0ce0';

    public function __construct()
    {
        $this->credentialsFilePath = storage_path('app/chennai-angadi-b0ce0-firebase-adminsdk-fbsvc-6ad465ed5d.json');
    }

    /**
     * Get a short-lived OAuth 2.0 access token for FCM HTTP v1 API.
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
     * Send push notification to a single device.
     *
     * @param string $fcmToken  The device FCM token
     * @param string $title     Notification title
     * @param string $body      Notification body
     * @param array  $data      Optional extra data payload
     * @return bool
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

            $message = [
                'token' => $fcmToken,
                'notification' => [
                    'title' => $title,
                    'body'  => $body,
                ],
            ];

            // Add data payload if provided
            if (!empty($data)) {
                // FCM data values must all be strings
                $message['data'] = array_map('strval', $data);
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type'  => 'application/json',
            ])->post($url, ['message' => $message]);

            if ($response->successful()) {
                Log::info("Push notification sent successfully to token: " . substr($fcmToken, 0, 20) . '...');
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

    /**
     * Send push notification to multiple devices.
     *
     * @param array  $fcmTokens  Array of FCM tokens
     * @param string $title      Notification title
     * @param string $body       Notification body
     * @param array  $data       Optional extra data payload
     * @return array             ['success' => count, 'failed' => count]
     */
    public function sendToMultiple(array $fcmTokens, $title, $body, $data = [])
    {
        $success = 0;
        $failed = 0;

        foreach ($fcmTokens as $token) {
            if ($this->sendNotification($token, $title, $body, $data)) {
                $success++;
            } else {
                $failed++;
            }
        }

        Log::info("Bulk push: {$success} sent, {$failed} failed out of " . count($fcmTokens));

        return ['success' => $success, 'failed' => $failed];
    }
}
