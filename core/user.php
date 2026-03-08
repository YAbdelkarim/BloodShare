<?php

class user{

  private $conn;
  private $table = 'user';

  //post properties
  public $id;
  public $fname;
  public $lname;
  public $email;
  public $password;
  public $gender;
  public $age;
  public $address;
  public $city;
  public $bloodgroup;
  public $lastDonation;

  //constructor with db conn

  public function __construct($db)
  {
    $this -> conn = $db;
  }

    //getting data from database
    public function read(){
      $query = 'SELECT * FROM'.' '.$this->table;
  
      $stmt = $this->conn->prepare($query);
  
      $stmt -> execute();
  
      return $stmt;
  }
  

}

/*
    user.id,
    user.fname,
    user.lname,
    user.email,
    user.password,
    user.gender,
    user.age,
    user.address,
    user.city,
    user.bloodgroup
    user.lastDonation   
    */