<?php

namespace App\Utils;

use Carbon\Carbon;

trait FormatTimestamp
{
    public function getCreatedAtAttribute($date) {
        if( $date ) {
            if( strpos($date, "Z") !== false ) {
                return Carbon::createFromFormat("Y-m-d\TH:i:s\.000000\Z", $date)->addHours(7)->format("Y-m-d H:i:s");
            }
            $exploded   = explode(" ", $date);
            if( count($exploded) == 2 ) {
                return Carbon::createFromFormat("Y-m-d H:i:s", $date)->addHours(7)->format("Y-m-d H:i:s");
            }
        }
        return null;
    }

    public function getUpdatedAtAttribute($date) {
        if( $date ) {
            if( strpos($date, "Z") !== false ) {
                return Carbon::createFromFormat("Y-m-d\TH:i:s\.000000\Z", $date)->addHours(7)->format("Y-m-d H:i:s");
            }
            $exploded   = explode(" ", $date);
            if( count($exploded) == 2 ) {
                return Carbon::createFromFormat("Y-m-d H:i:s", $date)->addHours(7)->format("Y-m-d H:i:s");
            }
        }
        return null;
    }
}
