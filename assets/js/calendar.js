const header = document.querySelector(".calendar h3");
const dates = document.querySelector(".calendar-dates");
const navs = document.querySelectorAll("#calendar-prev, #calendar-next");

const months = [
  "January",
  "February",
  "March",
  "April",
  "May",
  "June",
  "July",
  "August",
  "September",
  "October",
  "November",
  "December",
];

let date = new Date();
let month = date.getMonth();
let year = date.getFullYear();
let selectedDate = new Date(); // Initialize selectedDate to the current date

function renderCalendar() {
    const start = new Date(year, month, 1).getDay();
    const endDate = new Date(year, month + 1, 0).getDate();
    const end = new Date(year, month, endDate).getDay();
    const endDatePrev = new Date(year, month, 0).getDate();

    let datesHtml = "";

    for (let i = start; i > 0; i--) {
        datesHtml += `<li class="inactive">${endDatePrev - i + 1}</li>`;
    }

    for (let i = 1; i <= endDate; i++) {
        let className =
        i === selectedDate.getDate() &&
        month === selectedDate.getMonth() &&
        year === selectedDate.getFullYear()
            ? ' class="selected"'
            : i === date.getDate() &&
            month === new Date().getMonth() &&
            year === new Date().getFullYear()
            ? ' class="today"'
            : "";
        datesHtml += `<li${className}>${i}</li>`;
    }

    for (let i = end; i < 6; i++) {
        datesHtml += `<li class="inactive">${i - end + 1}</li>`;
    }

    dates.innerHTML = datesHtml;
    header.textContent = `${months[month]} ${year}`;
}

navs.forEach((nav) => {
  nav.addEventListener("click", (e) => {
    e.preventDefault();
    const btnId = e.target.id;

    if (btnId === "calendar-prev" && month === 0) {
      year--;
      month = 11;
    } else if (btnId === "calendar-next" && month === 11) {
      year++;
      month = 0;
    } else {
      month = btnId === "calendar-next" ? month + 1 : month - 1;
    }

    date = new Date(year, month, new Date().getDate());
    year = date.getFullYear();
    month = date.getMonth();

    renderCalendar();
  });
});

dates.addEventListener("click", (e) => {
  e.preventDefault();
  if (e.target.tagName === "LI" && !e.target.classList.contains("inactive")) {
    selectedDate = new Date(year, month, parseInt(e.target.textContent) + 1);
    console.log(
      `Selected date: ${selectedDate.toISOString().split("T")[0]}`
    );
    selectedDate = new Date(year, month, parseInt(e.target.textContent));
    renderCalendar();
  }
});

renderCalendar();
console.log(`Today's date (selected initially): ${selectedDate.toISOString().split("T")[0]}`);
