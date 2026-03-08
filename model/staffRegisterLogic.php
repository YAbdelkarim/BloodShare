<?php



include_once('../core/init.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
 // Retrieve the input parameters from the POST method
$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];
$blood_bank_id = $_POST['blood_bank_id'];
$password = password_hash($_POST['pass'], PASSWORD_DEFAULT); // Hash the user's password for security


if (!preg_match('/@staff\.com$/', $email)) {
  // If the email domain does not match "@staff.com",
  // output an error message and terminate the script
  echo 'Invalid email address. Please enter an email address with the domain "@staff.com".';
  header('Location: ../view/staffRegister.php?msg=invalid_email');
  unset($_GET['msg']);
  exit();
}

// Prepare the SQL statement to insert the user's information into the database
$stmt = $db->prepare("INSERT INTO donation_center (donation_center_name, email, password, blood_bank_id, donation_center_location) VALUES (:name, :email, :password, :blood_bank_id, :location)");

// Bind the input parameters to the prepared statement
$stmt->bindParam(':name', $name);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':location', $address);
$stmt->bindParam(':blood_bank_id', $blood_bank_id);


  // Execute the prepared statement to insert the user's information into the database
  if($stmt->execute()) {
    header('Location:../view/login.php');
  } else {
      echo "Registration failed.";
  }
}
//force