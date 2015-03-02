			var gameStarted = "<?php echo @$gameStarted?>";
			
				
			won = false;
			lost = false;
			maskedPhrase= "<?php echo @$maskedPhrase ?>";
			$(document).ready(function(){
				mainImage = $('#mainImage');
				letterBox = $("#letter");
				newGame = $('#new');
				newGame.click(function(){
					localStorage['gameStarted'] = 'true';						
				});
		
				if(!mainImage.length){
						$('#mainArea').append('<div id="startImage" ><img src="startImage.png" width="700px" height="200px" ></div>');
					}
					
				/*	
				$(window).bind('beforeunload', function(){
			  		localStorage['gameStarted'] = 'false';
				});		
				*/	
				mainImage.append('<img src="img/0.jpg">');
				//Throws masked phrase on the screen
				currentPhrase = $('#currentPhrase');
				currentPhrase.append(maskedPhrase);
				letterBox.focus();
			
				drawedPhrase = "<?php echo @$drawedPhrase; ?>"; 
			
				var get = function (key) {
			 	 return window.localStorage ? window.localStorage[key] : null;
				}
			
				var put = function (key, value) {
			 		if (window.localStorage) {
			    		window.localStorage[key] = value;
			  		}
				}
				//this will set count of wrong answers:
				function setCount (count){
					put('count', count);	
				}
				//this will get cout of wrong answers:
				function getCount (){
				return parseInt(get('count'));
				}
				//parameters true, false and function which gets its value:
				function setTrue(){
					put('bool', 'true');
				}
				function setFalse(){
					put('bool', 'false');
				}
				//that gets value either true or false:
				function getBool(){
					return get('bool');
				}
				// two funcions which measure and get start time, that will be necesary when counting score
				function setStartTime(time){
					put('startTime',time);
				}
				
				function getStartTime(){
					return get('startTime');
				}
				gameStarted = "<?php echo $gameStarted?>";
			
				if(gameStarted){
					//var start = new Date().getTime();
					//setStartTime(start);
				
				}
				
				setCount(0); // wrong letters = 0
			
				currentPhrase = $("#currentPhrase").text();
		
		
				$('#okS').click ( function(){
					letter = $('#letter').val();
					currentPhrase = $('#currentPhrase');
					//check if count of wrong answers is less than 5:
					if(getCount()<5 && !won && gameStarted){ 
						setFalse();
					//iterate through all letters to check is some of them equeals input:
					for(i=1;i<drawedPhrase.length && !won;i++){
						//if given correct letter:
						if(drawedPhrase[i].toLowerCase()==letter){
							
			 	  			maskedPhrase = maskedPhrase.substring(0, i) + letter + maskedPhrase.substring(i + 1); //Uncover given letter
							currentPhrase.empty();
							currentPhrase.append(maskedPhrase);
							$("#letter").focus();
							setTrue();
								//if thw whole phrase is filled:
								if (maskedPhrase.indexOf("_") === -1){
									//mainImage = $('#mainImage');
									mainImage.empty();
									mainImage.append('<center><p style = "margin: 100px 430px 0px 0px;font-size: 88px; color: green">WON!</p></center>');
									won= true;
									//get end time:
									//var endTime = new Date().getTime();
									//var startTime =  getStartTime();
									//var time = endTime - startTime;
									//<?php
				
									//	sleep(13);
							
									//?>
									//alert("You won!!!. Your score is");
									
									window.location.replace("saveScore.php");
								
							}
						}
			
					}
			
					// if wrong letter is given:
					if(getBool()=='false'){
					
						function changeImage(){
				 		letterBox = $("#letter");
						//change image	 		
						switch(getCount()){
							case 1:
							imgN = 'img/1.jpg';
							break;
					
							case 2:
							imgN = 'img/2.jpg';
							break;
					
							case 3:
							imgN = 'img/3.jpg';
							break;
						
							case 4:
							imgN = 'img/4.jpg';
							break;
							
							case 5:
							imgN = 'img/6.jpg';
							break;
					
						}
						//mainImage =$('#mainImage');
						mainImage.empty();
						mainImage.append('<img src="'+imgN+'">');
						letterBox.focus();
			
						}
						//add 1 to wrong letters
						setCount(getCount()+1);
						if(getCount()>4){
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
				       	$('#okS').click();	   		
					}							
				});

				startImage = $('#startImage');
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
				//Animate arrow
				function moveArrow() {
					if(typeof animates=='undefined' || animates ){
						startImage.animate({
							marginLeft: '-=55px'	
						}, 500, 'linear');				
						moveArrowRight();
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