<?php
require_once '../Config/connect.php';
session_start();

if (isset($_POST["Add_Product"])) {

    class Product
    {
        private $conn;

        public function __construct($dbh)
        {
            $this->conn = $dbh->connect();
        }

        public function addProduct($data)
        {
            $query = "INSERT INTO `products` (
                Email,
                Product_Name,
                Product_Description,
                Product_Serie,
                Product_Price,
                Product_Location,
                Product_Model,
                Product_Added_Date,
                Product_Updated_Date,
                Vehicule_ID
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute([
                $data['Email'],
                $data['Product_Name'],
                $data['Product_Description'],
                $data['Product_Serie'],
                $data['Product_Price'],
                $data['Product_Location'],
                $data['Product_Model'],
                $data['Product_Added_Date'],
                $data['Product_Updated_Date'],
                $data['Vehicule_ID']
            ]);
            return $result ? $this->conn->lastInsertId() : false;
        }

        public function addImagePath($dbh, $last_inserted_id)
        {
            if (isset($_FILES['image']['name']) && count($_FILES['image']['name']) > 0 && count($_FILES['image']['name']) <= 4) {
                $total_count = count($_FILES['image']['name']);
                $imgRoles = ["primary", "secondary", "tertiary", "quaternary"];

                for ($i = 0; $i < $total_count; $i++) {
                    $tmpFilePath = $_FILES['image']['tmp_name'][$i];
                    if ($tmpFilePath != "") {
                        $image_Path = $_FILES['image']['name'][$i];
                        $newFilePath = "img/" . $image_Path;
                        if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                            $insertImg = "INSERT INTO `images` (Image_Path, Product_ID, Image_Type) VALUES (?, ?, ?)";
                            $stmt = $this->conn->prepare($insertImg);
                            $result = $stmt->execute([$image_Path, $last_inserted_id, $imgRoles[$i]]);
                            if (!$result) {
                                return false;
                            }
                        }
                    }
                }
                return true;
            }
        }
    }

    $dbh = new Dbh();
    $product = new Product($dbh);

    $data = array(
        'Email' => $_SESSION['Email'],
        'Product_Name' => $_POST['add_product_name'],
        'Product_Serie' => $_POST['add_product_serie'],
        'Product_Model' => $_POST['add_product_model'],
        'Product_Location' => $_POST['add_product_location'],
        'Product_Description' => $_POST['add_product_description'],
        'Product_Price' => $_POST['add_product_price'],
        'Product_Added_Date' => date('Y-m-d H:i:s'),
        'Product_Updated_Date' => date('Y-m-d H:i:s'),
        'Vehicule_ID' => $_POST['add_vehicule_id'],
    );

    $last_inserted_id = $product->addProduct($data);
    if ($last_inserted_id === false) {
        echo "Failed to add product";
    } else {
        if (!$product->addImagePath($dbh, $last_inserted_id)) {
            echo "Failed to add image";
        } else {
            header('Location:profile.php');
        }
    }

}
?>