<?php
try {  
	//MySQL with PDO_MYSQL    
	$pdo = new PDO('mysql:host=localhost; dbname=practice', 'root', $pass);  
}
catch(PDOException $e) {  
	echo $e->getMessage();  
}
