<?php
require_once '../Config/connect.php';
session_start();
if ($_SESSION['Admin'] !== true) {
  // Redirect the user to the login page
  header("Location: index.php");
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

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
    crossorigin="anonymous"></script>

  <!-- Favicon -->
  <link href="../../public/img/favicon.ico" rel="icon">

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap"
    rel="stylesheet">

  <!-- Icon Font Stylesheet -->
  <!-- Icon Font Stylesheet -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
  <!-- FontsAwesome -->

  <script src="https://kit.fontawesome.com/ad59909c53.js" crossorigin="anonymous"></script>

  <!-- Libraries Stylesheet -->
  <link href="../../public/lib/animate/animate.min.css" rel="stylesheet">
  <link href="../../public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../public/css/dashboard.css" type="text/css" />
  <title>Document</title>
</head>

<body>
  <div id="mySidenav" class="sidenav">
    <img style="height: 5rem;width: 18rem;" src="../../public/img/White_logo.png" alt="logo" />
    <a href="#" class="icon-a" id="Dashboard"><i class="fa fa-dashboard icons"></i> &nbsp;&nbsp;Dashboard</a>
    <a href="#" class="icon-a" id="Customers"><i class="fa fa-users icons"></i> &nbsp;&nbsp;Customers</a>
    <a href="#" class="icon-a" id="Products"><i class="fa fa-list icons"></i> &nbsp;&nbsp;Products</a>
    <a href="#" class="icon-a" id="Orders"><i class="fa fa-shopping-bag icons"></i> &nbsp;&nbsp;Orders</a>
    <a href="#" class="icon-a" id="Accounts"><i class="fa fa-user icons"></i> &nbsp;&nbsp;Accounts</a>
    <a href="#" class="icon-a" id="Passwords"><i class="fa-solid fa-lock"></i> &nbsp;&nbsp;Password</a>
    <a href="./profile.php" class="icon-a" id="Passwords"><i class="fa-solid fa-user"></i> &nbsp;&nbsp;Profile</a>
    <a href="./index.php" class="icon-a" id="Passwords"><i class="fa-solid fa-house"></i> &nbsp;&nbsp;Home</a>
    <a href="./logout.php" class="icon-a" id="Passwords"><i class="fa-solid fa-right-from-bracket"></i> &nbsp;&nbsp;Logout</a>
  </div>
  <div id="main">
    <div class="head">
      <div class="col-div-6">
        <span style="font-size: 30px; cursor: pointer; color: white" class="nav">&#9776; Dashboard</span>
        <span style="font-size: 30px; cursor: pointer; color: white" class="nav2">&#9776; Dashboard</span>
      </div>

      <div class="col-div-6">
        <div class="profile">
          <img src="../../public/img/<?php echo $profile_info['Image_Path'] ?>" class="pro-img rounded-circle mx-2"
            style="width:4rem; height:4rem;" />
          <p>
            <?php echo $profile_info['First_Name'] ?>
            <?php echo $profile_info['Last_Name'] ?><span>Admin</span>
          </p>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>

    <div class="clearfix"></div>
    <br />
    <?php
    class Stats
    {
      private $conn;

      public function __construct($conn)
      {
        $this->conn = $conn;
      }

      public function getCount($table, $column)
      {
        try {
          $query = $this->conn->query("SELECT COUNT($column) FROM $table");
          return $query->fetchColumn();
        } catch (PDOException $e) {
          echo "Query failed: " . $e->getMessage();
        }
      }
    }

    $dbh = new Dbh();
    $db = $dbh->connect();

    $stats = new Stats($db);
    $customers = $stats->getCount('users', 'Email');
    $products = $stats->getCount('products', 'Product_ID');
    $orders = $stats->getCount('orders', 'Order_ID');
    ?>
    <section id="full_data_section">
      <div class="col-div-4">
        <div class="box">
          <p>
            <?php echo $customers; ?><br /><span>Customers</span>
          </p>
          <i class="fa fa-users box-icon"></i>
        </div>
      </div>
      <div class="col-div-4">
        <div class="box">
          <p>
            <?php echo $products; ?><br /><span>Products</span>
          </p>
          <i class="fa fa-list box-icon"></i>
        </div>
      </div>
      <div class="col-div-4">
        <div class="box">
          <p>
            <?php echo $orders ?><br /><span>Orders</span>
          </p>
          <i class="fa fa-shopping-bag box-icon"></i>
        </div>
      </div>
    </section>

    <?php
    class TopProducts
    {
      private $conn;

      public function __construct($dbh)
      {
        $this->conn = $dbh->connect();
      }

      public function getTopSellingProducts($offset, $limit)
      {
        $query = "SELECT p.Product_Name, COUNT(o.Order_ID) as Orders, p.Product_Location as City
        FROM products p
        JOIN orders o ON p.Product_ID = o.Product_ID
        GROUP BY p.Product_Name, p.Product_Location
        ORDER BY Orders DESC
        LIMIT $offset, $limit";

        $statement = $this->conn->prepare($query);
        $statement->execute();
        $Top_Products_info = $statement->fetchAll();

        return $Top_Products_info;
      }

      public function getTotalProducts()
      {
        $query = "SELECT COUNT(DISTINCT p.Product_Name, p.Product_Location) as Total
        FROM products p
        JOIN orders o ON p.Product_ID = o.Product_ID";

        $statement = $this->conn->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        return $result['Total'];
      }
    }

    $dbh = new Dbh();
    $stats = new TopProducts($dbh);

    // Set the page number and limit
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $limit = 5;

    // Calculate the offset
    $offset = ($page - 1) * $limit;

    // Fetch the top selling products
    $Top_Products_info = $stats->getTopSellingProducts($offset, $limit);

    // Get the total number of products
    $totalProducts = $stats->getTotalProducts();

    // Calculate the total number of pages
    $totalPages = ceil($totalProducts / $limit);

    ?>

    <div class="clearfix"></div>
    <br /><br />
    <div id="Top_Products_Section">
      <div class="box-8">
        <div class="content-box">
          <p>Top Selling Products </p>
          <br />
          <table>
            <tr>
              <th>Product Name</th>
              <th>Orders</th>
              <th>City</th>
            </tr>
            <?php foreach ($Top_Products_info as $product): ?>
              <tr>
                <td>
                  <?php echo htmlspecialchars($product['Product_Name']); ?>
                </td>
                <td>
                  <?php echo $product['Orders']; ?>
                </td>
                <td>
                  <?php echo htmlspecialchars($product['City']); ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </table>
          <?php if ($totalPages > 1): ?>
            <div class="d-flex gap-4 justify-content-center">
              <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>">Prev</a>
              <?php endif; ?>
              <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php if ($i == $page): ?>
                  <span class="current">
                    <?php echo $i; ?>
                  </span>
                <?php else: ?>
                  <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
              <?php endfor; ?>
              <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>">Next</a>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <?php
    class CustomerOrders
    {
      private $conn;

      public function __construct($dbh)
      {
        $this->conn = $dbh->connect();
      }

      public function getCustomers($offset, $limit)
      {
        $query = "SELECT u.Nickname AS Customer_Name, COUNT(o.Order_ID) as Orders, u.Email, u.City
        FROM users u
        JOIN orders o ON u.Email = o.Email
        GROUP BY u.Nickname, u.Email, u.City
        ORDER BY Orders DESC
        LIMIT $offset, $limit";

        $statement = $this->conn->prepare($query);
        $statement->execute();
        $customer_info = $statement->fetchAll();

        return $customer_info;
      }

      public function getTotalCustomers()
      {
        $query = "SELECT COUNT(DISTINCT u.Email) as Total
        FROM users u
        JOIN orders o ON u.Email = o.Email";

        $statement = $this->conn->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        return $result['Total'];
      }
    }

    $dbh = new Dbh();
    $customers = new CustomerOrders($dbh);

    // Set the page number and limit
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $limit = 6;

    // Calculate the offset
    $offset = ($page - 1) * $limit;

    // Fetch the customers
    $customer_info = $customers->getCustomers($offset, $limit);

    // Get the total number of customers
    $totalCustomers = $customers->getTotalCustomers();

    // Calculate the total number of pages
    $totalPages = ceil($totalCustomers / $limit);

    ?>

    <section id="customers_section" class="hide">
      <div class="box-8">
        <div class="content-box">
          <p>Customers List </p>
          <br />
          <table>
            <tr>
              <th>Customer Name</th>
              <th>Orders</th>
              <th>Email</th>
              <th>City</th>
            </tr>
            <?php foreach ($customer_info as $customer): ?>
              <tr>
                <td>
                  <?php echo htmlspecialchars($customer['Customer_Name']); ?>
                </td>
                <td>
                  <?php echo $customer['Orders']; ?>
                </td>
                <td>
                  <?php echo htmlspecialchars($customer['Email']); ?>
                </td>
                <td>
                  <?php echo htmlspecialchars($customer['City']); ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </table>
          <?php if ($totalPages > 1): ?>
            <div class="d-flex gap-4 justify-content-center">
              <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>">Prev</a>
              <?php endif; ?>
              <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php if ($i == $page): ?>
                  <span class="current">
                    <?php echo $i; ?>
                  </span>
                <?php else: ?>
                  <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
              <?php endfor; ?>
              <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>">Next</a>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </section>




    <?php
    class Orders
    {
      private $conn;

      public function __construct($dbh)
      {
        $this->conn = $dbh->connect();
      }

      public function getOrders($offset, $limit)
      {
        $query = "SELECT orders.Order_ID,orders.Email,orders.Phone_Number,orders.City,orders.Order_Status,products.Product_Name,products.Product_Location,users.Nickname FROM orders 
        INNER JOIN products ON orders.Product_ID = products.Product_ID
        INNER JOIN users ON orders.Email = users.Email
        ORDER BY Order_ID DESC
        LIMIT $offset, $limit";

        $statement = $this->conn->prepare($query);
        $statement->execute();
        $orders_info = $statement->fetchAll();

        return $orders_info;
      }

      public function getTotalOrders()
      {
        $query = "SELECT COUNT(*) as Total
        FROM orders";

        $statement = $this->conn->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        return $result['Total'];
      }
    }

    $dbh = new Dbh();
    $orders = new Orders($dbh);

    // Set the page number and limit
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $limit = 5;

    // Calculate the offset
    $offset = ($page - 1) * $limit;

    // Fetch the orders
    $orders_info = $orders->getOrders($offset, $limit);

    // Get the total number of orders
    $totalOrders = $orders->getTotalOrders();

    // Calculate the total number of pages
    $totalPages = ceil($totalOrders / $limit);

    ?>

    <section id="orders_section" class="hide">
      <div class="box-8">
        <div class="content-box">
          <p>Orders List <span><select name="order_status" id="order_status">
                <option value="Pending">Pending</option>
                <option value="Confirmed">Confirmed</option>
                <option value="Livring">Livring</option>
                <option value="Livred">Livred</option>
                <option value="On Hold">On Hold</option>
                <option value="Completed">Completed</option>
                <option value="Returned">Returned</option>
              </select></span></p>
          <br />
          <form action="./update.php" method="POST">
            <table>
              <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Phone</th>
                <th>Customer City</th>
                <th>Product Location</th>
                <th>Order Status</th>
                <th>Action</th>
              </tr>
              <?php foreach ($orders_info as $order_info): ?>
                <tr>
                  <td>
                    <input type="hidden" name="order_id_to_change[]" value="<?php echo $order_info['Order_ID']; ?>">
                    <input type="hidden" name="original_order_status[]"
                      value="<?php echo $order_info['Order_Status']; ?>">
                    <?php echo $order_info['Order_ID']; ?>
                  </td>
                  <td>
                    <?php echo $order_info['Nickname']; ?>
                  </td>
                  <td>
                    <?php echo $order_info['Phone_Number']; ?>
                  </td>
                  <td>
                    <?php echo $order_info['City']; ?>
                  </td>
                  <td>
                    <?php echo $order_info['Product_Location']; ?>
                  </td>
                  <td>
                    <?php echo $order_info['Order_Status']; ?>
                  </td>
                  <td>
                    <select name="change_order_status[]" class="btn btn-success">
                      <option value="Pending" <?php if ($order_info['Order_Status'] == 'Pending')
                        echo 'selected'; ?>>Pending
                      </option>
                      <option value="Confirmed" <?php if ($order_info['Order_Status'] == 'Confirmed')
                        echo 'selected'; ?>>
                        Confirmed</option>
                      <option value="Livring" <?php if ($order_info['Order_Status'] == 'Livring')
                        echo 'selected'; ?>>Livring
                      </option>
                      <option value="Livred" <?php if ($order_info['Order_Status'] == 'Livred')
                        echo 'selected'; ?>>Livred
                      </option>
                      <option value="On Hold" <?php if ($order_info['Order_Status'] == 'On Hold')
                        echo 'selected'; ?>>On Hold
                      </option>
                      <option value="Completed" <?php if ($order_info['Order_Status'] == 'Completed')
                        echo 'selected'; ?>>
                        Completed</option>
                      <option value="Returned" <?php if ($order_info['Order_Status'] == 'Returned')
                        echo 'selected'; ?>>
                        Returned</option>
                    </select>
                    <input type="submit" class="btn btn-primary" name="validate_status" value="Update">
                  </td>
                </tr>

              <?php endforeach; ?>
            </table>
          </form>

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
        </div>
      </div>
    </section>


    <section id="accounts_section" class="hide">

      <div class="mx-2 text-center mb-4" id="prodile_image">
        <div class="profile-pic w-25 container">
          <label class="-label" for="file">
            <span><i class="fa-solid fa-camera"></i></span>
            <span>Change Image</span>
          </label>
          <input id="file" type="file" onchange="loadFile(event)" />
          <img src="../../public/img/<?php echo $profile_info['Image_Path'] ?>" alt="profile picture" id="output"
            style="width: 11rem; height: 11rem; border-radius: 100%" />
        </div>
      </div>


      <form class="mb-5" id="setting_section" action="./profile_code.php" method="POST">
        <h3 class="mx-4">My Account</h3>
        <div class="d-flex gap-4 mx-4 justify-content-center">
          <div class="w-50">
            <label for="text" class="d-block pb-2 pt-3">First Name</label>
            <div class="input-group mb-3">
              <input type="text" class="form-control" readonly value="<?php echo $profile_info['First_Name'] ?>"
                class="form-control" name="first_name" id="f_Name">
              <button class="btn btn-outline-secondary" type="button" id="edit_Fname"><i
                  class="bi bi-pencil"></i></button>
            </div>
          </div>
          <div class="w-50">
            <label for="text" class="d-block pb-2 pt-3">Last Name</label>
            <div class="input-group mb-3">
              <input type="text" class="form-control" readonly value="<?php echo $profile_info['Last_Name'] ?>"
                class="form-control" name="last_name" id="l_Name">
              <button class="btn btn-outline-secondary" type="button" id="edit_Lname"><i
                  class="bi bi-pencil"></i></button>
            </div>
          </div>
        </div>
        <div class="d-flex gap-4 mx-4 justify-content-center">
          <div class="w-50">
            <label for="email" class="d-block pb-2 pt-3">Email</label>
            <div class="input-group mb-3">
              <input type="text" class="form-control" readonly value="<?php echo $profile_info['Email'] ?>"
                class="form-control" name="email">

            </div>
          </div>
          <div class="w-50">
            <label for="number" class="d-block pb-2 pt-3">Phone</label>
            <div class="input-group mb-3">
              <input type="text" class="form-control" readonly value="<?php echo $profile_info['Phone'] ?>"
                class="form-control" name="phone" id="phone">
              <button class="btn btn-outline-secondary" type="button" id="edit_Phone"><i
                  class="bi bi-pencil"></i></button>
            </div>
          </div>
        </div>
        <div class="d-flex gap-4 mx-4 justify-content-center">
          <div class="w-50">
            <label for="text" class="d-block pb-2 pt-3">CIN</label>
            <div class="input-group mb-3">
              <input type="text" class="form-control" readonly value="<?php echo $profile_info['CIN'] ?>"
                class="form-control" name="cin" id="cin">
              <button class="btn btn-outline-secondary" type="button" id="edit_Cin"><i
                  class="bi bi-pencil"></i></button>
            </div>
          </div>
          <div class="w-50">
            <label for="text" class="d-block pb-2 pt-3">City</label>
            <div class="input-group">
              <select class="form-control" name="city">
                <option value="<?php echo $profile_info['City'] ?>" selected><?php echo $profile_info['City'] ?>
                </option>
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
              <input type="text" class="form-control" readonly value="<?php echo $profile_info['Account_Type'] ?>"
                class="form-control" name="account_type" id="account_type">

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
    </section>
    <section id="password_section" class="mx-4 mb-5 hide profile_data">
      <!-- =================== Account Password start =================== -->

      <form action="./profile_code.php" method="POST">
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
    </section>


    <?php
class Products
{
  private $conn;

  public function __construct($dbh)
  {
    $this->conn = $dbh->connect();
  }

  public function getProducts($userEmail, $offset, $limit)
  {
    $sql = "SELECT * FROM Products 
                                INNER JOIN Images ON Products.Product_ID = Images.Product_ID
                                INNER JOIN Vehicules ON Products.Vehicule_ID = Vehicules.Vehicule_ID
                                WHERE Image_Type = 'primary'
                                LIMIT $offset, $limit;";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $products;
  }

  public function getTotalProducts()
  {
    $sql = "SELECT COUNT(*) as Total
            FROM Products";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch();

    return $result['Total'];
  }
}

$dbh = new Dbh();
$products = new Products($dbh);
$userEmail = $_SESSION['Email']; // assuming you store user email in session

// Set the page number and limit
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 2;

// Calculate the offset
$offset = ($page - 1) * $limit;

// Fetch the products
$productsData = $products->getProducts($userEmail, $offset, $limit);

// Get the total number of products
$totalProducts = $products->getTotalProducts();

// Calculate the total number of pages
$totalPages = ceil($totalProducts / $limit);
?>

<div class="hide" id="products_section">
  <?php
  foreach ($productsData as $product) {
    ?>
    <div class="d-flex w-100 my_product">
      <div class="img_holder">
        <img src="../../public/img/<?php echo $product['Image_Path'] ?>" alt="disk image" style="width: 21rem;height: 19rem;" />
      </div>
      <div class="data w-100 text-light">
        <h4>
          <?php echo $product['Product_Name'] ?>
        </h4>
        <p>
          <?php echo $product['Product_Price'] ?> $
        </p>
        <p>Serie :<span>
            <?php echo $product['Product_Serie'] ?>
          </span></p>
        <p>
          <?php echo $product['Product_Description'] ?>
        </p>
      </div>
      <form class="d-flex flex-column w-25 gap-4 justify-content-center">
        <input type="submit" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#DeleteModal"
          onclick="delete_product(event , <?php echo $product['Product_ID'] ?>)" value="Delete">

        <input type="submit" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#more_details_modal"
          onclick="getMore_Details(event, <?php echo $product['Product_ID'] ?>);" value="Details">

      </form>
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
        <span class="current-page"><?php echo $i; ?></span>
      <?php else: ?>
        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
      <?php endif; ?>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
      <a href="?page=<?php echo ($page + 1); ?>">Next</a>
    <?php endif; ?>
  </div>
</div>

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


  </div>
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





  <div class="clearfix"></div>
  </div>

  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="lib/wow/wow.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/waypoints/waypoints.min.js"></script>
  <script src="lib/owlcarousel/owl.carousel.min.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="../../public/js/dashboard.js"></script>
  <script>
    $(".nav").click(function () {
      $("#mySidenav").css("width", "70px");
      $("#main").css("margin-left", "70px");
      $(".logo").css("visibility", "hidden");
      $(".logo span").css("visibility", "visible");
      $(".logo span").css("margin-left", "-10px");
      $(".icon-a").css("visibility", "hidden");
      $(".icons").css("visibility", "visible");
      $(".icons").css("margin-left", "-8px");
      $(".nav").css("display", "none");
      $(".nav2").css("display", "block");
    });

    $(".nav2").click(function () {
      $("#mySidenav").css("width", "300px");
      $("#main").css("margin-left", "300px");
      $(".logo").css("visibility", "visible");
      $(".icon-a").css("visibility", "visible");
      $(".icons").css("visibility", "visible");
      $(".nav").css("display", "block");
      $(".nav2").css("display", "none");
    });
  </script>
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

    function delete_product(event, Product_ID) {
      event.preventDefault();
      const place_Product_ID = document.getElementById('delete_id');
      place_Product_ID.value = Product_ID;
    }
  </script>
</body>

</html>