<?php

namespace FinalYear;

class Validator
{
    public function __construct() { }

    public function __destruct() { }

    public function sanitiseString(string $string_to_sanitise): string
    {
        $sanitised_string = false;

        if (!empty($string_to_sanitise))
        {
            $sanitised_string = filter_var($string_to_sanitise, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        }
        return $sanitised_string;
    }

    public function sanitiseEmail(string $email_to_sanitise): string
    {
        $cleaned_string = false;

        if (!empty($email_to_sanitise))
        {
            $sanitised_email = filter_var($email_to_sanitise, FILTER_SANITIZE_EMAIL);
            $cleaned_string = filter_var($sanitised_email, FILTER_VALIDATE_EMAIL);
        }
        return $cleaned_string;
    }

    public function sanitiseNumber(string $numbers_to_sanitise): string
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

}