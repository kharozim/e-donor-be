<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Utils\ResponseUtil;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;

class NotificationController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function sendMessage()
    {

        // $factory = (new Factory)
        // ->withServiceAccount('sa.json');

        // $message = Firebase::messaging();

        $deviceToken = 'dfZeUhmXSf2_iyH3bf1wJc:APA91bFZxL8NdJ2fk-toOvV9Q5iSrEVpsN6dEV_E--hV97m8sHTGIniA3pQlFxW0nMxYGLge9ylKZjzkJ2bmaEkVP0F5biybpxlcQ3vsp7WCtgR26YNhhAb3QvkLEfrD5EhQIS5gujJt';

        $messaging = new Messaging;
        // $message = CloudMessage::withTarget('token', $deviceToken);

        $message = CloudMessage::fromArray([
            'token' => $deviceToken,
            'notification' => ['title' => 'coba', 'body' => 'ini body'], // optional
            'data' => [/* data array */], // optional
        ]);

        $messaging->send($message);
        return ResponseUtil::success('stop');
    }
}
