<?php


ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

session_start();
include_once('../core/init.php');


$donor_id = base64_decode(urldecode($_GET['did']));
$blood_group = $_POST['bloodgroup'];

try {


    // Prepare the SQL statement to update the bloodstatus column
    $stmt = $db->prepare("UPDATE user SET bloodgroup = :blood_group WHERE id = :donor_id");

    // Bind the transaction_id and status values to the prepared statement parameters
    $stmt->bindParam(':donor_id', $donor_id, PDO::PARAM_INT);
    $stmt->bindParam(':blood_group', $blood_group, PDO::PARAM_STR);



    // Execute the SQL statement
    if ($stmt->execute()) {
        // Redirect to a success page after the alert is dismissed
        echo '<script>window.location.href = "../view/staffPortal.php?msg=successbg";</script>';
    } else {
        echo "something gone wrong!";
    }

} catch (PDOException $e) {
    // Output an error message
    echo "Status update failed: " . $e->getMessage();
}
