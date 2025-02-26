<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<h2>Search Address</h2>
    <input type="text" id="searchBox" placeholder="Enter an address">
    <button id="searchBtn">Search</button>
</body>
</html>
<script>
    $(document).ready(function(){
        $("#searchBtn").click(function(){
            let address = $("#searchBox").val();
            if(address === ""){
                alert("please enter the address");
                return;
            }

            // Call OpenStreetMap Nominatim API
            $.get(`https://nominatim.openstreetmap.org/search?format=json&addressdetails=1&q=${address}`, function (data) {

                if(data.length > 0) {
                    let result = data[0];

                    let formattedAddress = result.display_name;
                    let lat = result.lat;
                    let lon = result.lon;

                    // Extract city, state, country, and postal code
                    let addressDetails = result.address;
                    let city = addressDetails.city || addressDetails.town || addressDetails.village || "";
                    let state = addressDetails.state || "";
                    let country = addressDetails.country || "";
                    let postal_code = addressDetails.postcode || "";

                    $.post("save_address.php",{
                    address: formattedAddress,
                    city: city,
                    state: state,
                    country: country,
                    postal_code: postal_code,
                    lat: lat,
                    lon: lon
                    }, function(response){
                    alert(response);

                    });

                }else{
                    alert("No results found.");
                }

                
            });

        });

        


    });
</script>