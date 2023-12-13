/**
 * Loader
 */

document.addEventListener('DOMContentLoaded', function () {
    // Get a reference to the loader
    var loader = document.getElementById('loader');
      
    // After 3 seconds, hide the loader
    setTimeout(function () {
        loader.style.display = 'none';
    }, 1000); // 3000 milliseconds (3 seconds)
  });
  
/**
 * navgation bar
 */

$(document).ready(function() {
  var navigation = $('.navigation');
  var offset = navigation.offset().top;

  $(window).scroll(function() {
      if ($(window).scrollTop() > offset) {
          navigation.addClass('fixed-navigation');
      } else {
          navigation.removeClass('fixed-navigation');
      }
  });
});

/**
 * Account drop down
 */
$(document).ready(function () {
  $(".dropdown-toggle").click(function () {
      $(".nav-account.active").not($(this).parent()).removeClass("active");

      $(this).parent().toggleClass("active");
  });
});

/**
 * categories
 */

$(document).ready(function() {
  $("#toggleCategories").click(function() {
      $(".nav-categories").toggleClass("active");
  });

  $("#closeCategories").click(function() {
      $(".nav-categories").removeClass("active");
  });

  $("#toggleCategories-mobile").click(function() {
      $(".nav-categories-mobile").toggleClass("active");
  });

  $("#closeCategories-mobile").click(function() {
      $(".nav-categories-mobile").removeClass("active");
  });
});

/**
 * Categories
 */
$(document).ready(function () {
  $(".main-dropper-icon").click(function (event) {
    event.preventDefault();

    var $mainDropper = $(this).parent();
    var $subCategory = $mainDropper.next(".sub-category");

    // Close other main droppers
    $(".main-dropper").not($mainDropper).next(".sub-category").slideUp();
    $(".main-dropper").not($mainDropper).find('.main-dropper-icon').removeClass("active");

    // Toggle the current main dropper
    $subCategory.slideToggle();
    $mainDropper.find('.main-dropper-icon').toggleClass("active");
  });

  $(".sub-dropper-icon").click(function (event) {
    event.preventDefault();

    var $subDropper = $(this).parent();
    var $subSubCategory = $subDropper.next(".sub-sub-category");

    // Close other sub droppers
    $(".sub-dropper").not($subDropper).next(".sub-sub-category").slideUp();
    $(".sub-dropper").not($subDropper).find('.sub-dropper-icon').removeClass("active");

    // Toggle the current sub dropper
    $subSubCategory.slideToggle();
    $subDropper.find('.sub-dropper-icon').toggleClass("active");
  });
});

/**
 * Slider
 */
$.global = new Object();
$.global.item = 1;
$.global.total = 0;

$(document).ready(function() {
  var WindowWidth = $(window).width();
  var SlideCount = $('.banner-img').length; // Get the number of banner images
  var SlidesWidth = SlideCount * WindowWidth;

  $.global.item = 0;
  $.global.total = SlideCount;

  $('.banner-img').css('width', WindowWidth + 'px'); // Set the width of banner images
  $('.banner-images').css('width', SlidesWidth + 'px'); // Set the width of the banner container

  // Automatically slide the images to the right
  setInterval(function() {
    Slide('forward');
  }, 3000);
});

function Slide(direction) {
  var $target;
  if (direction == 'forward') {
    $target = $.global.item + 1;
  }

  if ($target == $.global.total) {
    $target = 0;
  }
  
  DoIt($target);
}

function DoIt(target) {
  var $windowwidth = $(window).width();
  var $margin = $windowwidth * target;
  var $actualtarget = target + 1;

  $(".banner-img").removeClass('alive');
  $(".banner-img:nth-child(" + $actualtarget + ")").addClass('alive');

  $('.banner-images').css('transform', 'translate3d(-' + $margin + 'px,0px,0px)');

  $.global.item = target;
}

/**
 * FAQs
 */

const faqItems = document.querySelectorAll('.faq-item');

faqItems.forEach(item => {
  const question = item.querySelector('.faq-question');
  const answer = item.nextElementSibling;
  const icon = item.querySelector('i');

  item.addEventListener('click', () => {
    faqItems.forEach(otherItem => {
      if (otherItem !== item) {
        const otherAnswer = otherItem.nextElementSibling;
        const otherIcon = otherItem.querySelector('i');

        otherAnswer.classList.remove('active');
        otherIcon.classList.remove('active');
        otherAnswer.style.maxHeight = "0";
      }
    });

    answer.classList.toggle('active');
    icon.classList.toggle('active');
    if (answer.classList.contains('active')) {
      answer.style.maxHeight = answer.scrollHeight + "px";
    } else {
      answer.style.maxHeight = "0";
    }
  });
});

/**
 * Product Gallery
 */
$(document).ready(function() {
  // Set the initial image index
  var currentIndex = 0;

  // Select all sub-images
  var $subImages = $(".sub-images");

  // Function to update the main image
  function updateMainImage() {
      var $mainImage = $(".product-main-image");
      $mainImage.css("background-image", $subImages.eq(currentIndex).css("background-image"));
  }

  // Function to show the next image
  function showNextImage() {
      currentIndex = (currentIndex + 1) % $subImages.length;
      updateMainImage();
  }

  // Auto slide every 3 seconds (adjust the interval as needed)
  var slideInterval = setInterval(showNextImage, 3000);

  // Stop the auto slide on mouse hover
  $(".product-images").hover(
      function() {
          clearInterval(slideInterval);
      },
      function() {
          slideInterval = setInterval(showNextImage, 3000);
      }
  );

  // Add click event handlers to sub-images
  $subImages.click(function() {
      currentIndex = $subImages.index(this);
      updateMainImage();
  });

  // Initial main image update
  updateMainImage();
});