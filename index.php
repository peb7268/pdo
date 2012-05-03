<?php //include db
if(isset($_POST['submit'])){
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
} 


try {  
  //MySQL with PDO_MYSQL    
  $pdo = new PDO('mysql:host=localhost; dbname=practice', 'root', $pass);  
  //$data = array('', $first_name, $last_name, $email, $password); 
  
  //$stmnt = $pdo-> prepare("INSERT INTO users (id, first_name, last_name, email, password) values (?, ?, ?, ?, ?)");
  //$stmnt->setFetchMode(PDO::FETCH_ASSOC);
  //$stmnt->execute($data);
}  
catch(PDOException $e) {  
    echo $e->getMessage();  
}

  
?>
<!DOCTYPE html>

<!--[if lt IE 7]>      <html class="ie6"> <![endif]-->
<!--[if IE 7]>         <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if gt IE 8]><!--> <html>         <!--<![endif]-->

<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>Page Title</title>
	<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="print.css" type="text/css" media="print" title="no title" charset="utf-8">
	
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" src="js/global.js" charset="utf-8"></script>
</head>

<body>


<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	
	<p><label>First Name: </label><input type="text" name="first_name"></p>
	<p><label>Last Name:</label> <input type="text" name="last_name"></p>
	<p><label>Email: </label><input type="email" required="required" name="email"></p>
	<p><label>Password:</label> <input type="password" name="password"></p>
	
	<p><input type="submit" name="submit" value="Continue &rarr;"></p>
</form>
<?php
function selectAll($pdo){
	$sql = "SELECT * FROM users";
	foreach($pdo->query($sql) as $row){
		echo $row['first_name'].$row['last_name'].'<br />';
		echo $row['email'];
		echo $row['password'];
	}
}	
selectAll($pdo);
?>


</body>
</html>