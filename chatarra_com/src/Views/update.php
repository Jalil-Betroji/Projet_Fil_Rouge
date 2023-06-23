<?php

require_once '../Config/connect.php';

class Product
{
    private $conn;

    public function __construct($dbh)
    {
        $this->conn = $dbh->connect();
    }

    public function updateProduct($data)
    {
        $query = "UPDATE products SET Product_Name = ?, Product_Serie = ?, Product_Location = ?, Product_Model = ?, Product_Description = ? , Product_Updated_Date = NOW() WHERE Product_ID = ?";
        $stmt = $this->conn->prepare($query);
        $result = $stmt->execute([$data['Product_Name'], $data['Product_Serie'], $data['Product_Location'], $data['Product_Model'], $data['Product_Description'], $data['Product_ID']]);
        return $result;
    }

    public function updateImagePath($data)
{
    if (isset($_FILES['image']['name']) && count($_FILES['image']['name']) <= 4) {

        // Delete existing rows
        $deleteQuery = "DELETE FROM `images` WHERE Product_ID = ?";
        $deleteStmt = $this->conn->prepare($deleteQuery);
        $deleteStmt->execute([$data['Product_ID']]);

        // Count the number of images files in array
        $total_count = count($_FILES['image']['name']);

        // Define the roles
        $imgRoles = ["primary", "secondary", "tertiary", "quaternary"];

        // Loop through every file
        for ($i = 0; $i < $total_count; $i++) {
            //The temp file path is obtained
            $tmpFilePath = $_FILES['image']['tmp_name'][$i];
            //A file path needs to be present
            if ($tmpFilePath != "") {
                //Setup our new file path
                $image_Path = $_FILES['image']['name'][$i];
                $newFilePath = "../../public/img/" . $image_Path;
                //File is uploaded to temp dir
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    // Insert a new row for each image
                    $insertImg = "INSERT INTO `images` (Image_Path, Product_ID, Image_Type) VALUES (?, ?, ?)";
                    $stmt = $this->conn->prepare($insertImg);
                    $result = $stmt->execute([$image_Path, $data['Product_ID'], $imgRoles[$i]]);

                    if (!$result) {
                        return false;
                    }
                }
            }
        }
        return true;
    }
}

    
    public function updateVehicule($data)
    {
        $query = "UPDATE vehicules SET Vehicule_Name = ? , Vehicule_Serie = ? WHERE Vehicule_ID = ?";
        $stmt = $this->conn->prepare($query);
        $result = $stmt->execute([$data['Vehicule_Name'], $data['Vehicule_Serie'], $data['Vehicule_ID']]);
        return $result;
    }
}

if (isset($_POST["update_The_Product"])) {
    $data = array(
        'Product_ID' => $_POST['hidden_product_id'],
        'Product_Name' => $_POST['update_name'],
        'Product_Serie' => $_POST['update_serie'],
        'Product_Model' => $_POST['update_model'],
        'Product_Location' => $_POST['update_location'],
        'Vehicule_Name' => $_POST['update_vehicule_name'],
        'Vehicule_Serie' => $_POST['update_vehicule_serie'],
        'Product_Description' => $_POST['update_description'],
        'Vehicule_ID' => $_POST['hidden_vehicule_id']
    );

    $dbh = new Dbh();
    $product = new Product($dbh);

    // Updating the product
    if (!$product->updateProduct($data)) {
        echo "Failed to update product";
    }

    // Updating the image path
    if (isset($_FILES['image']) && count($_FILES['image']['name']) > 0) {
        if (!$product->updateImagePath($data)) {
            echo "Failed to update image path";
        }
    }


    // Updating the vehicule
    if (!$product->updateVehicule($data)) {
        echo "Failed to update vehicule";
    }
    header('Location: ./profile.php?');
    exit();
}
class ChangeStatus {
    private $conn;
    public function __construct($dbh){
        $this->conn = $dbh->connect();
    } 
    public function updateStatus($update_date ,$order_status, $order_id){
        $query = "UPDATE orders SET Order_Updated_Date = ? , Order_Status = ? WHERE Order_ID = ? ;";
        $stmt = $this->conn->prepare($query);
        $statement = $stmt->execute([$update_date ,$order_status, $order_id]);
        return $statement;
    }
    
} 
if(isset($_POST['validate_status'])) {
    $order_statuses = $_POST['change_order_status'];
    $order_ids = $_POST['order_id_to_change'];
    $original_statuses = $_POST['original_order_status'];

    for($i = 0; $i < count($order_statuses); $i++) {
        $order_status = $order_statuses[$i];
        $order_id = $order_ids[$i];
        $original_status = $original_statuses[$i];

        if ($order_status != $original_status) {
            // Only update the status in the database if it has changed
            $dbh = new Dbh();
            $orderStatus = new ChangeStatus($dbh);
            $update_date = date('Y-m-d H:i:s');
            $orderStatus->updateStatus($update_date ,$order_status, $order_id);
        }
    }
}


?>