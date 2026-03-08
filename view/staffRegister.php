<?php session_start();

unset($_SESSION['page']);
$page = 'staffreg';
$_SESSION['page'] = $page;
include 'nav.php';
include_once('../core/init.php');

$stmt = $db->prepare("SELECT bloodbank_id, bloodbank_name FROM blood_bank");
$stmt->execute();


  

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


    <link rel="stylesheet" href="../assets/css/register.css" />
    <link rel="stylesheet" href="../assets/css/nav.css" />

    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

  </head>
  
  <body>

    <section class="container" style="margin-top:10%;">
      <header>Registration Form</header>
      <form action="../model/staffRegisterLogic.php" method="post" class="form">

        <div class="column">
          <div class="input-box">
            <label>Name</label>
            <input type="text" placeholder="Enter first name"  name="name" required />
          </div>
          <div class="input-box">
            <label>Email Address</label>
            <input type="text" placeholder="Enter email address"  name="email" required/>
          </div>
        </div>

        <div class="column">
          <div class="input-box">
            <label>Password</label>
            <input type="password" placeholder="Enter Password" required name="pass" />
          </div>
          <div class="input-box">
          <label>Location</label>
          <input type="text" placeholder="Enter street address" name="address" required />
        </div>
        </div>

        <div class="column">
          <div class="input-box">
            <label>Blood Bank</label>
            <select name="blood_bank_id" class="select-box">
        <option hidden>Select Blood Bank</option>
        <?php

        // Fetch the results and create option elements
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="' . $row['bloodbank_id'] . '">' . $row['bloodbank_name'] . '</option>';
          }
        ?>
      </select>
        </div>
        </div>
       
        <?php
    if (isset($_GET['msg']) && $_GET['msg'] == 'invalid_email') {
        $alert_message = 'Invalid email address. Please enter an email address with the domain @staff.com.';
        echo '<script>window.onload=function(){alert("' . $alert_message . '");};</script>';}

      ?>
      
    
        <button type="submit">Submit</button>
      </form>
    </section>
  </body>
</html>