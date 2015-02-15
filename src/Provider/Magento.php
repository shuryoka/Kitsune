<?php
namespace Kitsune\Provider;

use Kitsune\Kitsune;

class Magento extends Kitsune
{
    const PROVIDER_TYPE = 'magento';

    public function openHomepage()
    {
        $this->open();
        $this->assertIsHomepage();
    }

    public function checkBodyClassByXPath($xpath = '', $errorMsg)
    {
        $this->assertTrue(
            $this->findByXPath($xpath) instanceof \RemoteWebElement,
            $errorMsg
        );
    }

    public function assertIsHomepage()
    {
        $this->checkBodyClassByXPath(
            "//body[contains(@class,'cms-index-index')]",
            "that's not the homepage"
        );
    }

    public function openCart()
    {
        $this->open('checkout/cart/');
        $this->assertIsCart();
    }

    public function assertIsCart()
    {
        $this->checkBodyClassByXPath(
            "//body[contains(@class,'checkout-cart-index')]",
            "that's not the cart"
        );
    }

}