function updateClock() {
  let current_time = new Date();
  let hour = current_time.getHours();
  let minutes = current_time.getMinutes();
  let seconds = current_time.getSeconds();
 
  function mechanism_of_clock() {
   
    seconds++;

    if (seconds>= 60) {
      minutes++;
      seconds= 0;
    }

    if (minutes >= 60) {
      hour++;
      minutes = 0;
    }

    if (hour > 23) {
      hour = 0;
    }
 let seconds_display = String(seconds).padStart(2, '0');
  let minutes_display = String(minutes).padStart(2, '0');
  let hour_display = String(hour).padStart(2, '0');
    let html_clock = `${hour_display}:${minutes_display}:${seconds_display}`;
    let html_element = document.getElementById('clock');
    html_element.textContent = html_clock;

  }

  setInterval(mechanism_of_clock, 1000);

}
updateClock();
setInterval(updateClock, 2 * (60 * 1000));