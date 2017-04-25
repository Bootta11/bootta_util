<?php

namespace Bootta\Util;

use Exception;

date_default_timezone_set('Europe/Sarajevo');

class Log {

    private static $log_location;
    private static $update_interval = 60;
    private static $last_update_time;

    public static function init($path) {

        Log::$log_location = $path;
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
        if (Log::$log_location) {
            $log_file_date = date("Y-m-d");
            $location_log_info = Log::$log_location;
            $called_from = ($_SERVER["SCRIPT_FILENAME"] ? $_SERVER["SCRIPT_FILENAME"] : "");
            $date = date("Y-m-d h:i:s");
            $level = "Info";

            $message = "[{$date}] [{$called_from}] [{$level}] " . $msg . PHP_EOL;

            $result = error_log($message, 3, $location_log_info . "/" . ($module && strlen($module) > 0 ? $module . "_" : "") . ($logs_file_by_date ? "info" . $log_file_date . ".txt" : "info.txt"));

            return $result;
        } else {
            throw LogNotInitializedException();
        }
    }

    public static function error($msg, $module = "", $logs_file_by_date = true) {
        if (Log::$log_location) {
            $log_file_date = date("Y-m-d");
            $location_log_error = Log::$log_location;
            $date = date("Y-m-d h:i:s");
            $level = "Error";
            $called_from = ($_SERVER["SCRIPT_FILENAME"] ? $_SERVER["SCRIPT_FILENAME"] : "");
            $message = "[{$date}] [{$called_from}] [{$level}] " . $msg . PHP_EOL;

            error_log($message, 3, $location_log_error . "/" . ($module && strlen($module) > 0 ? $module . "_" : "") . ($logs_file_by_date ? "error" . $log_file_date . ".txt" : "error.txt"));
            return $result;
        } else {
            throw LogNotInitializedException();
        }
    }

}

class LogNotInitializedException extends Exception {

}

?>
