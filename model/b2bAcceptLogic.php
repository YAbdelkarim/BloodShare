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

$id = $_SESSION['id'];
$request_id = base64_decode(urldecode($_GET['b2bid']));

$sql = "SELECT requester_blood_bank, bloodgroup, no_of_bags FROM B2B_requests WHERE B2B_id = $request_id";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$requester_blood_bank = $row['requester_blood_bank'];
$bloodgroup = $row['bloodgroup'];
$no_of_bags = $row['no_of_bags'];

mysqli_close($conn);

$cwd = getcwd();
$exec = exec("sudo $cwd/../bash/getAll.sh 2>&1");
$blood_bags = json_decode($exec, true);

foreach ($blood_bags as $blood_bag){
    if($no_of_bags != 0 && $blood_bag['possessorID'] == $id && $blood_bag['bloodType'] == $bloodgroup){
        $blood_bag_id = $blood_bag['id'];
        exec("sudo $cwd/../bash/updatePossessor.sh $blood_bag_id $requester_blood_bank 2>&1");
        $no_of_bags--;
    
        $sql = "UPDATE B2B_requests SET status = 'accepted' WHERE B2B_id = $request_id";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    }
}

header('Location: ../view/staffPortalAcceptBB.php');