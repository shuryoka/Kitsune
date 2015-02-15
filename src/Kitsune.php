<?php
namespace Kitsune;
include "vendor/autoload.php";

class Kitsune extends \PHPUnit_Framework_TestCase
{
    const PROVIDER_TYPE = 'default';

    /**
     * @var \RemoteWebDriver
     */
    protected $webDriver;

    /**
     * @var Configuration
     */
    protected $config;

    final public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->config = new Configuration();

    }

    public function setUp()
    {
        parent::setUp();

        $capabilities = array(
            \WebDriverCapabilityType::BROWSER_NAME => $this->getConfig('config.selenium.browser')
        );

        $this->webDriver = \RemoteWebDriver::create(
            $this->getConfig('config.selenium.server'),
            $capabilities
        );
    }

    public function open($path = '/')
    {
        if ($path[0] != '/') {
            $path = '/' . $path;
        }

        $this->webDriver->get($this->getConfig('config.base.url') . $path);
    }

    public function tearDown()
    {
        $this->webDriver->close();
    }

    /**
     * identify element with id attribute or xpath and click it
     * for id: param has to start with @
     *
     * @param $identifier string
     * @param $wait int
     */
    public function click($identifier, $wait = 3)
    {
        if (strpos($identifier, '@') === 0) {
            try {
                $id = ltrim($identifier);

                $this->webDriver->findElement(\WebDriverBy::id($id))->click();
            } catch (Exception $e) {
                $this->assertTrue(false, "element '$identifier' not found");
            }
        } else {
            $this->findByXPath($identifier)->click();
        }

        $this->webDriver->wait($wait); // assume that a page loads in about 3 seconds
    }

    public function findByXPath($xpath = '')
    {
        try {
            $element = $this->webDriver->findElement(\WebDriverBy::xpath($xpath));
        } catch (NoSuchElementException $exception) {
            $this->assertTrue(false, "element '$xpath' not found");
        }

        return $element;
    }

    public function find($identifier = '') {
        if (strpos($identifier, '@') === 0) {
            try {
                $id = ltrim($identifier, '@');

                return $this->webDriver->findElement(\WebDriverBy::id($id));
            } catch (Exception $e) {
                $this->assertTrue(false, "element '$identifier' not found");
            }
        }

        return $this->findByXPath($identifier);
    }

    public function assertElement($identifier)
    {
        $this->find($identifier);
    }

    public function getConfig($value)
    {
        if (!empty($this->config)) {
            return $this->config->getValue($value);
        }

        return '';
    }
}