<?php
require_once '../Config/connect.php';

class Product
{
    private $conn;

    public function __construct($dbh)
    {
        $this->conn = $dbh->connect();
    }

    public function isProductOrdered($product_ID)
    {
        $query = "SELECT * FROM orders WHERE Product_ID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$product_ID]);
        return $stmt->fetch();
    }

    public function deleteProductImages($product_ID)
    {
        $query = "DELETE FROM images WHERE Product_ID = ?";
        $stmt = $this->conn->prepare($query);
        $result = $stmt->execute([$product_ID]);
        return $result;
    }

    public function deleteProduct($product_ID)
    {
        $query = "DELETE FROM products WHERE Product_ID = ?";
        $stmt = $this->conn->prepare($query);
        $result = $stmt->execute([$product_ID]);
        return $result;
    }
}

if(isset($_POST['confirm_delete'])){
    $product_ID = $_POST['delete_id'];

    $dbh = new Dbh();
    $product = new Product($dbh);

    // Checking if the product is ordered
    if ($product->isProductOrdered($product_ID)) {
    header('Location: profile.php?message=rejection');
    } else {
        // Deleting the product images
        if (!$product->deleteProductImages($product_ID)) {
            echo "Failed to delete product images";
        }

        // Deleting the product
        if (!$product->deleteProduct($product_ID)) {
            echo "Failed to delete product";
        } else {
            echo "Product deleted successfully";
        }
    }
}
?>
