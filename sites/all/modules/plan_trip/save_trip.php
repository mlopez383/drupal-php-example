<?php 
	
	
	if($_SERVER['SERVER_NAME']=='127.0.0.1'){
		$folderj = substr($_SERVER['REQUEST_URI'],1);
		$posposj = strpos($folderj, '/');
		$folderj = '/'.substr($folderj,0,$posposj);
	}else{
		$folderj = '';
	}
	
	
	$path = $_SERVER['DOCUMENT_ROOT'];
	chdir($path.$folderj);             //chdir($path."/FunnyTrip6");
	define('DRUPAL_ROOT', getcwd()); //the most important line
	require_once './includes/bootstrap.inc';
	drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
	
	$cidder = $_POST['cityq2q3'];
	$idtripb = $_POST['tripq2q3'];
	
	
	foreach($cidder as $row){
		if(substr($row,0,3)=="dia") {$diadiaf = substr($row,3);}
		else{
			if (is_array($row)){//services
				foreach($row as $fil){
					//echo "[".$idtripb.", ".$fil.", ".$diadiaf.", S]";
					
					db_insert('wptsc_trips_resources')
						->fields(array(
								'trip_id' => $idtripb,
								'resource_id' => $fil,
								'daydata' => $diadiaf,
								'category' => 'S',
						))
						->execute();
						
				}	
			}else{//pois
				//echo "[".$idtripb.", ".$row.", ".$diadiaf.", P]";
				
				db_insert('wptsc_trips_resources')
					->fields(array(
							'trip_id' => $idtripb,
							'resource_id' => $row,
							'daydata' => $diadiaf,
							'category' => 'P',
					))
					->execute();
					
			}
		}
	}
	
	//print_r($cidder);
	echo "Saved";
?>