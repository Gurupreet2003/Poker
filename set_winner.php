<?php
include "./db_connect.php";

$conn = connect();

session_start();

$user_id = $_POST["winner"];

$sql_query = "SELECT chips_on_table FROM game_list WHERE game_id = {$_SESSION["game_id"]};";
$record = $conn->query($sql_query);
$record = $record->fetch_assoc();
$chips_on_table = $record["chips_on_table"];

$sql_query = "UPDATE game_table SET game_won = game_won + 1 WHERE user_id = '$user_id';";
$sql_query .= "UPDATE game_table SET poker_chips = poker_chips + $chips_on_table WHERE user_id = '$user_id';";
$sql_query .= "UPDATE game_list SET chips_on_table = 0 WHERE game_id = {$_SESSION["game_id"]};";

if(mysqli_multi_query($conn, $sql_query) === TRUE) {
  header("location:table.php");
} else {
  die("ERROR WRITING DATA");
}
?>