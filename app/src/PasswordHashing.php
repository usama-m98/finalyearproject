<?php
/**
 * Wrapper class for the PHP BCrypt library.  Takes the pain out of using the library.
 *
 * @author CF Ingrams <cfi@dmu.ac.uk>
 * @copyright De Montfort University
 */

namespace FinalYear;

class PasswordHashing
{

  public function __construct(){}

  public function __destruct(){}

  public function createHashedPassword($password_string)
  {
    $password_to_hash = $password_string;
    $hashed_password = '';

    if (!empty($password_to_hash))
    {
      $options = array('cost' => BCRYPT_COST);
      $hashed_password = password_hash($password_to_hash, BCRYPT_ALGO, $options);
    }
    return $hashed_password;
  }


}
