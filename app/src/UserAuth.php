<?php


namespace FinalYear;

use FinalYear\User;

class UserAuth
{

    public function user()
    {
        if(isset($_SESSION['user'])){
            return User::where('user_id', $_SESSION['user'])->first();
        }
    }

    public function check()
    {
        return isset($_SESSION['user']);
    }

    public function signInAttempt($username, $password)
    {
        $signed = User::where('username', $username)->first();

        if(!$signed)
        {
            return false;
        }

        if(password_verify($password, $signed->password))
        {
            $_SESSION['user'] = $signed->user_id;
            return true;
        }

        return false;
    }


}