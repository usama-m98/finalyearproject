<?php
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    private $cart;
    private $product;

    public function setUp(): void
    {
        $this->cart = new \FinalYear\Cart();
        $this->product = [
            'product_id' => '1',
            'name' => 'Asus Laptop',
            'price' => '400',
            'product_image' => '/media/asus.jpeg',
        ];
        $this->cart->setSession();
        $this->cart->setProductValues($this->product, '4');
        $this->cart->setSessionValues();

    }

    public function testCart()
    {
        $this->assertIsArray($this->cart->getSession());
        $this->assertEquals([
            'product_id' => '1',
            'name' => 'Asus Laptop',
            'quantity' => '4',
            'total' => 1600,
            'price' => '400',
            'product_image' => '/media/asus.jpeg',
        ], $this->cart->getSessionIndex($this->product['product_id']));
    }

    public function testIncrementQuantity()
    {
        $this->cart->incrementQuantity();
        $this->cart->incrementQuantity();
        $this->assertEquals('6', $this->cart->getQuantity());
    }

    public function testDecrementFunction()
    {
        $this->cart->decrementQuantity();
        $this->cart->decrementQuantity();
        $this->cart->decrementQuantity();
        $this->assertEquals('1', $this->cart->getQuantity());
    }

    public function testRemoveIndex()
    {
        $this->cart->removeSessionCartValue($this->product['product_id']);

        $this->assertEmpty($this->cart->getSession());
    }


}