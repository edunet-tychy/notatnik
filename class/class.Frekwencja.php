<?php

// class.frekwencja.php
include_once("interface.database.php");

class Frekwencja implements Database
{
	private $_idFrek;
	private $_idUcz;
	private $_idPrzedUser;
	private $_frek;
	public $dane;
	public $ile;

	/**
	*	Format daty: 2015-09-01
	*/
	private $_data;

	/**
	*	Format godziny lekcyjnej: 0-12; integer(2)
	*/	
	private $_godz;

	/**
	*	Przyjęte oznaczenia
	*	o - obecny; n - nieobecny; s - spóźniony; z - zwolniony; d - delegowany
	*/	
	private $_stan = array('o','n','s','z','d');

	/**
	*	Przedstawia listę frekwencji ucznia
	*/
	public function pokaz($id_ucz=NUll,$zm_2=NULL){

		if(is_numeric($id_ucz) && $id_ucz > 0){

			$this->_idUcz = $id_ucz;

			if($stmt = Connect::getPolacz()->prepare("SELECT id_frek, id_ucz, id_pu, data, godz, stan FROM frekwencja WHERE id_ucz = ?")) {
				$stmt->bind_param("i",$this->_idUcz);
				$stmt->execute();
				$stmt->bind_result($this->_idFrek,$this->_idUcz,$this->_idPrzedUser, $this->_data, $this->godz, $this->_frek);
				
				while ($stmt->fetch())
				{
					$this->dane[] = $this->_idFrek.' '.$this->_idUcz.' '.$this->_idPrzedUser.' '.$this->_data.' '.$this->godz.' '.$this->_frek;
				}
				
				return $this->dane;
			}
		}
	}

	/**
	*	Przedstawia ucznia i konkretną godzinę lekcyjną
	*/
	public function pokazUczenGodzina($id_ucz, $id_pu, $data, $godz){

		if(is_numeric($id_ucz) && $id_ucz > 0 && is_numeric($id_pu) && $id_pu > 0 && is_string($data) && $data != '' && is_numeric($godz) && $godz >= 0 ){

			$this->_idUcz = $id_ucz;
			$this->_idPrzedUser = $id_pu;
			$this->_data = $data;
			$this->_godz = $godz;

			if($stmt = Connect::getPolacz()->prepare("SELECT id_frek, stan FROM frekwencja WHERE id_ucz = ? AND id_pu = ? AND data = ? AND godz = ?")) {
				$stmt->bind_param("iisi",$this->_idUcz, $this->_idPrzedUser, $this->_data, $this->_godz);
				$stmt->execute();
				$stmt->bind_result($this->_idFrek, $this->_frek);
				
				while ($stmt->fetch())
				{
					$this->dane[] = array($this->_idFrek, $this->_frek);
				}
				
				return $this->dane;
			}
		}
	}

	/**
	*	Dodaje dane związane z frekwencją
	*/	
	public function dodaj($id_ucz,$id_pu,$data,$godz,$stan,$zm_6=NULL){

		if(is_numeric($id_ucz) && is_numeric($id_pu) && is_string($data) && is_numeric($godz) && is_string($stan)){

			if($id_ucz > 0 && $id_pu > 0 && $data != '' && $godz >= 0 && $stan !=''){

				foreach ($this->_stan as $frek) {
					if($frek == $stan){

						$this->_idUcz = $id_ucz;
						$this->_idPrzedUser = $id_pu;
						$this->_data = $data;
						$this->_godz = $godz;
						$this->_frek = $stan;

						if($stmt = Connect::getPolacz()->prepare("SELECT id_ucz, id_pu, data, godz FROM frekwencja WHERE id_ucz = ? AND id_pu = ? AND data = ? AND godz = ?")){
							$stmt->bind_param("iisi",$this->_idUcz,$this->_idPrzedUser,$this->_data,$this->_godz);
							$stmt->execute();
							$stmt->store_result();

							if($stmt->num_rows > 0){
								$stmt->close();

							} else {

								$stmt = Connect::getPolacz()->prepare("INSERT INTO frekwencja VALUE(NULL,?,?,?,?,?)");
								$stmt->bind_param("iisis",$this->_idUcz,$this->_idPrzedUser,$this->_data,$this->_godz,$this->_frek);
								$stmt->execute();
								$stmt->close();

							}
						}
					}
				}
			}
		}
	}

	/**
	*	Poprawia dane związane z frekwencją
	*/
	public function popraw($id_frek,$id_pu,$data,$godz,$stan,$zm_6=NULL,$zm_7=NULL){

		if(is_numeric($id_frek) && is_numeric($id_pu) && is_string($data) && is_numeric($godz) && is_string($stan)){

			if($id_frek > 0 && $id_pu > 0 && $data != '' && $godz >= 0 && $stan != ''){

				$this->_idFrek = $id_frek;
				$this->_idPrzedUser = $id_pu;
				$this->_data = $data;
				$this->_godz = $godz;
				$this->_frek = $stan;

				if($stmt = Connect::getPolacz()->prepare("SELECT * FROM frekwencja WHERE id_frek = ?")){
					
					$stmt->bind_param("i",$this->_idFrek);
					$stmt->execute();
					$stmt->store_result();

					if($stmt->num_rows > 0){

						$stmt = Connect::getPolacz()->prepare("UPDATE frekwencja SET id_pu = ?, data = ?, godz = ?, stan = ? WHERE id_frek = ?");
						$stmt->bind_param("isisi",$this->_idPrzedUser,$this->_data,$this->_godz,$this->_frek,$this->_idFrek);
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
	*	Usuwa dane związane z frekwencją
	*/
	public function usun($id_frek,$zm_2=Null){
	

		if(is_numeric($id_frek) && $id_frek > 0){

			$this->_idFrek = $id_frek;

			if($stmt = Connect::getPolacz()->prepare("SELECT * FROM frekwencja WHERE id_frek = ?")){
				
				$stmt->bind_param("i",$this->_idFrek);
				$stmt->execute();
				$stmt->store_result();

				if($stmt->num_rows > 0){

					$stmt = Connect::getPolacz()->prepare("DELETE FROM frekwencja WHERE id_frek = ?");
					$stmt->bind_param("i",$this->_idFrek);
					$stmt->execute();
					$stmt->close();

				} else {

					$stmt->close();
				}
			}			
		}
	}

	/**
	*	Oblicza frekwencję ucznia
	*/
	public function oblicz($id_ucz,$zm_2=NULL){

		if(is_numeric($id_ucz) && $id_ucz > 0){
 			
 			$this->_idUcz = $id_ucz;

 			$stmt = Connect::getPolacz()->prepare("SELECT * FROM frekwencja WHERE id_ucz = ? AND stan = ? OR stan = ? OR stan = ?");
 			$stmt->bind_param("isss",$this->_idUcz,$this->_stan[1],$this->_stan[3],$this->_stan[4]);
			$stmt->execute();
			$stmt->store_result();

			$ile = $stmt->num_rows;

			return $ile;			
		}
	}
}
