<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use Bootta\Util\Config;
use Bootta\Util\Log;
use PHPUnit\Framework\TestCase;

class TestLibrary extends TestCase {

    public function testConfig() {
        $conf = new Config(__DIR__ . "/../config_local.php");
        Config::set_global_config(__DIR__ . "/../config_global2.php");
        try {
            echo Config::get_global('sample_conf');
            echo $conf->get_local();
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    public function testLogWhenNotInitialized() {
        //Log::init(__DIR__);
        Log::info("test log input");
    }

    public function testLogWhenInitialized() {
        Log::init(__DIR__);
        Log::info("test log input");
    }

}

?>