<?php
require_once '../Config/connect.php';
session_start();
if ($_SESSION['logged_in'] !== true) {
    // Redirect the user to the login page
    header("Location: ./index.php");
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
                <a href="./index.php" class="navbar-brand d-flex align-items-center text-center">
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
                            <a href="./index.php" class="nav-item nav-link active">Home</a>
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
                            <a href="./index.php" class="nav-item nav-link active">Home</a>
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
                    <a href="" class="btn btn-danger py-3 px-5 me-3 animated fadeIn" data-bs-toggle="modal"
                        data-bs-target="#product_list">SHOP NOW</a>
                </div>
                <div class="col-md-6 animated fadeIn">
                    <div class="owl-carousel header-carousel">
                        <div class="owl-carousel-item">
                            <img class="img-fluid size" src="../../public/img/slide1.jpg" alt="">
                        </div>
                        <div class="owl-carousel-item">
                            <img class="img-fluid size" src="../../public/img/slide2.jpg" alt="">
                        </div>
                        <div class="owl-carousel-item">
                            <img class="img-fluid size" src="../../public/img/slide3.jpg" alt="">
                        </div>
                        <div class="owl-carousel-item">
                            <img class="img-fluid size" src="../../public/img/slide2.jpg" alt="">
                        </div>
                        <div class="owl-carousel-item">
                            <img class="img-fluid size" src="../../public/img/slide3.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Header End -->

        <!-- Search Start -->
        <section class="container-fluid bg-color mb-5 wow fadeIn" data-wow-delay="0.1s" style="padding: 35px;">
            <div class="container">
                <form method="POST" action="items.php">
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
                        <input type="submit" name="searchbtn" class="btn btn-dark border-0" value="Search">

                    </div>
                </form>
            </div>
        </section>
        <!-- Search End -->

        <!-- =========== Announces List Start =========== -->

        <section class="container-xxl py-5" id="product_list">
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
                            if (isset($_POST['searchbtn'])) {
                                include './search.php';
                            } else {


                                class Products
                                {
                                    private $conn;

                                    public function __construct($dbh)
                                    {
                                        $this->conn = $dbh->connect();
                                    }

                                    public function getProducts($offset, $limit)
                                    {
                                        $query = "SELECT Products.Product_ID, Product_Name, Product_Description, Product_Serie, Product_Model, Product_Price, Product_Location, Image_Path, Vehicule_Name ,Vehicule_Serie
                                               FROM Products 
                                               INNER JOIN Images ON Products.Product_ID = Images.Product_ID
                                               INNER JOIN Vehicules ON Products.Vehicule_ID = Vehicules.Vehicule_ID
                                               WHERE Image_Type = 'primary'
                                               LIMIT $offset, $limit;";

                                        $statement = $this->conn->prepare($query);
                                        $statement->execute();
                                        $productList = $statement->fetchAll(PDO::FETCH_ASSOC);
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

                                // Set the page number and limit
                                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                $limit = 6;

                                // Calculate the offset
                                $offset = ($page - 1) * $limit;

                                // Fetch the products
                                $productList = $product->getProducts($offset, $limit);

                                // Get the total number of products
                                $totalProducts = $product->getTotalProducts();

                                // Calculate the total number of pages
                                $totalPages = ceil($totalProducts / $limit);
                                ?>

                                <!-- Display the products -->
                                <div class="row">
                                    <?php foreach ($productList as $values): ?>
                                        <div class="col-lg-4 col-md-6 wow fadeInUp mt-4" data-wow-delay="0.1s">
                                            <div class="property-item rounded overflow-hidden">
                                                <div class="position-relative overf low-hidden">
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
                                                <button type="button" class="btn btn-primary w-100"
                                                    onclick="get_Details(<?php echo $values['Product_ID'] ?>)">More
                                                    Details</button>

                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

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
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- =========== Announces List End =========== -->


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



                        <div class="align-items-center flex-column-reverse flex-md-row">
                            <div class="owl-carousel header-carousel">
                                <div class="owl-carousel-item">
                                    <img id="Product_image_1" class="img-fluid size" src="" alt="">
                                </div>
                                <div class="owl-carousel-item">
                                    <img id="Product_image_2" class="img-fluid size" src="" alt="">
                                </div>
                                <div class="owl-carousel-item">
                                    <img id="Product_image_3" class="img-fluid size" src="" alt="">
                                </div>
                                <div class="owl-carousel-item">
                                    <img id="Product_image_4" class="img-fluid size" src="" alt="">
                                </div>
                            </div>
                        </div>



                        <div class="row justify-content-center mt-5 w-100 form-box px-3">

                            <div class="col form-input">

                                <label for="Title" class="px-2 w-100">Product_Name :</label>
                                <input type="text" id="Product_Name" readonly class="border-primary w-100">

                                <label for="Rooms" class="px-2 w-100">Product_Serie :</label>
                                <input type="text" id="Product_Serie" readonly class="border-primary w-100">

                                <label for="Bathrooms" class="px-2 w-100">Product_Model :</label>
                                <input type="text" id="Product_Model" readonly class="border-primary w-100">


                            </div>

                            <div class="col form-input">


                                <label for="Country" class="px-2 w-100">Product_Location :</label>
                                <input type="text" id="Product_Location" readonly class="border-primary w-100">

                                <label for="City" class="px-2 w-100">Vehicule_Name :</label>
                                <input type="text" id="Vehicule_Name" readonly class="border-primary w-100">

                                <label for="Type" class="px-2 w-100">Vehicule_Serie :</label>
                                <input type="text" id="Vehicule_Serie" readonly class="border-primary w-100">

                            </div>
                            <div class="form-input">
                                <label for="Code_Postal" class="px-2 w-100">Product_Description :</label>
                                <input type="text" id="Product_Description" readonly class="border-primary w-100">
                            </div>


                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <a href="messenger.php"><button type="button" class="btn btn-primary w-45">Contact
                                    Announcer</button></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- =========================================== -->
        <!-- The End of More details Modal -->
        <!-- =========================================== -->

        <?php
        // Check if a success message is present in the query parameters
        if (isset($_GET['message']) && $_GET['message'] === 'success') {
            // Display the success message
            echo '<script>$(document).ready(function() { $("#order_completed").modal("show"); });</script>';
        }
        ?>


        <!-- Order completed modal start -->
        <div class="modal fade" id="order_completed" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="d-flex flex-wrap gap-2 justify-content-end">
                            <!-- ======== -->
                            <div class="blue d-flex flex-column">
                                <div>
                                    <img src="../../public/img/logo.png" alt="company logo" class="w-100">
                                </div>
                                <div>
                                    <img src="../../public/img/success_message.png" alt="success message image" class="w-100"
                                        style="height: 28rem;">
                                </div>
                            </div>
                            <div>
                                <h4 class="title text-center mt-4">
                                    <i class="fa-solid fa-square-check"></i>
                                    Order Submitted
                                </h4>
                                <p class="text-center">Thank you for your trust in our services.
                                    One of our team members will call you soon.</p>
                                <button class="btn btn-primary w-100 p-0 text-center" style="height:6%;"
                                    onclick="window.location.href='./items.php';">Continue shopping</button>
                            </div>
                            <!-- ======== -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Order completed modal end -->



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
    <script>
        // Check if a success message is present in the query parameters
        const urlParams = new URLSearchParams(window.location.search);
        const message = urlParams.get('message');
        if (message === 'success') {
            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('order_completed'));
            modal.show();
        }
    </script>


    <!-- Template Javascript -->
    <script>

        function get_Details(Product_ID) {
            console.log(Product_ID);
            window.location.href = "./product.php?Product_Info=" + Product_ID;
        }
    </script>
</body>

</html>