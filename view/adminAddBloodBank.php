<?php session_start();
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

    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

  </head>
  
  <body>
    <section class="container" style="margin-top:10%;">
      <header>Registration Form</header>
      <form action="../model/adminAdddBloodBankLogic.php" method="post" class="form">

        <div class="column">
          <div class="input-box">
            <label>Name</label>
            <input type="text" placeholder="Enter first name"  name="name" required />
          </div>
          <div class="input-box">
            <label>Password</label>
            <input type="text" placeholder="Enter first name"  name="password" required />
          </div>
        </div>

        <div class="column">
          <div class="input-box">
            <label>Email Address</label>
            <input type="text" placeholder="Enter email address"  name="email" required/>
          </div>

          <div class="input-box">
            <label>Phone Number</label>
            <input type="text" placeholder="Enter Password" required name="phone" />
          </div>
        </div>
</div>
       
        <div class="input-box address column">
          <div class="input-box">
          <label>Address</label>
          <input type="text" placeholder="Enter street address" name="address" required />
        </div>
        </div>
          </div>   
        </div>

        <button type="submit">Submit</button>
        </form>
    </section>
 
  </body>
</html>