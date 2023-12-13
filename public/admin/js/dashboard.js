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
 * Dashboard navigation
 */
$(document).ready(function () {
    // Function to toggle the sidebar
    $(".toggle").click(function () {
        $(".admin").toggleClass("open");
        $(".text").toggleClass("hidden");
    });
    
});

$(document).ready(function () {
    $(".dropdown .dropbtn").click(function () {
        // Close all other open dropdowns
        $(".dropdown.active").not($(this).parent()).removeClass("active");
        
        // Toggle the active class for the clicked dropdown
        $(this).parent().toggleClass("active");
    });
});

// Add new image
$(document).ready(function () {
    let counter = 1; // Initialize a counter for unique IDs

    $(".add-field").click(function (e) {
        e.preventDefault();
        var $lastInput = $(".image-input-container:last");
        var $clone = $lastInput.clone();
        counter++; // Increment the counter
        $clone.find("input").attr("name", "image[" + counter + "]");
        $clone.find("input").attr("id", "image_" + counter); 
        $clone.find("label").attr("for", "image_" + counter);
        $clone.find("input").val(""); 
        // $clone.find("img").attr("id", "preview_" + counter); 
        $clone.find(".preview").attr("src", "" + counter); 
        $lastInput.after($clone);
    });

    $(".remove-field").click(function (e) {
        e.preventDefault();
        var $imageContainers = $(".image-input-container");
        if ($imageContainers.length > 1) {
            $imageContainers.last().remove();
        } else {
            alert("You must have at least one image input field.");
        }
    });
    
   // Attach an event handler to all file input elements with class "image-input"
   $(document).on('change', '.image-input', function () {
        let $container = $(this).closest(".product-details-group"); // Find the parent container
        let img = $container.find(".preview")[0]; // Find the corresponding preview image

        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                img.src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        } else {
            img.src = "";
        }
    });
});

// Attributes
document.addEventListener('DOMContentLoaded', function () {
  // Function to handle dropdown behavior
  function handleDropdown(dropdown) {
    var anchor = dropdown.querySelector('.anchor');
    var items = dropdown.querySelector('.items');

    anchor.addEventListener('click', function (evt) {
      evt.stopPropagation();
      dropdown.classList.toggle('visible');
    });

    items.addEventListener('click', function (evt) {
      evt.stopPropagation(); // Prevent clicks inside the dropdown from closing it
    });

    document.addEventListener('click', function (evt) {
      if (!dropdown.contains(evt.target)) {
        dropdown.classList.remove('visible');
      }
    });
  }

  // Handle each dropdown
  var dropdowns = document.querySelectorAll('.unique-dropdown');
  dropdowns.forEach(function (dropdown) {
    handleDropdown(dropdown);
  });
  
  var dropdownSize = document.querySelector('.dropdown-check-list-size');
  handleDropdown(dropdownSize);

  var dropdownWarranty = document.querySelector('.dropdown-check-list-warranty');
  handleDropdown(dropdownWarranty);

  var dropdownCondition = document.querySelector('.dropdown-check-list-condition');
  handleDropdown(dropdownCondition);

  var dropdownAvailability = document.querySelector('.dropdown-check-list-availability');
  handleDropdown(dropdownAvailability);

  var dropdownCategories = document.querySelector('.dropdown-check-list-categories');
  handleDropdown(dropdownCategories);

  var dropdownsubCategories = document.querySelector('.dropdown-check-list-subcategories');
  handleDropdown(dropdownsubCategories);

  var dropdownsubsubCategories = document.querySelector('.dropdown-check-list-subsubcategories');
  handleDropdown(dropdownsubsubCategories);

  // Add more dropdowns here if needed
});

$(document).ready(function() {
  // Format numbers with commas
  $('input.number').keyup(function(event) {
    // Skip for arrow keys
    if (event.which >= 37 && event.which <= 40) return;

    // Format number
    $(this).val(function(index, value) {
      return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    });
  });

  // Get references to the input fields
  var $buyingInput = $('#buying');
  var $sellingInput = $('#selling');
  var $profitInput = $('#profit');
  var $totalCostInput = $('#total_cost');
  var $quantityInput = $('#quantity');
  var $alert_thresholdInput = $('#alert_threshold');

  // Calculate and update profit and total cost when buying or selling input changes
  $buyingInput.on('input', calculateProfitAndTotalCost);
  $sellingInput.on('input', calculateProfitAndTotalCost);

  function calculateProfitAndTotalCost() {
    var buyingPrice = parseFloat($buyingInput.val().replace(/,/g, '')) || 0;
    var sellingPrice = parseFloat($sellingInput.val().replace(/,/g, '')) || 0;
    var quantity = parseFloat($quantityInput.val().replace(/,/g, '')) || 0;
    var alert_threshold = parseFloat($alert_thresholdInput.val().replace(/,/g, '')) || 0;
    
    var profit = sellingPrice - buyingPrice;
    var totalCost = buyingPrice * quantity;

    // Format numbers with commas and display
    $profitInput.val(profit.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $totalCostInput.val(totalCost.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  }
});