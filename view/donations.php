<?php session_start();

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
unset($_SESSION['page']);
$page = 'login';
$_SESSION['page'] = $page;
include 'nav.php';
$uid = $_SESSION['user_id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final_bloodshare";

// // Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// // Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
// $sql = " SELECT d.request_id, d.donation_date, h.address, d.time_transaction FROM donation_requests d JOIN blood_bank h ON d.bloodbank_id = h.bloodbank_id WHERE d.donor_id= $uid";
// $result = mysqli_query($conn, $sql);
// $rows = array();
// while ($row = mysqli_fetch_assoc($result)) {
//     $rows[] = $row;
// }
// mysqli_close($conn);

// if (isset($_GET['msg']) && $_GET['msg'] == 'success') {
//   $alert_message = 'Invalid email address. Please enter an email address with the domain @staff.com.';
//   echo '<script>window.onload=function(){alert("' . $alert_message . '");};</script>';}

// 
$id = $_SESSION['user_id'];
$cwd = getcwd();
$exec = exec("sudo $cwd/../bash/getBloodBagsByDonorID.sh $id 2>&1");
// echo $exec;
$blood_bags = json_decode($exec, true);
//$blood_bags = implode(',', $blood_bags_json);
// echo $blood_bags;
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

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">


  <link rel="stylesheet" href="../assets/css/register.css" />
  <link rel="stylesheet" href="../assets/css/nav.css" />

  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

</head>

<body>

    <section class="container" style="margin-top:10%;">
      <header>Donations</header>
      <form action="../model/loginLogic.php" method="post" class="form">
<?php
echo "<table class='table'>";
echo "<thead>";
echo "<tr>";
echo "<th scope='col'>Blood Bag Number</th>";
echo "<th scope='col'>Status</th>";
echo "<th scope='col'>Location</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
$ctr = 1;
foreach ($blood_bags as $blood_bag) {
  $stmt = $db->prepare("SELECT address FROM blood_bank WHERE bloodbank_id = :possessorID");
  $possessorID = intval($blood_bag['possessorID']);
  $stmt->bindParam(':possessorID', $possessorID, PDO::PARAM_INT);

  if ($stmt->execute()) {
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $location = $result['address'];
} else {
    echo "something gone wrong!";
}
  echo "<tr>";
  echo "<td><a href='donation_details.php?id=" . $blood_bag['id'] . "' style='text-decoration: underline;'>" . $ctr . "</a></td>";
  echo "<td>" . $blood_bag['status'] . "</td>";
  echo "<td>" . $location . "</td>";
  echo "</tr>";
  $ctr++;
}
echo "</tbody>";
echo "</table>";
?>
      </form>
    </section> 
</body>

</html>