import $ from 'jquery'
// import 'googleapis';

let myLatLng = {lat: parseFloat($('#lat').attr('data')), lng: parseFloat($('#lon').attr('data'))};

function initMap() {
    let map = new google.maps.Map($('#map'), {
        center: myLatLng,
        zoom: 18,
        mapTypeId: 'hybrid'
    });
    map.setTilt(45);

    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: 'Emplacement véhicule'
    });
}