<?php 
	$nodewptrip = substr($_GET['q'],9);

	$result = db_query('SELECT entity_id, revision_id, field_dates_value, field_dates_value2 FROM field_data_field_dates WHERE bundle=\'trips\' AND entity_id='.$nodewptrip);
	
	$cant_dias=0;
	
	foreach ($result as $row) {
		$inisx = substr($row->field_dates_value,0,10);
		$finsx = substr($row->field_dates_value2,0,10);
		$date1 = new DateTime($inisx);
		$date2 = new DateTime($finsx);
		$interval = $date1->diff($date2);
		$cant_dias=$interval->d;
	}

?>

<script type="text/javascript">
		
	jQuery(document).ready(function($) {
		
		var countcitywpts=0;
		var countelimwptsc=0;
		var countelimcity=0;
        
		var sizesidebarizqw=305;
		jQuery("#map_canvas").width(jQuery(window).width()-sizesidebarizqw);
		jQuery(window).resize(function() {
			jQuery("#map_canvas").width(jQuery(window).width()-sizesidebarizqw);
		});

		
		jQuery("#poisdraggablewptsc").find('ul').find('li').draggable({
			helper : 'clone',
			appendTo : 'body'
		});

		<?php for($i=0; $i<$cant_dias; $i++){ ?>
		
			jQuery("#daywpf<?php echo $i;?>").droppable({
				drop: function( event, ui ) {
					countcitywpts++;
					var nomec=ui.draggable.find(".namemm").text();
					var idpoisc=ui.draggable.find(".idpoismm").text();
					
					var modificarlp=true;
					
					if(jQuery('#listplaceswptsc<?php echo $i;?>').length){
						jQuery('#listplaceswptsc<?php echo $i;?>').children('li').each(function(index) {
							if(jQuery(this).find(".citywpts").text()==nomec){ modificarlp=false;}
						});

						if(modificarlp){
							countelimcity++;
							jQuery('#listplaceswptsc<?php echo $i;?>').append('<li><div id="idcitywpts'+countcitywpts+'" class="citywpts">'+nomec+'<a href="#" id="idelimwptscit'+countelimcity+'" class="elimwptsc"><img src="../<?php echo drupal_get_path('module', 'plan_trip'); ?>/delete.png" alt="Delete" /></a></div><div class="idpoismmm" style="display: none;">'+idpoisc+'</div></li>');
						}	
					}else{
						modificarlp=true;
						countelimcity++;
						jQuery('#daywpf<?php echo $i;?>').after('<ul class="listsinbullet" id="listplaceswptsc<?php echo $i;?>"><li><div id="idcitywpts'+countcitywpts+'" class="citywpts">'+nomec+'<a href="#" id="idelimwptscit'+countelimcity+'" class="elimwptsc"><img src="../<?php echo drupal_get_path('module', 'plan_trip'); ?>/delete.png" alt="Delete" /></a></div><div class="idpoismmm" style="display: none;">'+idpoisc+'</div><div class="diammm" style="display: none;"><?php echo $i;?></div></li></ul>');
					}

					if(modificarlp){
						jQuery("#idelimwptscit"+countelimcity).live('click', function(){
							if(jQuery(this).parent('div').parent('li').parent('ul').children().size()==1){
								jQuery(this).parent('div').parent('li').parent('ul').remove();
							}else{
								jQuery(this).parent('div').parent('li').remove();
							}
						});
					}

					jQuery("#idcitywpts"+countcitywpts).droppable({
						drop: function( event, ui ) {
							countelimwptsc++;
							var nameservcc = ui.draggable.find(".namesermm").text();
							//alert(ui.draggable.text());
							//alert(nameservcc);
							var idservcc = ui.draggable.find(".idservvmm").text();
							if(jQuery(this).parent().find('ul').text().length){
								jQuery(this).parent().find('ul').append('<li><div class="droppablewptsc">'+nameservcc+'<a href="#" id="idelimwptsc'+countelimwptsc+'" class="elimwptsc"><img src="../<?php echo drupal_get_path('module', 'plan_trip'); ?>/delete.png" alt="Delete" /></a></div><div class="idservsmmm" style="display: none;">'+idservcc+'</div></li>');
							}else{	
								jQuery(this).after('<ul class="listsinbullet"><li><div class="droppablewptsc">'+nameservcc+'<a href="#" id="idelimwptsc'+countelimwptsc+'" class="elimwptsc"><img src="../<?php echo drupal_get_path('module', 'plan_trip'); ?>/delete.png" alt="Delete" /></a></div><div class="idservsmmm" style="display: none;">'+idservcc+'</div></li></ul>');	
							}

							jQuery('#idelimwptsc'+countelimwptsc).live('click', function(){
								if(jQuery(this).parent('div').parent('li').parent('ul').children().size()==1){
									jQuery(this).parent('div').parent('li').parent('ul').remove();
								}else{
									jQuery(this).parent('div').parent('li').remove();
								}
					        });
					
						}
					});

					jQuery("#idcitywpts"+countcitywpts).live('click', function(){
						var	vbnvcgv=jQuery(this).text();  //jQuery(this).html();
						
						jQuery('#servidraggablewptsc').load('../<?php echo drupal_get_path('module', 'plan_trip'); ?>/list_touristic_resources.php', {cityq2q3: vbnvcgv, fechaini: <?php echo substr($inisx,0,4).substr($inisx,5,2).substr($inisx,8,2);?>, nndia: <?php echo $i;?>}, function() {

							setmarkersonmap();
							//dragag();
						});
					});
				}
			});

			jQuery("#daywpf<?php echo $i;?>").click(function () {
				jQuery('#listplaceswptsc<?php echo $i;?>').toggle();
			});
			
		<?php } ?>

		jQuery("#mosdelitos").click(function () {
				setdelitosonmap();
		});
		
		jQuery("#savewptsc").click(function () {

			dadoshaha = new Array;
			jQuery('#menuizqwptsc > ul').children().each(function(index) {
				
				if(jQuery(this).find(".diammm").html())
					dadoshaha.push("dia"+jQuery(this).find(".diammm").html());
				
				dadoshaha.push(jQuery(this).find(".idpoismmm").html());
								
				parteshaha = new Array;	
				jQuery(this).find('ul').children().each(function(index1) {
					parteshaha.push(jQuery(this).find(".idservsmmm").html());
				});
					
				if(parteshaha.length>0)
					dadoshaha.push(parteshaha);				
			});
			
			
			jQuery("#savewptsc").load('../<?php echo drupal_get_path('module', 'plan_trip'); ?>/save_trip.php', {tripq2q3: <?php echo $nodewptrip; ?>, cityq2q3: dadoshaha}, function() {
				//
			});
		});
	
	});
		
</script>

<?php 
//if($_SERVER['SERVER_NAME']=='127.0.0.1'){
	$folderj = substr($_SERVER['REQUEST_URI'],1);
	$posposj = strpos($folderj, '/');
	$folderj = '/'.substr($folderj,0,$posposj);
//}else{
//	$folderj = '';
//}

?>
		
<div id="contenedorwptsc">
	<div id="cabecerawptsc">
		<a href="<?php echo $folderj?>" class="actionButton">Home</a>
	
		
		<span id="savewptsc" style="float: right; margin:4px;">
			<a href="#" class="actionButton"><?php echo t('Guardar'); ?></a>
		</span>
		
			
		<span id="mosdelitos"  style="float:right; margin:4px;">
			<a href="#" class="actionButton">Mostrar</a>
		</span>
		
	</div>
	<div style="clear: both;"></div>
	
	<div id="contenidowptsc">
		
		<div id="mapawptsc">
			
			<script type="text/javascript">
			  	window.onload = function() {
				  	initialize();
				}
			</script>
			<div id="map_canvas" style="width:300px;height:300px;"></div>
			
			<?php echo t('Ciudades'); ?>:
			<div id="poisdraggablewptsc" class="ui-widget-content">
               	<ul class="listsinbullet">
	               	<?php 
	               		$matches = array();
	               		$query = db_select('wptsc_resource_infos', 'ri');
	               		$query->join('wptsc_trips_resources', 'tr', 'tr.resource_id=ri.resource_id');
	               		$query->condition('tr.trip_id', $nodewptrip, '=')
	               			  ->fields('ri', array('resource_id','name'));
	               		$resultw=$query->execute();
	               		
	               		foreach ($resultw as $row) {
	                   		echo '<li class="poisitemdragablewp">';
	                   		echo '<div class="namemm">';
	                   		echo $row->name;
	                   		echo '</div>';
	                   		echo '<div class="idpoismm" style="display: none;">';
	                   		echo $row->resource_id;
	                   		echo '</div>';
	                   		echo '</li>';	
	               		} 
	               	?>
               	</ul>
           </div>
            
            <br><?php echo t('Lugares'); ?>:
            <div id="servidraggablewptsc" class="ui-widget-content"></div>
            
		</div>
			
						
		<div id="menuizqwptsc">
			
			<?php for($i=0; $i<$cant_dias; $i++){ 
					if($i>0){ $date1->add(new DateInterval('P1D')); };
                    
				?>
				<h1 id="daywpf<?php echo $i;?>" class="titledaywportal">
					<span class="titlewpft"><strong>Dia <?php echo ($i+1); echo '</strong>'; echo '&nbsp;&nbsp;&nbsp;<em>('; echo $date1->format('d/m/Y'); echo ')</em>'; ?></span>
				</h1>
			<?php } ?>
			
		</div>
		
	</div>
</div>



	               	<!--  
<div id="menuizqwptsc">
			
		<h1 id="daywpf0" class="titledaywportal ui-droppable">
		<span class="titlewpft">Day 1</span></h1>
			<ul class="listsinbullet" id="listplaceswptsc0">
				<li>
					<h2 id="idcitywpts1" class="citywpts ui-droppable">Braga</h2>
					<ul class="listsinbullet">
						<li><div class="droppablewptsc">restaurant maximos85</div></li>
						<li><div class="droppablewptsc">hotel bragak87</div></li>
					</ul>
					<div class="idpoismmm" style="display: none;">82</div>
				</li>
			</ul>
		<h1 id="daywpf1" class="titledaywportal ui-droppable">
		<span class="titlewpft">Day 2</span></h1>
			<ul class="listsinbullet" id="listplaceswptsc1">
				<li>
					<h2 id="idcitywpts2" class="citywpts ui-droppable">Roma</h2>
					<div class="idpoismmm" style="display: none;">84</div>
				</li>
			</ul>
						
		</div>
		
		-->