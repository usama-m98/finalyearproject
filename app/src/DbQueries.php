<?php


namespace FinalYear;


class DbQueries
{
    public function __construct(){}

    public function __destruct(){}

    public function storeUserLoginData()
    {
        $query_string = "INSERT INTO users";
        $query_string .= " SET ";
        $query_string .= "username = :username, ";
        $query_string .= "email = :email, ";
        $query_string .= "password = :password, ";
        $query_string .= "role = :role";

        return $query_string;
    }

    public function retrieveUserData()
    {
        $query_string = 'SELECT user_id, username, email, password ';
        $query_string .= 'FROM users ';
        $query_string .= 'WHERE username = :username';

        return $query_string;
    }

    public function updateUsername()
    {
        $query_string = 'UPDATE users';
        $query_string .= ' SET ';
        $query_string .= 'username = :username ';
        $query_string .= 'WHERE user_id = :user_id';

        return $query_string;
    }

    public function updateEmail()
    {
        $query_string = 'UPDATE users';
        $query_string .= ' SET ';
        $query_string .= 'email = :email ';
        $query_string .= 'WHERE user_id = :user_id';

        return $query_string;
    }

    public function updatePassword()
    {
        $query_string = 'UPDATE users';
        $query_string .= ' SET ';
        $query_string .= 'password = :password ';
        $query_string .= 'WHERE user_id = :user_id';

        return $query_string;
    }


    public function insertPersonalDetails()
    {
        $query_string = "INSERT INTO customer";
        $query_string .= " SET ";
        $query_string .= "first_name = :firstname, ";
        $query_string .= "surname = :surname, ";
        $query_string .= "address = :address, ";
        $query_string .= "phone_number = :phonenumber, ";
        $query_string .= "user_id = :userid";

        return $query_string;
    }
}