<?php
// $Id: template.php,v 1.10.4.3 2010/12/14 03:30:39 danprobo Exp $
function danland_page_class($sidebar_first, $sidebar_second) {
	if ($sidebar_first && $sidebar_second) {
		$id = 'layout-type-2';	
	}
	else if ($sidebar_first || $sidebar_second) {
		$id = 'layout-type-1';
	}

	if(isset($id)) {
		print ' id="'. $id .'"';
	}
}

function danland_preprocess_html(&$vars) {
  	// Add conditional CSS for IE6.
	drupal_add_css(path_to_theme() . '/style.ie6.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'IE 6', '!IE' => FALSE), 'preprocess' => FALSE));
	
	//js for plan_trip
	if (strpos($_SERVER['REQUEST_URI'],'/planning/')) {
		drupal_add_css('sites/all/modules/plan_trip/plan_trip.css');
		//drupal_add_js('https://maps.google.com/maps/api/js?sensor=false');
		drupal_add_js('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false');
		
		drupal_add_js('sites/all/modules/plan_trip/plan_trip_googlemaps.js');
		drupal_add_js('sites/all/modules/plan_trip/infobox.js');
		
		drupal_add_js('misc/ui/jquery.ui.core.min.js');
		drupal_add_js('misc/ui/jquery.ui.widget.min.js');
		drupal_add_js('misc/ui/jquery.ui.mouse.min.js');
		drupal_add_js('misc/ui/jquery.ui.draggable.min.js');
		drupal_add_js('misc/ui/jquery.ui.droppable.min.js');
	}
}

function danland_preprocess_maintenance_page(&$variables) {
  if (!$variables['db_is_active']) {
    unset($variables['site_name']);
  }
  drupal_add_css(drupal_get_path('theme', 'danland') . '/maintenance.css');
  drupal_add_js(drupal_get_path('theme', 'danland') . '/scripts/jquery.cycle.all.js');
}

if (drupal_is_front_page()) {
  drupal_add_js(drupal_get_path('theme', 'danland') . '/scripts/jquery.cycle.all.js');
}