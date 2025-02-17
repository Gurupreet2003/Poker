<?php
include "./db_connect.php";
$conn = connect();

session_start();
// add poker chip to table
$sql_query = "UPDATE game_list SET chips_on_table = chips_on_table + {$_POST["bet"]} WHERE game_id = {$_SESSION["game_id"]};";
$sql_query .= "UPDATE game_list SET last_bet = {$_POST["bet"]} WHERE game_id = {$_SESSION["game_id"]};";
$sql_query .= "UPDATE game_table SET poker_chips = poker_chips - {$_POST["bet"]} WHERE user_id = '{$_SESSION["user_id"]}';";
if(mysqli_multi_query($conn, $sql_query) === TRUE) {
  header("location:table.php");
} else {
  die("ERROR WRITING DATA");
}
?>