<?php
include_once('../core/init.php');

session_start();

unset($_SESSION['page']);
$page = 'bloodbank';
$_SESSION['page'] = $page;
include 'nav.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link rel="stylesheet" href="../assets/css/register.css" />
  <link rel="stylesheet" href="../assets/css/nav.css" />
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <!-- <style>
        .container {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
        }

        .container > div {
            margin-right: 10px;
        }

        .editable-field {
            display: none;
            width: 100%;
        }

        .edit-button {
            padding: 5px 10px;
        }
    </style> -->
    <style>
      .container {

}
    </style>
</head>

<body>
  <section class="container">
    <header>Edit blood bag status</header>
    <div class="form">
      <form action="../model/updateStatusBlockchain.php" method="POST">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="bag-id">Blood Bag ID:</label>
              <input type="text" name="bloodbag_id" id="bag-id" list="bag-id-list" class="form-control" required />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="status">Status:</label>
              <select id="status" name="status" class="form-control">
                <option value="laboratoy">In Lab</option>
                <option value="stored">Stored</option>
                <option value="corrupted">Corrupted</option>
                <option value="consumed">Consumed</option>
                <option value="expired">Expired</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 offset-md-3 text-center">
            <button id="save-button" type="submit" class="btn btn-success">Save</button>
          </div>
        </div>
      </form>
    </div>
    <?php
  $id = $_SESSION['id'];
  $cwd = getcwd();
  $exec = exec("sudo $cwd/../bash/getByPossID.sh $id 2>&1");
  $blood_bags = json_decode($exec, true);
  ?>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Blood Bag ID</th>
          <th scope="col">Donor ID</th>
          <th scope="col">Blood Group</th>
          <th scope="col">Donation Date</th>
          <th scope="col">Expiry Date</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($blood_bags as $blood_bag) {
        ?>
          <tr>
            <td>
              <?php echo $blood_bag['id']; ?>
            </td>
            <td>
              <?php echo $blood_bag['donorID']; ?>
            </td>
            <td>
              <?php echo $blood_bag['bloodType']; ?>
            </td>
            <td>
              <?php echo $blood_bag['donationDate']; ?>
            </td>
            <td>
              <?php echo $blood_bag['expiration']; ?>
            </td>
            <td>
              <?php echo $blood_bag['status']; ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </section>
  



</body>

</html>