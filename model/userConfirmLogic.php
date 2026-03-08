<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
include_once('../core/init.php');
session_start();
$user_id = $_SESSION['user_id'];
$request_id = $_SESSION['request_id'];



  try {
    $status = 'confirm';

    // Prepare the SQL statement to update the bloodstatus column
    $stmt = $db->prepare("UPDATE donation_requests SET status = :status WHERE request_id = :request_id");

  // Bind the transaction_id and status values to the prepared statement parameters
  $stmt->bindParam(':request_id', $request_id, PDO::PARAM_INT);
  $stmt->bindParam(':status', $status, PDO::PARAM_STR);

  if($stmt->execute()){
    header('Location: ../view/home.php?msg=confirmed');
    exit();
    exit;
  }
  else{
    echo "something gone wrong!";
    
  }
} catch(PDOException $e) {
    // Output an error message
    echo "Status update failed: " . $e->getMessage();
    
  }