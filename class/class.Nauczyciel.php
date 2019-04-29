<?php

// class.nauczyciel.php
include_once("interface.database.php");

class Nauczyciel implements Database
{
	private $_salt='e3FGde4';
	private $_id;
	private $_imie;
	private $_nazwisko;
	private $_login;
	private $_pass;
	private $_akt;
	private $_rola;
	public $dane;
	public $wynik;
	public $ile;

	public function __construct(){
	}
	
	/**
	*	Pokazuje użytkowników
	*	Return String $dane;
	*/
	public function pokaz($id=NULL,$zm_2=NULL){
		
		if($id==NULL){
			if($stmt = Connect::getPolacz()->prepare("SELECT id, nazwisko, imie, login, akt, rola FROM users ORDER BY nazwisko, imie")) {
				$stmt->execute();
				$stmt->bind_result($this->_id, $this->_nazwisko, $this->_imie, $this->_login, $this->_akt, $this->_rola);
				
				while ($stmt->fetch())
				{
					$this->dane[] = array($this->_id, $this->_nazwisko, $this->_imie, $this->_login, $this->_akt, $this->_rola);
				}
				
				return $this->dane;
			}

		} else {
			if(is_numeric($id) && $id > 0){

				$this->_id = $id;	

				if($stmt = Connect::getPolacz()->prepare("SELECT nazwisko, imie, login, akt, rola FROM users WHERE id = ?")) {
					$stmt->bind_param("i",$this->_id);
					$stmt->execute();
					$stmt->bind_result($this->_nazwisko, $this->_imie, $this->_login, $this->_akt, $this->_rola);
					
					while ($stmt->fetch())
					{
						$this->dane[] = array($this->_id, $this->_nazwisko, $this->_imie, $this->_login, $this->_akt, $this->_rola);
					}
					
					return $this->dane;
				}
			}				
		}
	}

	public function userId($nazwisko, $imie, $login){
		
		if($nazwisko != '' && $imie != '' && $login != '') {
			
			$this->_nazwisko = $nazwisko;
			$this->_imie = $imie;
			$this->_login = $login;

			if($stmt = Connect::getPolacz()->prepare("SELECT id FROM users WHERE nazwisko = ? AND imie = ? AND login = ?")) {
				$stmt->bind_param("sss",$this->_nazwisko, $this->_imie, $this->_login);
				$stmt->execute();
				$stmt->bind_result($this->_id);
					
				while ($stmt->fetch())
				{
					$this->wynik[] = array($this->_id);
				}
					
				return $this->wynik;
			}
		}
	}

	/**
	*	Dodaje użytkownika do bazy dancyh
	*/
	public function dodaj($nazwisko,$imie,$login,$pass,$akt,$rola){

		if(is_string($nazwisko) && is_string($imie) && is_string($login) && is_string($pass) && is_numeric($akt) && is_numeric($rola)){
		
			if($nazwisko != '' && $imie != '' && $login != '' && $pass != '' && ($akt == 0 || $akt == 1) && ($rola == 0 || $rola == 1)){
			
				$this->_nazwisko = $nazwisko;
				$this->_imie = $imie;
				$this->_login = $login;
				$this->_pass = $pass;
				$this->_akt = $akt;
				$this->_rola = $rola;

				if($stmt = Connect::getPolacz()->prepare("SELECT * FROM users WHERE nazwisko = ? AND imie = ? AND login = ?")){
					$stmt->bind_param("sss",$this->_nazwisko,$this->_imie,$this->_login);
					$stmt->execute();
					$stmt->store_result();

					if($stmt->num_rows > 0){
						$stmt->close();
					} else {

						$stmt = Connect::getPolacz()->prepare("INSERT INTO users VALUE(NULL,?,?,?,?,?,?)");
						$stmt->bind_param("ssssii",$this->_nazwisko,$this->_imie,$this->_login,md5($this->_pass.$this->_salt),$this->_akt,$this->_rola);
						$stmt->execute();
						$stmt->close();
					}
				}
			}
		}
	}

	/*
	*	Poprawia dane użytkowników w bazie danych
	*/
	public function popraw($nazwisko,$imie,$login,$pass,$akt,$rola,$id){

		if(is_string($nazwisko) && is_string($imie) && is_string($login) && is_string($pass) && is_numeric($akt) && is_numeric($rola) && is_numeric($id)){

			if($nazwisko != '' && $imie != '' && $login != '' && $pass != '' && $akt != '' && $rola != '' && $id != ''){

				$this->_nazwisko = $nazwisko;
				$this->_imie = $imie;
				$this->_login = $login;
				$this->_pass = $pass;
				$this->_akt = $akt;
				$this->_rola = $rola;
				$this->_id = $id;

				if($stmt = Connect::getPolacz()->prepare("SELECT * FROM users WHERE id = ?")){
					
					$stmt->bind_param("i",$this->_id);
					$stmt->execute();
					$stmt->store_result();

					if($stmt->num_rows > 0){

						$stmt = Connect::getPolacz()->prepare("UPDATE users SET nazwisko = ?, imie = ?, login = ?, pass = ?, akt = ?, rola = ? WHERE id = ?");
						$stmt->bind_param("ssssiii",$this->_nazwisko,$this->_imie,$this->_login,md5($this->_pass.$this->_salt),$this->_akt,$this->_rola,$this->_id);
						$stmt->execute();
						$stmt->close();

					} else {

						$stmt->close();
					}
				}
			}
		}
	}

	/*
	*	Usuwa użytkownika z bazy danych
	*/
	public function usun($id){

		if(is_numeric($id) && $id > 0){

			$this->_id = $id;

			if($stmt = Connect::getPolacz()->prepare("SELECT * FROM users WHERE id = ?")){
				
				$stmt->bind_param("i",$this->_id);
				$stmt->execute();
				$stmt->store_result();

				if($stmt->num_rows > 0){

					$stmt = Connect::getPolacz()->prepare("DELETE FROM users WHERE id = ?");
					$stmt->bind_param("i",$this->_id);
					$stmt->execute();
					$stmt->close();

				} else {

					$stmt->close();
				}
			}
		}
	}

	/*
	*	Blokowanie oraz odblokowanie możliwości logowania użytkownika
	*	Aktywny = 1; Nieaktywny = 0
	*/
	public function aktywnosc($akt,$id){

		if($id != 0 && ($akt == 0 || $akt == 1)){

			$this->_id = $id;
			$this->_akt = $akt;

			if($stmt = Connect::getPolacz()->prepare("SELECT * FROM users WHERE id = ?")){
				
				$stmt->bind_param("i",$this->_id);
				$stmt->execute();
				$stmt->store_result();

				if($stmt->num_rows > 0){

					$stmt = Connect::getPolacz()->prepare("UPDATE users SET akt = ? WHERE id = ?");
					$stmt->bind_param("ii",$this->_akt,$this->_id);
					$stmt->execute();
					$stmt->close();

				} else {

					$stmt->close();
				}
			}
		}
	}

	/*
	*	Oblicza ilość użytkowników
	*	Integer $ile;
	*/
	public function oblicz($rola=2,$zm_2=NULL){

		if(is_numeric($rola) && $rola >= 0){

			$this->_rola = $rola;

			if($this->_rola < 2){

				$stmt = Connect::getPolacz()->prepare("SELECT * FROM users WHERE rola = ?");
				$stmt->bind_param("i",$this->_rola);
				$stmt->execute();
				$stmt->store_result();

				$this->ile = $stmt->num_rows;

				return $this->ile;

			} else if($this->_rola == 2){

				$stmt = Connect::getPolacz()->prepare("SELECT * FROM users");
				$stmt->execute();
				$stmt->store_result();

				$this->ile = $stmt->num_rows;

				return $this->ile;
			}
		}
	}
}

/*
$Nauczyciel = new Nauczyciel();

//$Nauczyciel->dodaj('B','B','b','b',1,0);
$Nauczyciel->popraw('Nowy','Adam','nowy','nowy',1,1,5);
$Nauczyciel->aktywnosc(1,3);

$osoby = $Nauczyciel->pokaz();

foreach($osoby as $osoba) {
	echo $osoba. '<br>';
}

echo $Nauczyciel->oblicz(0);
*/

