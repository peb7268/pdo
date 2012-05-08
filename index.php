<?php 
/* --------------- Next Steps --------------------------------*
- write a switch to check what the user is wanting to extract from the db, build that into a function


- Make a required array. if is !empty process.
- Make an errors array. If is empty process.
- scrub the data
- put in regex validation.
- refactor code
- turn whole script into a db class
*/

	//Get Access to the db. If it doesnt work catch an error and let us know
	require_once('pdo.php');
	
	//Select All Has to be in scope of a pdo
	function selectAll($pdo){
		$sql = "SELECT * FROM users";
		foreach($pdo->query($sql) as $row){
			echo '<p id="'.$row['id'].'">'.$row['first_name'].' '.$row['last_name'].'<br />';
			echo $row['email'].'<br />';
			echo $row['password'].'</p>';
		}
	}
	function debugSql($keys, $placeholders){
		echo 'keys are: '.$keys.'<br />';
		echo 'placeholders are: '. $placeholders;
	}
	function loopData($row, $item, $keys){
		$i = 0;
		
		echo '<p id="'.$row[$keys[0]].'">';
		//remove id placeholder
		$trash = array_shift($keys);
		
		foreach($row as $item){
			echo $row[$keys[$i]].' ';
			$i++;
		}
		echo '</p>';
	}
	function prepSelected(){
		//All available fields
		$opts = array('id','first_name','last_name','email', 'password', 'all');
		$selected = array('id');
		$i = 0;
		
		foreach($opts as $item){
			switch($item){
				case $_POST[$opts[$i]] =='checked': array_push($selected, $item);
				break;
			}
			$i++;
		}
		$current = 0;
		$count = count($selected);

		$keys = ''; $placeholders = '';		
		
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
		
		//remove the last comma from the array if there is more than 1 element in the array
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
	function fetchData($pdo, $sql_vals){
		$keys = $sql_vals[0];
		$placeholders = $sql_vals[1];
		
		$sql = "SELECT".' '.$keys." FROM users"; 
		$keys = explode(',', $keys);
		$result = $pdo->query($sql);	
			
		foreach($result->fetchAll(PDO::FETCH_ASSOC) as $row){
			loopData($row, $item, $keys);
		}
	}
	function showErrors($error_array, $error_messages){
		foreach($error_array as $error){
			echo $error_messages[$error];
		}
	}
	
	//Insert
	if(isset($_POST['submit'])){
		$error_array = array();
		$error_messages = array(
			'first_name'=>'<p class="error">Please enter your first name.</p>',
			'last_name'=>'<p class="error">Please enter your last name.</p>',
			'email'=>'<p class="error">Please enter your email address.</p>'
		);
			
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		//Required Fields
		$required = array('first_name', 'last_name', 'email');
		$data = array('', $first_name, $last_name, $email, $password); 
		
		//If basic validation passes then
		foreach($required as $input){
			if($_POST[$input] == ''){
				array_push($error_array, $input);
			}
		}
		
		if(empty($error_array)){
			echo '$error_array is empty';
			print_r($error_array);
			$stmnt = $pdo-> prepare("INSERT INTO users (id, first_name, last_name, email, password) values (?, ?, ?, ?, ?)");
			$stmnt->setFetchMode(PDO::FETCH_ASSOC);
			$stmnt->execute($data);
		}
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
	
	
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" src="js/global.js" charset="utf-8"></script>
</head>

<body>

<div id="wrapper">
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="insert">
		<p><input type="text" name="first_name" value="<?php echo $_POST['first_name'] ?>" placeholder="First Name"></p>
		<p><input type="text" name="last_name" value="<?php echo $_POST['last_name'] ?>" placeholder="Last Name"></p>
		<p><input type="email" required="required" name="email" value="<?php echo $_POST['email'] ?>" placeholder="Email"></p>
		<p><input type="password" name="password" placeholder="Password"></p>
	
		<p><input type="submit" name="submit" value="Continue &rarr;"></p>
	</form>
	<br />
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="select">
		<p class="select"><input type="submit" name="select_submit" value="select"></p>
		<p><label><input type="checkbox" value="checked" name="first_name"> First Name</label> <label><input type="checkbox" value="checked" name="last_name">Last Name</label></p>
		<p><label><input type="checkbox" value="checked" name="email">Email</label>  <label><input type="checkbox" value="checked" name="password"> Password</label>   <label><input type="checkbox" value="checked" name="all"> All</label></p>
	</form>
	
	<div id="results">
		<?php
		//Select
		if(isset($_POST['select_submit'])){
			if($_POST['all'] == 'checked'){
				selectAll($pdo);
			} else {
				$sql_vals = prepSelected();
				fetchData($pdo, $sql_vals);
			}
			//debugSql($keys, $placeholders);
		} 
		?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="delete">
			<input type="submit" class="clicked delete" name="delete" value="delete">
		</form>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="update">
			<input type="submit" class="update" name="update" value="update">
		</form>
	</div><!-- #results -->
	<div id="errors">
		<?php
		if(!empty($error_array)){
			showErrors($error_array, $error_messages);
		}	
		?>
	</div><!-- #errors -->
	
</div><!-- #wrapper -->

</body>
</html>