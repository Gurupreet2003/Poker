function goFullScreen(element) {
  if (element.requestFullscreen) {
    element.requestFullscreen();
  } else {
    alert("Full-screen failed!");
  }
}

let bet_multiple = [
  10, 20, 50, 100, 150, 200, 250, 500, 550, 600, 650, 700, 750, 786, 800, 850,
  900, 1000,
];

class Main {
  /**
   * Constructor
   */
  constructor() {
    // set html elements
    this.btn_dsc_bet = document.querySelector("#btn-dsc-bet");
    this.bet_ammount_input = document.querySelector("#bet-ammount-input");
    this.btn_inc_bet = document.querySelector("#btn-inc-bet");
    this.bet_btn = document.querySelector("#bet-btn");
    this.pack_btn = document.querySelector("#pack-btn");
  }
  /**
   * This functions sets table UI for user input
   */
  setTableUI() {
    // full screen UI
    // document.querySelector("#full-screen").addEventListener("click", () => {
    //   goFullScreen(document.querySelector("main"));
    // });

    // UI btn animation & event
    // inc bet btn
    this.btn_inc_bet.addEventListener("click", (e) => {
      this.UI_btn_Anim(e);
      this.incBet();
    });
    this.btn_inc_bet.addEventListener("touchstart", (e) => {
      this.UI_btn_Anim(e);
      this.incBet();
    });
    // dsc bet btn
    this.btn_dsc_bet.addEventListener("click", (e) => {
      this.UI_btn_Anim(e);
      this.dscBet();
    });
    this.btn_dsc_bet.addEventListener("touchstart", (e) => {
      this.UI_btn_Anim(e);
      this.dscBet();
    });
    // bet btn
    this.bet_btn.addEventListener("click", (e) => {
      this.UI_btn_Anim(e);
      this.submitBet();
    });
    this.bet_btn.addEventListener("touchstart", (e) => {
      this.UI_btn_Anim(e);
      this.submitBet();
    });
    // pack btn
    this.pack_btn.addEventListener("click", (e) => {
      this.UI_btn_Anim(e);
    });
    this.pack_btn.addEventListener("touchstart", (e) => {
      this.UI_btn_Anim(e);
    });
    this.bet_ammount_input.addEventListener("input", (e) => {
      setTimeout(() => this.validateBetInput(), 3000);
    });
  }
  /**
   * Submits the bet to server
   */
  submitBet() {
    this.validateBetInput();
    let betVal = this.bet_ammount_input.value;
    document.querySelector("form.submit-bet input").value = betVal;
    document.querySelector("form.submit-bet").submit();
  }
  /**
   * Validate bet input box value
   */
  validateBetInput() {
    if (parseInt(this.bet_ammount_input.value) > player_data.poker_chips) {
      this.bet_ammount_input.value = this.bet_ammount_input.value % 10;
    }
    if (parseInt(this.bet_ammount_input.value) < player_data.last_bet) {
      this.bet_ammount_input.value = player_data.last_bet;
    }
  }
  /**
   * Increase value of Bet input box
   * @returns {null}
   */
  incBet() {
    let currVal = parseInt(this.bet_ammount_input.value);
    // exception
    if (currVal >= player_data.poker_chips) {
      this.bet_ammount_input.value = player_data.poker_chips;
      alert("Insufficient Poker chips");
      return;
    }

    let mltplyr = Math.floor(currVal / 1000);
    currVal %= 1000;
    for (let i = 0; i < bet_multiple.length; i++) {
      if (currVal < bet_multiple[i]) {
        currVal = bet_multiple[i];
        break;
      }
    }
    currVal = currVal + 1000 * mltplyr;
    this.bet_ammount_input.value = currVal;
  }
  /**
   * Decrease value of bet input box
   * @returns {null}
   */
  dscBet() {
    let currVal = parseInt(this.bet_ammount_input.value);
    if (currVal <= player_data.last_bet) {
      currVal = 0;
      return;
    }

    let temp_val = currVal % 1000;
    for (let i = 2; i < bet_multiple.length; i++) {
      if (temp_val < bet_multiple[i]) {
        temp_val = bet_multiple[i - 2];
        break;
      }
    }
    currVal -= currVal - temp_val;
    this.bet_ammount_input.value = currVal;
  }

  /**
   * Handles Animatoin of user interface buttons
   */
  UI_btn_Anim(target) {
    target = target.srcElement;
    target.style.backgroundColor = "#fff";
    target.style.color = "#000";
    setTimeout(() => {
      target.style.backgroundColor = "";
      target.style.color = "";
    }, 100);
  }
}

let main = new Main();
main.setTableUI();
