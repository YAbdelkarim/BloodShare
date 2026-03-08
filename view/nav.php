<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

include_once('../core/init.php');
if (!isset($_SESSION)) {
  session_start();
}
if (isset($_GET['page'])) {
  $_SESSION['page'] = $_GET['page'];
}
$page = $_SESSION['page'];
if (isset($_SESSION['user_id'])) {
  $user_id =  $_SESSION['user_id'];

  try {
    // prepare a SELECT statement to retrieve the user's first name
    $stmt = $db->prepare("SELECT fname FROM user WHERE id = :user_id");
    $stmt->bindParam(':user_id', $user_id);

    // execute the statement
    $stmt->execute();

    // retrieve the first name from the result
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $first_name = $row['fname'];
  } catch (PDOException $ex) {
    // handle any errors that occur during the database operation
    die("Failed to retrieve user information: " . $ex->getMessage());
  }
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final_bloodshare";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

?>

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>BloodShare</title>
  <meta content="" name="description">
  <meta content="" name="keywords">


  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/nav.css" rel="stylesheet">

</head>

<body>


  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">
      <?php
      if (isset($_SESSION['page']) && $_SESSION['page'] == 'home') {
      ?>
        <h1 class="logo me-auto"><a href="#">BloodShare</a></h1>
      <?php
      } else if (isset($_SESSION['page']) && $_SESSION['page'] == 'staff') {
      ?>
        <h1 class="logo me-auto"><a href="staffPortal.php">BloodShare</a></h1>
      <?php
      } else if (isset($_SESSION['page']) && $_SESSION['page'] == 'bloodbank') {
      ?>
        <h1 class="logo me-auto"><a href="../view/bloodbankPortal.php">BloodShare</a></h1>
      <?php
      } else if (isset($_SESSION['page']) && $_SESSION['page'] == 'admin') {
      ?>
        <h1 class="logo me-auto"><a href="../view/adminPortal.php">BloodShare</a></h1>
      <?php
      } else {
      ?>
        <h1 class="logo me-auto"><a href="../index.php">BloodShare</a></h1>
      <?php
      }
      ?>


      <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar" style="padding: 0.6%;">

        <ul>
          <?php if (isset($_SESSION['page']) && $_SESSION['page'] == 'home') { ?>
            <?php
            $flag = false;

            $sql = "SELECT request_id, status FROM donation_requests WHERE donor_id = '$user_id'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            if (!empty($row['status'])) {
              $_SESSION['request_id'] = $row['request_id'];
              $status = $row['status'];
            } else $status = '';
            ?>
            <li><a class="nav-link scrollto" href="#loc">Find Blood</a></li>
            <li><a class="nav-link scrollto active" href="#"><?php echo "Welcome, $first_name!"; ?></a></li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="../assets/img/bell.png">
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="background-color: rgba(69,5,38,1); align-items:center; width:200px;">
                <?php
                $stmt = "SELECT bloodgroup FROM user WHERE id = $user_id";

                // execute the SQL statement
                $result = mysqli_query($conn, $stmt);

                // process the result set
                $row = mysqli_fetch_array($result);
                // do something with each row of data
                $blood_group = $row['bloodgroup'];

                $stmt2 = "SELECT notification_id FROM notifications WHERE blood_group = '$blood_group'";

                // execute the SQL statement
                $result = mysqli_query($conn, $stmt2);

                // process the result set
                $row = mysqli_fetch_array($result);
                // do something with each row of data
                if (!empty($row['notification_id']))
                  $notification_id = $row['notification_id'];
                if ($status == "pending") {
                  $flag = true;
                ?>
                  <p style="color:#c9c9c9; text-align:center;">Previous request is pending.</p>
                <?php
                } else if ($status == "rejected") {
                  $flag = true;
                ?>
                  <p style="color:#c9c9c9; text-align:center;">Previous request rejected, please try again.</p>
                <?php } else if ($status == "accepted") {
                  $flag = true;
                ?>
                  <p style="color:#c9c9c9; text-align:center;">Click this button when donation is complete.</p>
                  <div style="padding-left:50px"><a href='../model/userConfirmLogic.php' class='btn btn-success' style="width: 100px; padding-left:20px"><span style="display: flex; justify-content: center; text-align: center;">Confirm</span></a></div>
                <?php } else if ($status == "confirm") {
                  $flag = true;
                ?>
                  <p style="color:#c9c9c9; text-align:center;">Waiting for admin confirmation.</p>
                <?php } else if ($status == "complete") {
                  $flag = true;
                ?>
                  <p style="color:#c9c9c9; text-align:center;">Your donation has been successfully completed!</p>
                <?php } else if (!isset($row['notification_id'])) {
                  $flag = true;
                ?>
                  <p style="color:#c9c9c9; text-align:center;">No notifications.</p>
                <?php } ?>

                <?php
                if (!empty($notification_id) && $status != 'confirm' && $status != 'pending' && $status != 'accepted') {
                  if ($flag) { ?>
                    <hr>
                    <?php } ?>

                  <div style="padding: 10px;">
                    <p style="color:#FFFFFF; text-align:center;">We need your donations! A blood bank is reqeusting your blood group!</p>
                  </div>
                <?php } ?>

              </div>

            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="../assets/img/user.png">
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="background-color: rgba(69,5,38,1);">
                <a class="dropdown-item" href="../view/donations.php">Your Donations</a>
                <a class="dropdown-item" href="homeEdit.php">View your data</a>
                <a class="nav-link scrollto" href="../model/logout.php"><img src="../assets/img/logouttt.png"></a>
              </div>
            </li>
          <?php } else if (isset($_SESSION['page']) && $_SESSION['page'] == 'staff') {  ?>

            <a class="nav-link scrollto" href="../model/logout.php"><img src="../assets/img/logouttt.png"></a>
          <?php } else if (isset($_SESSION['page']) && $_SESSION['page'] == 'homeEdit') {
          ?>
            <li><a class="nav-link scrollto" href="../view/home.php">back</a></li>

          <?php
          } else if (isset($_SESSION['page']) && $_SESSION['page'] == 'admin') {
          ?>
            <li><a class="nav-link scrollto" href="../view/adminAddBloodBank.php">Add Blood Bank</a></li>
            <a class="nav-link scrollto" href="../model/logout.php"><img src="../assets/img/logouttt.png"></a>


          <?php
          } else if (isset($_SESSION['page']) && $_SESSION['page'] == 'bloodbank') {
          ?>

            <li><a class="nav-link scrollto" href="../view/bloodbankAddDonationCenter.php">Add Donation Center</a></li>
            <li><a class="nav-link scrollto" href="../view/bloodbankEditStatus.php">Edit Status</a></li>
            <li><a class="nav-link scrollto" href="../view/staffPortalRequestBB.php">Request Blood B2B</a></li>
            <li><a class="nav-link scrollto" href="../view/staffPortalRequestB2C.php">Request Blood B2C</a></li>
            <li><a class="nav-link scrollto" href="../view/staffPortalAcceptBB.php">View Incoming Requests</a></li>
            <a class="nav-link scrollto" href="../model/logout.php"><img src="../assets/img/logouttt.png"></a>

          <?php } ?>

        </ul>

      </nav><!-- .navbar -->

    </div>
  </header>


  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>