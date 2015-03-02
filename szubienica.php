<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
<html>
	<head>	
		<title>Gallows! Try yourself!</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="ICON" href="icon.png" type="image/ico" />	
		<script type="text/javascript" src="jquery-2.0.3.min.js"></script>
		<script type="text/javascript" src="jquery-ui.js"></script>
	</head>
	<body>
		<div id="mainArea">
			<form action= "szubienica.php" method="post">
				<input type="submit" id="new" name="new"value= "new game">
			</form>
			<?php
				session_start();
				//Reset player score 
				$_SESSION['score'] = null;
				$gameStarted = false;
				// When new game starts
				if(isset($_POST['new'])){
		
					//Reset start time on new game
					if(isset($_SESSION['startTime'])){
						unset($_SESSION['startTime']);
					}
					$wordsArray =array();
					require "phraseMaker.php";
					//Get random phrase from phrases array
					$_SESSION['phrase']= (string) $wordsArray[array_rand($wordsArray)];				
					//Word that is drawed out the array
					$drawedPhrase =$_SESSION['phrase']; 	
					//Array, which holds discovered letters (First letter discovered at start):
					$uncompletedPhraseArray = array($drawedPhrase[0]);
					//Peform uncovered letters:
					for($i=1;$i<=strlen($drawedPhrase)-1; $i++){
						if(ctype_alnum($drawedPhrase[$i])){
							$uncompletedPhraseArray[] = '_';
						}else if($drawedPhrase[$i] == " "){
							//words are separated with this sign
							$uncompletedPhraseArray[] = "|";
						}else{
							$uncompletedPhraseArray[] = $drawedPhrase[$i];
						}
					}
					$maskedPhrase = implode("", $uncompletedPhraseArray); // makes covered phrase like R_ _ _ _ _
					 
					echo '<div id = "mainImage"> </div>';//Image with gallows
					echo '<div id="currentPhrase"></div>'; //makes div which contain current phrase
					//Field to submit user's letters 
					echo '
					</br>
					<div id = "submitField">	
					Your letter: <input type="text" id="letter" maxlength="1" autocomplete="off">
					<input type="submit" id="okS" value= "ok">
					</div> ';
					$gameStarted = true;	
				}
			?>
			<script>
			var gameStarted = "<?php echo @$gameStarted?>";
			won = false;
			lost = false;
			//New uncovered phrase
			maskedPhrase= "<?php echo @$maskedPhrase ?>";
			$(document).ready(function(){
				mainImage = $('#mainImage');
				letterBox = $("#letter");
				newGame = $('#new');
				//Append start arrow image
				if(!mainImage.length){
					$('#mainArea').append('<div id="startImage" ><img src="startImage.png" width="700px" height="200px" ></div>');
				}	
				//starting image - empty gallows				
				mainImage.append('<img src="img/0.jpg">');
				currentPhrase = $('#currentPhrase');
				//Prints masked phrase on the screen
				currentPhrase.append(maskedPhrase);
				letterBox.focus();
			
				drawedPhrase = "<?php echo @$drawedPhrase; ?>"; 
				//define functions that help saving variables in local storage end getting them
				var get = function (key) {
			 	 return window.localStorage ? window.localStorage[key] : null;
				}
			
				var put = function (key, value) {
			 		if (window.localStorage) {
			    		window.localStorage[key] = value;
			  		}
				}
				//this will set count of wrong answers:
				function setWrongAnswersCount (count){
					put('count', count);	
				}
				//this will get cout of wrong answers:
				function getWrongAnswersCount (){
				return parseInt(get('count'));
				}
				//parameters true, false and function which gets its value:
				function correctLetterGiven(){
					put('bool', 'true');
				}
				function wrongLetterGiven(){
					put('bool', 'false');
				}
				//that gets value either true or false:
				function isGivenLetterCorrect(){
					return get('bool');
				}

				<?php 
					 $startTime = $_SESSION['startTime'] = time();	
				?>

				setWrongAnswersCount(0); // wrong letters = 0
			
				ok = $('#okS');
				ok.click ( function(){
					letterBox = $("#letter");
					letter = $('#letter').val();
					currentPhrase = $('#currentPhrase');
					//check if count of wrong answers is less than 5:
					if(getWrongAnswersCount()<5 && !won && gameStarted && letter!==""){ 
						//assume, that wrong letter was give (if correct letter comes, its will change)
						wrongLetterGiven();
						//iterate through all letters to check is some of them equeals input:
						for(i=1;i<drawedPhrase.length && !won;i++){
							//if given correct letter:
							if(drawedPhrase[i].toLowerCase()==letter){	
								//Uncover given letter							
				 	  			maskedPhrase = maskedPhrase.substring(0, i) + letter + maskedPhrase.substring(i + 1); 
								currentPhrase.empty();
								currentPhrase.append(maskedPhrase);
								letterBox.focus();
								
								correctLetterGiven();
								//if the whole phrase is filled:
								if (maskedPhrase.indexOf("_") === -1){
									//Remove gallows image and replace it with "WON" message
									mainImage.empty();
									mainImage.append('<center><p style = "margin: 100px 430px 0px 0px;font-size: 88px; color: green">WON!</p></center>');
									won= true;									
									//Redirect to save score page									
									window.location.replace("saveScore.php");
								
								}
							}				
						}
						// if wrong letter is given:
						if(isGivenLetterCorrect()=='false'){						
							function changeImage(){	
								//set gallows image depending on wrong answers number 		
								switch(getWrongAnswersCount()){
									case 1:
									gallowsImage = 'img/1.jpg';
									break;
							
									case 2:
									gallowsImage = 'img/2.jpg';
									break;
							
									case 3:
									gallowsImage = 'img/3.jpg';
									break;
								
									case 4:
									gallowsImage = 'img/4.jpg';
									break;
									
									case 5:
									gallowsImage = 'img/6.jpg';
									break;
							
								}

								mainImage.empty();
								mainImage.append('<img src="'+gallowsImage+'">');
								letterBox.focus();			
							}
							//add 1 to wrong letters count
							setWrongAnswersCount(getWrongAnswersCount()+1);
							//If user gave 5 wrong letters, he/she lost
							if(getWrongAnswersCount()>4){
								alert ("You lost!");
							}
							changeImage();		
						}
					}	
					letterBox.val("");
				});
				//when enter pressed in letter box	
				letterBox.keyup(function(event){					
					if(!lost && event.keyCode == 13){
				       	ok.click();	   		
					}							
				});

				startImage = $('#startImage');
				//Animate arrow
				function moveArrow() {
					if(typeof animates=='undefined' || animates ){
						startImage.animate({
							marginLeft: '-=55px'	
						}, 500, 'linear');				
						moveArrowRight();
					}
				}
				
				function moveArrowRight(){
					startImage.animate({
						marginLeft: '+=55px'
					}, 500, 'linear');
					if(animates ){
					setTimeout(function(){
						moveArrow();
					}, 2000);
					}
				}				
						
				newGame.mouseover(function(){
					animates = true;
					//Animate arrow if it is not
					if (!$(startImage).is(':animated')) {
						moveArrow();
					}							
				});
				
				newGame.mouseout(function(){
					//Stop arrow animation
					animates = false;
					startImage.css({'margin-left':'335px'});
				});
			});		
		</script>
	</div>
	<a href ="leaderboard.php" style="font-size:35px; text-decoration:none; color:red; position:relative; top:50px;">Leaderboard</a>
</body>
</html>
