<?php

require_once '../Config/connect.php';

session_start();

if (isset($_POST['update'])) {
    $first_Name = $_POST['first_name'];
    $last_Name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $cin = $_POST['cin'];
    $account_type = $_POST['account_type'];
    $user_email = $_SESSION['Email'];
    $image_Path = "";

    if (isset($_FILES['image']['name']) && $_FILES['image']['tmp_name'] != "") {
        $tmpFilePath = $_FILES['image']['tmp_name'];
        $image_Path = $_FILES['image']['name'];
        $newFilePath = "../../public/img/" . $image_Path;
        move_uploaded_file($tmpFilePath, $newFilePath);
    }

    class Profile_info
    {
        private $conn;

        public function __construct($dbh)
        {
            $this->conn = $dbh->connect();
        }
        public function updateUser($first_Name, $last_Name, $phone, $cin, $account_type,$image_Path, $user_email)
        {
            
            if($account_type != "Switch Account"){
                 // Update the email column in the users table
            $query2 = "UPDATE users SET First_Name=?, Last_Name=?, Phone=?, CIN=?, Account_Type=?  WHERE Email=?";
            $statement = $this->conn->prepare($query2);
            $statement->execute(array($first_Name, $last_Name, $phone, $cin, $account_type, $user_email));
            }elseif($account_type != "Switch Account" && $image_Path !="" ){
                // Update the email column in the users table
            $query2 = "UPDATE users SET First_Name=?, Last_Name=?, Phone=?, CIN=? ,Account_Type = ?, Image_Path = ?  WHERE Email=?";
            $statement = $this->conn->prepare($query2);
            $statement->execute(array($first_Name, $last_Name, $phone, $cin,$account_type,$image_Path, $user_email));
            }elseif($image_Path != ""){
                   // Update the email column in the users table
            $query2 = "UPDATE users SET First_Name=?, Last_Name=?, Phone=?, CIN=? , Image_Path = ?  WHERE Email=?";
            $statement = $this->conn->prepare($query2);
            $statement->execute(array($first_Name, $last_Name, $phone, $cin,$image_Path, $user_email));
            }else{
                // Update the email column in the users table
            $query2 = "UPDATE users SET First_Name=?, Last_Name=?, Phone=?, CIN=?  WHERE Email=?";
            $statement = $this->conn->prepare($query2);
            $statement->execute(array($first_Name, $last_Name, $phone, $cin, $user_email));
            }
           
        }
        
    }
    $dbh = new Dbh();
    $update_profile_info = new Profile_info($dbh);
    $statement = $update_profile_info->updateUser($first_Name, $last_Name, $phone, $cin, $account_type,$image_Path, $user_email);
    header("Location: profile.php");
}
if(isset($_POST['update_password'])){
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $re_new_password = $_POST['re_new_password'];
    $user_email = $_SESSION['Email'];

    // Check if new passwords match
    if ($new_password !== $re_new_password) {
        die("New passwords do not match!");
    }

    class Password_Update
    {
        private $conn;

        public function __construct($dbh)
        {
            $this->conn = $dbh->connect();
        }

        public function update_Password($old_password, $new_password, $user_email)
        {
            // Verify the old password
            $query1 = "SELECT Password FROM users WHERE Email=?";
            $stmt = $this->conn->prepare($query1);
            $stmt->execute([$user_email]);
            $result = $stmt->fetch();

            if (!password_verify($old_password, $result['Password'])) {
                die("Incorrect old password!");
            }

            // Hash the new password
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password column in the users table
            $query2 = "UPDATE users SET Password=? WHERE Email=?";
            $stmt = $this->conn->prepare($query2);
            $stmt->execute([$hashed_new_password, $user_email]);
        }
    }

    $dbh = new Dbh();
    $update_profile_info = new Password_Update($dbh);
    $update_profile_info->update_Password($old_password, $new_password, $user_email);
    header("Location: profile.php");
}

?>