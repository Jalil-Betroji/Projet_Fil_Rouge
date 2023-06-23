<?php
include '../Config/connect.php';

class LoginModel extends Dbh {
    protected function getUser($login_Email, $login_Password)
    {
        $stm = $this->connect()->prepare('SELECT * FROM `users` WHERE Email = ? ;');
        if (!$stm->execute([$login_Email])) {
            $stm = null;
            echo 'error is on line 15';
            exit();
        }
        
        $user = $stm->fetch(PDO::FETCH_ASSOC); // Retrieve a single row
        if (!$user) {
            $stm = null;
            header("Location: ../Views/error.php");
            exit();
        }

        $checkPass = password_verify($login_Password, $user["Password"]);
        if ($checkPass == false) {
            $stm = null;
            echo 'error is on line 31';
            exit();
        } elseif ($checkPass == true) {
            $stm = $this->connect()->prepare('SELECT * FROM `users` WHERE Email = ? AND Password = ?;');
            if (!$stm->execute([$login_Email, $user["Password"]])) {
                $stm = null;
                echo 'error is on line 39';
                exit();
            }
            if ($stm->rowCount() == 0) {
                $stm = null;
                echo 'error is on line 46';
                exit();
            }
            if ($user['Admin'] == 1) {
                $user = $stm->fetch(PDO::FETCH_ASSOC);
                session_start();
                $_SESSION['logged_in'] = true;
                $_SESSION['Admin'] = true;
                $_SESSION['Email'] = $user["Email"];
                header("Location: ../Views/admin.php");
                exit();
            } else {
                $user = $stm->fetch(PDO::FETCH_ASSOC);
                session_start();
                $_SESSION['logged_in'] = true;
                $_SESSION['Email'] = $user["Email"];
                header("Location: ../Views/index.php");
                exit();
            }
        }
    }
}
?>