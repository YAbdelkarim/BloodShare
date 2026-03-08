<?php


ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

session_start();
include_once('../core/init.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final_bloodshare";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$request_id = base64_decode(urldecode($_GET['b2bid']));

$sql = "UPDATE B2B_requests SET status = 'rejected' WHERE B2B_id = $request_id";
$stmt = $db->prepare($sql);
$stmt->execute();

header('Location: ../view/staffPortalAcceptBB.php');
