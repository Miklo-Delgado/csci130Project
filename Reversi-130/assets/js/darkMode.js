if (localStorage.getItem("data-theme") === "dark") {
  document.documentElement.setAttribute("data-theme", "dark");
  darkMode();
}

window.onload = function() {
  document
    .querySelector('input[type = "checkbox"]')
    .addEventListener("click", darkMode);
};

function darkMode() {
  var checkbox = document.querySelector("input[id=tex]");
  if (checkbox) {
    checkbox.addEventListener("change", function() {
      if (this.checked) {
        trans();
        document.documentElement.setAttribute("data-theme", "dark");
        localStorage.setItem("data-theme", "dark");
        console.log(localStorage.getItem("data-theme"));
      } else {
        trans();
        document.documentElement.setAttribute("data-theme", "light");
        localStorage.setItem("data-theme", "light");
      }
    });
  }

  let trans = () => {
    document.documentElement.classList.add("transition");
    window.setTimeout(() => {
      document.documentElement.classList.remove("transition");
    }, 1000);
  };
}
