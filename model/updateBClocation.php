<?php
include_once('../core/init.php');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);


// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the necessary parameters are set
    if (isset($_POST['donation_center_id']) && isset($_POST['donation_center_location'])) {
        $donation_center_id = $_POST['donation_center_id'];
        $donation_center_location = $_POST['donation_center_location'];
        echo $donation_center_location;
        echo $donation_center_id;
        // Update the location in the database
        $stmt = $db->prepare("UPDATE donation_center SET donation_center_location = :location WHERE donation_center_id = :id");
        $stmt->bindParam(":location", $donation_center_location);
        $stmt->bindParam(":id", $donation_center_id);
        $stmt->execute();

        // Redirect back to the page to show updated data
     header('Location: ../view/bloodbankPortal.php');
    exit();
    }
}
?>
