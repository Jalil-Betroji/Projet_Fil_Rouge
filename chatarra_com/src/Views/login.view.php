<?php
if (isset($_POST['login_into_account'])) {
    // Get the data from input 
    $login_Email = $_POST['login_email'];
    $login_Password = $_POST['login_password'];

    // Initiate LoginController class
    include '../Controllers/login.controller.php';
    $login = new LoginController($login_Email, $login_Password);
    $login->loginUser();
}
?>
