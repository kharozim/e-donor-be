<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Utils\FirebaseUtil;
use App\Utils\ResponseUtil;
use Illuminate\Http\Request;
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
}
