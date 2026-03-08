<?php session_start();
unset($_SESSION['page']);
$page = 'login';
$_SESSION['page'] = $page;
include 'nav.php';

if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
  // redirect to the protected page
//  header('Location: home.php');
  exit;
}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <!--<title>Registration Form in HTML CSS</title>-->
    <!---Custom CSS File--->
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


    <link rel="stylesheet" href="../assets/css/register.css" />
    <link rel="stylesheet" href="../assets/css/nav.css" />

    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

  </head>
  
  <body>
    
    <section class="container" style="margin-top:10%;">
      <header>Login Form</header>
      <form action="../model/loginLogic.php" method="post" class="form">

        <div class="column">
          <div class="input-box">
            <label>Email Address</label>
            <input type="text" placeholder="Enter email address"  name="email" required/>
          </div>
          <div class="input-box">
            <label>Password</label>
            <input type="password" placeholder="Enter Password" required name="pass" />
          </div>
        </div>
        <div class="col-lg-6 mx-auto text-center">
          <button type="submit">Login</button>
          <br><br>
          <span>if you don't have an account <a href="./register.php" style="font-weight: bold">register here</a></span>
        </div>
        <div class="reg">
          
        </div>
      </form>
    </section>
    <?php
    if (isset($_GET['msg']) && $_GET['msg'] == 'invalid') {
        $alert_message = 'Invalid Email or password, please try again';
        echo '<script>alert("' . $alert_message . '");</script>';
      }
      ?>
  </body>
</html> 