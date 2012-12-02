<?php 
	
//	if($_SERVER['SERVER_NAME']=='127.0.0.1'){
		$folderj = substr($_SERVER['REQUEST_URI'],1);
		$posposj = strpos($folderj, '/');
		$folderj = '/'.substr($folderj,0,$posposj);
//	}else{
//		$folderj = '';
//	}
	
	
	$path = $_SERVER['DOCUMENT_ROOT'];
	chdir($path.$folderj);             //chdir($path."/FunnyTrip6");
	define('DRUPAL_ROOT', getcwd()); //the most important line
	require_once './includes/bootstrap.inc';
	drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
	
	$cidder = $_POST['cityq2q3'];
	
	
	$result = db_query('SELECT s.resource_ptr_id, ri."name", s.address, x("location"), y("location") FROM wptsc_services AS s, wptsc_resource_infos AS ri WHERE s.resource_ptr_id=ri.resource_id AND (s.address LIKE \'%,%,%,%,%,%'.$cidder.'%,%\' OR s.address LIKE \'%,%,%,%,%'.$cidder.'%,%,%\' OR s.address LIKE \'%,%,%,%'.$cidder.'%,%,%,%\' OR s.address LIKE \'%,%,%'.$cidder.'%,%,%,%,%\');');
	
	echo '<ul class="listsinbullet">';
	
	$i=0;
	foreach ($result as $row) {
		$i++;
		echo '<li class="servitemdragablewp">';
		echo '<div class="namesermm">'.$row->name.'</div>';
		echo '<div class="idservvmm" style="display: none">'.$row->resource_ptr_id.'</div>';
		echo '</li>';
		echo '<input type="hidden" id="locx'.$i.'" value="'.$row->x.'" />';
		echo '<input type="hidden" id="locy'.$i.'" value="'.$row->y.'" />';
		echo '<input type="hidden" id="nmea'.$i.'" value="'.$row->name.'" />';
		echo '<input type="hidden" id="idrr'.$i.'" value="'.$row->resource_ptr_id.'" />';
	}
	
	//echo '<li class="servitemdragablewp">'.print_r($HTTP_COOKIE_VARS).'</li>';
	echo '</ul>';
	echo '<input type="hidden" id="cantlocxy" value="'.$i.'" />';
?>