@extends('layouts.app')

@section('content')
<div class="mt-2">
    @include('layouts.partials.messages')
</div>

<form action="{{ route('place.custom.order') }}" method="post" enctype="multipart/form-data" class="checkout">
    @csrf
    <input type="text" name="order_status" value="pending" hidden>

    <div class="order-list" id="orderItemsContainer">
        <div class="checkout-header">{{__("ORDER ITEMS LIST")}}</div>
        <div class="order-items-list"  id="orderItemsList">
            <div class="order-items">
                <div class="address-info">
                    <img id="image-preview" src="" alt="" class="image-preview">
                    <input type="file" name="custom_img[]" id="custom-img" accept="image/*" style="font-size: 10px;" onchange="previewImage(this, 'image-preview-1')" @error('custom-img') is-invalid @enderror>
                    <label for="custom-img" style="color: #dddddd;">{{__("Upload Image *")}}</label>
                    @error('custom-img')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="address-info">
                    <input type="text" name="custom_name[]" id="custom-name"  required autofocus autocomplete="custom-name" maxlength="50" @error('custom-name') is-invalid @enderror>
                    <label for="custom-name">{{__("Item Name *")}}</label>
                    @error('custom-name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
        
                <div class="address-info">
                    <input type="text" name="custom_qty[]" id="custom-qty" min="1" class="custom-qty" required autocomplete="custom-qty" maxlength="10" @error('custom-qty') is-invalid @enderror>
                    <label for="custom-qty">{{__("Quantity *")}}</label>
                    @error('custom-qty')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
        
                <div class="address-info">
                    <input type="text" name="custom_price[]"  id="custom-price" min="1" class="custom-price"  required autocomplete="custom-price" maxlength="15" @error('custom-price') is-invalid @enderror>
                    <label for="custom-price">{{__("Budget Each @ *")}}</label>
                    @error('custom-price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
        
                <div class="address-info">
                    <input type="text" name="custom_total[]"  id="custom-total" min="1" class="custom-total" placeholder="Total" required readonly autocomplete="custom-total" @error('custom-total') is-invalid @enderror>
                    @error('custom-total')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        
            <div class="order-items">
                <div class="address-info">
                    <textarea name="custom_description[]" id="custom-description" required autocomplete="custom-description" @error('custom-description') is-invalid @enderror></textarea>
                    <label for="custom-description">{{__("Item Description *")}}</label>
                    @error('custom-description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="order-list">
        <div class="itembtn">
            <button id="addMoreBtn"><i class="fa fa-plus"></i></button>
            <button id="removeBtn"><i class="fa fa-minus"></i></button>
        </div>
    </div>

    <div class="checkout-address">
        <div class="checkout-header">{{__("RECIEVER'S INFO")}}</div>
        <div class="address-info">
            <input type="text" name="name" required autocomplete="name" maxlength="50" @error('name') is-invalid @enderror>
            <label for="names">{{__("Receiver's Name *")}}</label>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="address-host">
            <div class="address-info">
                <input type="text" name="city" required autocomplete="city" maxlength="50" @error('city') is-invalid @enderror>
                <label for="city">{{__('City *')}}</label>
                @error('city')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="address-info">
                <input type="text" id="origin" style="display: none;" value="Kampala Central Region" readonly>
                <input type="text" name="address" id="destination" required autocomplete="address" maxlength="100" @error('address') is-invalid @enderror>
                @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="address-host">
            <div class="address-info">
                <input type="text" name="tel_1" required autocomplete="Tel-1" maxlength="10" @error('tel_1') is-invalid @enderror>
                <label for="Tel-1">{{__('Phone Number *')}}</label>
                @error('tel_1')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="address-info">
                <input type="text" name="tel_2" required autocomplete="Tel-2" maxlength="10" @error('tel_2') is-invalid @enderror>
                <label for="Tel-2">{{__('Additional Phone Number *')}}</label>
                @error('tel_2')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="address-info">
            <textarea name="shipping_fee" id="result" style="height: 6vh; font-weight: 600; background-color:#dddddd;" placeholder="Shipping Fee." required readonly autocomplete="shipping-fee" maxlength="100" @error('shipping-fee') is-invalid @enderror></textarea>
            @error('shipping-fee')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="checkout-billing">
        <div class="checkout-header">{{__("PAYMENT & DELIVERY")}}</div>
        <div class="billing-host">
            <div class="billing-header">{{__('Pay On Delivery')}}</div>
            <div class="billing-info">
                <input type="radio" name="payment_method" value="cash_on_delivery" checked id="cash-on-delivery-radio">
                <div class="billing-details">
                    <span>{{__('Cash On Delivery')}}</span>
                    <i>{{__('You can pay with cash, mobile money, or card')}}</i>
                    <div class="billing-detail-info" id="billing-detail-info-cash">
                        {{__('Pay for your order when it is delivered to your doorstep. You have the option to pay with cash, mobile money, or card. Enjoy the convenience of payment upon receiving your items.')}}
                    </div>
                </div>
            </div>
        </div>

        <div class="billing-host">
            <div class="billing-header">{{__('Mobile Money')}}</div>
            <div class="billing-info">
                <input type="radio" name="payment_method" value="mobile_money" id="mobile-money-radio">
                <div class="billing-details">
                    <span>{{__('Mobile Money')}}</span>
                    <i>{{__('You can pay with MTN MoMo, AIRTEL MONEY')}}</i>
                    <div class="billing-detail-info" id="billing-detail-info-mobile-money">
                        {{__('Mobile Money is a convenient payment method that allows you to pay for your order using popular mobile money services like MTN MoMo and AIRTEL MONEY. Simply select this option and follow the instructions during checkout to complete your payment.')}}
                    </div>
                </div>
            </div>
        </div>

        <div class="billing-host">
            <div class="billing-header">{{__('Bank Card')}}</div>
            <div class="billing-info">
                <input type="radio" name="payment_method" value="bank_card" id="bank-card-radio">
                <div class="billing-details">
                    <span>{{__('Bank Transfer or Card')}}</span>
                    <i>{{__('You can pay securely with your bank card')}}</i>
                    <div class="billing-detail-info" id="billing-detail-info-bank-card">
                        {{__('Bank Card payment option allows you to make secure payments using your debit or credit card. Your financial information is protected and your payment is processed securely. Simply select this option and follow the instructions during checkout to complete your payment.')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="checkout-pay" >{{__('Confirm Order')}} <i class="fa fa-check"></i> </button>
</form>

@endsection

@section('custom-scripts')
<script>
    
    $(document).ready(function () {
        var originInput = document.getElementById('origin');
        var destinationInput = document.getElementById('destination');
        var resultOutput = document.getElementById('result');

        // Set the origin value
        originInput.value = "Kampala Central Region";

        // Create autocomplete objects
        var originAutocomplete = new google.maps.places.Autocomplete(originInput);
        var destinationAutocomplete = new google.maps.places.Autocomplete(destinationInput);

        // Listener for place_changed event in destination autocomplete
        destinationAutocomplete.addListener('place_changed', function () {
            calculateDistance();
        });

        // Input event on the destination field
        $('#destination').on('input', function () {
            calculateDistance();
        });

        function calculateDistance() {
            var origin = $('#origin').val();
            var destinationPlace = destinationAutocomplete.getPlace();

            if (!destinationPlace.geometry) {
                resultOutput.textContent = "Error: Unable to calculate distance.";
                return;
            }

            var destinationCoords = {
                lat: destinationPlace.geometry.location.lat(),
                lon: destinationPlace.geometry.location.lng()
            };

            // Use Nominatim for geocoding (you can replace this with Google Geocoding API if needed)
            geocode(origin, function (originCoords) {
                if (originCoords) {
                    var distance = haversine(originCoords, destinationCoords);
                    var multipliedDistance = distance * 500;
                    resultOutput.textContent = "Shipping Fee UGX : " + addCommas(multipliedDistance.toFixed(0));

                } else {
                    resultOutput.textContent = "Error: Unable to calculate distance.";
                }
            });
        }

        function geocode(location, callback) {
            var apiUrl = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(location)}`;

            $.getJSON(apiUrl, function (data) {
                if (data.length > 0) {
                    var coords = { lat: parseFloat(data[0].lat), lon: parseFloat(data[0].lon) };
                    callback(coords);
                } else {
                    callback(null);
                }
            });
        }

        function haversine(coord1, coord2) {
            var R = 6371; // Radius of the Earth in kilometers
            var dLat = (coord2.lat - coord1.lat) * Math.PI / 180;
            var dLon = (coord2.lon - coord1.lon) * Math.PI / 180;
            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(coord1.lat * Math.PI / 180) * Math.cos(coord2.lat * Math.PI / 180) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var distance = R * c;
            return distance;
        }

        function addCommas(number) {
        var parts = number.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join(".");
        }

    });


</script>

<script>

    function previewImage(input, previewId) {
        var preview = document.getElementById(previewId);
        var file = input.files[0];
        var reader = new FileReader();

        reader.onloadend = function () {
            preview.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }

    $(document).ready(function () {
        let count = 1; 

        // Function to clone the entire order items list section
        function cloneOrderItemsList() {
            let $lastOrderItemsList = $("#orderItemsList");
            let $clone = $lastOrderItemsList.clone();

            // Update the IDs and names of the input elements to make them unique
            $clone.find('.address-info').each(function (index, element) {
                $(element).find('input, textarea, img').each(function (index, input) {
                    // Get the existing name and ID of the input element
                    let existingName = $(input).attr('name');
                    let existingId = $(input).attr('id');

                    // Check if existingName is defined before using replace
                    if (existingName) {
                        // Add the current count to the existing name and ID
                        let newName = existingName.replace('[]', '[' + count + ']');
                        let newId = existingId + count;

                        // Update the name and ID of the input element
                        $(input).attr('name', newName);
                        $(input).attr('id', newId);

                        // Clear input values and set img src to an empty string
                        if (input.tagName === 'INPUT' || input.tagName === 'TEXTAREA') {
                            $(input).val('');
                        } else if (input.tagName === 'IMG') {
                            $(input).attr('src', '');
                        }
                    }
                });
            });

            // Add the current count attribute to the image preview element
            let previewId = 'image-preview-' + count;
            $clone.find('.image-preview').attr('id', previewId);

            // Update the previewImage function call to use the correct preview ID
            $clone.find('input[type="file"]').attr('onchange', 'previewImage(this, "' + previewId + '")');

            // Append the clone at the bottom of the existing order items
            $("#orderItemsContainer").append($clone);
                calculateTotalPrice($clone);
            // Increment the count variable
            count++;
        }
        
        // Function to format input value with commas
        function formatInputWithCommas(input) {
            var value = input.value.replace(/,/g, ''); // Remove existing commas
            var formattedValue = numberWithCommas(value);
            input.value = formattedValue;
        }

        // Function to calculate total price
        function calculateTotalPrice($container) {
            var quantity = parseFloat($container.find('.custom-qty').val().replace(/,/g, '')) || 0;
            var price = parseFloat($container.find('.custom-price').val().replace(/,/g, '')) || 0;

            var totalPrice = quantity * price;

            // Format the total price with commas
            var formattedTotalPrice = numberWithCommas(totalPrice.toFixed(0));

            $container.find('.custom-total').val(formattedTotalPrice);
        }

        // Function to add commas to a number
        function numberWithCommas(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }


        // Event handler for "Add More" button click
        $("#addMoreBtn").click(function (e) {
            e.preventDefault();
            cloneOrderItemsList();
        });

        // Event handler for "Remove" button click
        $("#removeBtn").click(function (e) {
            e.preventDefault();
            let $orderItemsLists = $(".order-items-list");
            if ($orderItemsLists.length > 1) {
                $orderItemsLists.last().remove();
            } else {
                alert("You must have at least one set of order items.");
            }
        });

        $(document).on('input', '.order-items-list input', function () {
            formatInputWithCommas(this);
            calculateTotalPrice($(this).closest('.order-items-list'));
        });
    
    });
    
</script>


@endsection