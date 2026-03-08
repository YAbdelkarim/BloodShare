<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

include_once('../core/init.php');


$secret_key = "mysecretkey";
$encoded_id = urldecode($_GET['id']);
$decoded_id = base64_decode($encoded_id);
list($encrypted_id, $iv) = explode("::", $decoded_id);
$request_id = openssl_decrypt($encrypted_id, "AES-256-CBC", $secret_key, 0, $iv);

if (isset($_GET['msg']) && $_GET['msg'] == 'accept') {
  $status = 'accepted';

  try {


    // Prepare the SQL statement to update the bloodstatus column
    $stmt = $db->prepare("UPDATE donation_requests SET status = :status WHERE request_id = :request_id");

    // Bind the transaction_id and status values to the prepared statement parameters
    $stmt->bindParam(':request_id', $request_id, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);

    // Execute the SQL statement
    if ($stmt->execute()) {
      // Redirect to a success page after the alert is dismissed
      echo '<script>window.location.href = "../view/staffPortal.php?msg=success";</script>';
      exit;
    } else {
      echo "something gone wrong!";

    }


  } catch (PDOException $e) {
    // Output an error message
    echo "Status update failed: " . $e->getMessage();

  }
} else {
  $status = 'rejected';


  try {


    // Prepare the SQL statement to update the bloodstatus column
    $stmt = $db->prepare("UPDATE donation_requests SET status = :status WHERE request_id = :request_id");
    // Bind the transaction_id and status values to the prepared statement parameters
    $stmt->bindParam(':request_id', $request_id, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);

    // Execute the SQL statement
    if ($stmt->execute()) {
      // Redirect to a success page after the alert is dismissed
      echo '<script>window.location.href = "../view/staffPortal.php?msg=fail";</script>';
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

?>