document.querySelector("body").insertAdjacentHTML(
  "beforeend",
  ` <div class="loader-div">
        <div class="bg">
  <div class="loader"></div>
</div>
        </div>
        `
);

window.addEventListener("load", function () {
  const loader = document.querySelector(".loader-div");
  if (loader) {
    loader.remove();
  }
});
const sideLinks = document.querySelectorAll(
  ".sidebar .side-menu li a:not(.logout)"
);

sideLinks.forEach((item) => {
  const li = item.parentElement;
  item.addEventListener("click", () => {
    sideLinks.forEach((i) => {
      i.parentElement.classList.remove("active");
    });
    li.classList.add("active");
  });
});

const menuBar = document.querySelector(".content nav .bx.bx-menu");
const sideBar = document.querySelector(".sidebar");

menuBar.addEventListener("click", () => {
  sideBar.classList.toggle("close");
});

const searchBtn = document.querySelector(
  ".content nav form .form-input button"
);
const searchBtnIcon = document.querySelector(
  ".content nav form .form-input button .bx"
);
const searchForm = document.querySelector(".content nav form");

searchBtn.addEventListener("click", function (e) {
  if (window.innerWidth < 576) {
    e.preventDefault;
    searchForm.classList.toggle("show");
    if (searchForm.classList.contains("show")) {
      searchBtnIcon.classList.replace("bx-search", "bx-x");
    } else {
      searchBtnIcon.classList.replace("bx-x", "bx-search");
    }
  }
});

window.addEventListener("resize", () => {
  if (window.innerWidth < 768) {
    sideBar.classList.add("close");
  } else {
    sideBar.classList.remove("close");
  }
  if (window.innerWidth > 576) {
    searchBtnIcon.classList.replace("bx-x", "bx-search");
    searchForm.classList.remove("show");
  }
});

const toggler = document.getElementById("theme-toggle");

toggler.addEventListener("change", function () {
  if (this.checked) {
    document.body.classList.add("dark");
  } else {
    document.body.classList.remove("dark");
  }
});

function getSuggestions() {
  // Get the value from the txt_id field
  var txt_id = document.getElementById("txt_id").value;

  // Send an AJAX request to a PHP script to fetch autocomplete suggestions
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "getSuggestions.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
      if (xhr.readyState == 4 && xhr.status == 200) {
          // Display the autocomplete suggestions
          document.getElementById("autocompleteSuggestions").innerHTML = xhr.responseText;
      }
  };
  xhr.send("txt_id=" + txt_id);
}

function selectSuggestion(value) {
  // Set the selected suggestion as the input value
  document.getElementById("txt_id").value = value;
  // Clear the autocomplete suggestions container
  document.getElementById("autocompleteSuggestions").innerHTML = "";
}
