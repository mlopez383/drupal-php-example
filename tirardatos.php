<?php 
//example by deerme.org xD 
$conflictos = array(); 
$content = file_get_contents("https://conflictosbolivia.crowdmap.com/"); 

if (  preg_match_all('|<tr>\n\t\t\t<td>(.*?)</td>\n\t\t\t<td>(.*?)</td>\n\t\t\t<td>(.*?)</td>\n\t\t</tr>|', $content , $matchs  )  ) 
{ 
        		
		foreach( $matchs[0] as $k => $v ) 
        { 
                $conflictos[] = array( 
						"titulo" => trim(strip_tags($matchs[1][$k])),
						"ubicacion" => trim($matchs[2][$k]),
						"fecha" => trim($matchs[3][$k]) 
                ); 
        } 

} 
print_r($conflictos);
?>