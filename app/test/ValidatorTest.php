<?php

use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{

    private $validator;

    public function setUp(): void
    {
        $this->validator = new \FinalYear\Validator();
    }

    public function testStringSanitise()
    {
        $string1 = "MSI Z390-A PRO LGA 1151 SATA 6GBs ATX";
        $empty_str = "";
        $string2 = "<script>alert('hello')</script>";
        $string3 = "<h2><script>alert('hello')</script></h2>";

        $this->assertEquals('MSI Z390-A PRO LGA 1151 SATA 6GBs ATX', $this->validator->sanitiseString($string1));
        $this->assertEquals("", $this->validator->sanitiseString($empty_str));
        $this->assertEquals("alert('hello')",$this->validator->sanitiseString($string2));
        $this->assertEquals("alert('hello')",$this->validator->sanitiseString($string3));

    }

    public function testValidatePassword()
    {
        $password1 = "Red123";
        $password2 = "Password_456";
        $password3 = "Hello_";

        $this->assertFalse($this->validator->validatePassword($password1));
        $this->assertEquals("Password_456",$this->validator->validatePassword($password2));
        $this->assertFalse($this->validator->validatePassword($password3));
    }

    public function testEmailSanitise()
    {
        $email1 = "usama2051@gmail.com";
        $email2 = "usama2051";
        $email3 = "";

        $this->assertEquals("usama2051@gmail.com", $this->validator->sanitiseEmail($email1));
        $this->assertEquals("", $this->validator->sanitiseEmail($email2));
        $this->assertEquals("", $this->validator->sanitiseEmail($email3));
    }

    public function testSanitiseNumber()
    {
        $number1 = '5';
        $number2 = '1.3253435423423';
        $number3 = '212141523421532451345131235';
        $string = "hello";
        $char = "!<.32";

        $this->assertEquals("5", $this->validator->sanitiseNumber($number1));
        $this->assertEquals( '13253435423423', $this->validator->sanitiseNumber($number2));
        $this->assertEquals( '', $this->validator->sanitiseNumber($number3));
        $this->assertEquals("", $this->validator->sanitiseNumber($string));
        $this->assertEquals("32", $this->validator->sanitiseNumber($char));

    }

    public function testSanitiseRole(){
        $admin = "Admin";
        $supplier = "Supplier";
        $char = "A";
        $number = "1";


        $this->assertEquals("Admin", $this->validator->sanitiseRole($admin));
        $this->assertFalse($this->validator->sanitiseRole($supplier));
        $this->assertFalse($this->validator->sanitiseRole($char));
        $this->assertFalse($this->validator->sanitiseRole($number));

    }

    public function testSanitiseImageFile()
    {
        $php = '/script.php';
        $js = '/script.js';
        $jpeg = '/image.jpeg';

        $this->assertFalse($this->validator->sanitiseImageFile($php));
        $this->assertFalse($this->validator->sanitiseImageFile($js));
        $this->assertEquals('/image.jpeg', $this->validator->sanitiseImageFile($jpeg));
    }
}