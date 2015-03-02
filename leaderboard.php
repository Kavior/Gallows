<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
<html>
	<head>	
		<title>Szubienica</title>
		<link rel="stylesheet" type="text/css" href="style.css">	
		<script type="text/javascript" src="jquery-2.0.3.min.js"></script>
		<script type="text/javascript" src="jquery-ui.js"></script>
	</head>
	<body>
		<?php
			echo '<center><h1><p>Top 10 Players</p></h1></center>';
			include 'user.php';
			$usersDB = new DatabaseTable('localhost', 'root', '', 'gallows', 'nicknames');
			$usersDB->connect();
			$usersDB->getScores();
			echo '<center><a href="szubienica.php">Back to main page</a></center>';
		?>

	</body>	
</html>
