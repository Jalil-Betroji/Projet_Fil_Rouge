<?php
require_once '../Config/connect.php';

if (isset($_GET["Product_details"])) {
    $Product_ID = $_GET['Product_details'];

    $dbh = new Dbh();
    // Call the connect method to establish a connection to the database
    $conn = $dbh->connect();

    $sql = "SELECT a.Product_ID, a.Vehicule_ID, a.Product_Name, a.Product_Serie, a.Product_Location, a.Product_Model, a.Product_Description, GROUP_CONCAT(b.Image_Path) AS Images, c.Vehicule_Name, c.Vehicule_Serie
                        FROM products a
                        INNER JOIN Vehicules c ON a.Vehicule_ID = c.Vehicule_ID
                        INNER JOIN images b ON a.Product_ID = b.Product_ID
                        WHERE a.Product_ID = $Product_ID
                        GROUP BY a.Product_ID";
    // execute a query
    $statement = $conn->query($sql);

    // fetch the result as an associative array
    $product_Data = $statement->fetch(PDO::FETCH_ASSOC);
    $imagesArray = explode(",", $product_Data['Images']);

    header('Content-Type: application/json');

    echo json_encode($product_Data);

}
if (isset($_GET["cancel"])) {

    $Reservation_ID = $_GET["cancel"];

    // Create a new Dbh object
    $dbh = new Dbh();
    // Call the connect method to establish a connection to the database
    $conn = $dbh->connect();

    $sql = "SELECT Reservation_ID
     FROM `reservation` WHERE  Reservation_ID = $Reservation_ID AND Reservation_Status = 'reserved' ";

    // execute a query
    $statement = $conn->query($sql);

    // fetch all rows
    $reserve_id = $statement->fetch(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');

    echo json_encode($reserve_id);
}

?>