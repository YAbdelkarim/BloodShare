<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
include_once('../core/init.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Check if the form fields are submitted and update the corresponding database fields
        $userID = $_SESSION['user_id'];

// Check if the email is already registered
// Function to check if the email already exists in the database
if (isset($_POST['email'])) {
    $email = $_POST['email'];
}

function isEmailUnique($email)
{
  global $db;

  try {
    $sql = "SELECT COUNT(*) FROM `user` WHERE `email` = :email";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    return ($count === 0);
  } catch (PDOException $ex) {
    echo "Database error: " . $ex->getMessage();
    exit; // Stop further execution
  }
}
$sqll = "SELECT email FROM `user` WHERE `id` = :id";
$stmtt = $db->prepare($sqll);
$stmtt->bindParam(':id', $userID);
$stmtt->execute();
$mail = $stmtt->fetchColumn();

if ((!isEmailUnique($email))&&!($email==$mail)) {
    header('Location: ../view/homeEdit.php?msg=mail');
    exit; // Stop further execution
  }

    // Function to update user data in the database
    function updateUser($field, $value, $userID, $db)
    {
        try {
            $sql = "UPDATE `user` SET `$field` = :value WHERE `id` = :userID";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':value', $value);
            $stmt->bindParam(':userID', $userID);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Handle the error here, you may want to log it or show an error message to the user
            return false;
        }
    }


    if (isset($_POST['f_name'])) {
        $fname = $_POST['f_name'];
        updateUser('fname', $fname, $userID, $db);
    }

    if (isset($_POST['l_name'])) {
        $lname = $_POST['l_name'];
        updateUser('lname', $lname, $userID, $db);
    }

    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        updateUser('email', $email, $userID, $db);
    }

    if (isset($_POST['pass'])) {
        $pass = $_POST['pass'];
        // Assuming you have a secure password hashing mechanism before updating it in the database
        // For example, using password_hash() function
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
        updateUser('password', $hashed_pass, $userID, $db);
    }

    if (isset($_POST['city'])) {
        $city = $_POST['city'];
        updateUser('city', $city, $userID, $db);
    }

    if (isset($_POST['address'])) {
        $address = $_POST['address'];
        updateUser('address', $address, $userID, $db);
    }

    if (isset($_POST['bloodgroup']) && !($_POST['bloodgroup'] == "")) {
        $bloodgroup = $_POST['bloodgroup'];
        updateUser('bloodgroup', $bloodgroup, $userID, $db);
    }
    else if($_POST['bloodgroup'] == ""){
        $bloodgroup = NULL;
        updateUser('bloodgroup', $bloodgroup, $userID, $db);
    }

    if (isset($_POST['lastDonation'])) {
        $lastDonation = $_POST['lastDonation'];
        updateUser('lastDonation', $lastDonation, $userID, $db);
    }

    header('Location:../view/homeEdit.php');
    exit();
}
