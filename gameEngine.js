class gameEngine {
  constructor() {}
  updateGame() {
    fetch("update_game.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        game_id: gameId,
        update_info: updateInfo,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.status === "success") {
          console.log(data.message);
          // Update UI based on successful response
        } else {
          console.error(data.message);
          // Handle errors
        }
      })
      .catch((error) => console.error("Error:", error));
  }
}