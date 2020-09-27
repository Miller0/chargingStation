<?php

$this->title = 'My Yii Application';

?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css">
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>

<button type="button" id="marker" class="btn btn-primary">Show charging stations</button>
<button type="button" id="nearby" class="btn btn-primary">Show charging stations nearby</button>

<div id="map" style="height:500px;width:100%;"></div>

<script>

    var logString = 'test';
    $('#marker').on('click', function () {

        $.ajax({
            xhrFields: {
                withCredentials: true
            },
            headers: {
                'Authorization': 'Basic ' + btoa(logString)
            },
            url: '/api/charging-stations/get-city',
            success: function (data) {
                //console.log(data);
                addMarker(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(xhr.responseText);
            },
        });
    });


    $('#nearby').on('click', function () {
       // navigator.geolocation.getCurrentPosition(function (position) {

            // var lat = position.coords.latitude;
            // var lng = position.coords.longitude;
        var lat = prompt('latitude', 50.45259262);
        var lng = prompt('longitude', 30.5208993);
        var markers = L.marker([lat, lng]).addTo(map);
        map.setView(new L.LatLng(lat, lng), 17);
        $.ajax({
            xhrFields: {
                withCredentials: true
            },
            headers: {
                'Authorization': 'Basic ' + btoa(logString)
            },
            data: {
                "latitude": lat,
                "longitude": lng
            },
            url: '/api/charging-stations/beside',
            success: function (data) {
                console.log(data);
                alert(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(xhr.responseText);
            },
        });
    });


    var center = [50.440539, 30.489380];
    var map = L.map('map').setView(center, 17);
    L.tileLayer(
        'https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18
        }).addTo(map);


    function addMarker(data) {

        data.forEach(myFunction);

        function myFunction(item, index) {
            var markers = L.marker([item['latitude'], item['longitude']]).addTo(map);
            markers.bindPopup(
                '<p> Мощность' + item["output"] + ' Киловат' + '</p>'
                + '<p>' + item['address'] + '</p>'
                + '<p>' + item['status'] + '</p>'
            );
        }
    }


</script>

