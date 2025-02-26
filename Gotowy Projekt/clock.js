function updateTime(){
  var currentTime = new Date()
  var year = currentTime.getFullYear()
  var month = currentTime.getMonth()
  if (month < 10){
      month = "0" + month
    }
    var day = currentTime.getDate()
    var weekday = currentTime.getDay()
    var hours = currentTime.getHours()
    var minutes = currentTime.getMinutes()
    if (minutes < 10){
      minutes = "0" + minutes
    }
    var weekdays = ['Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Niedziela'];
    var weekdayname = weekdays[weekday];
    document.querySelector('#date').textContent = (weekdayname+", "+day+'/'+month+'/'+year);
    document.querySelector('#hours').textContent = (hours);
    document.querySelector('#minutes').textContent = (minutes);
  }

  setInterval(updateTime, 10);
