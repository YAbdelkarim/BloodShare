<?php session_start();
unset($_SESSION['page']);
$page = 'login';
$_SESSION['page'] = $page;
include 'nav.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />




  <link rel="stylesheet" href="../assets/css/register.css" />
  <link rel="stylesheet" href="../assets/css/nav.css" />
  <link rel="stylesheet" href="../assets/css/details.css" />

  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

</head>

<body>

  <section class="container" style="margin-top:10%;">
    <header>Track your blood dontion</header>
    <div class="container">
      <div class="row no-gutters">
        <div class="col-12 col-md-12 hh-grayBox pt45">
          <div class="row justify-content-between align-items-center" id="order-tracking">
            <div class="order-tracking">
              <span class="is-complete"></span>
              <p>In lab</p>
            </div>
            <div class="order-tracking">
              <span class="is-complete"></span>
              <p>Stored</p>
            </div>
            <div class="order-tracking">
              <span class="is-complete"></span>
              <p>Consumed</p>
            </div>
          </div>
        </div>
      </div>

      <div id="message"></div>
    </div>
  </section>
  <?php

  $blood_bag_id = $_GET['id'];
  $cwd = getcwd();
  $exec = exec("sudo ../bash/query.sh $blood_bag_id 2>&1");
  $blood_bag = json_decode($exec, true);
  $status = $blood_bag['status'];
  ?>
  <script>
    $(document).ready(function() {
      // Fetch the order tracking data from the JSON file
      status = "<?php echo $status; ?>";
      console.log(status);

    // Update the order tracking bar with the new progress steps
    if (status === "laboratory") {
      $("#order-tracking > .order-tracking").eq(0).find(".is-complete").removeClass("is-complete").addClass("is-complete-green");
    } else if (status === "stored") {
      $("#order-tracking > .order-tracking").eq(0).find(".is-complete").removeClass("is-complete").addClass("is-complete-green");
      $("#order-tracking > .order-tracking").eq(1).find(".is-complete").removeClass("is-complete").addClass("is-complete-green");
    } else if (status === "consumed") {
      $("#order-tracking > .order-tracking").eq(0).find(".is-complete").removeClass("is-complete").addClass("is-complete-green");
      $("#order-tracking > .order-tracking").eq(1).find(".is-complete").removeClass("is-complete").addClass("is-complete-green");
      $("#order-tracking > .order-tracking").eq(2).find(".is-complete").removeClass("is-complete").addClass("is-complete-green");
      $("#message").text("You saved a life!");
    }
  });


</script>
  </body>
</html> 