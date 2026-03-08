<?php
session_start();
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
include_once('../core/init.php');

  $tobloodbank_id = $_GET['id'];
  $bloodgroup = $_GET['bt'];
  $btDec= base64_decode($bloodgroup);
  $quantity = $_GET['q'];
$fromBloodbankId= $_SESSION['id'];
$status = 'pending';
$requestDate = date('Y-m-d H:i:s');


$secret_key = "mysecretkey";
$encoded_id = urldecode($_GET['id']);
$decoded_id = base64_decode($encoded_id);
list($encrypted_id, $iv) = explode("::", $decoded_id);
$request_id = openssl_decrypt($encrypted_id, "AES-256-CBC", $secret_key, 0, $iv);

  // Process the form data here
  // ...
  $sql = "INSERT INTO B2B_requests (requester_blood_bank, recipient_blood_bank, request_date, bloodgroup, status, no_of_bags) VALUES (:fromBloodbankId, :toBloodbankId, :requestDate, :bloodGroup, :status, :numberOfBags)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':fromBloodbankId', $fromBloodbankId);
    $stmt->bindParam(':toBloodbankId', $request_id);
    $stmt->bindParam(':requestDate', $requestDate);
    $stmt->bindParam(':bloodGroup', $btDec);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':numberOfBags', $quantity);

    // Execute the statement to insert the B2B request
    if ($stmt->execute()) {
        header('Location: ../view/bloodbankPortal.php?msg=req_success');
      } else {
      echo "Error inserting B2B request for blood bank ID $tobloodbank_id<br>";
    }

// }}


// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', true);
// include_once('../core/init.php');
// session_start();
// if (isset($_POST['action'])) {
// //   $quantities = $_POST['quantity'];
// //   $bloodbankIds = $_POST['bloodbank_id'];
// //   $toBloodbankId = reset($bloodbankIds); // Get the first value in the array
//   $fromBloodbankId= $_SESSION['id'];
//   $status = 'pending';
//   $bloodbank_id = $_POST['bloodbank_id'];
//   $quantity = $_POST['quantity'];
//   $bloodType = $_POST['bloodgroup'];

//   // Get the current date and time in the format yyyy-mm-dd hh:mm:ss
//   $requestDate = date('Y-m-d H:i:s');


//   echo "fromBloodbankId: " . $fromBloodbankId . "<br>";
// echo "status: " . $status . "<br>";
// echo "bloodbank_id: " . $bloodbank_id . "<br>";
// echo "quantity: " . $quantity . "<br>";
// echo "bloodType: " . $bloodType . "<br>";
// echo $requestDate;
//   // Loop through the requested blood bags and insert a B2B request for each one
//     // Get the blood group and number of bags from the form action on another page
//     // $bloodGroup = $_POST['bloodgroup'];
//     // echo $bloodGrouFin;
//     // $bloodGrouFin= reset($bloodGroup);
//     // echo $bloodGrouFin;

//     // $numberOfBags = $_POST['no_of_bags'];
//     // $numberOfBagsFin = reset($numberOfBags);
//     // echo $numberOfBagsFin;
//     // Set the status to 'pending' initially


//     // Prepare a PDO statement to insert the B2B request into the database
//     $sql = "INSERT INTO B2B_requests (requester_blood_bank, recipient_blood_bank, request_date, bloodgroup, status, no_of_bags) VALUES (:fromBloodbankId, :toBloodbankId, :requestDate, :bloodGroup, :status, :numberOfBags)";
//     $stmt = $db->prepare($sql);
//     $stmt->bindParam(':fromBloodbankId', $fromBloodbankId);
//     $stmt->bindParam(':toBloodbankId', $bloodbank_id);
//     $stmt->bindParam(':requestDate', $requestDate);
//     $stmt->bindParam(':bloodGroup', $bloodType);
//     $stmt->bindParam(':status', $status);
//     $stmt->bindParam(':numberOfBags', $quantity);

//     // Execute the statement to insert the B2B request
//     if ($stmt->execute()) {
//         header('Location: ../view/bloodbankPortal.php?msg=req_success');
//       } else {
//       echo "Error inserting B2B request for blood bank ID $toBloodbankId<br>";
//     }

// }
// else {
//     echo "uh oh";
// }
?>