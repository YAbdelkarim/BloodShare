<?php 

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

session_start();
unset($_SESSION['page']);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final_bloodshare";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$id = $_SESSION['id'];
$blood_group = base64_decode($_GET['bg']);

$stmt = "INSERT INTO notifications (bloodbank_id, blood_group, date_notification) VALUES ($id, '$blood_group', DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'))";
if (mysqli_query($conn, $stmt)) {
    echo "<script>alert('Record inserted successfully');</script>";
} else {
    echo "<script>alert('Error inserting record: " . mysqli_error($conn) . "');</script>";
}
header("Location: ../view/bloodbankPortal.php");

// Close the database connection
mysqli_close($conn);