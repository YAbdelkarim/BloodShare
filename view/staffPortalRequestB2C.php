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
$id = $_SESSION['id'];

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

    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th,
        .table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .table td:last-child {
            white-space: nowrap;
        }
        .table .action {
            text-align: center;
        }
        .table .action button {
            padding: 5px 10px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .table .action button.approve {
            background-color: #8BC34A;
            color: #fff;
        }
        .table .action button.reject {
            background-color: #FF5722;
            color: #fff;
        }
    </style>
</head>

<body>

    <section class="container" style="margin-top:6%;">
        <h1 style="text-align: center;">Inventory</h1>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Blood Group</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $cwd = getcwd();
                        $exec = exec("sudo $cwd/../bash/getByPossID.sh $id 2>&1");
                        $blood_bags = json_decode($exec, true);
                        
                        $bloodGroups = array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-');
                        foreach ($bloodGroups as $bloodGroup) {
                            $quantity = 0;
                            foreach ($blood_bags as $blood_bag) {
                                if ($blood_bag['bloodType'] == $bloodGroup) {
                                    $quantity++;
                                }
                            }
                    ?>
                        <tr>
                            <td><?php echo $bloodGroup; ?></td>
                            <td><?php echo $quantity; ?></td>
                            <td class="action">
                                <a href="../model/b2cRequestLogic.php?bg='<?php echo base64_encode($bloodGroup); ?>'" class="btn btn-success" >Request</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>

</body>

</html>