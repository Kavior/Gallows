<div id="mainForm" style="display:inline-block; width:300px; position:absolute; left:30%; top:20%;">	
	<form action="createDb.php" method="post">
		<table>
			<tr>
				<td>Host name:</td><td><input type="text" name="host"></td>
			</tr>
			<tr>
				<td>User Name:</td><td><input type="text" name="username"></td>
			</tr>
			<tr>
				<td>Password:</td><td><input type="text" name="password"></td>
			</tr>	
			<tr>
				<td colspan="2"><input type="submit" value="Create Database"></td>
			</tr>
				
		</table>
	</form>
</div>
<?php
	if(isset($_POST['host']) && isset($_POST['username']) &&  isset($_POST['password'])){
		$host= $_POST['host'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$db = mysqli_connect($host, $username,$password);
		$databaseName= 'gallows';
		$createQuery = "CREATE DATABASE $databaseName";
		mysqli_query($db, $createQuery) or die('Wrong data given or database already exists.');
		$db  = mysqli_connect($host, $username,$password,$databaseName);
		
		$nicknamesQuery = "CREATE TABLE nicknames(
		id int(6) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		nickname varchar(22),
		score int(11)
		)";
		mysqli_query($db, $nicknamesQuery) or die('Database connect error');
		echo 'Database succesfully created!';
	}
?>