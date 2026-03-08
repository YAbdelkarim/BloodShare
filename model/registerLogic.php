<?php

include_once('../core/init.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fname = $_POST['f_name'];
  $lname = $_POST['l_name'];
  $email = $_POST['email'];
  $city = $_POST['city'];
  $DOB = $_POST['DOB'];
  $address = $_POST['address'];
  $gender = $_POST['gender'];
  $lastDonation = $_POST['lastDonation'];
  $bloodGroup = $_POST['bloodGroup'];
  if($bloodgroup == "")
    $bloodGroup = NULL;
  $ssn = $_POST['ssn'];

 // Check if the email is already registered
 if (!isEmailUnique($email)) {
  header('Location: ../view/register.php?msg=error');
  exit; // Stop further execution
}
if(!isSSNUnique($ssn)){
  header('Location: ../view/register.php?msg=ssn');
  exit;
}

  if (!preg_match('/^[0-9]{14}$/', $ssn)) {
    //echo '<script>alert("SSN should contain 11 digits.");</script>';
    header('Location: ../view/register.php?msg=digits');
    exit; // Stop further execution
  }

  // Check if the blood group is selected
  if ($bloodGroup === "Blood Group") {
    $bloodGroup = NULL;
  }

  // Hash the user's password for security
  $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);

  // Calculate age based on date of birth
  $bday = DateTime::createFromFormat('Y-m-d', $DOB);
  $today = new DateTime();
  $diff = $today->diff($bday);
  $age = $diff->y;
  if ($bday > $today || $age < 18) {
   header('Location: ../view/register.php?msg=age');
   exit;
  }
  // Prepare the SQL statement to insert the user's information into the database
  $stmt = $db->prepare("INSERT INTO user (fname, lname, email, password, ssn,gender, age, address, city, bloodgroup, lastDonation) VALUES (:fname, :lname, :email, :password,:ssn ,:gender, :age, :address, :city, :bloodgroup, :lastDonation)");

  // Bind the input parameters to the prepared statement
  $stmt->bindParam(':fname', $fname);
  $stmt->bindParam(':lname', $lname);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':password', $password);
  $stmt->bindParam(':ssn', $ssn);
  $stmt->bindParam(':gender', $gender);
  $stmt->bindParam(':age', $age);
  $stmt->bindParam(':address', $address);
  $stmt->bindParam(':city', $city);
  $stmt->bindParam(':bloodgroup', $bloodGroup);
  $stmt->bindParam(':lastDonation', $lastDonation, PDO::PARAM_NULL);

  // Execute the prepared statement to insert the user's information into the database
  if ($stmt->execute()) {
    header('Location:../view/login.php');
    exit; // Stop further execution
  } else {
    echo "Registration failed.";
    exit; // Stop further execution
  }
}

// Function to check if the email already exists in the database
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
}// Function to check if the ssn already exists in the database
function isSSNUnique($ssn)
{
  global $db;

  try {
    $sql = "SELECT COUNT(*) FROM `user` WHERE `ssn` = :ssn";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':ssn', $ssn);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    return ($count === 0);
  } catch (PDOException $ex) {
    echo "Database error: " . $ex->getMessage();
    exit; // Stop further execution
  }
}
