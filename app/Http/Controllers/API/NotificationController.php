<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Utils\FirebaseUtil;
use App\Utils\ResponseUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Contract\Messaging;

class NotificationController extends Controller
{
    public function __construct(Request $request, Messaging $messaging)
    {
        $this->request = $request;
        $this->messaging = $messaging;
    }

    public function sendMessage()
    {
        $request = $this->request->only(['title', 'body', 'token', 'type']);

        $deviceToken = $request['token'];

        $payload = [
            'title' => $request['title'],
            'body' => $request['body'],
            'type' => $request['type']
        ];

        FirebaseUtil::sendToFcm($deviceToken, $payload, $request['type']);
        return ResponseUtil::success($payload);
    }

    public function all()
    {
        $user = Auth::user();

        $result = Notification::where('user_id', '=', $user->id)->get();

        return ResponseUtil::success($result);
    }

    public function read($notifId)
    {
        $user = Auth::user();
        $notif = Notification::find($notifId);
        if (!$notif) {
            return ResponseUtil::error('Notifikasi tidak ditemukan', 400);
        }
        $notif->update(['is_read' => true]);
        return ResponseUtil::success($notif);
    }

    public static function add($payload)
    {
        $request = [
            'title' => $payload['title'],
            'description' => $payload['body'],
            'user_id' => $payload['user_id'],
            'is_read' => false
        ];

        Notification::created($request);
    }
}
