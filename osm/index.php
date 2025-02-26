<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

     <!-- Leaflet.js for OpenStreetMap -->
     <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        #search-container {
            margin: 20px auto;
            width: 50%;
        }
        #map {
            height: 400px;
            width: 80%;
            margin: auto;
        }
        
        .ui-autocomplete {
            z-index: 10000 !important; /* Ensure it appears above other elements */
            position: absolute; /* Prevent it from being constrained by parent elements */
            background: white; /* Improve visibility */
            border: 1px solid #ccc; /* Optional styling */
        }
    </style>

</head>
<body>   
<h2>Search Address</h2>
<div id="search-container">
    <input type="text" id="searchBox" placeholder="Enter an address">
    <ul id="suggestions" class="autocomplete-list"></ul>
    <button id="searchBtn">Search</button>
</div>

<div id="map"></div>
    
</body>
</html>
<script>
    $(document).ready(function () {
    var map = L.map('map').setView([20, 0], 2); // Default map view
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    }).addTo(map);
    var marker;

    $("#searchBox").autocomplete({
        source: function (request, response) {
            $.getJSON(`https://nominatim.openstreetmap.org/search?format=json&addressdetails=1&q=${request.term}`, function (data) {
                response($.map(data, function (item) {
                    return {
                        label: item.display_name,
                        value: item.display_name,
                        lat: item.lat,
                        lon: item.lon,
                        address: item.address
                    };
                }));
            });
        },
        select: function (event, ui) {
            $("#searchBox").val(ui.item.value);
            updateMap(ui.item.lat, ui.item.lon);
            saveAddress(ui.item);
        }
    });

    $("#searchBtn").click(function () {
        let address = $("#searchBox").val();
        if (address === "") {
            alert("Please enter an address.");
            return;
        }

        $.getJSON(`https://nominatim.openstreetmap.org/search?format=json&addressdetails=1&q=${address}`, function (data) {
            if (data.length > 0) {
                let result = data[0];

                let formattedAddress = result.display_name;
                let lat = result.lat;
                let lon = result.lon;

                let addressDetails = result.address;
                let city = addressDetails.city || addressDetails.town || addressDetails.village || "";
                let state = addressDetails.state || "";
                let country = addressDetails.country || "";
                let postal_code = addressDetails.postcode || "";


                updateMap(lat, lon);
                saveAddress({
                    label: formattedAddress,
                    lat: lat,
                    lon: lon,
                    address: { city, state, country, postcode: postal_code }
                });
            } else {
                alert("No results found.");
            }
        });
    });

    function updateMap(lat, lon) {
        if (marker) map.removeLayer(marker);
        marker = L.marker([lat, lon]).addTo(map);
        map.setView([lat, lon], 15);
    }

    function saveAddress(item) {
        $.post("save_address.php", {
            address: item.label,
            city: item.address.city || item.address.town || item.address.village || "",
            state: item.address.state || "",
            country: item.address.country || "",
            postal_code: item.address.postcode || "",
            lat: item.lat,
            lon: item.lon
        }, function (response) {
            alert(response);
        });
    }
});

</script>