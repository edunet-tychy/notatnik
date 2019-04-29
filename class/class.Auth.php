<?php

class Auth {

	private $_salt='e3FGde4';
	private $_nazwisko;
	private $_imie;
	private $_rola;

	function __construct(){
	}

	/**
	*	Sprawdzenie loginu oraz hasła
	*/
	public function validateLogin($user, $pass){

		if($stmt = Connect::getPolacz()->prepare("SELECT * FROM users WHERE login = ? AND pass = ?")){
			$stmt->bind_param("ss",$user, md5($pass.$this->_salt));
			$stmt->execute();
			$stmt->store_result();

			if($stmt->num_rows > 0){
				$stmt->close();
				return TRUE;
			} else {
				$stmt->close();
				return FALSE;
			}
		} else {
			die();
		}
	}

	/**
	*	Sprawdzenie uprawnień
	*/
	public function validateUprawnienia($user, $pass){

		if($stmt = Connect::getPolacz()->prepare("SELECT nazwisko, imie, rola FROM users WHERE login = ? AND pass = ?")){
			$stmt->bind_param("ss",$user, md5($pass.$this->_salt));
			$stmt->execute();
			$stmt->bind_result($this->_nazwisko,$this->_imie,$this->_rola);

				while ($stmt->fetch())
				{
					$this->_nazwisko;
					$this->_imie;					
					$this->_rola;
				}

		} else {
			die();
		}
	}

	/**
	*	Zwrócenie wartości uprawnienia
	*/
	public function getRola(){
		return $this->_rola;
	}

	/**
	*	Zwrócenie wartości uprawnienia
	*/
	public function getNazwisko(){
		return $this->_nazwisko;
	}

	/**
	*	Zwrócenie wartości - imie
	*/
	public function getImie(){
		return $this->_imie;
	}

	/**
	*	Sprawdzenie statusu użytkownika
	*/
	public function checkLoginStatus(){
		if(isset($_SESSION['loggedin'])){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	*	Sprawdzenie uprawnienie użytkownika
	*/
	public function checkAccessStatus(){
		if(isset($_SESSION['admin'])){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	/**
	*	Wylogowanie użytkownika
	*/
	public function logout(){
		session_destroy();
		session_start();
	}
}