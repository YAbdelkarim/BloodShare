<?php session_start();
unset($_SESSION['page']);
$page = 'login';
$_SESSION['page'] = $page;
include 'nav.php';


/*/////////////HOSPITAL CHECK//////////////*/

$db_host = 'localhost';
  $db_username = 'root';
  $db_password = '';
  $db_name = 'final_bloodshare';
  
  // create a database connection
  $conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

  // retrieve the user's first name from the database
  $sql = "SELECT donation_center_id, donation_center_location FROM donation_center";
  $result = mysqli_query($conn, $sql);
  
  // create an array to store the location options
  $location_options = array();
  
  if (mysqli_num_rows($result) > 0) {
    // loop through the result set and store the location options in the array
    while ($row = mysqli_fetch_assoc($result)) {
      $location_options[] = $row['donation_center_location'];
      $location_ids[] = $row['donation_center_id'];
    }
  }
  

// close the database connection
mysqli_close($conn);


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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" crossorigin="anonymous" referrerpolicy="no-referrer"/>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js" crossorigin="anonymous" referrerpolicy="no-referrer" ></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-ZG3lIyj5SpXxUs2dAOMq1q/4j7nztJm8E7yQw5jL6T15s2J5yGpD+g7DyX0l9lC/7x8XrIcKzVYlTYY9Jz+OzA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script>
  $(function() {
    // Get the current date in the desired format
    var currentDate = new Date().toLocaleDateString("en-US", {year: 'numeric', month: '2-digit', day: '2-digit'});
    
    // Set the value of the input field to the current date
    $('#datepicker').val(currentDate);

    // Initialize the datepicker with any additional options
    $('#datepicker').datepicker({
      beforeShowDay: function (d) {
        var day = d.getDay();
        return [day !=  4 && day != 5 && day != 7 && day != 6];
      },
    });
  });
</script>



            <script>
              $(function() {
  $('#timepicker').timepicker({
    timeFormat: 'h:mm p',
    interval: 30,
    minTime: '10:00am',
    maxTime: '8:00pm',
    defaultTime: '11:00am',
    startTime: '10:00am',
    dynamic: false,
    dropdown: true,
    scrollbar: true
  });
});
            </script>
  <style>

  </style>
  </head>
  
  <body>
    
  <section class="container" style="margin-top:10%; padding:3%;">
  <header>Donation Reservation</header>
  <form action="../model/donationResLogic.php" method="post"  class="form">
    <div class="input-box" style="display: flex;">
      <div style="width: 50%;">
        <label>Donation date</label>
        <input type="text" id="datepicker" placeholder="Click to select a date"  name="donation_date"/>
      </div>
      <div style="width: 50%;">
        <label>Donation Time</label>
        <br>
        <input type="text" id="timepicker" class="select-box" placeholder="Click to select a time"  name="donation_time">
      </div>
    </div>
    <br>
    <label>Donation Place</label>
    <br>
    <select name="location" id="location" class="select-box" required> 
      <option value="">Select a location</option>
      <?php foreach ($location_options as $location) { ?>
        <option value="<?php echo $location; ?>"><?php echo $location; ?></option>
      <?php } ?>
    </select>
    <br>
    <br>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</section>
   
  </body>
</html> 