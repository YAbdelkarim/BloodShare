<?php
session_start();
unset($_SESSION['page']);
$page = 'bloodbank';
$_SESSION['page'] = $page;
include 'nav.php';



//$id = 1;

$cwd = getcwd();
$exec = exec("sudo $cwd/../bash/getAll.sh 2>&1");
$blood_bags = json_decode($exec, true);
array_pop($blood_bags);

/*
$sql = "SELECT * FROM `user` WHERE `id` = :userID";
$stmt = $db->prepare($sql);
$stmt->bindParam(':userID', $userID);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

*/

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
    <style>
        .search-bar {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }

        .search-bar form {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f9f9f9;
            border-radius: 5px;
            overflow: hidden;
        }

        .search-bar input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .search-bar button[type="submit"] {
            padding: 10px 20px;
            background-color: rgba(69, 5, 38, 0.9);
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .search-bar button[type="submit"]:hover {
            background-color: rgba(69, 5, 38, 0.8);
        }
    </style>
</head>

<body>

<section class="container" style="margin-top:6%;">
  <header>Request Blood Bag</header>
  <div class="table-container">
    <form method="POST" onsubmit="return validateForm()">
      <div class="search-bar">
        <input type="text" name="search" id="search" placeholder="Search...">
        <button type="submit" id="search-btn">Search</button>
      </div>
    </form>
    <form method="POST" action="request_blood.php" id="request-form">
      <input type="hidden" name="action" value="request_blood">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Blood Bank</th>
            <th scope="col">Blood Type</th>
            <th scope="col">Quantity Available</th>
            <th scope="col">Quantity to Request</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Group the blood bags by blood bank and blood type
          $blood_bags_grouped = [];
          foreach ($blood_bags as $blood_bag) {
            $possessorID = $blood_bag['possessorID'];
            $bloodType = $blood_bag['bloodType'];
            if (!isset($blood_bags_grouped[$possessorID][$bloodType])) {
              $blood_bags_grouped[$possessorID][$bloodType] = 0;
            }
            $blood_bags_grouped[$possessorID][$bloodType]++;
          }

          // Loop through the groups and display the results
          foreach ($blood_bags_grouped as $possessorID => $blood_types) {

            if ($possessorID == $_SESSION['id']) {
              continue;
            }

            $sql = "SELECT * FROM `blood_bank` WHERE `bloodbank_id` = :possessorID";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':possessorID', $possessorID);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $bloodbank_name = $result['bloodbank_name'];
            foreach ($blood_types as $bloodType => $quantity) {
              echo "<tr>";
              echo "<td>" . $bloodbank_name . "</td>";
              echo "<td>" . $bloodType . "</td>";
              echo "<td>" . $quantity . "</td>";
              echo "<td><input type='number' name='requestedQuantity' min='1' max='" . $quantity . "'></td>";
              echo "<td>";
              echo "<div class='btn-group'>";
              $secret_key = "mysecretkey";
              $iv = random_bytes(16); // Generate a random initialization vector
              $encrypted_id = openssl_encrypt($result['bloodbank_id'], "AES-256-CBC", $secret_key, 0, $iv);
               $encoded_id = urlencode(base64_encode($encrypted_id . "::" . $iv));
               $btEnc=base64_encode($bloodType);
              echo "<a id='readValueButton' href='../model/b2bRequestLogic.php?id=" . $encoded_id."&bt=".$btEnc."&q=".$quantity."' class='btn btn-success'" . ">Request</a>"; 
              echo "</div>";
              echo "</td>";
              echo "</tr>";
            }
          }
          ?>
        </tbody>
      </table>
    </form>
  </div>
</section>

<script>
  function validateForm() {
    var form = document.getElementById("request-form");
    var quantities = form.elements["quantity"];
    for (var i = 0; i < quantities.length; i++) {
      if (quantities[i].value > quantities[i].getAttribute("max")) {
        alert("Quantity requested cannot be more than the quantity available.");
        return false;
      }
    }
    return true;
  }

  $(document).ready(function() {
    // Handle form submission
    $('#search-btn').click(function(e) {
      e.preventDefault(); // Prevent form submission
      var searchVal = $('#search').val().toLowerCase(); // Get search value
      $('.table tbody tr').each(function() {
        var bloodType = $(this).find('td:nth-child(2)').text().toLowerCase(); // Get blood type from table
        if (bloodType.indexOf(searchVal) !== -1) { // Check if search value matches blood type
          $(this).show();
        } else {
          $(this).hide();
        }
      });
    });
  });

  $(document).ready(function() {
    // Handle button click event
    $('#readValueButton').click(function() {
      // Read the value entered in the input field
      var requestedQuantity = $('#requestedQuantity').val();
      
    });
  });

</script>
</body>

</html>