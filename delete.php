<?php //delete.php
require_once('pdo.php');

//Capture data from Ajax
$ids = $_POST['id_array'];

//Create a to be deleted List
function prepSelected($ids){
	$current = 0;
	$count = count($ids);
	
	$keys = ''; $placeholders = ''; $selected = array();		
	$i = 0;
		
	foreach($ids as $item){
		switch($item){
			case $ids[$i] : array_push($selected, $item);
			break;
		}
		$i++;
	}
		
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
function deleteData($pdo, $sql_vals){
	$keys = $sql_vals[0];
	$placeholders = $sql_vals[1];
	
	$keys = explode(',', $keys);
	foreach($keys as $key){
		$sql = "DELETE FROM users WHERE id=" .$key; 
		$result = $pdo->query($sql);
		echo $key.',';	
	}
}

$sql_vals = prepSelected($ids);
deleteData($pdo, $sql_vals);
//echo $keys;


