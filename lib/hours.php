<?php

$clean = $_GET["cleanCache"];

$resetCache = 0;

if ($clean == "1") $resetCache = 1;
$halfCache = 0;

$locationReset = $_GET["locReset"];

$expireLong = 60*5; // 24 hours
$expireShort = 60*5; // 5 minutes
date_default_timezone_set("America/New_York");

function getHours() {
	global $resetCache, $expireLong, $expireShort, $locationReset; 
	
	$key = "getHours";
	$expire = $expireShort; 
	$data = get_transient( $key );
	
	if ($data === false || $resetCache) {
		
		// gets the entire hours object;
		global $post;
		
		$gHours = array();
		
		$args = array(
			'post_type' => 'hours',
			'posts_per_page' => -1,
			'post_parent' => 0,
		);
		
		$hours = new WP_Query( $args );
		while($hours->have_posts()):
			
			$hours->the_post();
			$id = get_the_ID();
			
			
			$name = get_the_title();
			
			$description = get_field("description");
			
			$start = get_field("start");
			$end = get_field("end");
			
			$spanning = get_field("show_spanning");
			
			$term = get_field("is_term");
			
			$location = get_field("associated_location");
			$locationId = $location->ID;
			
			$arHours[$locationId] = array(
				'name' => $name,
				'description' => $description,
				'start' => $start,
				'end' => $end,
				'show_spanning' => $spanning,
				'term' => $term,
				'terms' => getHoursChildren($id)
			);
		endwhile;
		
		wp_reset_query();
		
		$data = $arHours;
		set_transient( $key, $data, $expire );
	}
		
	return $data;
}

function getHoursChildren($parent) {
	$arHours = array();
	
	$args = array(
		'post_type' => 'hours',
		'posts_per_page' => -1,
		'post_parent' => $parent
	);
	
	
	$hours = new WP_Query( $args );

	while($hours->have_posts()):
		
		$hours->the_post();
		$id = get_the_ID();
		
		$name = get_the_title();
		
		$description = get_field("description");
		
		$start = get_field("start");
		$end = get_field("end");
		
		$spanning = get_field("show_spanning");
		
		$term = get_field("is_term");
		
		$arHours[$id] = array(
			'name' => $name,
			'description' => $description,
			'start' => $start,
			'end' => $end,
			'show_spanning' => $spanning,
			'term' => $term,
			'hours' => getHoursChildren($id)
		);
	endwhile;
	wp_reset_query();
	
	
	return $arHours;	
}

function getHoursToday($locationId) {
	global $resetCache, $expireLong, $expireShort, $locationReset; 
	$date = date("Y-m-d");
	$key = "getHoursToday-$locationId-$date";
	$expire = $expireShort;
	$data = get_transient( $key );
	
	if ($data === false || $resetCache || $locationReset == $locationId) {
		$data = getHoursDay($locationId, strtotime("Now"));
		set_transient( $key, $data, $expire );
	}
	return $data;
}

function hasHours($locationId) {
	global $resetCache, $expireLong, $expireShort, $locationReset; 
	$date = date("Y-m-d");
	$key = "hasHours-$locationId-$date";
	$expire = $expireShort;
	$data = get_transient( $key );
	
	if ($data === false || $resetCache || $locationReset == $locationId) {
		$arHours = getHours();
		
		$dt = strtotime("Now");
		$term = getTerm($arHours, $locationId, $dt);
		
		if (count($term)==0) {
			// no hours
			$data = 0;
		} else {
			$data = 1;
		}
		set_transient( $key, $data, $expire );		
	}
	
	return $data;
}

function getHoursDay($locationId, $dt) {
	global $resetCache, $expireLong, $expireShort, $locationReset; 
	$key = "getHoursDay-$locationId-$dt";
	$expire = $expireShort;
	$data = get_transient( $key );
	
	if ($data === false || $resetCache || $locationReset == $locationId) {


		$data = "";
		$today = $dt;
		//$today = strtotime("2013-04-20");
		$dt = $today; 
		
		//echo "{{".date("Y-m-d", $dt)."}}";
		
		$arHours = getHours();
			
		$term = getTerm($arHours, $locationId, $dt);
		//print_r($term);
		$hour = getTermHour($term, $dt);
		
		
		if (count($term)==0) {
			// no hours
			$data = "TBA";
		} else if (count($hour)==0) {
			// no hours
			$data = "TBA";
		} else {
			$data = $hour["description"];
		}
		
		set_transient( $key, $data, $expire );		
	}
	return $data;
}

function getMobileHoursDay($locationId, $dt) {
	global $resetCache, $expireLong, $expireShort, $locationReset; 
	$key = "getMobileHoursDay-$locationId-$dt";
	$expire = $expireShort;
	$data = get_transient( $key );
	
	if ($data === false || $resetCache || $locationReset == $locationId) {


		$data = "";
		$today = $dt;
		//$today = strtotime("2013-04-20");
		$dt = $today; 
		
		//echo "{{".date("Y-m-d", $dt)."}}";
		
		$arHours = getHours();
			
		$term = getTerm($arHours, $locationId, $dt);
		//print_r($term);
		$hour = getTermHour($term, $dt);
		
		
		if (count($term)==0) {
			// no hours
			$data = "TBA";
		} else if (count($hour)==0) {
			// no hours
			$data = "TBA";
		} else {
			$data = hourToMobile($hour["description"]);
		}
		
		set_transient( $key, $data, $expire );		
	}
	return $data;
}

function getMessageDay($locationId, $dt) {
	global $resetCache, $expireLong, $expireShort, $locationReset; 
	$key = "getMessageDay-$locationId-$dt";
	$expire = $expireShort;
	$data = get_transient( $key );
	
	if ($data === false || $resetCache || $locationReset == $locationId) {


		$data = "";
		$today = $dt;
		//$today = strtotime("2013-04-20");
		$dt = $today; 
		
		$arHours = getHours();
			
		$term = getTerm($arHours, $locationId, $dt);
		$hour = getTermHour($term, $dt);
				
		$data = "";
		
		if ($hour["show_spanning"] == 1) {
			$data = $hour;
		}
		
		set_transient( $key, $data, $expire );		
	}
	return $data;
}


function getOpen($locationId) {
	$today = strtotime("Now");
	$dt = $today; 
	
	

	$arHours = getHours();
	
	$term = getTerm($arHours, $locationId, $dt);
	$hour = getTermHour($term, $dt);
	
	if (count($term)==0) {
		// no hours
		return false;
	}	
	
	if (count($hour)==0) {
		// no hours
		return false;
	}	

	
	return checkOpen($hour, $dt);
}

function checkOpen($hour, $dt) {
	$hrs = strtolower($hour["description"]);
	
	if (
		$hrs == "closed" || 
		$hrs == "tba" ||
		$hrs == ""
		) {
		return false;
	}
	
	
	
	$arRange = explode("-", $hrs);
	$start = strtotime($arRange[0]);
	
	if ($arRange[1] == "midnight") {
		$end = strtotime($arRange[1]." + 1 day");
	} else {
		$end = strtotime($arRange[1]);
	}
	
	if ($start <= $dt && $dt <= $end) {
		return true;
	}
	
	return false;
}

function getTerm($obj, $location, $dt) {
	global $resetCache, $expireLong, $expireShort, $locationReset; 
	
	$key = "getTerm-$location-$dt";
	$expire = $expireLong;
	$data = get_transient( $key );
	
	if ($data === false || $resetCache || $location == $locationReset) {
		
		$data = array();
		
		if ($obj[$location]) {
			// location exists
			$arTerms = $obj[$location]["terms"];
			
			foreach($arTerms as $termId => $term) {
				$start = $term["start"];
				$end = $term["end"];
				
				$start = strtotime($start);
				$end = strtotime($end);
				
				if ($start <= $dt && $dt <= $end) {
					$data = array(
						"id"=>$key,
						"term"=>$term
					);
				}
				
			}
			
		}
		
		set_transient( $key, $data, $expire );		
	}
	
	return $data;
}

function getTermHour($term, $dt) {
	// check for special days
	
	if (count($term) == 0) {
		return array();
	}
	
	$dtWeek = date("l", $dt);
	
	$arHours = $term["term"]["hours"];
	
	// Special days
	foreach($arHours as $hours) {
		$start = $hours["start"];
		if ($start != "") {
			$end = $hours["end"];
			
			if ($end == "") $end = $start;
			
			$start = strtotime($start);
			$end = strtotime($end);		
						
			if ($start <= $dt && $dt <= $end) {
				return $hours;
			}
		}
	}

	
	// Day match
	foreach($arHours as $hours) {
		$start = $hours["start"];
		if ($start == "") {
			// only normal days
			$name = $hours["name"];
			if ($name == $dtWeek) {
				return $hours;
			}
		}
	}
	
	// Day Span Match
	foreach($arHours as $hours) {
		$start = $hours["start"];
		if ($start == "") {
			// only span days
			$name = $hours["name"];
			if (strpos($name, "-") !== false) {
				if (dateSpanFit($name, $dtWeek)) {
					return $hours;
				} else {
				}
			}
		}
	}
	
	
	return array();
}

function dateSpanFit($range, $dt) {
	$arRange = explode("-", $range);
	
	$start = strtotime(trim($arRange[0]));
	$end = strtotime(trim($arRange[1]));
	
	$startDay = date("N", $start);
	$endDay = date("N", $end);
	
	$dtDay = date("N", strtotime($dt));
	
	if ($startDay <= $dtDay && $dtDay <= $endDay) {
		return true;
	}
	
	return false;
}

function hourToMobile($str) {
	$str = str_replace("midnight", "midn", $str);
	$str = str_replace("-", "<br/>", $str);
	$str = str_replace("am", "a", $str);
	$str = str_replace("pm", "p", $str);
	$str = str_replace("by appointment only", "appt only", $str);
	
	
	return $str;
}