<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $surgery = $_POST["surgery"];
  $hiv = $_POST["hiv"];
  $cancer = $_POST["cancer"];
  $drugs = $_POST["drugs"];
  $vaccinations = $_POST["vaccinations"];
  $symptoms = $_POST["symptoms"];
  $medications = $_POST["medications"];
  $donation = $_POST["donation"];


  // Check if all responses are "no"
  if ($surgery == "no" && $hiv == "no" && $cancer == "no" && $drugs == "no" && $vaccinations == "no" && $symptoms == "no" && $medications == "no" && $donation == "no") {
    header("Location: ../view/donationRes.php");
    
    exit;
  }
  else{
    echo "Donation Failed. Please go back and review the form.";
  }

}
?>