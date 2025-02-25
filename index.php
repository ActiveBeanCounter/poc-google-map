<!-- AIzaSyD8ARgYhOPbaA6Fsa1zHj3W8lYY_iO8y5I -->
<!-- AIzaSyCcXWrf6r7ZXyoP9Jt1QjmjjBQNIHgMuoA -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Maps Address Autocomplete</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <input id="autocomplete" type="text" placeholder="Enter an address" style="width: 300px;">
    <div id="map" style="height: 400px; width: 100%; margin-top: 20px;"></div>

    <script>
        let autocomplete, map, marker;

        function initAutocomplete() {
            if (typeof google === 'undefined') {
                console.error("Google Maps API not loaded.");
                return;
            }

            autocomplete = new google.maps.places.Autocomplete(document.getElementById("autocomplete"));
            autocomplete.addListener('place_changed', function() {
                let place = autocomplete.getPlace();
                
                if (!place.geometry) {
                    alert("No details available for this location.");
                    return;
                }

                let addressData = {
                    place_id: place.place_id,
                    address: place.formatted_address,
                    latitude: place.geometry.location.lat(),
                    longitude: place.geometry.location.lng(),
                    city: getComponent(place, 'locality'),
                    state: getComponent(place, 'administrative_area_level_1'),
                    country: getComponent(place, 'country'),
                    postal_code: getComponent(place, 'postal_code')
                };

                saveAddress(addressData);
                updateMap(addressData.latitude, addressData.longitude);
            });
        }

        function getComponent(place, type) {
            for (let i = 0; i < place.address_components.length; i++) {
                if (place.address_components[i].types.includes(type)) {
                    return place.address_components[i].long_name;
                }
            }
            return "";
        }

        function saveAddress(data) {
            $.post("save_address.php", data, function(response) {
                console.log(response);
            });
        }

        function updateMap(lat, lng) {
            if (!map) {
                map = new google.maps.Map(document.getElementById("map"), {
                    center: { lat: lat, lng: lng },
                    zoom: 15
                });
            }

            if (marker) {
                marker.setMap(null);
            }

            marker = new google.maps.Marker({
                position: { lat: lat, lng: lng },
                map: map
            });

            map.setCenter({ lat: lat, lng: lng });
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=&libraries=places&callback=initAutocomplete" async defer></script>

</body>
</html>