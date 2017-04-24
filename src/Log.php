<?php

namespace Bootta\Util;

date_default_timezone_set('Europe/Sarajevo');

require __DIR__ . '/../../vendor/autoload.php';

use Bootta\Util\Config;

class Log {

    private static $log_location;
    private static $update_interval = 60;
    private static $last_update_time;

    public static function init() {
        if (!Log::$log_location || (time() - Log::$last_update_time) > Log::$update_interval) {
            Log::$last_update_time = time();
            echo Log::$log_location;
            Log::$log_location = __DIR__ . "/../../" . Config::get_global('log_location');
        }
    }

    /**
     * info
     *
     * Logs info data to log
     *
     * @param string $msg Message that will be logged
     * @param bool $logs_file_by_date Boolean value that decide will date shown in filename
     * @param string $module Short describe of module that will be displayed in filename
     * @return bool If true log is saved successfully otherwise not
     */
    public static function info($msg, $module = "", $logs_file_by_date = true) {
        Log::init();
        $log_file_date = date("Y-m-d");
        $location_log_info = Log::$log_location;
        $called_from = ($_SERVER["SCRIPT_FILENAME"] ? $_SERVER["SCRIPT_FILENAME"] : "");
        $date = date("Y-m-d h:i:s");
        $level = "Info";

        $message = "[{$date}] [{$called_from}] [{$level}] " . $msg . PHP_EOL;

        $result = error_log($message, 3, $location_log_info . "/" . ($module && strlen($module) > 0 ? $module . "_" : "") . ($logs_file_by_date ? "info" . $log_file_date . ".txt" : "info.txt"));

        return $result;
    }

    public static function error($msg, $module = "", $logs_file_by_date = true) {
        Log::init();
        $log_file_date = date("Y-m-d");
        $location_log_error = Log::$log_location;
        $date = date("Y-m-d h:i:s");
        $level = "Error";
        $called_from = ($_SERVER["SCRIPT_FILENAME"] ? $_SERVER["SCRIPT_FILENAME"] : "");
        $message = "[{$date}] [{$called_from}] [{$level}] " . $msg . PHP_EOL;

        error_log($message, 3, $location_log_error . "/" . ($module && strlen($module) > 0 ? $module . "_" : "") . ($logs_file_by_date ? "error" . $log_file_date . ".txt" : "error.txt"));
        return $result;
    }

}

?>
