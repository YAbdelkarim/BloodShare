<?php
session_start();
//to check if user is logged in
if ($_SESSION['logged_in'] == false) {
  header("Location: login.php");
}


unset($_SESSION['page']);
$page = 'homeEdit';
$_SESSION['page'] = $page;
include 'nav.php';

// Assuming you have already established a database connection

// Retrieve user data from the database
$userID = $_SESSION['user_id']; // Assuming you have stored the user ID in the session
$sql = "SELECT * FROM `user` WHERE `id` = :userID";
$stmt = $db->prepare($sql);
$stmt->bindParam(':userID', $userID);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Function to populate the form fields with the retrieved values
function populateFormField($fieldName, $user)
{
  if (isset($user[$fieldName])) {
    echo 'value="' . htmlspecialchars($user[$fieldName]) . '"';
  }
}

// Function to calculate age based on the date of birth
function calculateAge($dob)
{
  $today = new DateTime();
  $birthdate = new DateTime($dob);
  $age = $birthdate->diff($today)->y;
  return $age;
}
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
</head>

<body>
  <section class="container" style="margin-top:10%;">
    <header>Registration Form</header>
    <form action="../model/updateHomeLogic.php" method="post" class="form">
      <div class="column">
        <div class="input-box">
          <label>First Name</label>
          <input type="text" placeholder="Enter first name" name="f_name" required <?php populateFormField('fname', $user); ?> />
        </div>
        <div class="input-box">
          <label>Last Name</label>
          <input type="text" placeholder="Enter Last name" name="l_name" required <?php populateFormField('lname', $user); ?> />
        </div>
      </div>
      <div class="column">
        <div class="input-box">
          <label>Email Address</label>
          <input type="text" placeholder="Enter email address" name="email" required <?php populateFormField('email', $user); ?> />
        </div>
        <div class="input-box">
          <label>Password</label>
          <input type="password" placeholder="Enter Password" required name="pass" />
        </div>
      </div>
      <div class="column">
        <div class="input-box">
          <label>City</label>
          <input type="text" placeholder="Enter city name" name="city" required <?php populateFormField('city', $user); ?> />
        </div>
      </div>
      <div class="input-box address column">
        <div class="input-box">
          <label>Address</label>
          <input type="text" placeholder="Enter street address" name="address" required <?php populateFormField('address', $user); ?> />
        </div>
      </div>
      <br>
      <div class="input-box address column">

      </div>
      <?php if (is_null($user['bloodgroup'])) : ?>
        <label>Blood Group</label>
        <div class="select-box" id="blood-group">
          <select name="bloodgroup">
            <option value="" hidden>Select blood group</option>
            <option>A+</option>
            <option>A-</option>
            <option>B+</option>
            <option>B-</option>
            <option>AB+</option>
            <option>AB-</option>
            <option>O+</option>
            <option>O-</option>
          </select>
        </div>
      <?php else : ?>
        <div class="input-box">
          <label>Blood Group</label>
          <input type="text" name="bloodgroup" required <?php populateFormField('bloodgroup', $user); ?> disabled />
        </div>
      <?php endif; ?>


      <?php if (isset($user['lastDonation']) && !empty($user['lastDonation'])) : ?>
        <div class="input-box">
          <label>Last Donation Date</label>
          <input type="date" name="lastDonation" value="<?php echo htmlspecialchars($user['lastDonation']); ?>" />
        </div>
      <?php else : ?>
        <div class="input-box" id="last-donation-date">
          <label>Last Donation Date</label>
          <input type="date" name="lastDonation" />
        </div>
      <?php endif;

      if (isset($_GET['msg']) && $_GET['msg'] == 'mail') {
        $alert_message = 'Email already exists, enter another email';
        echo '<script>alert("' . $alert_message . '");</script>';
      }
      ?>


      <button type="submit">Change</button>
    </form>
  </section>
</body>

</html>