<?php
session_set_cookie_params(2400); // set the session cookie lifetime to 2 seconds
session_start(); // start the session

$_SESSION['page'] = 'home'; // set a session variable
if (isset($_SESSION['expire_time']) && time() > $_SESSION['expire_time']) {
  session_unset(); // unset all session variables
  session_destroy(); // destroy the session
  header('Location:../index.php'); // redirect to the login page
  exit;
} else {
  $_SESSION['expire_time'] = time() + 2400; // set the expiration time to 2 seconds from now
}
unset($_SESSION['page']);
$page = 'home';
$_SESSION['page'] = $page;
$user_id = $_SESSION['user_id'];

//to check if user is logged in
if ($_SESSION['logged_in']==false){
  header("Location: login.php");  

}
$last_donation_date = $_SESSION['donation_date']; // replace with the input date variable
if (!is_null($last_donation_date)){
  $today = new DateTime(); // create a new DateTime object for today's date
  $last_donation = new DateTime($last_donation_date); // create a new DateTime object for the last donation date
  $interval = $today->diff($last_donation); // calculate the difference between today and the last donation date
  $days_since_last_donation = $interval->format('%a'); // format the difference as the number of days
  // echo $days_since_last_donation;
}
include 'nav.php';
// if (isset($_SESSION['page'])) {
//   echo 'Welcome back, ' . $_SESSION['page'];
// } else {
//   echo 'Please log in.';
// }


// if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
// header('Location:../index.php');
//   exit;
// }
?>

<?php
if (isset($_GET['msg']) && $_GET['msg'] == 'success') {
  $alert_message = 'Request successfully sent! Thank you.';
  echo '<script>window.onload=function(){alert("' . $alert_message . '");};</script>';
}
if (isset($_GET['msg']) && $_GET['msg'] == 'confirmed') {
  $alert_message = 'Confirmed successfully, please check for admin acceptence message in notifications.';
  echo '<script>window.onload=function(){alert("' . $alert_message . '");};</script>';
}

$sql = "SELECT request_id, status FROM donation_requests WHERE donor_id = '$user_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if (!empty($row['status'])) {
  $_SESSION['request_id'] = $row['request_id'];
  $status = $row['status'];
} else $status = '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <!--  -->
  <link rel="stylesheet" href="../assets/css/home.css">

  <script src="../assets/js/home.js"></script>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {
      'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Month', 'Donations'],
        ['12', 900],
        ['1', 1600],
        ['2', 1170],
        ['3', 2007],
        ['4', 1030],
        ['5', 1000],
        ['6', 1400],
        ['7', 1000]
      ]);

      var options = {
        curveType: 'function',
        legend: 'none',
        lineWidth: 4,
        baselineColor: 'transparent',
        backgroundColor: 'transparent',
        colors: ['white', 'blue', 'red', 'green', 'yellow', 'gray'],
        vAxis: {
          gridlines: {
            color: 'transparent'
          },
          textStyle: {
            color: 'transparent'
          }
        },
        hAxis: {
          gridlines: {
            color: 'transparent'
          },
          textStyle: {
            color: 'transparent'
          }
        }
      };

      var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

      chart.draw(data, options);
    }
  </script>


  <title>Document</title>
</head>

<body style="overflow-x: hidden;">


  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.0/chart.js"></script>
  <section class="moving-background">
    <div class="container">
      <?php if ($status == 'pending') { ?>
        <h2 class="mainTitle">Your current request <br>
          is pending.</h2>
      <?php } else if ($status == 'accepted') { ?>
        <h2 class="mainTitle">Click this button when donation <br>
          is complete.</h2>
          <a href="../model/userConfirmLogic.php" class="btn-get-started donate">Confirm</a>
        <?php }else if ($status == 'confirm') { ?>
        <h2 class="mainTitle"> Waiting for admin confirmation. <br>
          Please wait for our response.</h2>
        <?php }else{ ?>
        <h2 class="mainTitle">Thank you being an <br>
          active member.</h2>

        <a href="<?php if(!isset($days_since_last_donation) || $days_since_last_donation >= 56) { ?>../view/quest.php<?php } else { ?>javascript:void(0);" onclick="alert('You must wait at least <?php if(isset($days_since_last_donation)) echo 56 - $days_since_last_donation; ?> days before donating blood.');" <?php } ?>" class="btn-get-started donate">Donate Now</a>
        <?php } ?>
    </div>
  </section>



  <!-- ======= Clients Section ======= -->
  <section id="clients" class="clients section-bg sec">
    <div class="container">

      <div class="row">

        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
          <img src="../assets/img/Arab_Academy_for_Science,_Technology_and_Maritime_Transport_Logo.png" class="img-fluid" alt="">
        </div>

        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
          <img src="../assets/img/Sustainable_Development_Goal_3.png" class="img-fluid" alt="">
        </div>

        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
          <img src="../assets/img/Sustainable_Development_Goal_9.png" class="img-fluid" alt="">
        </div>

        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
          <img src="../assets/img/Sustainable_Development_Goal_11.png" class="img-fluid" alt="">
        </div>


        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
          <img src="../assets/img/Sustainable_Development_Goal_16.png" class="img-fluid" alt="">
        </div>

        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
          <img src="../assets/img/Sustainable_Development_Goal_17.png" class="img-fluid" alt="">
        </div>


      </div>

    </div>
  </section><!-- End Cliens Section -->




  <!-- <div class="row" style="height: 100px; background-color:rgba(69, 5, 38, 0.9);" ></div> -->

  <section>
    <div class="row">
      <?php
      if (!is_null($last_donation_date)) {
      ?>
        <div class="counter" style="background-color: #fff; ">
          <span class="count">0</span>
          <span class="label">Days since last donation</span>
        </div>
      <div class="cont" style="display: flex; justify-content: center; padding: 2%;">
        <?php if (($status == '' || $status == 'rejected' || $status == 'complete') && $days_since_last_donation >= 56) { ?>
          <a href="quest.php" class="btn-get-started donatePurple">Donate Now</a>
        <?php } else if($days_since_last_donation <= 56){ ?>
          <span class="label">Thank you for your donation but you'll have to wait at least <?php echo 56 - $days_since_last_donation; ?> days before donating once again.</span>
        <?php } }?>
      </div>
    </div>
  </section>

  <div class="sections" style="background-color:rgba(69, 5, 38, 0.9); padding:5%;">
    <div class="row">

      <div class="col-sm-4 my-auto">
        <h1 style="color:aliceblue; padding-left:4%;">Number of donors in previous weeks</h1>
      </div>


      <div class="col-sm-8">
        <div id="curve_chart" style="width: 120%; height: 500px"></div>
      </div>

      <br><br>

      <!-- ======= Locations near you ======= -->
    </div>
    <div class="container-fluid" id="loc">
      <div class="row">

        <div class="col-sm-7">

          <iframe class="float-right" src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d65709.45135323692!2d31.25860311138078!3d30.053274514329235!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sblood%20donation!5e0!3m2!1sen!2seg!4v1684274885654!5m2!1sen!2seg" width="100%" height="300px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="col-sm-5 my-auto">
          <h1 style="color:aliceblue">Find location of blood donation centers near you</h1>
        </div>
      </div>
    </div>


    <!-- ======= End Locations near you ======= -->

    <div>

    </div>



  </div>




  <script>
    const countEl = document.querySelector('.count');
    const target = <?php echo $days_since_last_donation ?>; // replace with the actual number of donations
    const duration = 2000; // duration in milliseconds

    const countUp = (timestamp) => {
      const progress = Math.min((timestamp - startTime) / duration, 1);
      countEl.innerText = Math.floor(progress * target);
      if (progress < 1) {
        requestAnimationFrame(countUp);
      }
    };

    const startTime = performance.now();
    requestAnimationFrame(countUp);
  </script>
</body>

</html>