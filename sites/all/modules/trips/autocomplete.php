<?php 

function _trips_autocomplete($string) {
		
	$query = db_select('wptsc_resource_infos', 'ri');
	$query->join('wptsc_resources', 'r', 'r.id=ri.resource_id');
	$query
		->condition('r.type', 1, '=')
		->condition('ri.name', '%'.db_like($string).'%', 'LIKE')
		->fields('ri', array('resource_id','name'))
		->range(0, 7);
	$resultw=$query->execute();
	
	
	$cadenajjj='';
	foreach ($resultw as $row) {
		$cadenajjj.='{"id":"'.$row->resource_id.'","name":"'.$row->name.'"},';
	}
	$json_response = '['.substr($cadenajjj, 0, -1).']'; 
	
	if($_GET["callback"]) {
		$json_response = $_GET["callback"] . "(" . $json_response . ")";
	}
	
	echo $json_response;
}

//chdir('../../../../');
//if($_SERVER['SERVER_NAME']=='127.0.0.1'){
	$folderj = substr($_SERVER['REQUEST_URI'],1);
	$posposj = strpos($folderj, '/');
	$folderj = '/'.substr($folderj,0,$posposj);
//}else{
//	$folderj = '';
//}

$path = $_SERVER['DOCUMENT_ROOT'];
chdir($path.$folderj);            //chdir($path."/FunnyTrip6");
define('DRUPAL_ROOT', getcwd()); //the most important line
require_once './includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

_trips_autocomplete($_GET['q']);





