<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bloodbag_id = $_POST['bloodbag_id'];
    $status = $_POST['status'];
}
$cwd = getcwd();
$exec = exec("sudo $cwd/../bash/updateStatus.sh $bloodbag_id $status 2>&1");

header('Location: ../view/bloodbankEditStatus.php?msg=success');

?>