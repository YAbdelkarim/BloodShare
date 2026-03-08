<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

include_once('../core/init.php');

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['pass']; // Get the plaintext password

  var_dump($email, $password);
  // Check if the email and password were submitted
  if (!empty($email) && !empty($password)) {

    if ($email == 'admin@admin.com' && $password == '123') {
      session_start();
      $_SESSION['logged_in'] = true;
      header("Location: ../view/adminPortal.php");

      exit();
    }

    // Check if the email ends with @staff.com
    elseif (strpos($email, '@staff.com') !== false) {
      // Prepare the SQL statement to query the bloodbank table for a staff member with the submitted email
      $stmt = $db->prepare("SELECT * FROM donation_center WHERE email = :email");

      // Bind the email parameter to the prepared statement
      $stmt->bindParam(':email', $email);

      // Execute the prepared statement
      $stmt->execute();

      // Fetch the bloodbank member's data from the database
      $staff = $stmt->fetch(PDO::FETCH_ASSOC);

      // Check if a staff member was found with the submitted email
      if ($staff && password_verify($password, $staff['password'])) {
        // Start a new session for the staff member
        session_start();
        // Set session variables for the staff member's ID and email
        $_SESSION['id'] = $staff['donation_center_id'];
        $_SESSION['email'] = $staff['email'];
        $_SESSION['blood_bank_id'] = $staff['blood_bank_id'];
        $_SESSION['logged_in'] = true;

        // Redirect the staff member to the staff portal page
        header("Location: ../view/staffPortal.php");
        exit();
      } else {
        // No staff member was found with the submitted email or password is incorrect
        header('Location: ../view/login.php?msg=invalid');  
      }
    } elseif (strpos($email, '@bloodbank.com') !== false) {


      $stmt = $db->prepare("DELETE FROM notifications WHERE date_notification < DATE_SUB(NOW(), INTERVAL 24 HOUR)");
      $stmt->execute();

      // Prepare the SQL statement to query the bloodbank table for a staff member with the submitted email
      $stmt = $db->prepare("SELECT * FROM blood_bank WHERE email = :email");

      // Bind the email parameter to the prepared statement
      $stmt->bindParam(':email', $email);
      // Execute the prepared statement
      $stmt->execute();

      // Fetch the bloodbank member's data from the database
      $staff = $stmt->fetch(PDO::FETCH_ASSOC);

      // Check if a staff member was found with the submitted email
      if ($staff && password_verify($password, $staff['password'])) {
        // Start a new session for the staff member
        session_start();
        // Set session variables for the staff member's ID and email
        $_SESSION['id'] = $staff['bloodbank_id'];
        $_SESSION['email'] = $staff['email'];
        $_SESSION['bloodbank_name'] = $staff['bloodbank_name'];
        $_SESSION['logged_in'] = true;

        // Redirect the staff member to the staff portal page
        header("Location: ../view/bloodbankPortal.php");
        exit();
      } else {
        // No staff member was found with the submitted email or password is incorrect
        header('Location: ../view/login.php?msg=invalid');      }
    } else {
      // Prepare the SQL statement to query the user table for a user with the submitted email
      $stmt = $db->prepare("SELECT * FROM user WHERE email = :email");

      // Bind the email parameter to the prepared statement
      $stmt->bindParam(':email', $email);

      // Execute the prepared statement
      $stmt->execute();

      // Fetch the user's data from the database
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      // Check if a user was found with the submitted email
      if ($user && password_verify($password, $user['password'])) {
        // Start a new session for the user
        session_start();
        // Set session variables for the user's ID and email
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $email = $_SESSION['email'];
        $_SESSION['logged_in'] = true;
        $_SESSION['donation_date'] = $user['lastDonation'];

        // Redirect the user to the home page
        header("Location: ../view/home.php");
        exit();
      } else {
        // No user was found with the submitted email or password is incorrect
        header('Location: ../view/login.php?msg=invalid');

      }
    }
  } else {
    // email or password was not submitted
    header('Location: login.php?msg=invalid');
  }
}
