<?php
	session_start();
	if(isset($_SESSION['startTime']) && !isset($score)){
			
		//Give the score according to time and phrase length:
		function getScore(){
			$startTime =$_SESSION['startTime'];
			$endTime =  time();					
			$totalTime=  $_SESSION['totalTime']= $endTime - $startTime;
			
			$drawedPhrase =strval($_SESSION['phrase']); 
			$phraseLength =strlen($drawedPhrase);
			$score =$phraseLength*150- $totalTime*20;
			
			if($score>0){
				return round( $score ) ;
			}else{
				return 0;
			}		
		}
		//Save score in session variable
		if( $_SESSION['score'] == null){
			$_SESSION['score'] = getScore(); 
		}	
			
		$score =$_SESSION['score'];	
		if(!isset($_POST['nickname']) || $_POST['nickname']==""){		
			echo 'Congratulations! Your score is '.$score.'!</br>Give your nickname:';
			echo'</br><form action = "saveScore.php" method="post">
			<input type= "text" name="nickname" id="nickname">
			<input type="submit" name="submit" value="Save score">
			</form>';

		}else{
			require 'user.php';
				$nickname = $_POST['nickname'];				
				$usersDB = new DatabaseTable('localhost', 'root', '', 'gallows', 'nicknames');
				$usersDB->connect();
				$usersDB->createUser($nickname);
				$usersDB->setScore($nickname, $score);
				$_SESSION['scoreSaved'] = true;
				//this will protect from adding score tiwce
				$_SESSION['startTime'] = null;
				echo 'your score was succesfully saved</br>';	
		}
	}else{
		echo 'There is no score to be saved</br>';
	}
	echo '<a href="leaderboard.php">Leaerboard</a></br><a href="szubienica.php">Back to the main page</a>';
?>
