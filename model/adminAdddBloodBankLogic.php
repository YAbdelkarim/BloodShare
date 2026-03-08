<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
include_once('../core/init.php');
// Get the blood bank details from a form or other source
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phome = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


// Prepare the SQL statement to insert a new blood bank
$stmt = $db->prepare("INSERT INTO blood_bank (bloodbank_name, address, phone_number, email, password) VALUES (:bloodbank_name, :address, :phone_number, :email, :password)");

// Bind the parameters to the prepared statement
$stmt->bindParam(':bloodbank_name', $name);
$stmt->bindParam(':address', $address);
$stmt->bindParam(':phone_number', $phome);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $password);



// Execute the prepared statement
if ($stmt->execute()) {
    // The blood bank was successfully inserted
    ob_start();
    header('Location: ../view/adminPortal.php?msg=success');
    ob_end_flush();
    exit();
  } else {
    // An error occurred while inserting the blood bank
    echo "Error inserting blood bank";
  }
}