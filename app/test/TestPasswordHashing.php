<?php
use PHPUnit\Framework\TestCase;

class TestPasswordHashing extends TestCase
{
    private $password;

    public function setUp(): void
    {
        $this->password = new \FinalYear\PasswordHashing();
    }

    public function testPasswordHash()
    {
        $password = 'Empty_456';
        $hashed = $this->password->createHashedPassword($password);
        $password2 = "";
        $hashed2 = $this->password->createHashedPassword($password2);
        $password3 = null;

        $this->assertTrue(password_verify($password, $hashed));
        $this->assertEquals("" ,$this->password->createHashedPassword($password2));
        $this->assertEquals("", $this->password->createHashedPassword($password3));
    }
}