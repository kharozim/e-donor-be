<?php

namespace App\Utils;

class UploadUtil
{
    public static function upload($directory = 'upload', \Illuminate\Http\UploadedFile $file, $newName = null)
    {
        $extension      = strtolower($file->getClientOriginalExtension());
        if (!$newName) {
            $newName        = UploadUtil::randomString(16) . '.' . $extension;
        }
        return $file->storeAs($directory, $newName);
    }

    public static function randomString($length = 10) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $response = '';
        $charLength = strlen($chars);
        $maxIndex = $charLength - 1;
        for($i = 0; $i <= $length; $i++) {
            $response .= $chars[mt_rand(0, $maxIndex)];
        }

        return $response;
    }
}
