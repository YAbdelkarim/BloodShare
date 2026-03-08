<?php session_start();
unset($_SESSION['page']);
$page = 'reg';
$_SESSION['page'] = $page;
include 'nav.php';
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
      <header>Registration Form</header>
      <form action="../model/registerLogic.php" method="post" class="form">

        <div class="column">
          <div class="input-box">
            <label>First Name</label>
            <input type="text" placeholder="Enter first name"  name="f_name" required />
          </div>
          <div class="input-box">
            <label>Last Name</label>
            <input type="text" placeholder="Enter Last name"  name="l_name" required />
          </div>
        </div>

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
        <div class="input-box">
    <label>SSN</label>
    <input type="text" placeholder="Enter SSN" name="ssn" required />
  </div>
</div>
        <div class="column">
          <div class="input-box">
            <label>City</label>
            <input type="text" placeholder="Enter city name"  name="city"  required/>
          </div>
          <div class="input-box">
            <label>Birth Date</label>
            <input type="date" placeholder="Enter birth date"  name="DOB" required />
          </div>
        </div>
       
        <div class="input-box address column">
          <div class="input-box">
          <label>Address</label>
          <input type="text" placeholder="Enter street address" name="address" required />
        </div>
        </div>
          <div class="gender-box">
            <h3>Gender</h3>
            <div class="gender-option">
              <div class="gender">
                <input type="radio" id="check-male" name="gender" value="male" checked />
                <label for="check-male">Male</label>
              </div>
              <div class="gender">
                <input type="radio" id="check-female" name="gender"  value="female"/>
                <label for="check-female">Female</label>
              </div>
            </div>
          </div>   
        </div>
        <br>
        <input type="checkbox" id="donor-checkbox" onclick="toggleDonorFields()">
<label for="donor-checkbox">Donated Before?</label>

<div class="input-box" id="last-donation-date" style="display: none;">
  <label>Last donation date</label>
  <input type="date" name="lastDonation"/>
</div>
<br>
<label id="blood-group-label" style="display: none;">Blood Group</label>
<div class="select-box" id="blood-group" style="display: none;">
  <select name="bloodGroup">
    <option value="" hidden>Select blood group</option>
    <option>A+</option>
    <option>A-</option>
    <option>B+</option>
    <option>B-</option>
    <option>AB+</option>
    <option>AB-</option>
    <option>O+</option>
    <option>O-</option>
  </select>
</div>

<script>
function toggleDonorFields() {
  var checkbox = document.getElementById("donor-checkbox");
  var lastDonationDiv = document.getElementById("last-donation-date");
  var bloodGroupDiv = document.getElementById("blood-group");
  var bloodGroupLabel = document.getElementById("blood-group-label");

  
  if (checkbox.checked) {
    lastDonationDiv.style.display = "block";
    bloodGroupDiv.style.display = "block";
    bloodGroupLabel.style.display = "block";
  } else {
    lastDonationDiv.style.display = "none";
    bloodGroupDiv.style.display = "none";
    bloodGroupLabel.style.display = "none";
  }
}

</script>
        <button type="submit">Submit</button>
        </form>
    </section>
    <?php
    if (isset($_GET['msg']) && $_GET['msg'] == 'error') {
      $alert_message = 'Email already exists, enter another email';
  echo '<script>alert("' . $alert_message . '");</script>';
}
else if(isset($_GET['msg']) && $_GET['msg'] == 'digits'){

  $alert_message = 'SSN should contain 14 digits';
  echo '<script>alert("' . $alert_message . '");</script>';
}
else if(isset($_GET['msg']) && $_GET['msg'] == 'age'){
  $alert_message = 'Your age should be 18 years old at least';
  echo '<script>alert("' . $alert_message . '");</script>';
}
else if(isset($_GET['msg']) && $_GET['msg'] == 'ssn'){
  $alert_message = 'There is an account with this SSN';
  echo '<script>alert("' . $alert_message . '");</script>';
}
  ?>
  </body>
</html>