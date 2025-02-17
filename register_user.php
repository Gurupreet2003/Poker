<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./register user.css">
  <title>Document</title>
</head>

<body>
  <?php
  $reg_type = $_POST['reg_type'];
  ?>
  <main>
    <div class="input_cred">
      <?php
      if ($reg_type == "admin") {
        echo '
          <form action="./reg_usr.php" method="post">
            <input type="hidden" name="reg_type" value="'.$reg_type.'">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" placeholder="Name">
            <label for="chip_per_person">Chip per person</label>
            <input max="1000000" type="number" name="chip_per_person" id="chip_per_person" value="1000" placeholder="Chip per person">
            <button type="submit">Enter</button>
          </form>
          ';
      } else if ($reg_type == "user") {
        echo '
        <form action="./reg_usr.php" method="post">
          <input type="hidden" name="reg_type" value="'.$reg_type.'">
          <label for="name">Name</label>
          <input type="text" name="name" id="name" placeholder="Name">
          <label for="server_id">Server ID</label>
          <input type="number" name="server_id" id="server_id" placeholder="Server ID">
          <button type="submit">Enter</button>
        </form>
        ';
      }
      ?>
    </div>
  </main>
</body>
<script src="./register user.js"></script>

</html>