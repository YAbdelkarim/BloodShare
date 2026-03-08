<?php session_start();
unset($_SESSION['page']);
$page = 'login';
$_SESSION['page'] = $page;
include 'nav.php';

// if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
//   // redirect to the protected page
//   header('Location: home.php');
//   exit;
// }


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

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">


    <link rel="stylesheet" href="../assets/css/register.css" />
    <link rel="stylesheet" href="../assets/css/nav.css" />

    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

  </head>
  
  <body>
    
    <section class="container" style="margin-top:10%; padding:3%;">
      <header>Questionnaire</header>
      <form action="../model/questLogic.php" method="post" class="form">

      <div class="form-group">
        <label for="surgery">Have you had any surgery within the past year?</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="surgery" id="surgery_yes" value="yes" required>
          <label class="form-check-label" for="surgery_yes">
            Yes
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="surgery" id="surgery_no" value="no" required>
          <label class="form-check-label" for="surgery_no">
            No
          </label>
        </div>
      </div>
      <div class="form-group">
        <label for="hiv">Have you ever had a positive test for HIV/AIDS or hepatitis?</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="hiv" id="hiv_yes" value="yes" required>
          <label class="form-check-label" for="hiv_yes">
            Yes
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="hiv" id="hiv_no" value="no" required>
          <label class="form-check-label" for="hiv_no">
            No
          </label>
        </div>
      </div>
      <div class="form-group">
        <label for="cancer">Have you ever been diagnosed with cancer?</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="cancer" id="cancer_yes" value="yes" required>
          <label class="form-check-label" for="cancer_yes">
            Yes
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="cancer" id="cancer_no" value="no" required>
          <label class="form-check-label" for="cancer_no">
            No
          </label>
        </div>
      </div>
      <div class="form-group">
        <label for="drugs">Have you ever injected drugs or used illegal drugs?</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="drugs" id="drugs_yes" value="yes" required>
          <label class="form-check-label" for="drugs_yes">
            Yes
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="drugs" id="drugs_no" value="no" required>
          <label class="form-check-label" for="drugs_no">
            No
          </label>
        </div>
      </div>
      <div class="form-group">
        <label for="vaccinations">Have you had any recent vaccinations or received any immunizations?</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="vaccinations" id="vaccinations_yes" value="yes" required>
          <label class="form-check-label" for="vaccinations_yes">
            Yes
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="vaccinations" id="vaccinations_no" value="no" required>
          <label class="form-check-label" for="vaccinations_no">
            No
          </label>
        </div>
      </div>
      <div class="form-group">
        <label for="symptoms">Have you had a fever, cough, or other symptoms of illness within the past two weeks?</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="symptoms" id="symptoms_yes" value="yes" required>
          <label class="form-check-label" for="symptoms_yes">
            Yes
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="symptoms" id="symptoms_no" value="no" required>
          <label class="form-check-label" for="symptoms_no">
            No
          </label>
        </div>
      </div>
      <div class="form-group">
        <label for="medications">Are you currently taking any prescription medications?</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="medications" id="medications_yes" value="yes" required>
          <label class="form-check-label" for="medications_yes">
            Yes
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="medications" id="medications_no" value="no" required>
          <label class="form-check-label" for="medications_no">
            No
          </label>
        </div>
      </div>
      <div class="form-group">
        <label for="donation">Have you donated blood within the past eight weeks?</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="donation" id="donation_yes" value="yes" required>
          <label class="form-check-label" for="donation_yes">
            Yes
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="donation" id="donation_no" value="no" required>
          <label class="form-check-label" for="donation_no">
            No
          </label>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </section>
  </body>
</html> 