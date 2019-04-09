<?php
namespace App\Helper;

use Illuminate\Support\Facades\Log;

class LogMessages
{
    public static function info($messages = "", $val = [], $who)
    {
        $logMessage = "$messages - " . json_encode($val) . " - action by user_id : $who [SUCCESS]";
        Log::info($logMessage);
    }

    public static function error($messages = "", $val = [], $who)
    {
        $logMessage = "$messages - " . json_encode($val) . " - action by user_id : $who [ERROR]";
        Log::error($logMessage);
    }
}
