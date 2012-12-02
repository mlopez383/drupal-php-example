<?php print $fechast ?>
<strong>
	<font size="5pt"> <a style="float:right" href="../planning/<?php print $nodewpt ?>">PLAN TRIP&nbsp;&nbsp;&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;
</font>
</strong>
<br />
<?php print $citiest ?>
<br />

<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="../sites/all/modules/trip_list/infobox.js"></script>
<script type="text/javascript">
	var mapwptsc;//
	
	var markerswptsc = [];//
	var infoswptsc = [];
	
	function addMarker(xvx, yvy) {
	    markerswptsc.push(new google.maps.Marker({
	      position: new google.maps.LatLng(xvx, yvy),
	      map: mapwptsc,
	      draggable: false,
	    }));
	}

	function initialize() {
		var myOptions = {
			zoom: 14,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		mapwptsc = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
		var bounds = new google.maps.LatLngBounds();

		
		<?php print $maist ?>

		var listener = google.maps.event.addListener(mapwptsc, "idle", function() { 
		  if (mapwptsc.getZoom() > 16)  mapwptsc.setZoom(16); 
		  google.maps.event.removeListener(listener); 
		});
					
	}

	
	function attachSecretMessage(idmarker, nmvnmb, ccllc) {
	
		var boxText = document.createElement("div");
		boxText.style.cssText = "border: 1px solid black; margin-top: 8px; background: yellow; padding: 5px;";
		boxText.innerHTML = '<div class="ui-widget-content">'+nmvnmb+'</div>';

		var myOptions1 = {
				 content: boxText
				,disableAutoPan: false
				,maxWidth: 0
				,pixelOffset: new google.maps.Size(-125, 0)
				,zIndex: null
				,boxStyle: { 
				  background: "url('../sites/all/modules/plan_trip/tipbox.gif') no-repeat"
				  ,opacity: 0.85
				  ,width: "250px"
				 }
				,closeBoxMargin: "10px 2px 2px 2px"
				,closeBoxURL: "../sites/all/modules/plan_trip/close.gif"
				,infoBoxClearance: new google.maps.Size(1, 1)
				,isHidden: false
				,pane: "floatPane"
				,enableEventPropagation: false
			};
		
		infoswptsc.push(new InfoBox(myOptions1));
			
		
		google.maps.event.addListener(markerswptsc[idmarker], 'click', function () {
			(infoswptsc[idmarker]).open(mapwptsc, this);
			
			for (b=0; b<ccllc; b++){
				if(idmarker!=b) (infoswptsc[b]).close();
			}	
		});
	}

	window.onload = function() {
	  	initialize();
	}
</script>
<div align="center"><div id="map_canvas" style="width: 650px; height: 400px"></div></div>
