<?php


ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

session_start();
include_once('../core/init.php');


$request_id = base64_decode(urldecode($_GET['id']));
if (isset($_GET['msg']) && $_GET['msg'] == 'accept') {
    $status = 'complete';


    try {


        // Prepare the SQL statement to update the bloodstatus column
        $stmt = $db->prepare("UPDATE donation_requests SET status = :status WHERE request_id = :request_id");

        // Bind the transaction_id and status values to the prepared statement parameters
        $stmt->bindParam(':request_id', $request_id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);



        // Execute the SQL statement
        if ($stmt->execute()) {
            echo '<script>alert("You successfully updated the status!");</script>';
            // Redirect to a success page after the alert is dismissed
            //echo '<script>window.location.href = "../view/staffPortal.php";</script>';
        } else {
            echo "something gone wrong!";
        }



        $sql = $db->prepare("SELECT dr.donor_id, us.bloodgroup FROM donation_requests dr JOIN user us ON dr.donor_id = us.id WHERE dr.request_id = :request_id");
        $sql->bindParam(':request_id', $request_id, PDO::PARAM_INT);

        // Execute the SQL statement
        if ($sql->execute()) {
            $result = $sql->fetch(PDO::FETCH_ASSOC);
            // Redirect to a success page after the alert is dismissed
            //echo '<script>window.location.href = "../view/staffPortal.php";</script>';
            $donor_id = $result['donor_id'];
            $blood_group = $result['bloodgroup'];
        } else {
            echo "something gone wrong!";
        }
        $today = date("Y-m-d");
        // Prepare the SQL statement to update the bloodstatus column
        $stmt = $db->prepare("UPDATE user SET lastDonation = :today WHERE id = :donor_id");
        // Bind the transaction_id and status values to the prepared statement parameters
        $stmt->bindParam(':donor_id', $donor_id, PDO::PARAM_INT);
        $stmt->bindParam(':today', $today, PDO::PARAM_STR);

        // Execute the SQL statement
        if ($stmt->execute()) {
            header('Location: ../view/staffPortal.php?msg=complete');
            // Redirect to a success page after the alert is dismissed
            //echo '<script>window.location.href = "../view/staffPortal.php";</script>';
        } else {
            echo "something gone wrong!";
        }

        $days_to_add = 42;
        $expiry_date = date("Y-m-d", strtotime("+{$days_to_add} days"));

        $blood_bank_id = $_SESSION['blood_bank_id'];
        $bcstatus = 'laboratory';

        $cwd = getcwd();
        $exec = exec("sudo $cwd/../bash/create.sh $donor_id $blood_bank_id $blood_group $today $expiry_date $bcstatus 2>&1");

    } catch (PDOException $e) {
        // Output an error message
        echo "Status update failed: " . $e->getMessage();
    }
} else {
    echo $request_id;
    $status = 'rejected';


    try {


        // Prepare the SQL statement to update the bloodstatus column
        $stmt = $db->prepare("UPDATE donation_requests SET status = :status WHERE request_id = :request_id");
        // Bind the transaction_id and status values to the prepared statement parameters
        $stmt->bindParam(':request_id', $request_id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);

        // Execute the SQL statement
        if ($stmt->execute()) {
            header('Location: ../view/staffPortal.php?msg=failed');
            exit;
        } else {
            echo "something gone wrong!";
        }
    } catch (PDOException $e) {
        // Output an error message
        echo "Status update failed: " . $e->getMessage();
    }
}
// Output a success message
// echo '<script language="javascript">';
// echo 'alert("Status updated successfully.")';
// echo '</script>';

// Redirect back to the staff portal page after updating all the records
// header("Location: ../view/staffPortal.php");
