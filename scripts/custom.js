// isotope js
$(window).on("load", function () {
  $(".filters_menu li").click(function () {
    $(".filters_menu li").removeClass("active");
    $(this).addClass("active");

    var data = $(this).attr("data-filter");
    $grid.isotope({
      filter: data,
    });
  });

  var $grid = $(".grid").isotope({
    itemSelector: ".all",
    percentPosition: false,
    masonry: {
      columnWidth: ".all",
    },
  });
});

// nice select
$(document).ready(function () {
  $("select").niceSelect();
});

// client section owl carousel
$(".client_owl-carousel").owlCarousel({
  loop: true,
  margin: 0,
  dots: false,
  nav: true,
  navText: [],
  autoplay: true,
  autoplayHoverPause: true,
  navText: [
    '<i class="fa fa-angle-left" aria-hidden="true"></i>',
    '<i class="fa fa-angle-right" aria-hidden="true"></i>',
  ],
  responsive: {
    0: {
      items: 1,
    },
    768: {
      items: 2,
    },
    1000: {
      items: 2,
    },
  },
});
const deliverySelect = document.getElementById('deliverySelect');
const btn_price = document.getElementById('btn_price');
const checkButton = document.getElementById('checkButton');

// Initialize Nice Select on your dropdown
$(deliverySelect).niceSelect();

// Event listener for the change event provided by Nice Select
$(deliverySelect).on('change', function() {
  const selectedOption = $(this).val();
  updateButtonValue(selectedOption);
});

// Event listener for the "Check Price" button click
checkButton.addEventListener('click', function() {
  $(deliverySelect).val('extreme').niceSelect('update');
  btn_price.innerHTML = '60 Rs';
});

// Function to update the button value based on the selected option
function updateButtonValue(selectedOption) {
  if (selectedOption === 'extreme') {
    btn_price.innerHTML = '60 Rs';
  } else {
    btn_price.innerHTML = '40 Rs';
  }
}


const selectImage = document.querySelector('.select-image');
const inputFile = document.querySelector('#file');
const imgArea = document.querySelector('.img-area');
const errorMessage = document.querySelector('.error-message');

selectImage.addEventListener('click', function() {
    inputFile.click();
});

inputFile.addEventListener('change', function() {
    const image = this.files[0];

    if (image) {
        const reader = new FileReader();
        reader.onload = () => {
            const allImg = imgArea.querySelectorAll('img');
            allImg.forEach(item => item.remove());
            const imgUrl = reader.result;
            const img = document.createElement('img');
            img.src = imgUrl;
            imgArea.appendChild(img);
            imgArea.classList.add('active');
            imgArea.dataset.img = image.name;
            errorMessage.style.display = 'none'; // Hide error message when an image is selected
        };
        reader.readAsDataURL(image);
    } else {
        imgArea.classList.remove('active');
        imgArea.dataset.img = '';
        errorMessage.style.display = 'block'; // Show error message when no image is selected
    }
});


  $(document).ready(function () {
    // Function to set a cookie with a specific name, value, and expiration days
    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    }

    // Function to get the value of a cookie by its name
    function getCookie(name) {
        var nameEQ = name + "=";
        var cookies = document.cookie.split(';');
        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i];
            while (cookie.charAt(0) === ' ') {
                cookie = cookie.substring(1, cookie.length);
            }
            if (cookie.indexOf(nameEQ) === 0) {
                return cookie.substring(nameEQ.length, cookie.length);
            }
        }
        return null;
    }

    // Attach click event handler to each like button
    $("i.fa-solid.fa-heart").click(function () {
        // Get the unique ID from the clicked like button's ID attribute
        var id = $(this).attr("id").split("_")[1];
        var likeStatusElement = $("#likeStatus_" + id);

        // Check if the cookie exists
        var cookieName = "likeStatus_" + id;
        var existingStatus = getCookie(cookieName);

        // Toggle the color between red and white
        if (existingStatus === "liked") {
            $(this).css("color", "#fff"); // Change color to black (or any desired color)
            likeStatusElement.text("Like"); // Update like status to "Like"
            // Set the cookie with an expiry date one month from now
            setCookie(cookieName, "like", 30);
        } else {
            $(this).css("color", "#ff0000"); // Change color to red
            likeStatusElement.text("Liked"); // Update like status to "Liked"
            // Set the cookie with an expiry date one month from now
            setCookie(cookieName, "liked", 30);
        }
    });

    // Restore like statuses from cookies on page load
    $("i.fa-solid.fa-heart").each(function () {
        var id = $(this).attr("id").split("_")[1];
        var likeStatusElement = $("#likeStatus_" + id);
        var cookieName = "likeStatus_" + id;
        var existingStatus = getCookie(cookieName);

        if (existingStatus === "liked") {
            $(this).css("color", "#ff0000");
            likeStatusElement.text("Liked");
        } else {
            $(this).css("color", "#fff");
            likeStatusElement.text("Like");
        }
    });
});




