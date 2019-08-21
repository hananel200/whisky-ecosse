var southWest = L.latLng(48.50146096971154, -11.658038727733015);
var northEast = L.latLng(61.96835832759686, 3.1500391120455333);
var mybounds = L.latLngBounds(southWest, northEast);
var width = document.documentElement.clientWidth;
console.log(width);

var map = L.map('mapid',{minZoom: 6.2,
    maxZoom: 10, maxBounds: [
        //south west
        [53.82248980822159, -11.053332658967634],
        //north east
        [59.89331229860002, 3.5228392160323665]
    ], }).setView([56.72067119999999, -4.2026458000000275]);
if (width < 768) {
    map.setZoom(6);
}  else {
        map.setZoom(6.5);
}
L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1Ijoidm9pbGEiLCJhIjoiY2pyN3M1bjk4MDIzcDQ4bnh0bG44eWZtOSJ9.2Gp_-UOnRFvsaoPP4ocRSg', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    id: 'mapbox.streets',
    accessToken: 'your.mapbox.access.token'
}).addTo(map);
// var layer = L.esri.basemapLayer('NationalGeographic').addTo(map);

//
// var southWest = L.latLng(48.50146096971154, -11.658038727733015);
// var northEast = L.latLng(61.96835832759686, 3.1500391120455333);

// //south west
// [43.82248980822159, -22.053332658967634],
    //north east
    // [64.89331229860002, 10.5228392160323665]
