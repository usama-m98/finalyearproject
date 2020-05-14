<?php

namespace FinalYear;

class Validator
{
    public function __construct() { }

    public function __destruct() { }

    public function sanitiseString(string $string_to_sanitise)
    {
        $sanitised_string = false;

        if (!empty($string_to_sanitise))
        {
            $sanitised_string = filter_var($string_to_sanitise, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        }
        return $sanitised_string;
    }

    public function validatePassword(string $password)
    {
        $password_string = false;
        $lowercase_case = preg_match('/[a-z]/', $password);
        $upper_case = preg_match('/[A-Z]/', $password);
        $number = preg_match('/[0-9]/', $password);
        $special_char = preg_match('/[!@#$%^&*_-]/', $password);
        $length = strlen($password) > 7;

        if (($lowercase_case && $upper_case && $number && $special_char) && $length)
        {
            $password_string = $password;
        }else{
            $_SESSION['failed_message'] = 'The password must follow the criteria';
        }

        return $password_string;
    }

    public function sanitiseEmail(string $email_to_sanitise)
    {
        $cleaned_string = false;

        if (!empty($email_to_sanitise))
        {
            $sanitised_email = filter_var($email_to_sanitise, FILTER_SANITIZE_EMAIL);
            $cleaned_string = filter_var($sanitised_email, FILTER_VALIDATE_EMAIL);
        }
        return $cleaned_string;
    }

    public function sanitiseNumber(string $numbers_to_sanitise)
    {
        $cleaned_string = false;

        if (!empty($numbers_to_sanitise))
        {
            $sanitised_number = filter_var($numbers_to_sanitise, FILTER_SANITIZE_NUMBER_INT);
            $cleaned_string = filter_var($sanitised_number, FILTER_VALIDATE_INT);
        }

        return $cleaned_string;
    }

    public function sanitiseRole($role_to_sanitise)
    {
        $checked_roles = false;
        $expected_values = [
            'Member' => 'Member',
            'Admin' => 'Admin',
        ];

        $result = array_key_exists($role_to_sanitise, $expected_values);

        if ($result===true)
        {
            $checked_roles = $expected_values[$role_to_sanitise];
        }

        return $checked_roles;
    }

    public function sanitiseImageFile($image_file)
    {
        $checked_image = false;
        $extensions= ["jpeg","jpg","png"];
        $tmp_file= explode('.',$image_file);
        $file_ext = strtolower(end($tmp_file));
        $result = in_array($file_ext, $extensions);

        if ($result===true){
            $checked_image = $image_file;
        }

        return $checked_image;
    }

}