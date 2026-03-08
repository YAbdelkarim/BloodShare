<?php

include_once('../core/init.php');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
// Get the blood bank details from a form or other source
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  session_start();
    $bloodBankId = $_SESSION['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Prepare the SQL statement to insert a new blood bank
    $stmt = $db->prepare("INSERT INTO donation_center (donation_center_name, email, password, blood_bank_id, donation_center_location) VALUES (:name, :email, :password, :bloodBankId, :address)");

    // Bind the parameters to the prepared statement
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':bloodBankId', $bloodBankId);
    $stmt->bindParam(':address', $address);

    // Execute the prepared statement
    if ($stmt->execute()) {
        // The blood bank was successfully inserted
        header('Location: ../view/bloodbankPortal.php');
        exit();
    } else {
        // An error occurred while inserting the blood bank
        echo "Error inserting blood bank";
    }
}