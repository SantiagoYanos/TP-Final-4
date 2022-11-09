let available_dates = "";

function InitializeAvailableDates(availableDatesJson) {
  available_dates = JSON.parse(availableDatesJson);
  available_dates = available_dates.map((date) => {
    return new Date(date).getTime();
  });

  console.log(available_dates);
}

let observer = new MutationObserver((mutationRecords) => {
  Highlight();
});

observer.observe(document, {
  attributes: false,
  childList: true,
  characterData: false,
  subtree: true,
});

function Highlight() {
  let days = document.getElementsByClassName("day");

  for (let i = 0; i < days.length; i++) {
    if (available_dates.includes(Number(days[i].dataset.date))) {
      days[i].classList.add("highlighted");
    } else {
      days[i].classList.add("disabled");
    }
  }
}
