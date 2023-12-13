@extends('layouts.app')

@section('content')
<div class="mt-2">
    @include('layouts.partials.messages')
</div>

<form action="{{ route('returns.store') }}" method="POST" enctype="multipart/form-data" class="checkout">
    @csrf
    <input type="text" name="return_status" value="pending" hidden>
    <div class="checkout-address">
        <div class="checkout-header">{{ __("RETURN PRODUCT INFO") }}</div>
        <div class="address-host">
            <div class="address-info">
                <input type="text" name="product_name" required autocomplete="product_name" maxlength="255" @error('product_name') is-invalid @enderror>
                <label for="product_name">{{ __("Product Name *") }}</label>
                @error('product_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="address-info">
                <input type="text" name="product_code" required autocomplete="product_code" maxlength="255" @error('product_code') is-invalid @enderror>
                <label for="product_code">{{ __("Product Code *") }}</label>
                @error('product_code')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="address-host">

            <div class="address-info">
                <input type="text" name="return_reason" required autocomplete="return_reason" maxlength="255" @error('return_reason') is-invalid @enderror>
                <label for="return_reason">{{ __("Return Reason *") }}</label>
                @error('return_reason')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="address-info">
                <select name="payment_method" id="payment_method" class="form-control" required>
                    <option value="" selected disabled>{{ __('Selecte Prefered Refund Method') }}</option>
                    <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>{{ __('Cash') }}</option>
                    <option value="mobile_money" {{ old('payment_method') === 'mobile_money' ? 'selected' : '' }}>{{ __('Mobile Money') }}</option>
                    <option value="bank" {{ old('payment_method') === 'bank' ? 'selected' : '' }}>{{ __('Bank') }}</option>
                </select>
                @error('payment_method')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
        </div>
      
    </div>
    <div class="checkout-address">
        <div class="checkout-header">{{__("CLIENT'S INFO")}}</div>
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
    <button type="submit" class="checkout-pay" >{{__('Confirm Return')}} <i class="fa fa-check"></i> </button>
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
@endsection
