<?php

session_start();
//to check if user is logged in
if ($_SESSION['logged_in'] == false) {
  header("Location: login.php");
}

unset($_SESSION['page']);
$page = 'staff';
$_SESSION['page'] = $page;
include 'nav.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final_bloodshare";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $status = $_POST['status'];
//     $transactionId = $_POST['transaction_id'];
// }

$donation_center_id = $_SESSION['id'];
$sql = "SELECT dr.request_id, dr.donor_id, dr.request_date, dr.status, us.bloodgroup FROM donation_requests dr JOIN user us ON dr.donor_id = us.id WHERE dr.donation_center_id = $donation_center_id AND (status= 'pending' OR status= 'confirm' OR status='accepted') ORDER BY status ASC, request_date ASC";
$result = mysqli_query($conn, $sql);
$rows = array();
while ($row = mysqli_fetch_assoc($result)) {
  $rows[] = $row;
}
mysqli_close($conn);

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
    <header>Donation Requests</header>
    <?php
    echo "<table class='table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th scope='col'>Request ID</th>";
    echo "<th scope='col'>Request Date</th>";
    echo "<th scope='col'>Status</th>";
    echo "<th scope='col'>Action</th>";
    echo "<th scope='col'>Blood Group</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($rows as $row) {
      echo "<tr>";
      echo "<td>" . $row['request_id'] . "</td>";
      echo "<td>" . $row['request_date'] . "</td>";
      echo "<td>" . $row['status'] . "</td>";
      echo "<td>";
      echo "<div class='button-group'>";
      if ($row['status'] == 'pending') {
        $secret_key = "mysecretkey";
        $iv = random_bytes(16); // Generate a random initialization vector
        $encrypted_id = openssl_encrypt($row['request_id'], "AES-256-CBC", $secret_key, 0, $iv);
        $encoded_id = urlencode(base64_encode($encrypted_id . "::" . $iv));

        echo "<a href='../model/updateStatus.php?msg=accept&id=" . $encoded_id . "' class='btn btn-success' data-request-id='" . $row['request_id'] . "'>Accept</a>";
        echo "<a href='../model/updateStatus.php?msg=reject&id=" . $encoded_id . "' class='btn btn-danger' data-request-id='" . $row['request_id'] . "'>Reject</a>";

        if (!empty($row['bloodgroup']))
          echo "<td>" . $row['bloodgroup'] . "</td>";
        else
          echo "<td> - </td>";
      } else if ($row['status'] == 'confirm') {
        $secret_key = "mysecretkey";
        // $iv = random_bytes(16); // Generate a random initialization vector
        // $encrypted_id = openssl_encrypt($row['request_id'], "AES-256-CBC", $secret_key, 0, $iv);
        // $encoded_id = urlencode(base64_encode($encrypted_id . "::" . $iv));

        $encoded_id = base64_encode(urlencode($row['request_id']));

        if (!empty($row['bloodgroup'])) {
          echo "<a href='../model/adminConfirmLogic.php?msg=accept&id=" . $encoded_id . "' class='btn btn-success' data-request-id='" . $row['request_id'] . "'>Accept</a>";
          echo "<a href='../model/adminConfirmLogic.php?msg=reject&id=" . $encoded_id . "' class='btn btn-danger' data-request-id='" . $row['request_id'] . "'>Reject</a>";
          echo "<td>" . $row['bloodgroup'] . "</td>";
        } else {
          echo "<a href='javascript:void(0);' class='btn btn-success' style='background-color: gray; border:none' disabled>Accept</a>";
          echo "<a href='javascript:void(0);' class='btn btn-danger' style='background-color: gray; border:none' disabled>Reject</a>";
          echo "<td><form action=\"../model/addBloodGroup.php?did=" . urlencode(base64_encode($row['donor_id'])) . "\" method=\"post\"> <select id=\"bloodgroup\" name=\"bloodgroup\">
            <option value=\"\" selected disabled>Select blood group</option>
            <option value=\"A+\">A+</option>
            <option value=\"A-\">A-</option>
            <option value=\"B+\">B+</option>
            <option value=\"B-\">B-</option>
            <option value=\"AB+\">AB+</option>
            <option value=\"AB-\">AB-</option>
            <option value=\"O+\">O+</option>
            <option value=\"O-\">O-</option>
          </select> <input type=\"submit\" value=\"Add\"/></form></td>";
        }
      } else if ($row['status'] == 'accepted') {
        echo "<a href='javascript:void(0);' class='btn btn-success' style='background-color: gray; border:none' disabled>Accept</a>";
        echo "<a href='javascript:void(0);' class='btn btn-danger' style='background-color: gray; border:none' disabled>Reject</a>";
        if (!empty($row['bloodgroup']))
          echo "<td>" . $row['bloodgroup'] . "</td>";
        else
          echo "<td> - </td>";
      }
      echo "</div>";
      echo "</td>";
      echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    ?>
    <input type="hidden" name="request_id" value="">

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
    echo '<script>alert("Status updated successsfully.");</script>';
  } else if (isset($_GET['msg']) && $_GET['msg'] == 'fail') {
    echo '<script>alert("Status updated successsfully.");</script>';
  } else if (isset($_GET['msg']) && $_GET['msg'] == 'successbg') {
    echo '<script>alert("You successfully updated the blood group!");</script>';
  } else if (isset($_GET['msg']) && $_GET['msg'] == 'complete') {
    echo '<script>window.onload=function(){alert("Blood bag is accepted successfully from the user.");};</script>';
  }
  ?>
</body>

</html>