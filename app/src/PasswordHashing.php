

namespace FinalYear;

class PasswordHashing
{

  public function __construct(){}

  public function __destruct(){}

  public function createHashedPassword($password_string)
  {
    $password_to_hash = $password_string;
    $hashed = '';
    $options = array('cost' => BCRYPT_COST);
    if (!empty($password_to_hash))
    {
      $hashed = password_hash($password_to_hash, BCRYPT_ALGO, $options);
    }
    return $hashed;
  }


}
