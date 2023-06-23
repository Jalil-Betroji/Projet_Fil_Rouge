<?php
require_once '../Config/connect.php';
session_start();
if ($_SESSION['logged_in'] !== true) {
    // Redirect the user to the login page
    header("Location: ../Views/index.php");
    exit;
}
if (isset($_SESSION['Email'])) {

    class Profile_info
    {
        private $conn;

        public function __construct($dbh)
        {
            $this->conn = $dbh->connect();
        }

        public function getUser()
        {
            $query = "SELECT Nickname,Image_Path FROM users WHERE Email = ? ;";
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
    <main class="container-xxl bg-white p-0">


        <!-- Navbar Start -->
        <div class="container-fluid nav-bar bg-transparent">
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
                    <?php
                    if (isset($_SESSION['Email'])) {
                        ?>
                        <div class="navbar-nav ms-auto">
                            <a href="index.php" class="nav-item nav-link active">Home</a>
                            <a href="#footer" class="nav-item nav-link">About</a>
                            <a href="contact.php" class="nav-item nav-link">Contact</a>
                            <div class="nav-item dropdown d-flex m-1">
                                <a href="#" class="nav-item"><img class="rounded-circle" style="width:4rem; height:4rem;"
                                        src="../../public/img/<?php echo $profile_info['Image_Path'] ?>">
                                    <span class="fw-bold">
                                        <?php echo $profile_info['Nickname'] ?>
                                    </span>
                                </a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="./profile.php" class="dropdown-item" id="my_announces">Profile</a>
                                    <a href="./logout.php" name="logout" class="dropdown-item">Log out</a>

                                </div>
                            </div>


                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="navbar-nav ms-auto">
                            <a href="index.php" class="nav-item nav-link active">Home</a>
                            <a href="#footer" class="nav-item nav-link">About</a>
                            <a href="#call" class="nav-item nav-link">Contact</a>
                            <div class="nav-item dropdown d-flex m-1">
                                <div class="nav-item nav-link user_sign">
                                    <i class="fa-solid fa-right-to-bracket" data-bs-toggle="modal"
                                        data-bs-target="#Login_modal"></i>
                                </div>
                                <div class="nav-item nav-link user_sign">
                                    <i class="fa-solid fa-user-plus" data-bs-toggle="modal"
                                        data-bs-target="#signup_modal"></i>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </nav>
        </div>
        <!-- Navbar End -->

        <section>
            <div class="align-items-center flex-column-reverse flex-md-row">
                <?php

                $Product_ID = $_GET["Product_Info"];

                // Create a new Dbh object
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

                // print_r($product_Data);
                ?>
                <div class="col-md-6 animated fadeIn container">
                    <div class="owl-carousel header-carousel">
                        <div class="owl-carousel-item">
                            <img id="Product_image_1" class="img-fluid size" src="../../public/img/<?php echo $imagesArray[0] ?>"
                                alt="slide image">
                        </div>
                        <div class="owl-carousel-item">
                            <img id="Product_image_2" class="img-fluid size" src="../../public/img/<?php echo $imagesArray[1] ?>"
                                alt="slide image">
                        </div>
                        <div class="owl-carousel-item">
                            <img id="Product_image_3" class="img-fluid size" src="../../public/img/<?php echo $imagesArray[2] ?>"
                                alt="slide image">
                        </div>
                        <div class="owl-carousel-item">
                            <img id="Product_image_4" class="img-fluid size" src="../../public/img/<?php echo $imagesArray[3] ?>"
                                alt="slide image">
                        </div>
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

                <button class="btn btn-primary btn-outline-light" data-bs-toggle="modal" data-bs-target="#confirm_order"
                    onclick="complete_order(<?php echo $product_Data['Product_ID'] ?>)">Complete Order</button>
            </div>

        </section>

        <!-- complete order modal start -->

        <section class="modal fade" id="confirm_order" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog-centered modal-dialog modal-x">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- ======== -->
                        <h4 class="title text-center mt-4">
                            Fullfil your information below
                        </h4>

                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                            <form class="px-3 w-500" action="./code.php" method="POST" id="confirm_order_form">

                                <input type="hidden" name="save_data" id="save_data" value="">
                                <div class="d-flex justify-content-around">
                                    <p id="Full_name_error" class="error"></p>
                                </div>
                                <div class="form-input">

                                    <input type="text" class="w-100" name="Order_client_fullname" id="fname_validation"
                                        placeholder="Full Name" tabindex="10" required>
                                    <p id="phone_error" class="error"></p>

                                    <input type="number" class="w-100" name="order_client_phone" id="phone_Validation"
                                        placeholder="Phone Number" tabindex="10" required>
                                    <p id="city_error" class="error"></p>
                                    <input type="text" class="w-100" name="order_client_city" id="city_Validation"
                                        placeholder="City" tabindex="10" required>
                                    <input type="hidden" value="<?php echo $product_Data['Product_ID'] ?>"
                                        name="confirm_product_id">
                                    <input type="submit" id="signUp" class="btn btn-primary w-100 p-0"
                                        data-bs-toggle="modal" data-bs-target="#confirm_order" name="confirm_order"
                                        class="btn btn-primary w-100" value="Complete Order">
                                </div>
                            </form>
                        </div>

                        <!-- ======== -->
                    </div>

                </div>
            </div>
        </section>

        <!-- Complete order modal end -->

    </main>

    <!-- Footer Start -->
    <footer id="footer" class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">Get In Touch</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Morocco, Tanger-Ahlan</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+212 567182560</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>support@Chattara.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="text-white mb-4">Quick Links</h5>
                    <a class="btn btn-link text-white-50" href="">About Us</a>
                    <a class="btn btn-link text-white-50" href="">Contact Us</a>
                    <a class="btn btn-link text-white-50" href="">Our Services</a>
                    <a class="btn btn-link text-white-50" href="">Privacy Policy</a>
                    <a class="btn btn-link text-white-50" href="">Terms & Condition</a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-white mb-4">Newsletter</h5>
                    <p>Subscribe to our Newsletter to get updates on every new announcement.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5 email_Validation" type="text"
                            placeholder="Your email">
                        <button type="button"
                            class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Subscribe</button>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <img src="../../public/img/white_logo.png" alt="" style="width: 15rem;height: 7rem; margin-top:3.5rem;">
                </div>


            </div>
        </div>
        <div class="copyright d-flex justify-content-center">
            <p>&copy; <a class="border-bottom" href="#">Chattara.com</a>,
                All Rights Reserved. 2023-2024
            </p>
        </div>
    </footer>

    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../public/lib/wow/wow.min.js"></script>
    <script src="../../public/lib/easing/easing.min.js"></script>
    <script src="../../public/lib/waypoints/waypoints.min.js"></script>
    <script src="../../public/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../../public/js/main.js"></script>

    <!-- Template Javascript -->


</body>

</html>