<?php
require_once '../Config/connect.php';
session_start();

if (isset($_POST['confirm_order'])) {
    // Get the user input data from the form and store it in variables
    $full_Name = $_POST['Order_client_fullname'];
    $user_Email = $_SESSION['Email'];
    $client_Phone = $_POST['order_client_phone'];
    $client_City = $_POST['order_client_city'];
    $order_Status = "Pending";
    $product_ID = $_POST["confirm_product_id"];

    // Create a Products class
    class Products
    {
        private $conn;

        public function __construct($dbh)
        {
            $this->conn = $dbh->connect();
        }

        public function addOrder($user_Email, $full_Name, $product_ID, $client_Phone, $client_City, $order_Status)
        {
            $query = "INSERT INTO orders (Email, Full_Name, Product_ID, Phone_Number, City, Order_Status)
                      VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$user_Email, $full_Name, $product_ID, $client_Phone, $client_City, $order_Status]);
        }
        public function updateProduct ($product_ID){
            $query = "UPDATE products SET Product_Status = ? WHERE Product_ID = ?;";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['Sold',$product_ID]);
        }
    }

    // Create a Dbh object and instantiate the Products class
    $dbh = new Dbh();
    $product = new Products($dbh);
    $product->addOrder($user_Email, $full_Name, $product_ID, $client_Phone, $client_City, $order_Status);
    $product->updateProduct($product_ID);

    // Redirect to success.php with success message
    header('Location: items.php?message=success');
    exit();
}

?>