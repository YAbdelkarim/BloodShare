<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

$db_user = 'root';
$db_pass = '';
$db_name = 'final_bloodshare';

$db = new PDO('mysql:host=localhost;dbname='.$db_name.';charset=utf8',$db_user,$db_pass);


$db -> setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
$db -> setAttribute(PDO:: MYSQL_ATTR_USE_BUFFERED_QUERY, true);
$db -> setAttribute(PDO:: ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

define ('APP_NAME' , 'BloodShare');