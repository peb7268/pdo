<?php
require_once('pdo.php');

//Capture data from Ajax
$data = $_POST['data'];


//Create a to be deleted List
function prepSelected($data){
	
	$current = 0;
	$count = count($data);
	
	$placeholders = ''; $selected = array(); $i = 0;
	$keys = array_keys($data); 
	
	foreach($keys as $item){
		print_r($data);
		
		switch($item){
			case $data[$i] == $keys[$i] : array_push($selected, $item);
			break;
		}
		$i++;
	}
	print_r($selected);
		
	//While there are selected items
	while($current < $count){
		//create the keys	
		if($count == 1) { 
			$keys .= $selected[$current];
		} else {
			$keys .= $selected[$current].',';
		} 	
		//create the placeholders	
		if($count == 1) { 
			$placeholders .= '?';
		} else {
			$placeholders .= '?,';
		} 	
		$current++; 
	}
	if($count > 1){
		$keys = explode(',', $keys);
		$trash = array_pop($keys);
		$keys = implode(',', $keys);
			
		$placeholders = explode(',', $placeholders);
		$trash = array_pop($placeholders);
		$placeholders = implode(',', $placeholders);
			
	}
	

	
	return $sql_vals = array($keys, $placeholders);
}
function updateData($pdo, $sql_vals){
	$keys = $sql_vals[0];
	$placeholders = $sql_vals[1];
	
	//echo  $keys;
	//echo  $placeholders;
	
	$keys = explode(',', $keys);
	// foreach($keys as $key){
	// 	$sql = "UPDATE users WHERE id=" .$key; 
	// 	$result = $pdo->query($sql);
	// 	echo $key.',';	
	// }
	
}

$sql_vals = prepSelected($data);
updateData($pdo, $sql_vals);
