<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body>

    <h2>Search Address</h2>
    <input type="text" id="searchBox" placeholder="Enter address" autocomplete="off">
    <button id="searchBtn">Search</button>

    <script>
        $(document).ready(function () {

            let apiKey = "xhXNhKWQ1FfToDTaOuTxCkRcOf4HXa6G7L4j3V2P";

            $("#searchBox").autocomplete({

                source : function(request, response){
                    $.getJSON(`proxy.php?query=${request.term}&apikey=${apiKey}`, function(data){

                        response($.map(data.results, function (item) {
                            return {
                                label: item.display_name,
                                value: item.display_name,
                                address: item.address
                            };
                        }));

                    });

                },
                select : function(event , ui){
                    $("#searchBox").val(ui.item.value);
                    saveAddress(ui.item);
                }
            });

             // Manual search button
            $("#searchBtn").click(function () {

                let address = $("#searchBox").val();
                if (address === "") {
                    alert("Please enter an address.");
                    return;
                }

                $.getJSON(`proxy.php?query=${address}&apikey=${apiKey}`, function (data) {

                    if(data.results.length > 0){

                        let result = data.results[0];
                        let formattedAddress = result.display_name;
                        let addressDetails = result.address;

                        saveAddress({
                            label: formattedAddress,
                            address: addressDetails
                        });
                    }else{

                        alert("No results found.");

                    }
                });

            });

            function saveAdress(item){
                

            }
        });
    </script>
    
</body>
</html>