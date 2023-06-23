<?php

require_once '../Config/connect.php';

if(isset($_POST['vehicule_name'])) {
    $dbh = new Dbh();
    $query = "SELECT Vehicule_Serie , Vehicule_ID FROM vehicules WHERE Vehicule_Name = ?";
    $stmt = $dbh->connect()->prepare($query);
    $stmt->execute([$_POST['vehicule_name']]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // foreach($data as $row) {
    //     echo '<option value="'.$row['Vehicule_Serie'].'">'.$row['Vehicule_Serie'].'</option>
    //     ';
    // }
    header('Content-Type: application/json');

    echo json_encode($data);
}
?>