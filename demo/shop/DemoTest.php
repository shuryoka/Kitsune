<?php
namespace Kitsune;

class DefaultTest extends \Kitsune\Provider\Magento
{
    /**
     * @test
     */
    public function testHomepage()
    {
        $this->openHomepage();
    }

    /**
     * @test
     */
    public function testContact()
    {
        $this->openHomepage();
        $this->click("//a[@href='/contacts/']");
        $this->assertElement("@name");
        //$this->assertElement("@email");


    }
}