<?php
session_start();
unset($_SESSION['page']);
$page = 'bloodbank';
$_SESSION['page'] = $page;
include 'nav.php';

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


$searchPhrase = "";
if (isset($_POST['search'])) {
    $searchPhrase = $_POST['search'];
    $searchCondition = " AND (b2b.bloodgroup LIKE '%$searchPhrase%' OR bb.bloodbank_name LIKE '%$searchPhrase%')";
} else {
    $searchCondition = "";
}

$id = $_SESSION['id'];
//DAAAAAA HAYETGHAYAR BEL QUERY EL ALA TABLE EL B2B TRANSACTIONS EL LESA HAYET3EMEL
$sql = "SELECT b2b.B2B_id, bb.bloodbank_name, b2b.requester_blood_bank, b2b.recipient_blood_bank, 
b2b.request_date, b2b.bloodgroup, b2b.status, b2b.no_of_bags
FROM B2B_requests b2b JOIN blood_bank bb 
ON b2b.requester_blood_bank = bb.bloodbank_id WHERE b2b.recipient_blood_bank = $id AND b2b.status = 'pending'" . $searchCondition;

$result = mysqli_query($conn, $sql);
$rows = array();
while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
}
mysqli_close($conn);
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

    <section class="container" style="margin-top:6%;">
        <h1>Incoming Requests</h1>
        <div class="table-container">
            <form action="" method="POST">
                <div class="search-bar">
                    <input type="text" name="search" placeholder="Search..." />
                    <button type="submit">Search</button>
                </div>
            </form>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Request ID</th>
                        <th scope="col">from Blood Bank</th>
                        <th scope="col">Request Date</th>
                        <th scope="col">Blood Group</th>
                        <th scope="col">No. of Bags</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($rows as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['B2B_id'] . "</td>";
                        echo "<td>" . $row['bloodbank_name'] . "</td>";
                        echo "<td>" . $row['request_date'] . "</td>";
                        echo "<td>" . $row['bloodgroup'] . "</td>";
                        echo "<td>" . $row['no_of_bags'] . "</td>";
                        echo "<td>";
                        echo "<div class='btn-group'>";
                        echo "<a href=\"../model/b2bAcceptLogic.php?b2bid=". urlencode(base64_encode($row['B2B_id'])) . "\" class='btn btn-success'>Accept</button>";
                        echo "<a href=\"../model/b2bRejectLogic.php?b2bid=". urlencode(base64_encode($row['B2B_id'])) . "\" class='btn btn-danger'>Reject</button>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</body>

</html>