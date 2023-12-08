// Select the View type of Feeds
document.addEventListener("DOMContentLoaded", function () {
  const radioOptions = document.querySelector(".sqf-radio-options");
  const divs = radioOptions.querySelectorAll(".common");

  divs.forEach(function (div) {
    const radioButton = div.querySelector('input[type="radio"]');
    // const imgLabel = div.querySelector(".common-img-label");

    div.addEventListener("click", function () {
      radioButton.checked = true;

      divs.forEach(function (otherDiv) {
        if (otherDiv !== div) {
          otherDiv.classList.remove("selected");
        }
      });

      div.classList.add("selected");
    });
    // Set the default checked radio button
    if (radioButton.checked) {
      div.classList.add("selected");
    }
  });
});

// Retrieve the element for Number of Columns
var noOfCol = document.getElementById("sqf-carousel-col");
// Access the data attribute value
if (noOfCol !== null) {
  var carouselColValue = noOfCol.dataset.colattribute;
}

// Retrieve the time interval for autoplay slider
var timeInterval = document.getElementById("sqf-carousel-col");
if (timeInterval !== null) {
  var timeInterval = timeInterval.dataset.timeinterval;
}

window.onload = function carouselAction() {
  var selectedValue = document.querySelector(
    'input[name="sqf_carousel_view_type"]:checked'
  );
  if (selectedValue) {
    var selectedValueOG = selectedValue.value;
  }
  var autoplayClass = document.querySelector(".carousel-autoplay");

  //Image Carousel Autoplay
  if (autoplayClass) {
    if (selectedValueOG === "autoplay") {
      let slideImages = document.querySelectorAll(".sqf-post-carousel");

      if (slideImages.length > 0) {
        let slideElements = document.querySelectorAll(".sqf-post-carousel");
        if (slideElements.length >= 0) {
          let sliderReel = document.querySelector(".carousel-row");

          let i = 0;
          setInterval(function () {
            i++;
            if (i == Math.floor(slideElements.length / carouselColValue)) {
              i = 0;
            }
            //Image Div Width
            let imageDiv = document.querySelectorAll(".sqf-post-carousel");
            const imageWidth = imageDiv[0].clientWidth;

            let shiftBy = `translateX(-${
              (imageWidth * carouselColValue + carouselColValue * 15) * i
            }px`;

            sliderReel.style.transform = shiftBy;

            let currSlide = document.querySelector(
              `.sqf-post-carousel[data-target="${i}"]`
            );

            let activeSlides = document.querySelectorAll(
              ".sqf-post-carousel--active"
            );

            activeSlides.forEach(function (slide) {
              slide.classList.remove("sqf-post-carousel--active");
            });

            currSlide.classList.add("sqf-post-carousel--active");
          }, timeInterval);
        }
      }
    }
  }
  //Image Carousel On Click
  else if (selectedValue === "button_click") {
    // Get the carousel elements
    var carouselWrapper = document.querySelector(".carousel-row");
    var prevBtn = document.querySelector(".prev");
    var nextBtn = document.querySelector(".next");
    var images = document.querySelectorAll(".sqf-post-carousel");

    // Initialize the current slide index
    var currentSlide = 0;

    // Add event listener to the previous button
    prevBtn.addEventListener("click", function () {
      // Decrement the current slide index
      currentSlide = Math.max(0, currentSlide - 1);

      // Calculate the shift distance for the carousel
      var shiftBy = `translateX(calc(-${currentSlide * 100}% - ${
        currentSlide * 15
      }px))`;

      // Apply the transform to the carousel wrapper
      carouselWrapper.style.transform = shiftBy;
    });

    // Add event listener to the next button
    nextBtn.addEventListener("click", function () {
      // Increment the current slide index
      currentSlide = Math.min(
        Math.floor(images.length / carouselColValue) - 1,
        currentSlide + 1
      );

      // Calculate the shift distance for the carousel
      var shiftBy = `translateX(calc(-${currentSlide * 100}% - ${
        currentSlide * 15
      }px))`;

      // Apply the transform to the carousel wrapper
      carouselWrapper.style.transform = shiftBy;
    });
  }
};

//Image Carousel Autoplay on web page
var autoplayClass = document.querySelector(".carousel-autoplay");
if (autoplayClass) {
  let slideImages = document.querySelectorAll(".sqf-post-carousel");
  if (slideImages.length > 0) {
    let slideElements = document.querySelectorAll(".sqf-post-carousel");
    if (slideElements.length >= 0) {
      let sliderReel = document.querySelector(".carousel-row");
      let i = 0;
      setInterval(function () {
        i++;
        if (i == Math.floor(slideElements.length / carouselColValue)) {
          i = 0;
        }

        //Image Div Width
        let imageDiv = document.querySelectorAll(".sqf-post-carousel");
        const imageWidth = imageDiv[0].clientWidth;

        let shiftBy = `translateX(-${
          (imageWidth * carouselColValue + carouselColValue * 15) * i
        }px`;

        sliderReel.style.transform = shiftBy;

        let currSlide = document.querySelector(
          `.sqf-post-carousel[data-target="${i}"]`
        );

        let activeSlides = document.querySelectorAll(
          ".sqf-post-carousel--active"
        );

        activeSlides.forEach(function (slide) {
          slide.classList.remove("sqf-post-carousel--active");
        });

        currSlide.classList.add("sqf-post-carousel--active");
      }, timeInterval);
    }
  }
}

//Image Carousel buttonclick on web page
var buttonclickClass = document.querySelector(".carousel-button-click");
if (buttonclickClass) {
  // Get the carousel elements
  var carouselWrapper = document.querySelector(".carousel-row");
  var prevBtn = document.querySelector(".prev");
  var nextBtn = document.querySelector(".next");
  var images = document.querySelectorAll(".sqf-post-carousel");

  // Initialize the current slide index
  var currentSlide = 0;

  // Add event listener to the previous button
  prevBtn.addEventListener("click", function () {
    // Decrement the current slide index
    currentSlide = Math.max(0, currentSlide - 1);

    // Calculate the shift distance for the carousel
    var shiftBy = `translateX(calc(-${currentSlide * 100}% - ${
      currentSlide * 15
    }px))`;

    // Apply the transform to the carousel wrapper
    carouselWrapper.style.transform = shiftBy;
  });

  // Add event listener to the next button
  nextBtn.addEventListener("click", function () {
    // Increment the current slide index
    currentSlide = Math.min(
      Math.floor(images.length / carouselColValue) - 1,
      currentSlide + 1
    );

    // Calculate the shift distance for the carousel
    var shiftBy = `translateX(calc(-${currentSlide * 100}% - ${
      currentSlide * 15
    }px))`;

    // Apply the transform to the carousel wrapper
    carouselWrapper.style.transform = shiftBy;
  });
}

//Input field for Access token
function accesstokenFunction() {
  // Get the text field
  var copyText = document.getElementById("myInput");

  // Select the text field
  copyText.select();
  copyText.setSelectionRange(0, 99999); // For mobile devices

  // Copy the text inside the text field
  navigator.clipboard.writeText(copyText.value);

  // Alert the copied text
  alert("Copied the text: " + copyText.value);
}

//Input field for Short code
function shortcodeFunction() {
  // Get the text field
  var copyText = document.getElementById("shortcodeInput");

  // Select the text field
  copyText.select();
  copyText.setSelectionRange(0, 99999); // For mobile devices

  // Copy the text inside the text field
  navigator.clipboard.writeText(copyText.value);

  // Alert the copied text
  alert("Copied the text: " + copyText.value);
}

// Upload PNG button for left arrow
jQuery(document).ready(function ($) {
  // Upload PNG button click event
  $("#sqf-upload-png-left").on("click", function (e) {
    e.preventDefault();

    // Create the media frame
    var frame = wp.media({
      title: "Upload PNG",
      button: {
        text: "Use this PNG",
      },
      multiple: false, // Allow only single image selection
      library: {
        type: "image/png", // Limit to PNG images
      },
    });

    // Open the media uploader and select the image
    frame.on("select", function () {
      var attachment = frame.state().get("selection").first().toJSON();

      // Set the PNG image URL to the hidden input field
      $("#sqf-custom-png-left").val(attachment.url);

      // Display the selected PNG image
      $("#custom-png-preview-left").attr("src", attachment.url);
    });

    frame.open();
  });
});

// Upload PNG button for right arrow
jQuery(document).ready(function ($) {
  // Upload PNG button click event
  $("#sqf-upload-png-right").on("click", function (e) {
    e.preventDefault();

    // Create the media frame
    var frame = wp.media({
      title: "Upload PNG",
      button: {
        text: "Use this PNG",
      },
      multiple: false, // Allow only single image selection
      library: {
        type: "image/png", // Limit to PNG images
      },
    });

    // Open the media uploader and select the image
    frame.on("select", function () {
      var attachment = frame.state().get("selection").first().toJSON();

      // Set the PNG image URL to the hidden input field
      $("#sqf-custom-png-right").val(attachment.url);

      // Display the selected PNG image
      $("#sqf-custom-png-right").attr("src", attachment.url);
    });

    frame.open();
  });
});

//Message for view types
const messageDiv = document.getElementById("saveMessage");
const radioOptions = document.querySelector(".sqf-radio-options");
const divs = radioOptions.querySelectorAll(".common");
let messageTimeout;

divs.forEach(function (div) {
  const radioButton = div.querySelector('input[type="radio"]');

  div.addEventListener("click", function () {
    radioButton.checked = true;

    divs.forEach(function (otherDiv) {
      if (otherDiv !== div) {
        otherDiv.classList.remove("selected");
      }
    });

    div.classList.add("selected");
    // Display alert message
    messageDiv.style.display = "block";
    messageDiv.textContent = "Click on Update to Save the View Type";

    clearTimeout(messageTimeout);

    // Set timeout to hide the message after 5 seconds (5000 milliseconds)
    messageTimeout = setTimeout(function () {
      messageDiv.style.display = "none";
    }, 5000);
  });
});

// Get the radio buttons for carousel view type
const carouselRadios = document.querySelectorAll(
  'input[name="sqf_carousel_view_type"]'
);
let messageContain;

// Add event listener to each radio button
carouselRadios.forEach(function (carouselRadio) {
  carouselRadio.addEventListener("change", function () {
    // Check if the selected radio button has a specific value
    if (this.checked) {
      messageDiv.style.display = "block";
      if (this.value === "autoplay" || this.value === "button_click") {
        messageDiv.textContent = "Click on Update to Save Carousel View Type";
      } else {
        messageDiv.textContent = ""; // Clear the message container after reloaded
      }
    } else {
      messageDiv.style.display = "none";
    }

    clearTimeout(messageContain);

    messageContain = setTimeout(function () {
      messageDiv.style.display = "none";
    }, 5000);
  });
});

//change width of prevsqf-border-radiusiew and place of follow button and upload png buttoniew and place of follow button and upload png button
document.addEventListener("DOMContentLoaded", function () {
  var gridColumns = document.getElementById("sqf-grid-columns");
  var scrollableColumns = document.getElementById("sqf-scrollable-columns");
  var carouselColumns = document.getElementById("sqf-carousel-columns");
  var postLimit = document.getElementById("instagram_post_limit");
  var heightInput = document.getElementById("my-plugin-height");
  var widthSelect = document.getElementById("my-plugin-width");
  var timeIntervalInput = document.getElementById("sqf-carousel-time-interval");
  var borderRadius = document.getElementById("sqf-border-radius");
  var followButton = document.getElementById("sqf-follow-button");
  var uploadLeftMessage = document.getElementById("sqf-upload-png-left");
  var uploadRightMessage = document.getElementById("sqf-upload-png-right");

  var messageContainer = document.getElementById("saveMessage");
  let messageTimeout;

  if (gridColumns && messageContainer) {
    gridColumns.addEventListener("change", function () {
      if (gridColumns) {
        messageContainer.style.display = "block";
        var selectedValue = this.value;
        if (selectedValue) {
          messageContainer.textContent =
            "Click on Update to Save the Selected Columns!";
        } else {
          messageContainer.textContent = ""; // Clear the message container if the condition is met
        }
      } else {
        messageContainer.style.display = "none";
      }
      clearTimeout(messageTimeout);

      // Set timeout to hide the message after 5 seconds (5000 milliseconds)
      messageTimeout = setTimeout(function () {
        messageContainer.style.display = "none";
      }, 5000);
    });
  }

  if (scrollableColumns && messageContainer) {
    scrollableColumns.addEventListener("change", function () {
      if (scrollableColumns) {
        messageContainer.style.display = "block";
        var selectedValue = this.value;
        if (selectedValue) {
          messageContainer.textContent =
            "Click on Update to Save the Selected Columns!";
        } else {
          messageContainer.textContent = ""; // Clear the message container if the condition is met
        }
      } else {
        messageContainer.style.display = "none";
      }
      clearTimeout(messageTimeout);

      // Set timeout to hide the message after 5 seconds (5000 milliseconds)
      messageTimeout = setTimeout(function () {
        messageContainer.style.display = "none";
      }, 5000);
    });
  }

  if (carouselColumns && messageContainer) {
    carouselColumns.addEventListener("change", function () {
      if (carouselColumns) {
        messageContainer.style.display = "block";
        var selectedValue = this.value;
        if (selectedValue) {
          messageContainer.textContent =
            "Click on Update to Save the Selected Columns!";
        } else {
          messageContainer.textContent = ""; // Clear the message container if the condition is met
        }
      } else {
        messageContainer.style.display = "none";
      }
      clearTimeout(messageTimeout);

      // Set timeout to hide the message after 5 seconds (5000 milliseconds)
      messageTimeout = setTimeout(function () {
        messageContainer.style.display = "none";
      }, 5000);
    });
  }

  if (postLimit && messageContainer) {
    postLimit.addEventListener("input", function () {
      var inputValue = parseInt(this.value);
      if (inputValue > 0) {
        messageContainer.style.display = "block";
        messageContainer.textContent = "Click on Update to Save the Limit";
      } else {
        messageContainer.textContent = ""; // Clear the message container if the condition is not met
        messageContainer.style.display = "none";
      }
      clearTimeout(messageTimeout);

      // Set timeout to hide the message after 5 seconds (5000 milliseconds)
      messageTimeout = setTimeout(function () {
        messageContainer.style.display = "none";
      }, 5000);
    });
  }

  if (heightInput && messageContainer) {
    heightInput.addEventListener("input", function () {
      var inputValue = parseInt(this.value);
      if (inputValue > 0) {
        messageContainer.style.display = "block";
        messageContainer.textContent = "Click on Update to Save the Height!";
      } else {
        messageContainer.textContent = ""; // Clear the message container if the condition is met
        messageContainer.style.display = "none";
      }
      clearTimeout(messageTimeout);

      // Set timeout to hide the message after 5 seconds (5000 milliseconds)
      messageTimeout = setTimeout(function () {
        messageContainer.style.display = "none";
      }, 5000);
    });
  }

  if (widthSelect && messageContainer) {
    widthSelect.addEventListener("change", function () {
      if (widthSelect) {
        messageContainer.style.display = "block";
        var selectedValue = this.value;
        if (selectedValue) {
          messageContainer.textContent =
            "Click on Update to Save the Selected Width!";
        } else {
          messageContainer.textContent = ""; // Clear the message container if the condition is met
        }
      } else {
        messageContainer.style.display = "none";
      }
      clearTimeout(messageTimeout);

      // Set timeout to hide the message after 5 seconds (5000 milliseconds)
      messageTimeout = setTimeout(function () {
        messageContainer.style.display = "none";
      }, 5000);
    });
  }

  if (timeIntervalInput && messageContainer) {
    timeIntervalInput.addEventListener("input", function () {
      var inputValue = parseInt(this.value);
      if (inputValue > 0) {
        messageContainer.style.display = "block";
        messageContainer.textContent =
          "Click on Update to Save the Time Interval!";
      } else {
        messageContainer.textContent = ""; // Clear the message container if the condition is met
        messageContainer.style.display = "none";
      }
      clearTimeout(messageTimeout);

      // Set timeout to hide the message after 5 seconds (5000 milliseconds)
      messageTimeout = setTimeout(function () {
        messageContainer.style.display = "none";
      }, 5000);
    });
  }

  if (borderRadius && messageContainer) {
    borderRadius.addEventListener("input", function () {
      var inputValue = parseInt(this.value);
      if (inputValue > 0) {
        messageContainer.style.display = "block";
        messageContainer.textContent =
          "Click on Update to Save the Border Radius!";
      } else {
        messageContainer.textContent = ""; // Clear the message container if the condition is met
        messageContainer.style.display = "none";
      }
      clearTimeout(messageTimeout);

      // Set timeout to hide the message after 5 seconds (5000 milliseconds)
      messageTimeout = setTimeout(function () {
        messageContainer.style.display = "none";
      }, 5000);
    });
  }

  if (followButton && messageContainer) {
    followButton.addEventListener("input", function () {
      var inputValue = parseInt(this.value);
      if (inputValue !== "") {
        messageContainer.style.display = "block";
        messageContainer.textContent =
          "Click on Update to Save the Button Text!";
      } else {
        messageContainer.textContent = ""; // Clear the message container if the condition is met
        messageContainer.style.display = "none";
      }
      clearTimeout(messageTimeout);

      // Set timeout to hide the message after 5 seconds (5000 milliseconds)
      messageTimeout = setTimeout(function () {
        messageContainer.style.display = "none";
      }, 5000);
    });
  }

  if (uploadLeftMessage && messageContainer) {
    uploadLeftMessage.addEventListener("click", function () {
      messageContainer.style.display = "block";
      messageContainer.textContent =
        "Click on Update to Save the Left Arrow Key!";

      clearTimeout(messageTimeout);
      // Set timeout to hide the message after 5 seconds (5000 milliseconds)
      messageTimeout = setTimeout(function () {
        messageContainer.style.display = "none";
      }, 10000);
    });
  }

  if (uploadRightMessage && messageContainer) {
    uploadRightMessage.addEventListener("click", function () {
      messageContainer.style.display = "block";
      messageContainer.textContent =
        "Click on Update to Save the Right Arrow Key!";

      clearTimeout(messageTimeout);
      // Set timeout to hide the message after 5 seconds (5000 milliseconds)
      messageTimeout = setTimeout(function () {
        messageContainer.style.display = "none";
      }, 10000);
    });
  }
});

//change the place of follow button
document.addEventListener("DOMContentLoaded", function () {
  var followMessage = document.getElementById("profile-place-select");
  var messageContainer = document.getElementById("saveMessage");
  let messageTimeout;

  if (followMessage && messageContainer) {
    followMessage.addEventListener("change", function () {
      if (followMessage) {
        messageContainer.style.display = "block";
        var selectedValue = this.value;

        if (selectedValue) {
          messageContainer.textContent =
            "Click on Update to Save the Place of Follow Button!";
        } else {
          messageContainer.textContent = "";
        }
      } else {
        messageContainer.style.display = "none";
      }

      clearTimeout(messageTimeout);
      // Set timeout to hide the message after 5 seconds (5000 milliseconds)
      messageTimeout = setTimeout(function () {
        messageContainer.style.display = "none";
      }, 5000);
    });
  }
});

// Get the checkboxes
const userChecks = document.querySelectorAll(
  'input[name="sqf_my_instagram_username"]'
);
const followChecks = document.querySelectorAll(
  'input[name="sqf_display_profile_checkbox"]'
);

const instaIcons = document.querySelectorAll(
  'input[name="sqf_instagram_icon_field"]'
);

const colorShades = document.querySelectorAll(
  'input[name="sqf_carousel_shade_field"]'
);

// Get the message element
const messageElement = document.getElementById("saveMessage");
let messageSetTimout;
// Add event listener to each checkbox

userChecks.forEach(function (userCheck) {
  userCheck.addEventListener("change", function () {
    if (this.checked) {
      messageElement.style.display = "block";
      // Check if the selected checkbox has a specific value
      if (this.value === "1") {
        messageElement.textContent =
          "Click on Update to Save the Username Option!";
      } else {
        messageElement.textContent = ""; // Clear the message if the checkbox value is not option2
      }
    } else {
      messageElement.style.display = "none";
    }
    clearTimeout(messageSetTimout);
    // Set timeout to hide the message after 5 seconds (5000 milliseconds)
    messageSetTimout = setTimeout(function () {
      messageElement.style.display = "none";
    }, 5000);
  });
});

// Add event listener to each checkbox

followChecks.forEach(function (followCheck) {
  followCheck.addEventListener("change", function () {
    // Check if the selected checkbox has a specific value
    if (this.checked) {
      messageElement.style.display = "block";
      if (this.value === "1") {
        messageElement.textContent =
          "Click on Update to Save the Follow Button!";
      } else {
        messageElement.textContent = ""; // Clear the message if the checkbox value is not option2
      }
    } else {
      messageElement.style.display = "none";
    }
    clearTimeout(messageSetTimout);
    // Set timeout to hide the message after 5 seconds (5000 milliseconds)
    messageSetTimout = setTimeout(function () {
      messageElement.style.display = "none";
    }, 5000);
  });
});

// Add event listener to each checkbox

instaIcons.forEach(function (instaIcon) {
  instaIcon.addEventListener("change", function () {
    // Check if the selected checkbox has a specific value
    if (this.checked) {
      messageElement.style.display = "block";
      if (this.value === "1") {
        messageElement.textContent = "Click on Update to Show Instagram Icon !";
      } else {
        messageElement.textContent = ""; // Clear the message if the checkbox value is not option2
      }
    } else {
      messageElement.style.display = "none";
    }
    clearTimeout(messageSetTimout);
    // Set timeout to hide the message after 5 seconds (5000 milliseconds)
    messageSetTimout = setTimeout(function () {
      messageElement.style.display = "none";
    }, 5000);
  });
});

// Add event listener to each checkbox

colorShades.forEach(function (colorShade) {
  colorShade.addEventListener("change", function () {
    // Check if the selected checkbox has a specific value
    if (this.checked) {
      messageElement.style.display = "block";
      if (this.value === "1") {
        messageElement.textContent =
          "Click on Update to Save Color Shade Option!";
      } else {
        messageElement.textContent = ""; // Clear the message if the checkbox value is not option2
      }
    } else {
      messageElement.style.display = "none";
    }
    clearTimeout(messageSetTimout);
    // Set timeout to hide the message after 5 seconds (5000 milliseconds)
    messageSetTimout = setTimeout(function () {
      messageElement.style.display = "none";
    }, 5000);
  });
});
