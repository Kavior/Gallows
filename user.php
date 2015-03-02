<?php
	class DatabaseTable{
		public $server = null;
		public $username= null;
		public $password = null;
		public $database = null;
		
		public function __construct($server, $username, $password, $database, $table){		
			$this->server= $server;
			$this->username = $username;
			$this->password = $password;
			$this->database = $database;
			$this->table = $table;
		}
		
		public function connect(){
			$connect = mysql_connect($this->server, $this->username, $this->password) or die('Database connction error');
			$dataBase = mysql_select_db($this->database, $connect) or die ('There is a problem with database');
		}
		
		public function createUser($nickname){
			$table =$this->table;
			return mysql_query("INSERT INTO $table (nickname) VALUES('$nickname')") or die('Wrong query');
		}
		
		public function setScore($username, $score){
			$table =$this->table;
			return mysql_query("UPDATE $table SET score='$score' WHERE nickname='$username' ")or die('score setting error');
		}
		
		public function getScores(){
			$table =$this->table;

			$data =  mysql_query("SELECT nickname, score FROM $table ORDER BY score DESC LIMIT 10") or die ('score getting error');
			echo '<div id="leadersTable"><table><tr><th>Nickname</th><th>Score</th></tr><tr>';
			while($row = mysql_fetch_row($data)){			
				echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td></tr>';				
			}
			echo '</table></div>';	
		}
	}
?>
