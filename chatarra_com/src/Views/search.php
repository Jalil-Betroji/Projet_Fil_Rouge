<?php

if (isset($_POST['searchbtn_Home'])) {
    $min_Price = $_POST['min_price'];
    $max_Price = $_POST['max_price'];
    $city = $_POST['city'];
    $home_name_search = $_POST['home_name_search'];

    class Products
    {
        private $conn;

        public function __construct($dbh)
        {
            $this->conn = $dbh->connect();
        }

        public function getProducts($min_Price, $max_Price, $city, $home_name_search)
        {
            $query = "SELECT Products.Product_ID, Product_Name, Product_Description, Product_Serie, Product_Model, Product_Price, Product_Location, Image_Path, Vehicule_Name, Vehicule_Serie
                    FROM Products 
                    INNER JOIN Images ON Products.Product_ID = Images.Product_ID
                    INNER JOIN Vehicules ON Products.Vehicule_ID = Vehicules.Vehicule_ID
                    WHERE Image_Type = 'primary'";

            if (!empty($min_Price)) {
                $query .= " AND Product_Price > $min_Price ";
            }
            if (!empty($max_Price)) {
                $query .= " AND Product_Price < $max_Price";
            }
            if ($city != "City") {
                $query .= " AND Product_Location LIKE '$city'";
            }
            if ($home_name_search != "") {
                $query .= " AND Product_Name LIKE '%$home_name_search%'";
            }
            $query .= "LIMIT 6;";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $productList = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $productList;
        }
    }

    $dbh = new Dbh();
    $product = new Products($dbh);
    $productList = $product->getProducts($min_Price, $max_Price, $city, $home_name_search);



    if (count($productList) > 0) {
        foreach ($productList as $values) {
            ?>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="property-item rounded overflow-hidden">
                    <div class="position-relative overflow-hidden">
                        <a href=""><img style="height:20rem;" class="w-100" src="../../public/img/<?php echo $values['Image_Path'] ?>"
                                alt=""></a>
                        <div class="bg-color rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">
                            <?php echo $values['Vehicule_Name'] ?>
                        </div>
                        <div class="bg-white rounded-top text-color position-absolute start-0 bottom-0 mx-4 pt-1 px-3">
                            <?php echo $values['Vehicule_Serie'] ?>
                        </div>
                    </div>
                    <div class="p-4 pb-0">
                        <h5 class="text-color mb-3">
                            <?php echo $values['Product_Price'] ?>$
                        </h5>
                        <a class="d-block h5 mb-2" href="">
                            <?php echo $values['Product_Name'] ?>
                        </a>
                        <p>
                            <?php echo $values['Product_Description'] ?>
                        </p>
                    </div>
                    <div class="d-flex border-top">
                        <small class="flex-fill text-center border-end py-2">
                            <?php echo $values['Product_Serie'] ?>
                        </small>
                        <small class="flex-fill text-center border-end py-2">
                            <?php echo $values['Product_Model'] ?>
                        </small>
                        <small class="flex-fill text-center py-2">
                            <i class="fa fa-map-marker-alt text-color me-2"></i>
                            <?php echo $values['Product_Location'] ?>
                        </small>
                    </div>
                    <?php
                    if (isset($_SESSION["Email"])) {
                        ?>
                        <button type="button" class="btn btn-primary w-100"
                            onclick="get_Details(<?php echo $values['Product_ID'] ?>)">More Details</button>
                        <?php
                    } else {
                        ?>
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#Login_modal">More
                            Details</button>
                        <?php
                    }
                    ?>


                </div>
            </div>
            <?php
        }
    }

    if (isset($_SESSION['Email'])) {
        ?>
        <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s">
            <a class="btn btn-primary py-3 px-5" href="items.php">Browse More spare parts</a>
        </div>
        <?php
    } else {
        ?>
        <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s" data-bs-toggle="modal" data-bs-target="#Login_modal">
            <button class="btn btn-primary py-3 px-5">Browse More spare parts</button>
        </div>
        <?php
    }
} elseif (isset($_POST['searchbtn'])) {
    $min_Price = $_POST['min_price'];
    $max_Price = $_POST['max_price'];
    $city = $_POST['city'];
    $home_name_search = $_POST['home_name_search'];
    // Set the page number and limit
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $limit = 6;

    // Calculate the offset
    $offset = ($page - 1) * $limit;


    class Products
    {
        private $conn;

        public function __construct($dbh)
        {
            $this->conn = $dbh->connect();
        }

        public function getProducts($min_Price, $max_Price, $city, $offset, $limit, $home_name_search)
        {
            $query = "SELECT Products.Product_ID, Product_Name, Product_Description, Product_Serie, Product_Model, Product_Price, Product_Location, Image_Path, Vehicule_Name, Vehicule_Serie
                    FROM Products 
                    INNER JOIN Images ON Products.Product_ID = Images.Product_ID
                    INNER JOIN Vehicules ON Products.Vehicule_ID = Vehicules.Vehicule_ID
                    WHERE Image_Type = 'primary'
                    ";

            if (!empty($min_Price)) {
                $query .= " AND Product_Price > $min_Price ";
            }
            if (!empty($max_Price)) {
                $query .= " AND Product_Price < $max_Price";
            }
            if ($city != "City") {
                $query .= " AND Product_Location LIKE '$city'";
            }
            if ($home_name_search != "") {
                $query .= " AND Product_Name LIKE '%$home_name_search%'";
            }
            $query .= " LIMIT $offset, $limit";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $productList = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $productList;
        }
        public function getTotalProducts()
        {
            $query = "SELECT COUNT(*) as Total FROM Products;";

            $statement = $this->conn->prepare($query);
            $statement->execute();
            $result = $statement->fetch();

            return $result['Total'];
        }
    }

    $dbh = new Dbh();
    $product = new Products($dbh);
    $productList = $product->getProducts($min_Price, $max_Price, $city, $offset, $limit, $home_name_search);
    // Get the total number of products

    $totalProducts = $product->getTotalProducts();

    // Calculate the total number of pages
    $totalPages = ceil($totalProducts / $limit);

    if (count($productList) > 0) {
        foreach ($productList as $values) {
            ?>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="property-item rounded overflow-hidden">
                    <div class="position-relative overflow-hidden">
                        <a href=""><img style="height:20rem;" class="w-100" src="../../public/img/<?php echo $values['Image_Path'] ?>"
                                alt=""></a>
                        <div class="bg-color rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">
                            <?php echo $values['Vehicule_Name'] ?>
                        </div>
                        <div class="bg-white rounded-top text-color position-absolute start-0 bottom-0 mx-4 pt-1 px-3">
                            <?php echo $values['Vehicule_Serie'] ?>
                        </div>
                    </div>
                    <div class="p-4 pb-0">
                        <h5 class="text-color mb-3">
                            <?php echo $values['Product_Price'] ?>$
                        </h5>
                        <a class="d-block h5 mb-2" href="">
                            <?php echo $values['Product_Name'] ?>
                        </a>
                        <p>
                            <?php echo $values['Product_Description'] ?>
                        </p>
                    </div>
                    <div class="d-flex border-top">
                        <small class="flex-fill text-center border-end py-2">
                            <?php echo $values['Product_Serie'] ?>
                        </small>
                        <small class="flex-fill text-center border-end py-2">
                            <?php echo $values['Product_Model'] ?>
                        </small>
                        <small class="flex-fill text-center py-2">
                            <i class="fa fa-map-marker-alt text-color me-2"></i>
                            <?php echo $values['Product_Location'] ?>
                        </small>
                    </div>
                    <?php
                    if (isset($_SESSION["Email"])) {
                        ?>
                        <button type="button" class="btn btn-primary w-100"
                            onclick="get_Details(<?php echo $values['Product_ID'] ?>)">More Details</button>
                        <?php
                    } else {
                        ?>
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#Login_modal">More
                            Details</button>
                        <?php
                    }
                    ?>

                </div>
            </div>
            <?php
        }
        ?>
        <!-- Pagination links -->
        <div class="d-flex gap-4 justify-content-center">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo ($page - 1); ?>">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php if ($i == $page): ?>
                    <span class="current-page">
                        <?php echo $i; ?>
                    </span>
                <?php else: ?>
                    <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo ($page + 1); ?>">Next</a>
            <?php endif; ?>
        </div>
        <?php
    }
}
?>