<?php

namespace App\Utils;

class HelperUtil {


    public static function randomChar($length   = 8) {
        if( $length <= 0 ) {
            $length = 8;
        }
        $chars  = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0912345678';
        $count  = strlen($chars);
        $lastIndex  = $count - 1;
        $return = '';

        for ($i=0; $i < $length; $i++) { 
            $index  = mt_rand(0, $lastIndex);
            $return .= $chars[$index];
        }

        return $return;
    }


}