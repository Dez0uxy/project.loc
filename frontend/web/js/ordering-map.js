$(function(){
    var stl=[
        {
            "featureType": "water",
            "stylers": [
                {
                    "color": "#19a0d8"
                }
            ]
        },
        {
            "featureType": "administrative",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "color": "#ffffff"
                },
                {
                    "weight": 6
                }
            ]
        },
        {
            "featureType": "administrative",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#e85113"
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry.stroke",
            "stylers": [
                {
                    "color": "#efe9e4"
                },
                {
                    "lightness": -40
                }
            ]
        },
        {
            "featureType": "road.arterial",
            "elementType": "geometry.stroke",
            "stylers": [
                {
                    "color": "#efe9e4"
                },
                {
                    "lightness": -20
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "lightness": 100
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "lightness": -100
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "labels.icon"
        },
        {
            "featureType": "landscape",
            "elementType": "labels",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "landscape",
            "stylers": [
                {
                    "lightness": 20
                },
                {
                    "color": "#efe9e4"
                }
            ]
        },
        {
            "featureType": "landscape.man_made",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "water",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "lightness": 100
                }
            ]
        },
        {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "lightness": -100
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "hue": "#11ff00"
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "lightness": 100
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "labels.icon",
            "stylers": [
                {
                    "hue": "#4cff00"
                },
                {
                    "saturation": 58
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [
                {
                    "visibility": "on"
                },
                {
                    "color": "#f0e4d3"
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#efe9e4"
                },
                {
                    "lightness": -25
                }
            ]
        },
        {
            "featureType": "road.arterial",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#efe9e4"
                },
                {
                    "lightness": -10
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "labels",
            "stylers": [
                {
                    "visibility": "simplified"
                }
            ]
        }
    ];
    var map;
    function initMap(){
        map = new google.maps.Map(document.getElementById('map_cont'),{
            center: {lat: 50.4466878, lng: 30.4078552},
            zoom: 16,
        });
        var marker = new google.maps.Marker({
            position:{lat: 50.4466878, lng: 30.4078552},
            map:map,
        });
        
    };
    initMap();
    
    $(window).resize(function(){
        initMap();
    });
})