<?php

// class.oddzialKlasowy.php
include_once("interface.database.php");

class OddzialKlasowy
{
	private $_idKl;
	private $_kl;
	private $_skrot;
	public $dane;
	public $ile;

	function __construct(){
	
	}

	/**
	* Pokazuje oddział klasowy do bazy
	*/
	public function pokaz($id_kl=NULL,$zm_2=NULL){

		if($id_kl==NULL){
			if($stmt = Connect::getPolacz()->prepare("SELECT id_kl, kl, skrot FROM klasy ORDER BY kl, skrot")) {
				$stmt->execute();
				$stmt->bind_result($this->_idKl, $this->_kl, $this->_skrot);
				
				while ($stmt->fetch())
				{
					$this->dane[] = array($this->_idKl, $this->_kl, $this->_skrot);
				}
				
				return $this->dane;
			}

		} else {

			if(is_numeric($id_kl) && $id_kl > 0){
				
				$this->_idKl = $id_kl;

				if($stmt = Connect::getPolacz()->prepare("SELECT kl, skrot FROM klasy WHERE id_kl = ?")) {
					$stmt->bind_param("i",$this->_idKl);
					$stmt->execute();
					$stmt->bind_result($this->_kl, $this->_skrot);
					
					while ($stmt->fetch())
					{
						$this->dane[] = array($this->_kl, $this->_skrot);
					}
				
					return $this->dane;
				}
			}
		}
	}

	/**
	* Dodaje oddział klasowy do bazy
	*/
	public function dodaj($kl,$skrot,$zm_3=NULL,$zm_4=NULL,$zm_5=NULL,$zm_6=NULL){

		if(is_string($kl) && is_string($skrot)){

			if($kl != '' && $skrot != ''){
	
				$this->_kl = $kl;
				$this->_skrot = $skrot; 
				
				if($stmt = Connect::getPolacz()->prepare("SELECT * FROM klasy WHERE kl = ? AND skrot = ?")){
					$stmt->bind_param("ss",$this->_kl,$this->_skrot);
					$stmt->execute();
					$stmt->store_result();

					if($stmt->num_rows > 0){
						$stmt->close();
					} else {

						$stmt = Connect::getPolacz()->prepare("INSERT INTO klasy VALUE(NULL,?,?)");
						$stmt->bind_param("ss",$this->_kl,$this->_skrot);
						$stmt->execute();
						$stmt->close();
					}
				}
			}
		}
	
	}

	/**
	* Poprawia dane oddziału klasowego w bazie
	*/
	public function popraw($id_kl,$kl,$skrot,$zm_4=NULL,$zm_5=NULL,$zm_6=NULL,$zm_7=NULL){
	
		if(is_numeric($id_kl) && is_string($kl) && is_string($skrot)){

			if($kl != '' && $skrot != ''){

				$this->_idKl = $id_kl;
				$this->_kl = $kl;
				$this->_skrot = $skrot;

				if($stmt = Connect::getPolacz()->prepare("SELECT * FROM klasy WHERE id_kl = ?")){
					
					$stmt->bind_param("i",$this->_idKl);
					$stmt->execute();
					$stmt->store_result();

					if($stmt->num_rows > 0){

						$stmt = Connect::getPolacz()->prepare("UPDATE klasy SET kl = ?, skrot = ? WHERE id_kl = ?");
						$stmt->bind_param("ssi",$this->_kl,$this->_skrot,$this->_idKl);
						$stmt->execute();
						$stmt->close();

					} else {

						$stmt->close();
					}
				}
			}

		}

	}

	/**
	* Usuwa oddział klasowy z bazy
	*/
	public function usun($id_kl){

		if(is_numeric($id_kl)) {
			
			$this->_idKl = $id_kl;

			if($stmt = Connect::getPolacz()->prepare("SELECT * FROM klasy WHERE id_kl = ?")){
				
				$stmt->bind_param("i",$this->_idKl);
				$stmt->execute();
				$stmt->store_result();

				if($stmt->num_rows > 0){

					$stmt = Connect::getPolacz()->prepare("DELETE FROM klasy WHERE id_kl = ?");
					$stmt->bind_param("i",$this->_idKl);
					$stmt->execute();
					$stmt->close();

				} else {

					$stmt->close();
				}
			}			
		}
	}

	/**
	* Oblicza ilość oddziałów klasowych
	*/
	public function oblicz($zm_1=NULL,$zm_2=NULL){

		$stmt = Connect::getPolacz()->prepare("SELECT * FROM klasy");
		$stmt->execute();
		$stmt->store_result();

		$this->ile = $stmt->num_rows;

		return $this->ile;
	}

	/**
	* Zmienne SET
	*/
	public function setIdKlasa($id){
		$this->_idKl = $id;
	}

	/**
	* Zmienne GET
	*/
	public function getIdKlasa(){
		return $this->_idKl;
	}

}