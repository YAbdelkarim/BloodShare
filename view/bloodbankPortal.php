<?php
include_once('../core/init.php');

session_start();
// to check if user is logged in
//if ($_SESSION['logged_in'] == false) {
//    header("Location: login.php");
//}

unset($_SESSION['page']);
$page = 'bloodbank';
$_SESSION['page'] = $page;
$id=$_SESSION['id'];
include 'nav.php';

if (isset($_GET['msg']) && $_GET['msg'] == 'success') {
    echo '<script>alert("You successfully updated the blood group!");</script>';
}

// Retrieve donation centers from the database

$stmt = $db->prepare("SELECT dc.donation_center_name, dc.email, dc.donation_center_location,dc.donation_center_id
                      FROM donation_center dc
                      JOIN blood_bank bc ON dc.blood_bank_id = bc.bloodbank_id WHERE dc.blood_bank_id={$id}");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link rel="stylesheet" href="../assets/css/register.css" />
    <link rel="stylesheet" href="../assets/css/nav.css" />
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <style>
        .editable-field {
            display: none;
            width: 100%;
        }

        .edit-button {
            padding: 5px 10px;
        }
    </style>
</head>

<body>
    <section class="container" style="margin-top:10%;">
        <header>Donation Centers</header>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Donation Center Name</th>
                    <th scope="col">Donation Center Email</th>
                    <th scope="col">Donation Center Location</th>
                    <th scope="col">Change Location</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($rows as $row) { 

                    ?>
                    <tr>
                        <td>
                            <?php echo $row['donation_center_name']; ?>
                        </td>
                        <td>
                            <?php echo $row['email']; ?>
                        </td>
                        <form id="location-form" action="../model/updateBClocation.php" method="post">
                            <input name="donation_center_id" value="<?php echo $row['donation_center_id']; ?>" hidden> </input>
                        <td>
                            <span class="display-field">
                                <?php echo $row['donation_center_location']; ?>
                            </span>
                            <input type="text" name="donation_center_location"class="editable-field"
                                value="<?php echo $row['donation_center_location']; ?>">
                        </td>
                        <td>
                            <button class="save-button" type="submit" style="display: none">Save</button>
                        </form>
                        <button class="edit-button" onclick="toggleEdit(this)">Edit</button>
                    </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>

    <script>
        function toggleEdit(button) {
            var row = button.parentNode.parentNode;
            var displayField = row.querySelector('.display-field');
            var editableField = row.querySelector('.editable-field');
            var editButton = row.querySelector('.edit-button');
            var saveButton = row.querySelector('.save-button');

            displayField.style.display = 'none';
            editableField.style.display = 'block';
            editButton.style.display = 'none';
            saveButton.style.display = 'inline-block';
        }
               
    </script>
<?php
 if (isset($_GET['msg']) && $_GET['msg'] == 'req_success') {
    echo '<script>alert("Request was sent successfully.");</script>';
  }
  echo $id;
  ?>
</body>

</html>
