<?php
include_once('../core/init.php');
session_start();
//to check if user is logged in
if ($_SESSION['logged_in']==false){
  header("Location: login.php");  

}

unset($_SESSION['page']);
$page = 'admin';
$_SESSION['page'] = $page;

include 'nav.php';

$statement = $db->prepare("SELECT * FROM blood_bank");
$statement->execute();
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);


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
      <header>Registered blood banks details</header>
      <form id="status-form" action="../model/updateStatus.php" method="post" class="form">
  <?php
   echo "<table class='table'>";
   echo "<thead>";
   echo "<tr>";
   echo "<th scope='col'>Blood Bank ID </th>";
   echo "<th scope='col'>Blood Bank Name</th>";
   echo "<th scope='col'>Address</th>";
   echo "<th scope='col'>Phone Number</th>";
   echo "<th scope='col'>Email</th>";
   echo "</tr>";
   echo "</thead>";
   echo "<tbody>";
   
   foreach ($rows as $row) {
     echo "<tr>";
     echo "<td>" . $row['bloodbank_id'] . "</td>";
     echo "<td>" . $row['bloodbank_name'] . "</td>";
     echo "<td>" . $row['address'] . "</td>";
     echo "<td>" . $row['phone_number'] . "</td>";
     echo "<td>" . $row['email'] . "</td>";
     echo "</tr>";
   }
   
   echo "</tbody>";
   echo "</table>";
  ?>
  <input type="hidden" name="request_id" value="">
</form>

<script>
  var acceptButtons = document.querySelectorAll("a.accept-button");
  acceptButtons.forEach(function(button) {
    button.addEventListener("click", function(event) {
      event.preventDefault();
      var request_Id = this.getAttribute("data-request-id");
      document.querySelector("input[name='request_id']").value = request_Id;
      document.getElementById("status-form").submit();
    });
  });
</script>
    </section>

    <?php
     if (isset($_GET['msg']) && $_GET['msg'] == 'success') {
    echo '<script>alert("Blood bank added successfully.");</script>';
  }

  ?>
  </body>
</html>
