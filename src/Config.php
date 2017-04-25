<?php

/**
 * This is doc block
 */

namespace Bootta\Util;

use Exception;

/**
 * Utility class used for creating simple configuration system.
 *
 * By using this class is easy to create and use configuration system.
 * There is 2 types of configuration files: global and local. Global configuration
 * only need 1 time initializing and can be used in whole project. And local configuration
 * Is used to create more configuration files by creating new instances of Config class.
 */
class Config {

    /**
     * Global configuration path
     * @var type string
     */
    private static $global_config_path;

    /**
     * Global configuration file
     * @var type
     */
    private static $global_config;

    /**
     * Local configuration path
     * @var type string
     */
    private $local_config_path;

    /**
     * Local configuration file
     * @var type string
     */
    private $local_config;

    /**
     * Initialization of local configuration
     *
     * @param type $path Local configuration path.
     */
    public function __construct($path) {

        $this->local_config_path = $path;
        if (!file_exists($path)) {
            if (!file_exists(dirname($path))) {
                mkdir(dirname($path), '0711', true);
            }

            $config_file = fopen($path, "w") or die("Unable to open file!");
            $init_config_content = "<?php\n\nreturn array(\n\t\"sample_conf\" => \"sample_conf value\",\n\t\"sample_conf2\" => \"sample_conf value 2\"\n);";
            fwrite($config_file, $init_config_content);
            fclose($config_file);
        }
        $this->local_config = include($path);
    }

    /**
     * Initialize global configuration
     *
     * @param type $path Set global configuration path.
     */
    public static function set_global_config($path) {
        Config::$global_config_path = $path;
        if (!file_exists($path)) {
            if (!file_exists(dirname($path))) {
                mkdir(dirname($path), '0711', true);
            }

            $config_file = fopen($path, "w") or die("Unable to open file!");
            $init_config_content = "<?php\n\nreturn array(\n\t\"sample_conf\" => \"sample_conf value\",\n\t\"sample_conf2\" => \"sample_conf value 2\"\n);";
            fwrite($config_file, $init_config_content);
            fclose($config_file);
        }
        Config::$global_config = include($path);
    }

    /**
     * Get global configuration value
     *
     * Get global configuration value by providing configuration key value.
     *
     * @param type $key Key value
     * @return type any
     * @throws ConfigKeyNotExistException
     * @throws GlobalConfigNotInitializedException
     */
    public static function get_global($key = "") {

        if (Config::$global_config) {
            if (array_key_exists($key, Config::$global_config)) {
                return Config::$global_config[$key];
            } else {
                throw new ConfigKeyNotExistException("Global config entry with key = " . $key . " not exist");
            }
        } else {
            throw new GlobalConfigNotInitializedException("Global config not initialized");
        }
    }

    /**
     * Get local configuration value
     *
     * Get global configuration value by providing configuration key value.
     *
     * @param type $key Key value
     * @return type any
     * @throws ConfigKeyNotExistException
     * @throws LocalConfigNotInitializedException
     */
    public function get_local($key = "") {

        if ($this->local_config) {
            if (array_key_exists($key, $this->local_config)) {
                return $this->local_config[$key];
            } else {
                throw new ConfigKeyNotExistException("Local config entry with key = " . $key . " not exist");
            }
        } else {
            throw new LocalConfigNotInitializedException("Local config not initialized");
        }
    }

}

/**
 * Raised exception because asking for value that don't exist in configuration file
 */
class ConfigKeyNotExistException extends Exception {

}

/**
 * Local configuration is not properly initialized
 */
class LocalConfigNotInitializedException extends Exception {

}

/**
 * Global configuration is not properly initialized
 */
class GlobalConfigNotInitializedException extends Exception {

}

?>