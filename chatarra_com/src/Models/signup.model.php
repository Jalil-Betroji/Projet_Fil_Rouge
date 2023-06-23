<?php
require_once '../Config/connect.php';

class SignupModel extends Dbh
{
  public function setUser(
    $first_name,
    $last_name,
    $signup_Email,
    $signup_Phone,
    $CIN,
    $City,
    $address,
    $account_Type,
    $signup_Password,
    $signup_Re_Password,
    $admin = 0 
  )
  {
    $stm = $this->connect()->prepare('INSERT INTO `users`(
        Nickname,
        First_Name,	
        Last_Name,	
        Password,	
        Email,	
        Phone,	
        CIN,	
        City,	
        Address,	
        Account_Type,
        Admin
        ) VALUES(?,?,?,?,?,?,?,?,?,?,?);');
    $hashedPw = password_hash($signup_Password, PASSWORD_DEFAULT);
    if (
      !$stm->execute([
        $first_name . "_" . $last_name,
        $first_name,
        $last_name,
        $hashedPw,
        $signup_Email,
        $signup_Phone,
        $CIN,
        $City,
        $address,
        $account_Type,
        $admin 
      ])
    ) {
      $stm = null;
      return false;
    }
    return true;
  }
}
?>