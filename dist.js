var latVal = "0";
var lngVal = "0";
var coords = [0, 0, 0];
//MINIMUM ALLOWED DISTANCE
var minDist = 10;
var distance = -1;
var good = false;
 
function geocode(platform) {
  	var geocoder1 = platform.getGeocodingService(),
    geocodingParameters1 = {
    //*********************ENTER RESTURANT ADDRESS**********************
      searchText: 'Milton WI',
      /* houseNumber: '',
      street: '',
      city: '',
      state: '',
      postalCode: '', */ 
      jsonattributes : 1
    }
    geocoder1.geocode(geocodingParameters1,onSuccess,onError);
    
   	var geocoder2 = platform.getGeocodingService(),
    geocodingParameters2 = {
    //*********************ENTER CUSTOMER ADDRESS**********************
      //searchText: 'Janesville WI',
      houseNumber: '150',
      street: 'Hamilton Green Way',
      city: 'Whitewater',
      state: 'WI',
      postalCode: '53190',
      jsonattributes : 1
    }
    geocoder2.geocode(geocodingParameters2,onSuccess,onError); 
}
  
function onSuccess(result) {
  var locations = result.response.view[0].result;
  const coords = addLocationsToMap(locations);
  addLocationsToPanel(locations);
  alert(coords[0]);
  if(coords[4]>0){
  	alert(coords[0], coords[1], coords[2], coords[3]);
  }
  else{
  	alert(coords[0], coords[1], coords[2], coords[3]);
	}
  // ... etc.
}

/**
 * This function will be called if a communication error occurs during the JSON-P request
 * @param  {Object} error  The error message received.
 */
function onError(error) {
  alert('Ooops!');
}




/**
 * Boilerplate map initialization code starts below:
 */

//Step 1: initialize communication with the platform
var platform = new H.service.Platform({
  app_id: 'DemoAppId01082013GAL',
  app_code: 'AJKnXv84fjrb0KIHawS0Tg',
  useCIT: true,
  useHTTPS: true
});
var defaultLayers = platform.createDefaultLayers();

//Step 2: initialize a map - this map is centered over California
var map = new H.Map(document.getElementById('map'),
  defaultLayers.normal.map,{
  center: {lat:37.376, lng:-122.034},
  zoom: 10
});

var locationsContainer = document.getElementById('panel');

//Step 3: make the map interactive
// MapEvents enables the event system
// Behavior implements default interactions for pan/zoom (also on mobile touch environments)
var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

// Create the default UI components
var ui = H.ui.UI.createDefault(map, defaultLayers);

// Hold a reference to any infobubble opened
var bubble;

/**
 * Opens/Closes a infobubble
 * @param  {H.geo.Point} position     The location on the map.
 * @param  {String} text              The contents of the infobubble.
 */
function openBubble(position, text){
 if(!bubble){
    bubble =  new H.ui.InfoBubble(
      position,
      {content: text});
    ui.addBubble(bubble);
  } else {
    bubble.setPosition(position);
    bubble.setContent(text);
    bubble.open();
  }
} 

/**
 * Creates a series of list items for each location found, and adds it to the panel.
 * @param {Object[]} locations An array of locations as received from the
 *                             H.service.GeocodingService
 */
function addLocationsToPanel(locations){

  var nodeOL = document.createElement('ul'),
    i;

  nodeOL.style.fontSize = 'small';
  nodeOL.style.marginLeft ='5%';
  nodeOL.style.marginRight ='5%';


   for (i = 0;  i < locations.length; i += 1) {
     var li = document.createElement('li'),
        divLabel = document.createElement('div'),
        address = locations[i].location.address,
        content =  '<strong style="font-size: large;">' + address.label  + '</strong></br>';
        position = {
          lat: locations[i].location.displayPosition.latitude,
          lng: locations[i].location.displayPosition.longitude
        };

      content += '<strong>houseNumber:</strong> ' + address.houseNumber + '<br/>';
      content += '<strong>street:</strong> '  + address.street + '<br/>';
      content += '<strong>district:</strong> '  + address.district + '<br/>';
      content += '<strong>city:</strong> ' + address.city + '<br/>';
      content += '<strong>postalCode:</strong> ' + address.postalCode + '<br/>';
      content += '<strong>county:</strong> ' + address.county + '<br/>';
      content += '<strong>country:</strong> ' + address.country + '<br/>';
      content += '<br/><strong>position:</strong> ' +
        Math.abs(position.lat.toFixed(4)) + ((position.lat > 0) ? 'N' : 'S') +
        ' ' + Math.abs(position.lng.toFixed(4)) + ((position.lng > 0) ? 'E' : 'W');

      divLabel.innerHTML = content;
      li.appendChild(divLabel);

      nodeOL.appendChild(li);
  }

  locationsContainer.appendChild(nodeOL);
}


/**
 * Creates a series of H.map.Markers for each location found, and adds it to the map.
 * @param {Object[]} locations An array of locations as received from the
 *                             H.service.GeocodingService
 */
function addLocationsToMap(locations){
  var group = new  H.map.Group(),
    position,
    i;

  // Add a marker for each location found
  for (i = 0;  i < locations.length; i += 1) {
    position = {
      lat: locations[i].location.displayPosition.latitude,
      lng: locations[i].location.displayPosition.longitude
    };
    
    
    marker = new H.map.Marker(position);
    marker.label = locations[i].location.address.label;
    group.addObject(marker);
 /* var x1 = position.lat;
    var y1 = position.lng;
    var x2 = 42.6828; // Janesvile Lat
    var y2 = -89.0187; // Janesville Long
    var distance = Math.sqrt( Math.pow((x1-x2), 2) + Math.pow((y1-y2), 2) )*69; */
    latVal = position.lat
    lngVal = position.lng
    //alert(latVal);
    //alert("Lat: "+position.lat +"\nLong "+ position.lng + "\nDistance = "+distance+" Miles");
  }

  group.addEventListener('tap', function (evt) {
    map.setCenter(evt.target.getPosition());
    openBubble(
       evt.target.getPosition(), evt.target.label);
  }, false);

  // Add the locations group to the map
  map.addObject(group);
  map.setCenter(group.getBounds().getCenter());
  if(coords[2] == 0){
  	coords[0] = latVal;
    coords[1] = lngVal;
    coords[2] = 1;
  }
  else{
  	//coords[2] = latVal;
    //coords[3] = lngVal;
    var x1 = coords[0];
    var y1 = coords[1];
    var x2 = latVal; // Janesvile Lat
    var y2 = lngVal; // Janesville Long
    distance = Math.sqrt( Math.pow((x1-x2), 2) + Math.pow((y1-y2), 2) )*69;
    if(distance < minDist){
        alert("GOOD TO GO\nDistance = "+distance+" Miles")
    }
    else{
    		alert("WARNING: Distance is too long\nDistance = "+distance+" Miles")
    }
  }
}

// Now use the map as required...
geocode(platform);


$('head').append('<link rel="stylesheet" href="https://js.api.here.com/v3/3.0/mapsjs-ui.css" type="text/css" />');
