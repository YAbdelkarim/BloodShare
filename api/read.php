<?php

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//intializing API
include_once('../core/init.php');

//init user

$user = new user($db);

//query
$result = $user->read();

if ($result !== null) {
    $num = $result->rowCount();
    // rest of the code
} else {
    echo json_encode(array('message' => 'Error reading users.'));
}

//get the row count

$num = $result->rowCount();

//
if ($num>0){

  $user_arr = array();
  $user_arr['data']= array();

  while($row = $result-> fetch(PDO::FETCH_ASSOC)){
    extract($row);
    $user_info = array(
      'id' => $id,
      'fname' => $fname,
      'lname' => $lname,
      'email' => $email,
      'password' => $password,
      'gender' => $gender,
      'age' => $age,
      'address' => $address,
      'city' => $city,
      'blood group' => $bloodgroup,
      'last donation' => $lastDonation

    );
    array_push($user_arr['data'], $user_info);
  }
  echo json_encode($user_arr);

}else{
echo json_encode(array('message' => 'no users found'));
}
