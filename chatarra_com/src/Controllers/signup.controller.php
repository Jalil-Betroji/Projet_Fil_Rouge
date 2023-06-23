<?php
require_once '../Models/signup.model.php';

class SignupController
{
    private $model;

    public function __construct()
    {
        $this->model = new SignupModel();
    }

    public function signupUser()
    {
        if (isset($_POST['add_client'])) {
            $first_name = $_POST['fname'];
            $last_name = $_POST['lname'];
            $signup_Email = $_POST['signUp_Email'];
            $signup_Phone = $_POST['signUp_Phone'];
            $CIN = $_POST['cin'];
            $City = $_POST['signUp_City'];
            $address = $_POST['signUp_Address'];
            $account_Type = $_POST['type'];
            $signup_Password = $_POST['signUp_Password'];
            $signup_Re_Password = $_POST['signUp_Re_Password'];

            $result = true;

            if (
                empty($first_name) || empty($last_name) || empty($signup_Email) || empty($signup_Phone)
                || empty($CIN) || empty($address) || empty($City) || empty($account_Type)
                || empty($signup_Password) || empty($signup_Re_Password)
            ) {
                $result = false;
            }

            if (!preg_match("/^[a-zA-Z0-9]*$/", $first_name)) {
                $result = false;
            }

            if (!preg_match("/^[a-zA-Z0-9]*$/", $last_name)) {
                $result = false;
            }

            if (!filter_var($signup_Email, FILTER_VALIDATE_EMAIL)) {
                $result = false;
            }

            if ($signup_Password !== $signup_Re_Password) {
                $result = false;
            }

            // Check if user with same email and name already exists
            $stmt = $this->model->connect()->prepare('SELECT COUNT(*) FROM users WHERE Email = ? AND First_Name = ? AND Last_Name = ?');
            $stmt->execute([$signup_Email, $first_name, $last_name]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $result = false;
            }

            if (!$result) {
                // Redirect to error page
                header('Location: ../Views/error.php');
                exit();
            }

            // Add user to database
            $success = $this->model->setUser(
                $first_name,
                $last_name,
                $signup_Email,
                $signup_Phone,
                $CIN,
                $City,
                $address,
                $account_Type,
                $signup_Password,
                $signup_Re_Password
            );

            if (!$success) {
                // Redirect to error page
                header('Location: ../Views/error.php');
                exit();
            }

            // Redirect to success page
            header('Location: ../Views/index.php');
            exit();
        }
    }
}
?>