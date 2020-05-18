<?php


namespace FinalYear;


class Cart
{
    private $index;
    private $name;
    private $quantity;
    private $price;
    private $total;
    private $img;

    public function __construct()
    {
        $this->index = null;
        $this->name = null;
        $this->quantity = 0;
        $this->price = null;
        $this->total = 0;
        $this->img = null;
    }

    public function __destruct(){}

    public function setProductValues($product_details, $quantity)
    {
        $this->index = $product_details['product_id'];
        $this->name = $product_details['name'];
        $this->quantity = $quantity;
        $this->price = $product_details['price'];
        $this->img = $product_details['product_image'];
    }

    public function setSession()
    {
        if (isset($_SESSION['cart']))
        {
            return $_SESSION['cart'];
        }
    }

    public function setSessionValues()
    {
        $this->total = $this->price * $this->quantity;

        $name = [
            'product_id' => $this->index,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'total' => $this->total,
            'product_image' => $this->img
        ];
        $_SESSION['cart'][$this->index] = $name;
    }

    public function removeSessionCartValue($index)
    {
        unset($_SESSION['cart'][$index]);
    }

    public function getSession()
    {
        return $_SESSION['cart'];
    }

    public function getSessionIndex($index)
    {
        return $_SESSION['cart'][$index];
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function incrementQuantity()
    {
        $this->quantity += 1;
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 0)
        {
            $this->quantity -= 1;
        }
    }

}