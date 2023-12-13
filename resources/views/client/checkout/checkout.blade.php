@extends('layouts.app')

@section('content')
<div class="mt-2">
    @include('layouts.partials.messages')
</div>
<form action="{{ route('checkout.details') }}" method="POST" enctype="multipart/form-data" class="checkout">
    @csrf
    <input type="text" name="order_status" value="pending" hidden>
    <div class="checkout-address">
        <div class="checkout-header">{{__("RECIEVER'S INFO")}}</div>
        <div class="address-info">
            <input type="text" name="name" required autocomplete="name" autofocus maxlength="50" @error('name') is-invalid @enderror>
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
            <input type="text" name="shipping_fee" id="result" style="height: 6vh; font-weight: 600; background-color:#dddddd;" placeholder="Shipping Fee." required readonly autocomplete="shipping_fee" @error('shipping_fee') is-invalid @enderror>
            @error('shipping_fee')
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
            resultOutput.value = "Error: Unable to calculate distance.";
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
                resultOutput.value = "Shipping Fee UGX : " + addCommas(multipliedDistance.toFixed(0));
            } else {
                resultOutput.value = "Error: Unable to calculate distance.";
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
   $(document).ready(function() {
    // Get references to the radio buttons and the billing detail info elements
    const cashOnDeliveryRadio = $("#cash-on-delivery-radio");
    const mobileMoneyRadio = $("#mobile-money-radio");
    const bankCardRadio = $("#bank-card-radio");

    const cashDetailInfo = $("#billing-detail-info-cash");
    const mobileMoneyDetailInfo = $("#billing-detail-info-mobile-money");
    const bankCardDetailInfo = $("#billing-detail-info-bank-card");

    // Function to hide all detail info elements
    function hideAllDetailInfo() {
        cashDetailInfo.hide();
        mobileMoneyDetailInfo.hide();
        bankCardDetailInfo.hide();
    }

    // Add an event listener to each radio button
    cashOnDeliveryRadio.change(function() {
        if (cashOnDeliveryRadio.is(":checked")) {
            hideAllDetailInfo();
            cashDetailInfo.show();
        }
    });

    mobileMoneyRadio.change(function() {
        if (mobileMoneyRadio.is(":checked")) {
            hideAllDetailInfo();
            mobileMoneyDetailInfo.show();
        }
    });

    bankCardRadio.change(function() {
        if (bankCardRadio.is(":checked")) {
            hideAllDetailInfo();
            bankCardDetailInfo.show();
        }
    });

    // Trigger the change event initially to set the initial state
    cashOnDeliveryRadio.change();
});

</script>

@endsection