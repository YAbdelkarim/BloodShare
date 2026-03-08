<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
include_once('../core/init.php');
session_start();
$user_id = $_SESSION['user_id'];



$sql = $db->prepare("SELECT request_id FROM donation_requests WHERE donor_id = :donor_id");
// Bind the transaction_id and status values to the prepared statement parameters
$sql->bindParam(':donor_id', $user_id);

// Execute the SQL statement
if ($sql->execute()) {
  $result = $sql->fetch(PDO::FETCH_ASSOC);
  if (!empty($result['request_id'])) {
    $request_id = $result['request_id'];
    $stmt = $db->prepare("DELETE FROM donation_requests WHERE request_id = :request_id");
    $stmt->bindParam(':request_id', $request_id, PDO::PARAM_INT);
    $stmt->execute();
  }
  // Redirect to a success page after the alert is dismissed
  //echo '<script>window.location.href = "../view/staffPortal.php";</script>';
} else {
  echo "something gone wrong!";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $donation_center_location = $_POST['location'];
  $donation_date = $_POST['donation_date'];
  $donation_time = $_POST['donation_time'];
  // Get the blood group value from the user table
  $sql_user = "SELECT bloodgroup FROM user WHERE id = :user_id";
  $stmt_user = $db->prepare($sql_user);
  $stmt_user->bindParam(':user_id', $user_id);
  $stmt_user->execute();
  $result_user = $stmt_user->fetch(PDO::FETCH_ASSOC);
  $blood_group = $result_user['bloodgroup'];

  // Get the blood group value from the user table
  $sql_hos = "SELECT donation_center_id FROM donation_center WHERE donation_center_location = :donation_center_location";
  $stmt_user = $db->prepare($sql_hos);
  $stmt_user->bindParam(':donation_center_location', $donation_center_location);
  $stmt_user->execute();
  $result_user = $stmt_user->fetch(PDO::FETCH_ASSOC);
  $donation_center_id = $result_user['donation_center_id'];
  // Prepare the SQL statement
  $mysql_date = date('Y-m-d', strtotime($donation_date));
  $datetime_value = $mysql_date . ' ' . date('H:i:s', strtotime($donation_time));

  $sql = "INSERT INTO donation_requests (donor_id, donation_center_id, request_date, status) VALUES (:donor_id , :donation_center_id, :request_date, 'pending')";
  $stmt = $db->prepare($sql);

  // Bind the parameters
  $stmt->bindParam(':donation_center_id', $donation_center_id);
  $stmt->bindParam(':donor_id', $user_id);
  $stmt->bindParam(':request_date', $datetime_value);

  // Execute the statement
  if ($stmt->execute()) {
    // Redirect to a success page
    // Display a success message to the user
    // echo '<script>
    // window.location.href = "../view/donations.php";
    // alert("Your request is sent. Thank you!");</script>';
    // // Redirect to a success page after the alert is dismissed
    // echo '<script></script>';
    header('Location: ../view/home.php?msg=success');
    exit();
    exit;
  } else {
    // Log the error and redirect to an error page
    error_log('Error inserting donation: ' . print_r($stmt->errorInfo(), true));
    header('Location: error.php');
    exit;
  }
}
