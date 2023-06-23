<?php
require_once '../Config/connect.php';
session_start();
if ($_SESSION['logged_in'] !== true) {
    // Redirect the user to the login page
    header("Location: ./locked.php");
    exit;
} elseif (isset($_SESSION['Email'])) {

    class Profile_info
    {
        private $conn;

        public function __construct($dbh)
        {
            $this->conn = $dbh->connect();
        }

        public function getUser()
        {
            $query = "SELECT * FROM users WHERE Email = ? ;";
            $statement = $this->conn->prepare($query);
            $statement->execute(array($_SESSION['Email']));
            $profile_info = $statement->fetch(PDO::FETCH_ASSOC);
            return $profile_info;
        }
    }

    $dbh = new Dbh();
    $profile_info_obj = new Profile_info($dbh);
    $profile_info = $profile_info_obj->getUser();
}
?>


<!DOCTYPE html>
<html lang="en">

<?php include_once('./templates/header.php') ?>

<body>

    <!-- ============ Header Navbar Start ============ -->

    <header class="container-fluid nav-bar bg-transparent">
        <nav class="navbar navbar-expand-lg bg-white navbar-light py-0 px-4">
            <a href="index.php" class="navbar-brand d-flex align-items-center text-center">
                <div class="icon me-2">
                    <img class="img-fluid" src="../../public/img/logo.png" alt="Icon" style="width: 15rem; height: 4rem;">
                </div>
            </a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto">
                    <a href="items.php" class="nav-item nav-link active">Home</a>
                    <a href="#footer" class="nav-item nav-link">About Us</a>


                    <div class="nav-item dropdown d-flex m-1">
                        <a href="#" class="nav-item"><img class="rounded-circle" style="width:4rem; height:4rem;"
                                src="../../public/img/<?php echo $profile_info['Image_Path'] ?>">
                            <span class="fw-bold">
                                <?php echo $profile_info['Nickname'] ?>
                            </span>
                        </a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="#" class="dropdown-item" id="setting_btn">Setting</a>
                            <a href="#" class="dropdown-item" id="change_password_btn">Password</a>

                            <?php
                            if ($profile_info['Account_Type'] == "Buyer") {
                                ?>
                                <a href="#" class="dropdown-item" id="my_orders_btn">My Orders</a>
                                <?php
                            } else {
                                ?>
                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#add_products">Add
                                    Product</a>
                                <a href="#" class="dropdown-item" id="my_products_btn">My Products</a>
                                <?php
                            }
                            ?>
                            <a href="./logout.php" name="logout" class="dropdown-item">Log out</a>
                        </div>
                    </div>

                </div>
            </div>
        </nav>
    </header>
    <!-- ============ Header Navbar End ============ -->

    <section>
        <div class="d-flex flex-column border-right w-100 lines mt-5">

            <div class="container ">
                <form class="mb-5" id="setting_section" action="./profile_code.php" method="POST"
                    enctype="multipart/form-data">
                    <div class="mx-2 text-center mb-4" id="prodile_image">
                        <div class="profile-pic w-25 container">
                            <label class="-label" for="file">
                                <span><i class="fa-solid fa-camera"></i></span>
                                <span>Change Image</span>
                            </label>
                            <input id="file" type="file" name="image" onchange="loadFile(event)" />
                            <img src="../../public/img/<?php echo $profile_info['Image_Path'] ?>" alt="profile picture" id="output"
                                style="width: 11rem; height: 11rem; border-radius: 100%" />
                        </div>
                    </div>
                    <h3 class="mx-4">My Account</h3>
                    <div class="d-flex gap-4 mx-4 justify-content-center">
                        <div class="w-50">
                            <label for="text" class="d-block pb-2 pt-3">First Name</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" readonly
                                    value="<?php echo $profile_info['First_Name'] ?>" class="form-control"
                                    name="first_name" id="f_Name">
                                <button class="btn btn-outline-secondary" type="button" id="edit_Fname"><i
                                        class="bi bi-pencil"></i></button>
                            </div>
                        </div>
                        <div class="w-50">
                            <label for="text" class="d-block pb-2 pt-3">Last Name</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" readonly
                                    value="<?php echo $profile_info['Last_Name'] ?>" class="form-control"
                                    name="last_name" id="l_Name">
                                <button class="btn btn-outline-secondary" type="button" id="edit_Lname"><i
                                        class="bi bi-pencil"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-4 mx-4 justify-content-center">
                        <div class="w-50">
                            <label for="email" class="d-block pb-2 pt-3">Email</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" readonly
                                    value="<?php echo $profile_info['Email'] ?>" class="form-control" name="email">

                            </div>
                        </div>
                        <div class="w-50">
                            <label for="number" class="d-block pb-2 pt-3">Phone</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" readonly
                                    value="<?php echo $profile_info['Phone'] ?>" class="form-control" name="phone"
                                    id="phone">
                                <button class="btn btn-outline-secondary" type="button" id="edit_Phone"><i
                                        class="bi bi-pencil"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-4 mx-4 justify-content-center">
                        <div class="w-50">
                            <label for="text" class="d-block pb-2 pt-3">CIN</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" readonly
                                    value="<?php echo $profile_info['CIN'] ?>" class="form-control" name="cin" id="cin">
                                <button class="btn btn-outline-secondary" type="button" id="edit_Cin"><i
                                        class="bi bi-pencil"></i></button>
                            </div>
                        </div>
                        <div class="w-50">
                            <label for="text" class="d-block pb-2 pt-3">City</label>
                            <div class="input-group">
                                <select class="form-control" name="city">
                                    <option value="<?php echo $profile_info['City'] ?>" selected><?php echo $profile_info['City'] ?></option>
                                    <option value="tetouan">tetouan</option>
                                    <option value="tetouan">tetouan</option>
                                    <option value="tetouan">tetouan</option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-4 mx-4 justify-content-center">
                        <div class="w-50">
                            <label for="email" class="d-block pb-2 pt-3">Account Type</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" readonly
                                    value="<?php echo $profile_info['Account_Type'] ?>" class="form-control"
                                    name="account_type" id="account_type">

                            </div>
                        </div>
                        <div class="w-50">
                            <label for="number" class="d-block pb-2 pt-3">Switch Account</label>
                            <div class="input-group">
                                <select name="account_type" id="account_type" class="form-control rounded-3">
                                    <option value="Switch Account" selected>Click To Switch Account</option>
                                    <option value="Buyer">Buyer</option>
                                    <option value="Seller">Seller</option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mx-4 mt-3">
                        <button type="submit" class="btn btn-primary" name="update">Update</button>
                        <button class="btn" style="
                           background-color: #121826;
                           color: white;
                           border: 1px gray solid;
                           ">
                            Cancel
                        </button>
                    </div>
                </form>


                <!-- =================== Account Setting End =================== -->

                <!-- =================== Account Password start =================== -->

                <form action="./profile_code.php" method="POST" class="mx-4 mb-5 hide profile_data" id="password_section">
                    <fieldset>
                        <legend class="pb-3">Change Password</legend>

                        <label for="old_password" class="d-block pb-2 pt-3">Old Password</label>
                        <input type="password" id="old_password" class="rounded-3 w-75" name="old_password"
                            placeholder="*************" required />

                        <label for="new_password" class="d-block pb-2 pt-3">New Password</label>
                        <input type="password" id="new_password" class="rounded-3 w-75" name="new_password"
                            placeholder="*************" required />

                        <label for="re_new_password" class="d-block pb-2 pt-3">Confirm New Password</label>
                        <input type="password" id="re_new_password" class="rounded-3 w-75" name="re_new_password"
                            placeholder="*************" required />

                        <div class="d-flex gap-3 mt-3">
                            <button type="submit" class="btn btn-primary" name="update_password">Update</button>
                            <button class="btn" style="
                                background-color: #121826;
                                color: white;
                                border: 1px gray solid;
                               "> Cancel
                            </button>
                        </div>
                    </fieldset>
                </form>


                <!-- =================== Account Password End =================== -->
                <?php
                if ($profile_info['Account_Type'] == "Buyer") {
                    ?>
                    <!-- =================== Order Start =================== -->
                    <?php
                    class Orders
                    {
                        private $conn;

                        public function __construct($dbh)
                        {
                            $this->conn = $dbh->connect();
                        }

                        public function getOrders($userEmail)
                        {
                            $sql = "SELECT orders.*, products.Product_Name, products.Product_Price FROM orders
                            LEFT JOIN products ON orders.Product_ID = products.Product_ID
                            WHERE orders.Email=?";
                            $stmt = $this->conn->prepare($sql);
                            $stmt->execute([$userEmail]);
                            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            return $orders;
                        }

                    }

                    $dbh = new Dbh();
                    $orders = new Orders($dbh);
                    $userEmail = $_SESSION['Email']; // assuming you store user email in session
                    $orderData = $orders->getOrders($userEmail);

                    ?>
                    <div class="mx-4 mb-5 hide" id="order_section">
                        <?php
                        foreach ($orderData as $order) {
                            $date = new DateTime($order['Order_Date']);
                            ?>
                            <div class="d-flex order">
                                <div class="date">
                                    <p>
                                        <?php echo $date->format('d') ?>
                                    </p>
                                    <p>
                                        <?php echo $date->format('M') ?>
                                    </p>
                                    <p>
                                        <?php echo $date->format('Y') ?>
                                    </p>
                                </div>
                                <div class="d-flex justify-content-between data w-100">
                                    <h4>
                                        <?php echo $order['Product_Name'] ?>
                                    </h4>
                                    <div class="d-flex gap-2 w-25 justify-content-center">
                                        <button class="btn price w-50">$
                                            <?php echo $order['Product_Price'] ?>
                                        </button>
                                        <button class="w-50 btn btn-secondary">
                                            <?php echo $order['Order_Status'] ?>
                                        </button>
                                        <?php
                                        // Create a DateTime object for the current time
                                        $current_time = new DateTime();

                                        // Subtract three days from the current time
                                        $current_time->sub(new DateInterval('P3D'));

                                        // Create a DateTime object for the order's updated date
                                        $order_updated_date = new DateTime($order['Order_Updated_Date']);
                                        if ($order['Order_Status'] === "Livred" && $order_updated_date <= $current_time):
                                            ?>

                                            <select name="product_health" id="product_health" class="btn btn-warning"
                                                style="height:100%;">
                                                <option value="Worked" selected>Worked</option>
                                                <option value="Not working">Not Working</option>
                                            </select>

                                        <?php endif; ?>

                                    </div>

                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>

                </div>
                <!-- =================== Order End =================== -->
                <?php
                } else {
                    ?>

                <?php
                class Products
                {
                    private $conn;

                    public function __construct($dbh)
                    {
                        $this->conn = $dbh->connect();
                    }

                    public function getProducts($userEmail)
                    {
                        $sql = "SELECT Products.Product_ID, Product_Name, Product_Description, Product_Serie, Product_Model, Product_Price, Product_Location, Image_Path, Vehicule_Name ,Vehicule_Serie
                                FROM Products 
                                INNER JOIN Images ON Products.Product_ID = Images.Product_ID
                                INNER JOIN Vehicules ON Products.Vehicule_ID = Vehicules.Vehicule_ID
                                WHERE Image_Type = 'primary' AND Email = ?;";
                        $stmt = $this->conn->prepare($sql);
                        $stmt->execute([$userEmail]);
                        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        return $products;
                    }
                }

                $dbh = new Dbh();
                $products = new Products($dbh);
                $userEmail = $_SESSION['Email']; // assuming you store user email in session
                $productsData = $products->getProducts($userEmail);
                ?>
                <div class="hide" id="products_section">
                    <?php
                    foreach ($productsData as $products) {
                        ?>
                        <div class="d-flex w-100 my_product">
                            <div class="img_holder">
                                <img src="../../public/img/<?php echo $products['Image_Path'] ?>" alt="disk image"
                                    style="width: 21rem;height: 19rem;" />
                            </div>
                            <div class="data w-100 text-light">
                                <h4>
                                    <?php echo $products['Product_Name'] ?>
                                </h4>
                                <p>
                                    <?php echo $products['Product_Price'] ?> $
                                </p>
                                <p>Serie :<span>
                                        <?php echo $products['Product_Serie'] ?>
                                    </span></p>
                                <p>
                                    <?php echo $products['Product_Description'] ?>
                                </p>
                            </div>
                            <form class="d-flex flex-column w-25 gap-4 justify-content-around">
                                <input type="submit" class="btn btn-danger w-100" data-bs-toggle="modal"
                                    data-bs-target="#DeleteModal"
                                    onclick="delete_product(event , <?php echo $products['Product_ID'] ?>)" value="Delete">
                                <input type="submit" class="btn btn-success w-100" data-bs-toggle="modal"
                                    data-bs-target="#update_modal"
                                    onclick="update(event , <?php echo $products['Product_ID'] ?>)" value="Update">
                                <input type="submit" class="btn btn-warning w-100" data-bs-toggle="modal"
                                    data-bs-target="#more_details_modal"
                                    onclick="getMore_Details(event, <?php echo $products['Product_ID'] ?>);" value="Details">

                            </form>
                        </div>
                        <?php
                    }
                    ?>
                </div>



            </div>
        <?php } ?>
    </section>
    <?php
    // Check if a rejection message is present in the query parameters
    if (isset($_GET['message']) && $_GET['message'] === 'rejection') {
        // Set a JavaScript variable with the rejection message
        $rejection_message = "You can't delete an ordered product.";

        // Output the rejection message in a hidden HTML element
        echo '<div id="rejection-message" style="display:none;">' . $rejection_message . '</div>';

        // Output JavaScript code to display the rejection message after the page loads
        echo '<script>
                window.addEventListener("load", function() {
                    var message = document.getElementById("rejection-message").textContent;
                    if (message) {
                        window.alert(message);
                        window.location.href = "./profile.php";
                    }
                });
            </script>';
    }
    ?>

    <!-- =========================================== -->
    <!-- The Start Delete Modal -->
    <!-- =========================================== -->

    <div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Delete Announce
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="./delete.php" method="POST">
                        <input type="hidden" name="delete_id" id="delete_id">
                        <div>

                            <h4><i class="fa-sharp fa-solid fa-trash"></i>Are you sure you want to delete this announce
                                ?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <input type="submit" class="btn btn-danger" name="confirm_delete" value="Delete">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- =========================================== -->
    <!-- The End Delete Modal -->
    <!-- =========================================== -->


    <!-- =========================================== -->
    <!-- The Start of Update Modal -->
    <!-- =========================================== -->

    <div class="modal fade" id="update_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Add New Announce
                    </h1>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="update.php" method="POST" class="modal-body" enctype="multipart/form-data">

                    <section>

                        <div class="col-md-6 animated fadeIn container">

                            <div class="owl-carousel header-carousel">
                                <div class="owl-carousel-item">
                                    <img id="Product_image_1" class="img-fluid size" src="" alt="slide image">
                                </div>
                                <div class="owl-carousel-item">
                                    <img id="Product_image_2" class="img-fluid size" src="" alt="slide image">
                                </div>
                                <div class="owl-carousel-item">
                                    <img id="Product_image_3" class="img-fluid size" src="" alt="slide image">
                                </div>
                                <div class="owl-carousel-item">
                                    <img id="Product_image_4" class="img-fluid size" src="" alt="slide image">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image-upload">Select exactly 4 images to upload:</label>
                            <div class="custom-file">
                                <input type="file" name="image[]" class="custom-file-input" id="image-upload"
                                    accept="image/*" multiple="multiple" required>
                                <label class="custom-file-label" for="image-upload">Choose file</label>
                            </div>
                            <div id="image-upload-error" class="text-danger" style="display:none;">Please select exactly
                                4 images.</div>
                        </div>

                        <div class="row justify-content-center mt-5 w-100 form-box px-3">
                            <div class="col form-input">
                                <label for="Title" class="px-2 w-100">Product_Name :</label>
                                <input type="text" id="update_Product_Name" name="update_name"
                                    class="border-primary w-100">

                                <label for="Rooms" class="px-2 w-100">Product_Serie :</label>
                                <input type="text" id="update_Product_Serie" name="update_serie"
                                    class="border-primary w-100">

                                <label for="Bathrooms" class="px-2 w-100">Product_Model :</label>
                                <input type="text" id="update_Product_Model" name="update_model"
                                    class="border-primary w-100">
                            </div>

                            <div class="col form-input">
                                <label for="Country" class="px-2 w-100">Product_Location :</label>
                                <input type="text" id="update_Product_Location" name="update_location"
                                    class="border-primary w-100">

                                <label for="City" class="px-2 w-100">Vehicule_Name :</label>
                                <input type="text" id="update_Vehicule_Name" name="update_vehicule_name"
                                    class="border-primary w-100">

                                <label for="Type" class="px-2 w-100">Vehicule_Serie :</label>
                                <input type="text" id="update_Vehicule_Serie" name="update_vehicule_serie"
                                    class="border-primary w-100">
                            </div>

                            <div class="form-input">
                                <label for="Code_Postal" class="px-2 w-100">Product_Description :</label>
                                <input type="text" id="update_Product_Description" name="update_description"
                                    class="border-primary w-100">
                            </div>

                            <input type="hidden" id="hidden_id_to_update" name="hidden_product_id">
                            <input type="hidden" id="hidden_vehicule_id_to_update" name="hidden_vehicule_id">

                        </div>

                    </section>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <input type="submit" class="btn btn-primary" name="update_The_Product" value="Update">
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- =========================================== -->
    <!-- The End of Update Modal -->
    <!-- =========================================== -->



    <!-- =========================================== -->
    <!-- The Start of more details Modal -->
    <!-- =========================================== -->

    <div class="modal fade" id="more_details_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Add New Announce
                    </h1>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <section>

                        <div class="col-md-6 animated fadeIn container">
                            <div class="owl-carousel header-carousel">
                                <div class="owl-carousel-item">
                                    <img id="Product_image_1_1" class="img-fluid size" src="" alt="slide image">
                                </div>
                                <div class="owl-carousel-item">
                                    <img id="Product_image_2_2" class="img-fluid size" src="" alt="slide image">
                                </div>
                                <div class="owl-carousel-item">
                                    <img id="Product_image_3_3" class="img-fluid size" src="" alt="slide image">
                                </div>
                                <div class="owl-carousel-item">
                                    <img id="Product_image_4_4" class="img-fluid size" src="" alt="slide image">
                                </div>
                            </div>
                        </div>



                        <div class="row justify-content-center mt-5 w-100 form-box px-3">
                            <div class="col form-input">
                                <label for="Title" class="px-2 w-100">Product_Name :</label>
                                <input type="text" id="Product_Name" readonly class="border-primary w-100"
                                    value="<?php echo $product_Data['Product_Name'] ?>">

                                <label for="Rooms" class="px-2 w-100">Product_Serie :</label>
                                <input type="text" id="Product_Serie" readonly class="border-primary w-100"
                                    value="<?php echo $product_Data['Product_Serie'] ?>">

                                <label for="Bathrooms" class="px-2 w-100">Product_Model :</label>
                                <input type="text" id="Product_Model" readonly class="border-primary w-100"
                                    value="<?php echo $product_Data['Product_Model'] ?>">
                            </div>

                            <div class="col form-input">
                                <label for="Country" class="px-2 w-100">Product_Location :</label>
                                <input type="text" id="Product_Location" readonly class="border-primary w-100"
                                    value="<?php echo $product_Data['Product_Location'] ?>">

                                <label for="City" class="px-2 w-100">Vehicule_Name :</label>
                                <input type="text" id="Vehicule_Name" readonly class="border-primary w-100"
                                    value="<?php echo $product_Data['Vehicule_Name'] ?>">

                                <label for="Type" class="px-2 w-100">Vehicule_Serie :</label>
                                <input type="text" id="Vehicule_Serie" readonly class="border-primary w-100"
                                    value="<?php echo $product_Data['Vehicule_Serie'] ?>">
                            </div>

                            <div class="form-input">
                                <label for="Code_Postal" class="px-2 w-100">Product_Description :</label>
                                <input type="text" id="Product_Description" readonly class="border-primary w-100"
                                    value="<?php echo $product_Data['Product_Description'] ?>">
                            </div>


                        </div>

                    </section>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
                            Cancel
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- =========================================== -->
    <!-- The End of More details Modal -->
    <!-- =========================================== -->

    <!-- =========================================== -->
    <!-- The Start of add product Modal -->
    <!-- =========================================== -->

    <div class="modal fade" id="add_products" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Add New Announce
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="./add_product.php" method="POST" enctype="multipart/form-data" class="form-input">
                        <div class="form-group">
                            <label for="image-upload">Select exactly 4 images to upload:</label>
                            <div class="custom-file">
                                <input type="file" name="image[]" class="custom-file-input" id="image-upload"
                                    accept="image/*" multiple="multiple" required style="border:none;">
                                <label class="custom-file-label" for="image-upload">Choose file</label>
                            </div>
                            <div id="image-upload-error" class="text-danger" style="display:none;">Please select exactly
                                4 images.</div>
                        </div>
                        <div class="row justify-content-center mt-5 w-100 form-box px-3">
                            <div class="col form-input">
                                <label for="Title" class="px-2 w-100">Product_Name :</label>
                                <input type="text" id="Product_Name" name="add_product_name"
                                    class="border-primary w-100">

                                <label for="Rooms" class="px-2 w-100">Product_Serie :</label>
                                <input type="text" id="Product_Serie" name="add_product_serie"
                                    class="border-primary w-100">

                                <label for="Bathrooms" class="px-2 w-100">Product_Model :</label>
                                <input type="text" id="Product_Model" name="add_product_model"
                                    class="border-primary w-100">

                                <label for="Bathrooms" class="px-2 w-100">Product_Price :</label>
                                <input type=" number" id="Product_price" name="add_product_price"
                                    class="border-primary w-100">
                            </div>

                            <div class="col form-input">
                                <label for="Country" class="px-2 w-100">Product_Location :</label>
                                <input type="text" id="Product_Location" name="add_product_location"
                                    class="border-primary w-100">


                                <?php
                                class Vehicule
                                {
                                    private $conn;

                                    public function __construct($dbh)
                                    {
                                        $this->conn = $dbh->connect();
                                    }

                                    public function getVehicule()
                                    {
                                        $query = "SELECT Vehicule_Name FROM vehicules GROUP BY Vehicule_Name";

                                        $statement = $this->conn->prepare($query);
                                        $statement->execute();
                                        $vehicule_data = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        return $vehicule_data;
                                    }
                                }

                                $dbh = new Dbh();
                                $vehicule = new Vehicule($dbh);
                                $vehicule_data = $vehicule->getVehicule();
                                ?>

                                <label for="City" class="px-2 w-100">Vehicule_Name :</label>
                                <select name="add_vehicule_name" id="vehicule_name" class="border-primary w-100">
                                    <option value="Choose Vehicule Name" selected>Choose Vehicule Name</option>
                                    <?php foreach ($vehicule_data as $vehicule): ?>
                                        <option value="<?php echo $vehicule['Vehicule_Name'] ?>"><?php echo $vehicule['Vehicule_Name'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <label for="Type" class="px-2 w-100">Vehicule_Serie :</label>
                                <select name="add_vehicule_serie" id="vehicule_serie" class="border-primary w-100">
                                    <!-- Options will be populated by AJAX -->
                                </select>
                                <input type="hidden" name="add_vehicule_id" id="add_vehicule_ID">
                            </div>

                            <div class="form-input">
                                <label for="Code_Postal" class="px-2 w-100">Product_Description :</label>
                                <textarea type="text" id="Product_Description" name="add_product_description"
                                    class="border-primary w-100"></textarea>
                            </div>

                            <input type="submit" class="btn btn-primary" name="Add_Product" value="Add Product">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- =========================================== -->
    <!-- The End of add product Modal -->
    <!-- =========================================== -->

    <?php
    include './details.php';
    ?>

<?php include_once('./templates/footer.php') ?>

    <!-- Template Javascript -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../public/lib/wow/wow.min.js"></script>
    <script src="../../public/lib/easing/easing.min.js"></script>
    <script src="../../public/lib/waypoints/waypoints.min.js"></script>
    <script src="../../public/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../../public/js/profile.js"></script>
    <script src="../../public/js/main.js"></script>

    <script>
        const xhttp = new XMLHttpRequest();
        let product_Data = [];

        function getMore_Details(event, Product_ID) {
            // Prevent the form from being submitted and the page from refreshing
            event.preventDefault();

            console.log(Product_ID);
            const xhttp = new XMLHttpRequest();
            xhttp.open("GET", "./details.php?Product_details=" + Product_ID, true);
            xhttp.send();

            // Define a callback function
            xhttp.onload = function () {
                console.log(xhttp.response);
                if (this.readyState == 4 && this.status == 200) {
                    product_Data = JSON.parse(this.response);
                    console.log(product_Data);
                    let Images = product_Data.Images;
                    let Images_Array = Images.split(',');
                    console.log("jalil");
                    console.log(Images_Array[0]);
                    document.getElementById("Product_image_1_1").src = `../../public/img/${Images_Array[0]}`;
                    document.getElementById("Product_image_2_2").src = `../../public/img/${Images_Array[1]}`;
                    document.getElementById("Product_image_3_3").src = `../../public/img/${Images_Array[2]}`;
                    document.getElementById("Product_image_4_4").src = `../../public/img/${Images_Array[3]}`;
                    document.getElementById("Product_Name").value = product_Data.Product_Name;
                    document.getElementById("Product_Serie").value = product_Data.Product_Serie;
                    document.getElementById("Product_Model").value = product_Data.Product_Model;
                    document.getElementById("Product_Location").value = product_Data.Product_Location;
                    document.getElementById("Vehicule_Name").value = product_Data.Vehicule_Name;
                    document.getElementById("Vehicule_Serie").value = product_Data.Vehicule_Serie;
                    document.getElementById("Product_Description").value = product_Data.Product_Description;
                }
            };
        }
        function update(event, Product_ID) {
            // Prevent the form from being submitted and the page from refreshing
            event.preventDefault();

            console.log(Product_ID);
            const xhttp = new XMLHttpRequest();
            xhttp.open("GET", "./details.php?Product_details=" + Product_ID, true);
            xhttp.send();

            // Define a callback function
            xhttp.onload = function () {
                console.log(xhttp.response);
                if (this.readyState == 4 && this.status == 200) {
                    product_Data = JSON.parse(this.response);
                    console.log(product_Data);
                    let Images = product_Data.Images;
                    let Images_Array = Images.split(',');
                    document.getElementById("Product_image_1").src = `../../public/img/${Images_Array[0]}`;
                    document.getElementById("Product_image_2").src = `../../public/img/${Images_Array[1]}`;
                    document.getElementById("Product_image_3").src = `../../public/img/${Images_Array[2]}`;
                    document.getElementById("Product_image_4").src = `../../public/img/${Images_Array[3]}`;
                    document.getElementById("update_Product_Name").value = product_Data.Product_Name;
                    document.getElementById("update_Product_Serie").value = product_Data.Product_Serie;
                    document.getElementById("update_Product_Model").value = product_Data.Product_Model;
                    document.getElementById("update_Product_Location").value = product_Data.Product_Location;
                    document.getElementById("update_Vehicule_Name").value = product_Data.Vehicule_Name;
                    document.getElementById("update_Vehicule_Serie").value = product_Data.Vehicule_Serie;
                    document.getElementById("update_Product_Description").value = product_Data.Product_Description; hidden_id_to_update
                    document.getElementById("hidden_id_to_update").value = product_Data.Product_ID;
                    document.getElementById("hidden_vehicule_id_to_update").value = product_Data.Product_ID;

                }
            };
        }
        function delete_product(event, Product_ID) {
            event.preventDefault();
            const place_Product_ID = document.getElementById('delete_id');
            place_Product_ID.value = Product_ID;
        }
    </script>
    <script>
        // Get the file upload input element
        var fileInput = document.getElementById('image-upload');

        // Add an event listener to the input element to validate the number of files selected
        fileInput.addEventListener('change', function () {
            // Get the number of files selected
            var fileCount = fileInput.files.length;

            // Display an error message if the number of files is not 4
            if (fileCount !== 4) {
                document.getElementById('image-upload-error').style.display = 'block';
                fileInput.value = ''; // Clear the selected files
            } else {
                document.getElementById('image-upload-error').style.display = 'none';
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#vehicule_name').change(function () {
                var vehicule_name = $(this).val();
                if (vehicule_name) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', './get_vehicule_serie.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            console.log(xhr.responseText);
                            var data = JSON.parse(xhr.responseText);
                            console.log(data[0]["Vehicule_ID"]);
                            var options = '';
                            for (var i = 0; i < data.length; i++) {
                                var row = data[i];
                                options += '<option value="' + row['Vehicule_Serie'] + '">' + row['Vehicule_Serie'] + '</option>';
                            }
                            $('#vehicule_serie').html(options);
                            // Set the value of the hidden input field

                            $('#add_vehicule_ID').val(data[0]["Vehicule_ID"]);
                        }
                    };
                    xhr.send('vehicule_name=' + vehicule_name);
                }
            });
        });
    </script>



</body>

</html>