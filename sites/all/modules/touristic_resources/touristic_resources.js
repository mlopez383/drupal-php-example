var geocoder;
var map;
var marker;
var latlng;
	  
function initialize() {
	geocoder = new google.maps.Geocoder();
	
	if( (document) && (document.getElementById("edit-rt-location-x")) && (document.getElementById("edit-rt-location-y")) && document.getElementById("edit-rt-location-x").value && document.getElementById("edit-rt-location-y").value){
		latlng = new google.maps.LatLng(document.getElementById("edit-rt-location-x").value, document.getElementById("edit-rt-location-y").value);
	}else{
		latlng = new google.maps.LatLng(41.14961, -8.61099);
	}
	
	var myOptions = {
		zoom: 14,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
	
	marker = new google.maps.Marker({
		map:map,
		draggable:true,
		animation: google.maps.Animation.DROP,
		position: latlng
	});
	
	google.maps.event.addListener(marker, 'dragend', toggleBounce);
}

function codeAddress() {
	marker.setMap(null);
		
	var address = document.getElementById("edit-rt-address").value;
	var zipcode = document.getElementById("edit-rt-zipcode").value;
	var city = document.getElementById("edit-rt-city").value;
	var country = document.getElementById("edit-rt-country").value;
	
	var fullAddress = address + ' ' + city + ' ' + zipcode + ' ' + country;
		
	geocoder.geocode( { "address": fullAddress, "language": "en"}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			map.setCenter(results[0].geometry.location);
			
			if(address!='' || zipcode!='') map.setZoom(15);
			else if(city!='') map.setZoom(11);
			else if(country!='') map.setZoom(6);
						
			var country1a1s="";
			var administrative_area_level_11a1s="";
			var administrative_area_level_21a1s="";
			var administrative_area_level_31a1s="";
			var locality1a1s="";
			var route1a1s="";
			var street_number1a1s="";
			
			for (var i=0;i<results[0].address_components.length;i++){
			    for (var j=0;j<results[0].address_components[i].types.length;j++){
			       if(results[0].address_components[i].types[j]=="country" && results[0].address_components[i].long_name.length > country1a1s.length)
			    	   country1a1s = results[0].address_components[i].long_name;
			       
			       else if(results[0].address_components[i].types[j]=="administrative_area_level_1" && results[0].address_components[i].long_name.length > administrative_area_level_11a1s.length)
			    	   administrative_area_level_11a1s = results[0].address_components[i].long_name;
			       
			       else if(results[0].address_components[i].types[j]=="administrative_area_level_2" && results[0].address_components[i].long_name.length > administrative_area_level_21a1s.length)
			    	   administrative_area_level_21a1s = results[0].address_components[i].long_name;
			       
			       else if(results[0].address_components[i].types[j]=="administrative_area_level_3" && results[0].address_components[i].long_name.length > administrative_area_level_31a1s.length)
			    	   administrative_area_level_31a1s = results[0].address_components[i].long_name;
			       
			       else if(results[0].address_components[i].types[j]=="locality" && results[0].address_components[i].long_name.length > locality1a1s.length)
			    	   locality1a1s = results[0].address_components[i].long_name;
			       
			       else if(results[0].address_components[i].types[j]=="route" && results[0].address_components[i].long_name.length > route1a1s.length)
			    	   route1a1s = results[0].address_components[i].long_name;
			       
			       else if(results[0].address_components[i].types[j]=="street_number" && results[0].address_components[i].long_name.length > street_number1a1s.length)
			    	   street_number1a1s = results[0].address_components[i].long_name;
			    }
			}
			
			document.getElementById("edit-rt-full-address").value = street_number1a1s+", "+route1a1s+", "+locality1a1s+", "+administrative_area_level_31a1s+", "+administrative_area_level_21a1s+", "+administrative_area_level_11a1s+", "+country1a1s;
			//alert(document.getElementById("edit-rt-full-address").value);
			document.getElementById("edit-rt-location-x").value=results[0].geometry.location.lat();
			
			document.getElementById("edit-rt-location-y").value=results[0].geometry.location.lng();
					
			marker = new google.maps.Marker({
				map: map,
				draggable:true,
				animation: google.maps.Animation.DROP,
				position: results[0].geometry.location
			});
			google.maps.event.addListener(marker, 'dragend', toggleBounce);
		} else {
			alert("Geocode was not successful for the following reason: " + status);
		}
	});
}
  
function toggleBounce() {
	var latlngs1v1 = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
	
	geocoder.geocode( { "latLng": latlngs1v1, "language": "en"}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			map.setCenter(results[0].geometry.location);
			
			var country1a1s="";
			var administrative_area_level_11a1s="";
			var administrative_area_level_21a1s="";
			var administrative_area_level_31a1s="";
			var locality1a1s="";
			var route1a1s="";
			var street_number1a1s="";
			
			for (var i=0;i<results[0].address_components.length;i++){
			    for (var j=0;j<results[0].address_components[i].types.length;j++){
			       if(results[0].address_components[i].types[j]=="country" && results[0].address_components[i].long_name.length > country1a1s.length)
			    	   country1a1s = results[0].address_components[i].long_name;
			       
			       else if(results[0].address_components[i].types[j]=="administrative_area_level_1" && results[0].address_components[i].long_name.length > administrative_area_level_11a1s.length)
			    	   administrative_area_level_11a1s = results[0].address_components[i].long_name;
			       
			       else if(results[0].address_components[i].types[j]=="administrative_area_level_2" && results[0].address_components[i].long_name.length > administrative_area_level_21a1s.length)
			    	   administrative_area_level_21a1s = results[0].address_components[i].long_name;
			       
			       else if(results[0].address_components[i].types[j]=="administrative_area_level_3" && results[0].address_components[i].long_name.length > administrative_area_level_31a1s.length)
			    	   administrative_area_level_31a1s = results[0].address_components[i].long_name;
			       
			       else if(results[0].address_components[i].types[j]=="locality" && results[0].address_components[i].long_name.length > locality1a1s.length)
			    	   locality1a1s = results[0].address_components[i].long_name;
			       
			       else if(results[0].address_components[i].types[j]=="route" && results[0].address_components[i].long_name.length > route1a1s.length)
			    	   route1a1s = results[0].address_components[i].long_name;
			       
			       else if(results[0].address_components[i].types[j]=="street_number" && results[0].address_components[i].long_name.length > street_number1a1s.length)
			    	   street_number1a1s = results[0].address_components[i].long_name;
			    }
			}
			
			document.getElementById("edit-rt-full-address").value = street_number1a1s+", "+route1a1s+", "+locality1a1s+", "+administrative_area_level_31a1s+", "+administrative_area_level_21a1s+", "+administrative_area_level_11a1s+", "+country1a1s;
			//alert(document.getElementById("edit-rt-full-address").value);
		} else {
			alert("Geocode was not successful for the following reason: " + status);
		}
	});
	
	document.getElementById("edit-rt-location-x").value=marker.position.lat();		
	document.getElementById("edit-rt-location-y").value=marker.position.lng();
}

/*fix conflict ajax vs image field*/
/*accomodations*/
function rt_ente_num_rooms_change() {
	document.getElementById("edit-rt-entex-num-rooms").value=document.getElementById("edit-rt-ente-num-rooms").value;
}

function rt_ente_lower_price_change() {
	document.getElementById("edit-rt-entex-lower-price").value=document.getElementById("edit-rt-ente-lower-price").value;
}

function rt_ente_higher_price_change() {
	document.getElementById("edit-rt-entex-higher-price").value=document.getElementById("edit-rt-ente-higher-price").value;
}

/*enterteniametns*/
function rt_ente_schedule_change() {
	document.getElementById("edit-rt-entexx-schedule").value=document.getElementById("edit-rt-ente-schedule").value;
}

function rt_ente_price_change() {
	document.getElementById("edit-rt-entexx-price").value=document.getElementById("edit-rt-ente-price").value;
}

/*healths*/
function rt_ente_hschedule_change() {
	document.getElementById("edit-rt-healtx-schedule").value=document.getElementById("edit-rt-heal-schedule").value;
}

/*restaurants*/

function rt_rest_specialities_change() {
	document.getElementById("edit-rt-restx-specialities").value=document.getElementById("edit-rt-rest-specialities").value;
}

function rt_rest_avg_meal_price_change() {
	document.getElementById("edit-rt-restx-avg-meal-price").value=document.getElementById("edit-rt-rest-avg-meal-price").value;
}