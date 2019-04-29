<?php

// class.przedmioty.php
include_once("interface.database.php");

class Przedmioty implements Database
{

	private $_idPrzed;
	private $_nazwa;
	private $_skrot;
	public $dane;
	public $ile;

	/**
	*	Pokazuje przedmioty zapisane w bazie
	*/
	public function pokaz($id_przed=NULL,$zm_2=NULL){
		if($id_przed==NULL){
			if($stmt = Connect::getPolacz()->prepare("SELECT id_przed, nazwa, skrot FROM przedmiot ORDER BY nazwa, skrot")) {
				$stmt->execute();
				$stmt->bind_result($this->_idPrzed,$this->_nazwa,$this->_skrot);
				
				while ($stmt->fetch())
				{
					$this->dane[] = array($this->_idPrzed, $this->_nazwa, $this->_skrot);
				}
				
				return $this->dane;
			}

		} else {
			if(is_numeric($id_przed) && $id_przed > 0){

				$this->_idPrzed = $id_przed;

				if($stmt = Connect::getPolacz()->prepare("SELECT nazwa, skrot FROM przedmiot WHERE id_przed = ?")) {
					$stmt->bind_param("i",$this->_idPrzed);
					$stmt->execute();
					$stmt->bind_result($this->_nazwa, $this->_skrot);
					
					while ($stmt->fetch())
					{
						$this->dane[] = array($this->_nazwa, $this->_skrot);
					}
				
					return $this->dane;
				}
			}
		}

	}

	/**
	*	Dodaje przedmiot do bazy
	*/
	public function dodaj($nazwa,$skrot,$zm_3=NULL,$zm_4=NULL,$zm_5=NULL,$zm_6=NULL){

		if(is_string($nazwa) && is_string($skrot)){

			if($nazwa != '' && $skrot != ''){

				$this->_nazwa = $nazwa;
				$this->_skrot = $skrot;

				if($stmt = Connect::getPolacz()->prepare("SELECT nazwa, skrot FROM przedmiot WHERE nazwa = ? AND skrot = ?")){
					$stmt->bind_param("ss",$this->_nazwa,$this->_skrot);
					$stmt->execute();
					$stmt->store_result();

					if($stmt->num_rows > 0){
						$stmt->close();
					} else {

						$stmt = Connect::getPolacz()->prepare("INSERT INTO przedmiot VALUE(NULL,?,?)");
						$stmt->bind_param("ss",$this->_nazwa,$this->_skrot);
						$stmt->execute();
						$stmt->close();
					}
				}
			}
		}
	}

	/**
	*	Poprawia przedmiot w bazie
	*/
	public function popraw($id_przed,$nazwa,$skrot,$zm_4=NULL,$zm_5=NULL,$zm_6=NULL,$zm_7=NULL){

		if(is_numeric($id_przed) && is_string($nazwa) && is_string($skrot)){

			if($id_przed > 0 && $nazwa != '' && $skrot != ''){

				$this->_idPrzed = $id_przed;
				$this->_nazwa = $nazwa;
				$this->_skrot = $skrot;

				if($stmt = Connect::getPolacz()->prepare("SELECT * FROM przedmiot WHERE id_przed = ?")){
					
					$stmt->bind_param("i",$this->_idPrzed);
					$stmt->execute();
					$stmt->store_result();

					if($stmt->num_rows > 0){

						$stmt = Connect::getPolacz()->prepare("UPDATE przedmiot SET nazwa = ?, skrot = ? WHERE id_przed = ?");
						$stmt->bind_param("ssi",$this->_nazwa,$this->_skrot,$this->_idPrzed);
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
	*	Usuwa przemiot w bazie
	*/
	public function usun($id_przed){

		if(is_numeric($id_przed) && $id_przed > 0){

			$this->_idPrzed = $id_przed;

			if($stmt = Connect::getPolacz()->prepare("SELECT * FROM przedmiot WHERE id_przed = ?")){
				
				$stmt->bind_param("i",$this->_idPrzed);
				$stmt->execute();
				$stmt->store_result();

				if($stmt->num_rows > 0){

					$stmt = Connect::getPolacz()->prepare("DELETE FROM przedmiot WHERE id_przed = ?");
					$stmt->bind_param("i",$this->_idPrzed);
					$stmt->execute();
					$stmt->close();

				} else {

					$stmt->close();
				}
			}			
		}
	}

	/**
	*	Oblicza ilość przedmiotów zapisanych w bazie
	*/
	public function oblicz($zm_1=NULL,$zm_2=NULL){

		$stmt = Connect::getPolacz()->prepare("SELECT * FROM przedmiot");
		$stmt->execute();
		$stmt->store_result();

		$ile = $stmt->num_rows;

		return $ile;
	}
}