var geocoder;
var mapwptsc;
var latlngwptsc;

var markerswptsc = [];
var infoswptsc = [];
var bounds;

function initialize() {
	geocoder = new google.maps.Geocoder();
	latlngwptsc = new google.maps.LatLng(41.14961, -8.61099);
		
	var myOptions = {
		zoom: 14,
		center: latlngwptsc,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	mapwptsc = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
}


function addMarker(xvx, yvy) {
    markerswptsc.push(new google.maps.Marker({
      position: new google.maps.LatLng(xvx, yvy),
      map: mapwptsc,
      draggable: false,
    }));
}

var markidjj=0;


function attachSecretMessage(idmarker, iddvidd, nmvnmb, ccllc) {
	markidjj++;
	//onclick="dragag();"  onmouseover="dragag(this);"
	var boxText = document.createElement("div");
	boxText.style.cssText = "border: 1px solid black; margin-top: 8px; background: yellow; padding: 5px;";
	boxText.innerHTML = '<div id="btmarkinfo'+markidjj+'" class="ui-widget-content" onmouseover="dragag1('+markidjj+');"><ul class="listsinbullet"><li class="servitemdragablewp2" style="cursor: move;"><div class="namesermm">'+nmvnmb+'</div><div class="idservvmm" style="display: none">'+iddvidd+'</div></li></ul></div>';

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
		//(infoswptsc[idmarker]).show();
	});
	
	//(infoswptsc[idmarker]).open(mapwptsc, markerswptsc[idmarker]);
	//(infoswptsc[idmarker]).hide();
}


function dragag1(hn){
	jQuery("#btmarkinfo"+hn).find('ul').find('li').draggable({
		helper : 'clone',
		appendTo : 'body'
	});
	jQuery("#btmarkinfo"+hn).removeAttr("onmouseover");
}


function elimarrker(){
	var i=0;
	for (i=0; i<markerswptsc.length; i++){
		markerswptsc[i].setMap(null);
		infoswptsc[i].close();
	}
	markerswptsc = [];
	infoswptsc = [];
}


function setmarkersonmap(){
	elimarrker();
	var i=0;
	var cantloca = 1*document.getElementById("cantlocxy").value;
	bounds = new google.maps.LatLngBounds();
	
	for (i=1; i<=cantloca; i++)
	{
		xxvxx = eval("document.getElementById('locx"+i+"').value");
		yyvyy = eval("document.getElementById('locy"+i+"').value");
		nmvnm = eval("document.getElementById('nmea"+i+"').value");
		ddvdd = eval("document.getElementById('idrr"+i+"').value");
		
		addMarker(xxvxx, yyvyy);
						
		bounds.extend(new google.maps.LatLng(xxvxx, yyvyy));
		mapwptsc.fitBounds(bounds);
				
		attachSecretMessage(i-1, ddvdd, nmvnm, cantloca);
	}

	jQuery("#servidraggablewptsc").find('ul').find('li').draggable({
		helper : 'clone',
		appendTo : 'body'
	});
}

function setdelitosonmap(){
	var i=0;
	var cantlocad = 1*document.getElementById("delcantlocxy").value;
	
	for (i=1; i<=cantlocad; i++)
	{
		xxvxx = eval("document.getElementById('delocx"+i+"').value");
		yyvyy = eval("document.getElementById('delocy"+i+"').value");
		nmvnm = eval("document.getElementById('detipo"+i+"').value");
		
		
		var image = '../sites/all/modules/plan_trip/images/abduction.png';
        if(nmvnm=='ROBO CON ARMA'){
            ic =asaltoIcon;
        }else if(nmvnm=='ROBO-HURTO'){
        	image = "../sites/all/modules/plan_trip/images/theft.png";
        }else if(nmvnm=='PERSONA DESAPARECIDA'){
        	image = "../sites/all/modules/plan_trip/images/shooting.png";
        }else if(nmvnm=='HOMICIDIO'){
        	image = "../sites/all/modules/plan_trip/images/crimescene.png";
        }else if(nmvnm=='AGRESIONES-LESIONES'){
        	image = "../sites/all/modules/plan_trip/images/torture.png";
        }else if(nmvnm=='VIOLACION'){
        	image = "../sites/all/modules/plan_trip/images/rape.png";
        }else if(nmvnm=='HECHO DE TRANSITO'){
        	image = "../sites/all/modules/plan_trip/images/caraccident.png";
        }else if(nmvnm=='INCENDIO'){
        	image = "../sites/all/modules/plan_trip/images/fire.png";
        }else if(nmvnm=='VENTA O TRAFICO DE DROGAS'){
            image = "../sites/all/modules/plan_trip/images/narcotics.png";
        }
		
		
		markerswptsc.push(new google.maps.Marker({
		      position: new google.maps.LatLng(xxvxx, yyvyy),
		      map: mapwptsc,
  	          icon: image,
  	          title:nmvnm
		    }));
		
						
		bounds.extend(new google.maps.LatLng(xxvxx, yyvyy));
		mapwptsc.fitBounds(bounds);
				
		//attachSecretMessage(i-1, ddvdd, nmvnm, cantloca);
	}
	
}




