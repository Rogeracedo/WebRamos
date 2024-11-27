document.addEventListener("DOMContentLoaded", () => {
  const calendarBody = document.getElementById("calendar-body");
  const monthYear = document.getElementById("month-year");
  const prevMonth = document.getElementById("prev-month");
  const nextMonth = document.getElementById("next-month");

  let currentDate = new Date();

  let dates = [1, 2, 3, 4, 9, 11];

  const renderCalendar = (date) => {
    calendarBody.innerHTML = "";

    const firstDay = new Date(date.getFullYear(), date.getMonth(), 1).getDay();
    const daysInMonth = new Date(
      date.getFullYear(),
      date.getMonth() + 1,
      0
    ).getDate();
    const monthNames = [
      "Enero",
      "Febrero",
      "Marzo",
      "Abril",
      "Mayo",
      "Junio",
      "Julio",
      "Agosto",
      "Septiembre",
      "Octubre",
      "Noviembre",
      "Diciembre",
    ];

    monthYear.textContent = `${
      monthNames[date.getMonth()]
    } ${date.getFullYear()}`;

    let day = 1;
    for (let i = 0; i < 6; i++) {
      const row = document.createElement("tr");

      for (let j = 0; j < 7; j++) {
        const cell = document.createElement("td");

        if ((i === 0 && j < (firstDay || 7) - 1) || day > daysInMonth) {
          cell.textContent = "";
        } else {
          cell.textContent = day;
          day++;
          for (let date of dates) {
            if (date === day) {
              cell.textContent = "Evento";
              dates.splice(1, 1);
              cell.innerHTML = "";
              cell.addEventListener("click", () => {
                cell.innerHTML += "<br><div> Nuevo evento</div>";
              });
            }
          }
        }
        row.appendChild(cell);
      }

      calendarBody.appendChild(row);
    }
  };

  prevMonth.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar(currentDate);
  });

  nextMonth.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar(currentDate);
  });

  renderCalendar(currentDate);
});
