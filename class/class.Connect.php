<?php

//class.connect.php
class Connect {

	private static $server = 'sqlhosting5';
	private static $user = 'edunet_notatnik';
	private static $pass = 'alinka@12';
	private static $db = 'edunet_notatnik';
	private static $Database;

	function __construct(){
	  	@self::$Database = new mysqli(self::$server,self::$user,self::$pass,self::$db);
	  	@self::$Database->set_charset('utf8');

		if (mysqli_connect_errno()) {
			echo("Nawiązanie połączenia zakończyło się niepowodzeniem. Komunikat błędu: ".
			mysqli_connect_error());
			exit();
		}
	}
	
	static private function polacz(){
		
	  if(!empty(self::$Database)){
		  
		  @self::$Database = new mysqli(self::$server,self::$user,self::$pass,self::$db);
		  @self::$Database->set_charset('utf8');

			if (mysqli_connect_errno()) {
				echo("Nawiązanie połączenia zakończyło się niepowodzeniem. Komunikat błędu: ".
				mysqli_connect_error());
				exit();
			}
  
		  return self::$Database;
 
	  } else {
		  return self::$Database;
	  }
	}
	
	static public function getPolacz(){  
       return self::polacz();
    }
}
