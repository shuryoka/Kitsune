<?php
namespace Kitsune;

class Configuration
{
    const CONFIG_DIR          = 'conf';
    const CONFIG_FILE_DEFAULT = 'phpunit.xml.dist';

    protected $defaultConfig = array();

    public function __construct()
    {
        $this->loadDefaultConfig();
        $this->mergeConfig();
    }

    public function loadDefaultConfig()
    {
        $this->defaultConfig = \PHPUnit_Util_Configuration::getInstance(dirname(__DIR__)
                             . DIRECTORY_SEPARATOR
                             . self::CONFIG_DIR
                             . DIRECTORY_SEPARATOR
                             . self::CONFIG_FILE_DEFAULT
        );

        return $this->defaultConfig;
    }

    public function mergeConfig()
    {
        if (empty($this->defaultConfig)) {
            $this->loadDefaultConfig();
        }

        $config = $this->defaultConfig->getPHPConfiguration();

        if (isset($config['var'])) {
            foreach ($config['var'] AS $key => $value) {
                if (!isset($GLOBALS[$key])) {
                    $GLOBALS[$key] = $value;
                }
            }

            return true;
        }

        return false;
    }

    public function getValue($value)
    {
        if (empty($this->defaultConfig)) {
            $this->loadDefaultConfig();
        }

        if (isset($GLOBALS[$value])) {
            return $GLOBALS[$value];
        }

        return '';
    }
}