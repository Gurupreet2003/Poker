<?php
include "./db_connect.php";
$conn = connect();

$reg_type = $_POST['reg_type'];

if ($reg_type == "admin") {
  $name = $_POST["name"];
  $chip_per_person = $_POST["chip_per_person"];

  $user_id = $name . rand(1000, 9999);

  $game_id = rand(100, 1000);

  $sql_query = "INSERT INTO game_list(`game_id`, `chip_per_person`, `admin`) VALUES($game_id, $chip_per_person, '$user_id');";
  $sql_query .= "INSERT INTO game_table(`game_id`, `user_id`, `poker_chips`, `name`) VALUES($game_id, '$user_id', $chip_per_person, '$name');";

  session_start();
  $_SESSION['user_id'] = $user_id;
  $_SESSION['reg_type'] = "admin";
  $_SESSION['game_id'] = $game_id;

  if (mysqli_multi_query($conn, $sql_query) === TRUE) {
    header("location: table.php");
  } else {
    echo "Error: " . $sql_query . "<br>" . $conn->error;
  }
  // 
  // 
  // 
} else if ($reg_type == "user") {
  $name = $_POST["name"];
  $game_id = $_POST["server_id"];

  $user_id = $name . rand(1000, 9999);

  // check server
  $sql_query = "SELECT `chip_per_person` FROM game_list WHERE `game_id` = $game_id";
  $result = $conn->query($sql_query);

  if ($result->num_rows > 0) {
    $result = $result->fetch_assoc();
    $chip_per_person = $result['chip_per_person'];
  } else {
    die('ERROR, Server not found');
  }

  session_start();
  $_SESSION['user_id'] = $user_id;
  $_SESSION['reg_type'] = "user";
  $_SESSION['game_id'] = $game_id;

  // check user exsist;
  $sql_query = "SELECT user_id FROM game_table WHERE `name` = '$name'";
  $record = $conn->query($sql_query);
  
  if($record->num_rows > 0) {
    $record = $record->fetch_assoc();
    $user_id = $record["user_id"];
    $_SESSION['user_id'] = $user_id;
    
    $sql_query = "SELECT `admin` FROM game_list WHERE `admin` = '$user_id'";
    if($conn->query($sql_query)->num_rows > 0) $_SESSION['reg_type'] = "admin";
    header("location: table.php");
    die();
  }

  $sql_query = "INSERT INTO game_table(`game_id`, `user_id`, `poker_chips`, `name`) VALUES($game_id, '$user_id', $chip_per_person, '$name')";
  if (mysqli_multi_query($conn, $sql_query) === TRUE) {
    header("location: table.php");
  } else {
    echo "Error: " . $sql_query . "<br>" . $conn->error;
  }
}
