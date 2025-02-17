<?php
include "./db_connect.php";

session_start();

$user_id = $_SESSION['user_id'];
$reg_type = $_SESSION['reg_type'];
$game_id = $_SESSION['game_id'];

$conn = connect();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Table</title>
  <link rel="stylesheet" href="./table.css" />
</head>

<body>
  <!-- <div class="black-screen">
    <button id="full-screen">Full Screen</button>
  </div> -->
  <main>
    <div class="opponents-record-container">
      <?php
      $sql_query = "SELECT * FROM `game_table` WHERE game_id = $game_id";
      $records = $conn->query($sql_query);
      for ($i = 0; $i < $records->num_rows; $i++) {
        $row = $records->fetch_assoc();

        // skip player (user of this table)
        if ($row["user_id"] == $user_id) continue;

        $html = "
        <table class=\"opponent-table\" id=\"{$row["user_id"]}\">
          <thead> 
            <tr>
              <th colspan=\"2\">{$row["name"]}</th>
            </tr>
          </thead>
          <tbody>
            <tr class=\"chips\">
              <td>Chips :</td>
              <td>{$row["poker_chips"]}</td>
            </tr>
            <tr class=game_won\">
              <td>Game Won :</td>
              <td>{$row["game_won"]}</td>
            </tr>
            ADMIN_CONTROL
          </tbody>
        </table>
        ";
        if ($reg_type == "admin") {
          $replace_str = "
            <tr class=\"win-btn\">
              <td colspan=\"2\">
                <form action=\"./set_winner.php\" method=\"post\">
                  <input type=\"hidden\" name=\"winner\" value=\"{$row["user_id"]}\">
                  <button type=\"submit\">Set Winner</button>
                </form>
              </td>
            </tr>";
          $html = str_replace("ADMIN_CONTROL", $replace_str, $html);
        } else {
          $html = str_replace("ADMIN_CONTROL", "", $html);
        }
        echo $html;
      }
      ?>
    </div>
    <div class="amount-ontable">
      Money On table :
      <span id="money-on-table">
        <?php
        $sql_query = "SELECT chips_on_table FROM `game_list` WHERE game_id = $game_id";
        $records = $conn->query($sql_query);
        $chips = $records->fetch_assoc();
        echo $chips["chips_on_table"];
        ?>
      </span>
    </div>
    <div class="config_info">
      <div class="game_id">
        <?php
        echo $game_id;
        ?>
      </div>
      <div class="server_ip">
        <?php
        echo $_SERVER['SERVER_ADDR'];
        ?>
      </div>
    </div>
    <div class="my-record">
      <?php
      if($reg_type == "admin")
      echo "
      <form action=\"./set_winner.php\" method=\"post\">
        <input type=\"hidden\" name=\"winner\" value=\"{$user_id}\">
        <button type=\"submit\">Set Winner</button>
      </form>";

      $sql_query = "SELECT `poker_chips`, `game_won`, `name`, `last_bet` FROM `game_table`, `game_list` WHERE user_id = '$user_id'";
      $records = $conn->query($sql_query);
      $player_dat = $records->fetch_assoc();

      $formatted_chip_count = number_format($player_dat["poker_chips"]);
      echo "
      <table class=\"my-record-display\">
        <thead>
          <tr>
            <th colspan=\"2\"><button class=\"refresh-btn\" onclick=\"location.reload()\">Refresh</button>
          </tr>
          <tr>
            <th colspan=\"2\">{$player_dat["name"]}</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Poker Chips:</td>
            <td id=\"current-amount\">{$formatted_chip_count}</td>
          </tr>
          <tr>
            <td>Game Won:</td>
            <td id=\"total-bet\">{$player_dat["game_won"]}</td>
          </tr>
        </tbody>
      </table>
      ";
      ?>
      <div class="user-control">
        <div class="bet-input">
          <button id="btn-dsc-bet">-</button>
          <?php
            echo "
            <input min=\"{$player_dat["last_bet"]}\" max=\"10000000\" type=\"number\" id=\"bet-ammount-input\" value=\"0\" />
            ";
          ?>
          <button id="btn-inc-bet">+</button>
        </div>
        <button class="UI-btn" id="bet-btn">Bet</button>
        <button class="UI-btn" id="pack-btn">Pack</button>
      </div>
    </div>
  </main>
</body>
<form action="./submit_bet.php" method="post" class="submit-bet">
  <input type="hidden" name="bet" value="0">
</form>
<?php
$player_dat = json_encode($player_dat);
echo "
<script>
let player_data = {$player_dat};
</script>
";
?>
<script type="module" src="./table.js"></script>

</html>