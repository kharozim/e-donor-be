<?php

namespace App\Utils;

use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class FirebaseUtil

{

    public static function sendToFcm($tokenFcm = '', $payload)
    {

        $factory = (new Factory)
            ->withServiceAccount('../sa.json');

        $pesan = $factory->createMessaging();

        $deviceToken = $tokenFcm;

        $message = CloudMessage::fromArray([
            'token' => $deviceToken,
            // 'notification' => $payload,
            'data' => $payload,
        ]);

        $pesan->send($message);
    }
}
