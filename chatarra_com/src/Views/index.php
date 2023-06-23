<?php
require_once '../Config/connect.php';
session_start();

if (isset($_SESSION['Email'])) {

    class Profile_info
    {
        private $conn;

        public function __construct($dbh)
        {
            $this->conn = $dbh->connect();
        }

        public function getProducts()
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
    $profile_info = $profile_info_obj->getProducts();
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
                                <?php
                    }
                    ?>
                        </div>
            </nav>
        </div>
        <!-- Navbar End -->

        <!-- Header Start -->
        <header class="container-fluid header bg-white p-0">
            <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
                <div class="col-md-6 p-5 mt-lg-5">
                    <h1 class="display-5 animated fadeIn mb-4">Get <span class="text-color"> The Best </span> Auto Parts
                    </h1>
                    <p class="animated fadeIn mb-4 pb-2">FOR HUNDREDS
                        OF VEHICLES.</p>
                    <?php
                    if (isset($_SESSION["Email"])) {
                        ?>
                        <a href="./items.php" class="btn btn-danger py-3 px-5 me-3 animated fadeIn">SHOP NOW</a>
                        <?php
                    } else {
                        ?>
                        <button class="btn btn-danger py-3 px-5 me-3 animated fadeIn" data-bs-toggle="modal"
                            data-bs-target="#Login_modal">SHOP NOW</button>
                        <?php
                    }
                    ?>

                </div>
                <div class="col-md-6 animated fadeIn">
                    <div class="owl-carousel header-carousel">
                        <div class="owl-carousel-item">
                            <img class="img-fluid size" src="../../public/img/slide1.jpg" alt="slide image 1">
                        </div>
                        <div class="owl-carousel-item">
                            <img class="img-fluid size" src="../../public/img/slide2.jpg" alt="slide image 2">
                        </div>
                        <div class="owl-carousel-item">
                            <img class="img-fluid size" src="../../public/img/slide3.jpg" alt="slide image 3">
                        </div>
                        <div class="owl-carousel-item">
                            <img class="img-fluid size" src="../../public/img/slide2.jpg" alt="slide image 4">
                        </div>
                        <div class="owl-carousel-item">
                            <img class="img-fluid size" src="../../public/img/slide3.jpg" alt="slide image 5">
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Header End -->

        <!-- Search Start -->
        <section class="container-fluid bg-color mb-5 wow fadeIn" data-wow-delay="0.1s" style="padding: 35px;">
            <div class="container">
                <form method="POST" action="index.php">
                    <div class="d-flex gap-2 flex-wrap justify-content-center">

                        <input type="search" name="home_name_search" style="display:inline-block !important;"
                            class="border-0 rounded select_property p-3" placeholder="Search...">
                        <input type="number" name="min_price" class="border-0 rounded elect_property p-3"
                            placeholder="Min Price">
                        <input type="number" name="max_price" class="border-0 rounded select_property p-3 "
                            placeholder="Max Price">

                        <select class="border-0 rounded select_property p-3 " name="city">
                            <option selected>City</option>
                            <option value="Tangier">Tangier</option>
                            <option value="Tetouan">Tetouan</option>
                            <option value="Casablanca">Casablanca</option>
                            <option value="Hociema">Hociema</option>
                            <option value="Rabat">Rabat</option>
                        </select>
                        <input type="submit" name="searchbtn_Home" class="btn btn-dark border-0" value="Search">

                    </div>
                </form>
            </div>
        </section>
        <!-- Search End -->

        <!-- =========== Announces List Start =========== -->

        <section class="container-xxl py-5">
            <div class="container">
                <div class="row g-0 gx-5 align-items-end">
                    <div class="col-lg-6">
                        <div class="text-start mx-auto mb-5 wow slideInLeft" data-wow-delay="0.1s">
                            <h1 class="mb-3">Announces List</h1>
                            <p>in our platform we provide you the best spare parts in one place to save your time and
                                money.</p>
                        </div>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <?php
                            if (isset($_POST['searchbtn_Home'])) {
                                include './search.php';
                            } elseif (isset($_POST['home_product_search'])) {
                                include './search.php';
                            } else {

                                class Products
                                {
                                    private $conn;

                                    public function __construct($dbh)
                                    {
                                        $this->conn = $dbh->connect();
                                    }

                                    public function getProducts()
                                    {
                                        $query = "SELECT Products.Product_ID, Product_Name, Product_Description, Product_Serie, Product_Model, Product_Price, Product_Location, Image_Path, Vehicule_Name ,Vehicule_Serie
                                FROM Products 
                                INNER JOIN Images ON Products.Product_ID = Images.Product_ID
                                INNER JOIN Vehicules ON Products.Vehicule_ID = Vehicules.Vehicule_ID
                                WHERE Image_Type = 'primary' AND Product_Status = 'Active'
                                ORDER BY RAND()
                                LIMIT 6;";

                                        $statement = $this->conn->prepare($query);
                                        $statement->execute();
                                        $productList = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        return $productList;
                                    }
                                }

                                $dbh = new Dbh();
                                $product = new Products($dbh);
                                $productList = $product->getProducts();

                                foreach ($productList as $values) {
                                    ?>
                                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                        <div class="property-item rounded overflow-hidden">
                                            <div class="position-relative overflow-hidden">
                                                <a href=""><img style="height:20rem;" class="w-100"
                                                        src="../../public/img/<?php echo ($values['Image_Path']) ?>" alt=""></a>
                                                <div
                                                    class="bg-color rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">
                                                    <?php echo ($values['Vehicule_Name']) ?>
                                                </div>
                                                <div
                                                    class="bg-white rounded-top text-color position-absolute start-0 bottom-0 mx-4 pt-1 px-3">
                                                    <?php echo ($values['Vehicule_Serie']) ?>
                                                </div>
                                            </div>
                                            <div class="p-4 pb-0">
                                                <h5 class="text-color mb-3">
                                                    <?php echo ($values['Product_Price']) ?>$
                                                </h5>
                                                <a class="d-block h5 mb-2" href="">
                                                    <?php echo ($values['Product_Name']) ?>
                                                </a>
                                                <p>
                                                    <?php echo ($values['Product_Description']) ?>
                                                </p>
                                            </div>
                                            <div class="d-flex border-top">
                                                <small class="flex-fill text-center border-end py-2">
                                                    <?php echo ($values['Product_Serie']) ?>
                                                </small>
                                                <small class="flex-fill text-center border-end py-2">
                                                    <?php echo ($values['Product_Model']) ?>
                                                </small>
                                                <small class="flex-fill text-center py-2">
                                                    <i class="fa fa-map-marker-alt text-color me-2"></i>
                                                    <?php echo ($values['Product_Location']) ?>
                                                </small>
                                            </div>
                                            <?php
                                            if (isset($_SESSION["Email"])) {
                                                ?>
                                                <button type="button" class="btn btn-primary w-100"
                                                    onclick="get_Details(<?php echo $values['Product_ID'] ?>)">More
                                                    Details</button>
                                                <?php
                                            } else {
                                                ?>
                                                <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                                                    data-bs-target="#Login_modal">More
                                                    Details</button>
                                                <?php
                                            }
                                            ?>


                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (isset($_SESSION['Email'])) {
                                    ?>
                                    <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s">
                                        <a class="btn btn-primary py-3 px-5" href="./items.php">Browse More spare parts</a>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s" data-bs-toggle="modal"
                                        data-bs-target="#Login_modal">
                                        <button class="btn btn-primary py-3 px-5">Browse More spare parts</button>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- =========== Announces List End =========== -->

        <!-- Call to Action Start -->
        <section class="container-xxl py-5" id="call">
            <div class="container">
                <div class="bg-light rounded p-3">
                    <div class="bg-white rounded p-4" style="border: 1px dashed rgba(0, 185, 142, .3)">
                        <div class="row g-5 align-items-center">
                            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                                <img class="img-fluid rounded w-100" src="../../public/img/makecall.jpg" alt="">
                            </div>
                            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                                <div class="mb-4">
                                    <h1 class="mb-3">Contact With Our Library Team</h1>
                                    <p>In our platfrom we are online 7/24 for listen to you and answer
                                        your questions.</p>
                                </div>
                                <a href="tel:+212567182560" class="btn btn-primary py-3 px-4 me-2"><i
                                        class="fa fa-phone-alt me-2"></i>Make A Call</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Call to Action End -->

        <!-- Testimonial Start -->
        <section class="container-xxl py-5">
            <div class="container">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">Our Clients Reviews</h1>
                </div>
                <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                    <div class="testimonial-item bg-light rounded p-3">
                        <div class="bg-white border rounded p-4">
                            <p>The best platform i seen to find somthin to read ,recommended</p>
                            <div class="d-flex align-items-center">
                                <img class="img-fluid flex-shrink-0 rounded" src="../../public/img/Review1.jpg"
                                    style="width: 45px; height: 45px;">
                                <div class="ps-3">
                                    <h6 class="fw-bold mb-1">Jalil Betroji</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item bg-light rounded p-3">
                        <div class="bg-white border rounded p-4">
                            <p>it realy wonderful website , easy to use and very helpful</p>
                            <div class="d-flex align-items-center">
                                <img class="img-fluid flex-shrink-0 rounded" src="../../public/img/Review2.jpg"
                                    style="width: 45px; height: 45px;">
                                <div class="ps-3">
                                    <h6 class="fw-bold mb-1">Jalil Betroji</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item bg-light rounded p-3">
                        <div class="bg-white border rounded p-4">
                            <p>The best service, i was searchin about a spare part for 2 weeks without any
                                result
                                but after using this platform i found it within 1 hour
                            </p>
                            <div class="d-flex align-items-center">
                                <img class="img-fluid flex-shrink-0 rounded" src="../../public/img/Review3.jpg"
                                    style="width: 45px; height: 45px;">
                                <div class="ps-3">
                                    <h6 class="fw-bold mb-1">Jalil Betroji</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Testimonial End -->


        <!-- Log in  modal start -->

        <section class="modal fade" id="Login_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog-centered modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Sign in into your account and
                            enjoy
                            exploring the planet</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body row gap-3">
                        <!-- ======== -->
                        <div class="col img-left d-none d-md-flex">
                            <img src="../../public/img/sign-in.png" alt="log in image" style="width:100%; height:100%;">
                        </div>
                        <form class="col form-box px-3" action="./login.view.php" method="POST">

                            <h4 class="title text-center mt-4">
                                Login into account
                            </h4>
                            <div class="form-input">
                                <span><i class="fa fa-envelope-o"></i></span>
                                <input type="email" name="login_email" class="email_Validation"
                                    placeholder="Email Address" tabindex="10" required>
                            </div>
                            <div class="form-input">
                                <span><i class="fa fa-key"></i></span>
                                <input type="password" name="login_password" placeholder="Password" required>
                            </div>

                            <input type="submit" class="btn btn-primary w-100" name="login_into_account" value="Login">


                            <div class="text-center mb-2">
                                Don't have an account?
                                <a href="" class="register-link" data-bs-dismiss="modal" data-bs-toggle="modal"
                                    data-bs-target="#signup_modal">
                                    Register here
                                </a>
                            </div>
                        </form>



                        <!-- ======== -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Log in modal end -->

        <!-- signUp  modal start -->

        <section class="modal fade" id="signup_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog-centered modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">signUp and start make money from
                            your house
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- ======== -->
                        <h4 class="title text-center mt-4">
                            Create an account
                        </h4>

                        <div class="d-flex flex-wrap gap-2">
                            <div class="img-left d-none d-md-flex w-50">
                                <img src="../../public/img/signup.png" alt="sign up image" style="width:100%; height:100%;">
                            </div>
                            <form class="px-3" action="src/Views/signup.php" method="POST">
                                <input type="hidden" name="save_data" id="save_data" value="">
                                <div class="d-flex justify-content-around">
                                    <p id="First_name_error" class="error"></p>
                                    <p id="Last_name_error" class="error"></p>
                                </div>
                                <div class="form-input">
                                    <span><i class="fa-solid fa-user"></i></span>
                                    <input type="text" name="fname" id="fname_validation" placeholder="First Name"
                                        tabindex="10" required>


                                    <span><i class="fa-solid fa-user"></i></span>
                                    <input type="text" name="lname" id="lname_validation" placeholder="Last Name"
                                        tabindex="10" required>
                                </div>
                                <div class="d-flex justify-content-around">
                                    <p id="email_error" class="error"></p>
                                    <p id="phone_error" class="error"></p>
                                </div>
                                <div class="form-input">
                                    <span><i class="fa fa-envelope-o"></i></span>
                                    <input type="email" name="signUp_Email" id="email_Validation"
                                        placeholder="Email Address" tabindex="10" required>

                                    <span><i class="fa-solid fa-phone-volume"></i></span>
                                    <input type="number" name="signUp_Phone" id="phone_Validation"
                                        placeholder="Phone Number" tabindex="10" required>
                                </div>
                                <div class="d-flex justify-content-around">
                                    <p id="CIN_error" class="error"></p>
                                    <p id="City_error" class="error"></p>
                                </div>
                                <div class="form-input">
                                    <span><i class="fa-solid fa-address-card"></i></span>
                                    <input type="text" name="cin" id="cin_Validation" placeholder="CIN" tabindex="10"
                                        required>

                                    <span><i class="fa-solid fa-earth-americas"></i></span>
                                    <input type="text" name="signUp_City" id="city_Validation" placeholder="City"
                                        tabindex="10" required>
                                </div>
                                <div class="d-flex justify-content-around">
                                    <p id="address_error" class="error"></p>
                                    <p id="type_error" class="error"></p>
                                </div>
                                <div class="form-input">
                                    <span><i class="fa-solid fa-city"></i></span>
                                    <span><i class="fa-sharp fa-solid fa-location-dot"></i></span>
                                    <input type="text" name="signUp_Address" id="address_Validation"
                                        placeholder="Address" tabindex="10" required>
                                    <select class="type_Validation" name="type">
                                        <option class="type_Validation" value="Account Type" selected>Account
                                            Type</option>
                                        <option class="type_Validation" value="Seller">Seller</option>
                                        <option class="type_Validation" value="Buyer">Buyer</option>
                                    </select>

                                </div>
                                <div class="d-flex justify-content-around">
                                    <p id="password_error" class="error"></p>
                                    <p id="re_password_error" class="error"></p>
                                </div>
                                <p id="passwords_compare"></p>
                                <div class="form-input">
                                    <span><i class="fa fa-key"></i></span>
                                    <input type="password" name="signUp_Password" id="password_Validation"
                                        placeholder="Password" required>

                                    <span><i class="fa fa-key"></i></span>
                                    <input type="password" name="signUp_Re_Password" id="re_password_Validation"
                                        placeholder="Rewrite Password" required>
                                </div>

                                <p id="signup_error" class="error"></p>
                                <input type="submit" id="signUp" name="add_client" class="btn btn-primary w-100"
                                    value="Sign Up">
                                <div class="text-center mb-2">
                                    Already have an account?
                                    <a href="" class="register-link" data-bs-dismiss="modal" data-bs-toggle="modal"
                                        data-bs-target="#Login_modal">
                                        Login
                                    </a>
                                </div>
                            </form>
                        </div>

                        <!-- ======== -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- sign up modal end -->


    </main>

    <?php include_once('./templates/footer.php') ?>

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
    <script>

        function get_Details(Product_ID) {
            console.log(Product_ID);
            window.location.href = "./product.php?Product_Info=" + Product_ID;
        }
    </script>
</body>

</html>