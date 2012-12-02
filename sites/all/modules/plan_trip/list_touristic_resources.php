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
	$ndia = $_POST['nndia'];
	$fechaini = $_POST['fechaini'];
	
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
	
	
	$result = db_query('SELECT delito_id, x("location"), y("location"), departamento, municipio, address, fecha, hora, tipo, hecho FROM wptsc_delitos WHERE departamento LIKE \'%'.strtoupper($cidder).'%\';');
	
	$i=0;
	
	foreach ($result as $row) {
		$i++;
		echo '<input type="hidden" id="detipo'.$i.'" value="'.$row->tipo.'" />';
		echo '<input type="hidden" id="delocx'.$i.'" value="'.$row->x.'" />';
		echo '<input type="hidden" id="delocy'.$i.'" value="'.$row->y.'" />';
	}
	echo '<input type="hidden" id="delcantlocxy" value="'.$i.'" />';
	
	
	
	
	
	$algo="";
	$conflictos = array(); 
	$content = file_get_contents("https://conflictosbolivia.crowdmap.com/"); 
	
	
	$fechaini=new DateTime(substr($fechaini,0,4).'-'.substr($fechaini,4,2).'-'.substr($fechaini,6,2));
	if($ndia>0) $fechaini->add(new DateInterval('P'.$ndia.'D'));
	$fecharecibida = $fechaini->format('Y-m-d');
	
	if (  preg_match_all('|<tr>\n\t\t\t<td>(.*?)</td>\n\t\t\t<td>(.*?)</td>\n\t\t\t<td>(.*?)</td>\n\t\t</tr>|', $content , $matchs  )  ) 
	{ 
					
			foreach( $matchs[0] as $k => $v ) 
			{ 
					$xtitulo = trim(strip_tags($matchs[1][$k]));
					$xubicacion = trim($matchs[2][$k]);
					$xfecha = trim($matchs[3][$k]);
					
					$mes=substr($xfecha,0,3);
					switch($mes){
						case 'Ene': $mes1='01'; break;
						case 'Feb': $mes1='02'; break;
						case 'Mar': $mes1='03'; break;
						case 'Abr': $mes1='04'; break;
						case 'May': $mes1='05'; break;
						case 'Jun': $mes1='06'; break;
						case 'Jul': $mes1='07'; break;
						case 'Ago': $mes1='08'; break;
						case 'Sep': $mes1='09'; break;
						case 'Oct': $mes1='10'; break;
						case 'Nov': $mes1='11'; break;
						case 'Dic': $mes1='12'; break;
					}
					
					$xfecha1=substr($xfecha,7,4).'-'.$mes1.'-'.substr($xfecha,4,2);
									
					if ((stripos($xubicacion, $cidder)!= false) && ($xfecha1==$fecharecibida)) {
						$algo.=($xtitulo.'< /br>');
					}
			} 
	}  
	
	echo $algo;
?>