const text = document.querySelector(".wel");

const textLoad = () => {
  setTimeout(() => {
    text.textContent = "Welcome to";
  }, 0);
  setTimeout(() => {
    text.classList.add("show");
  }, 200);
  setTimeout(() => {
    text.classList.remove("show");
  }, 7000);

  setTimeout(() => {
    text.textContent = "Bienvenue à";
    text.classList.add("show");
  }, 7500);
  setTimeout(() => {
    text.classList.remove("show");
  }, 14000);

  setTimeout(() => {
    text.textContent = "Welkom by";
    text.classList.add("show");
  }, 14500);
  setTimeout(() => {
    text.classList.remove("show");
  }, 21000);

  setTimeout(() => {
    text.textContent = "Mi amukeriwile eka";
    text.classList.add("show");
  }, 21500);
  setTimeout(() => {
    text.classList.remove("show");
  }, 27750);
};

textLoad();
setInterval(textLoad, 28000);

const images = document.querySelector(".myImages");

document.getElementById("next").addEventListener("click", function () {
  images.scrollBy({ left: 200, behavior: "smooth" });
});
document.getElementById("previous").addEventListener("click", function () {
  images.scrollBy({ left: -200, behavior: "smooth" });
});

//Google translate API -by Trinity
// function googleTranslateElementInit() {
//   new google.translate.TranslateElement(
//     { pageLanguage: "en" },
//     "google_translate_element"
//   );
// }
// let count = 0;
// document.getElementById("dark").addEventListener("click", function () {
//   count++;
//   if (count % 2 != 0) {
//     document.body.style.backgroundColor = "black";
//     document.body.style.color = "white";
//   } else {
//     document.body.style.backgroundColor = "#a9d7e9";
//     document.body.style.color = "black";
//   }
// });

// document.getElementById("butt").addEventListener("click", function () {
//   console.log("Here");
//   let u = document.getElementById("profP").value;
//   console.log(u);
// });

// Counters

let counters = document.querySelectorAll(".counters span");

function updateCount(counter) {
  let target = parseInt(counter.dataset.count);
  let count = 0;

  function increment() {
    if (count < target) {
      count++;
      counter.innerText = count;
      setTimeout(increment, 40);
    } else {
      counter.innerText = target;
    }
  }

  increment();
}

let observer = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        let counter = entry.target;
        updateCount(counter);
        observer.unobserve(counter);
      }
    });
  },
  {
    threshold: 0.95,
  }
);

counters.forEach((counter) => {
  observer.observe(counter);
});
