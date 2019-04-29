<?php

// class.przedmiotyUser.php
include_once("interface.database.php");

class Rozklad implements Database
{

	private $_idRoz;
	private $_idPrzedmiotUser;
	private $_temat;
	private $_miesiac;
	private $_godz;
	public $dane;
	public $wynik;
	public $ile;

	/**
	*	Przedstawia listę tematów
	*/
	public function pokaz($id_PrzedmiotUser,$zm_2=NULL){
		
		if(is_numeric($id_PrzedmiotUser) && $id_PrzedmiotUser > 0 ){

			$this->_idPrzedmiotUser = $id_PrzedmiotUser;

			if($stmt = Connect::getPolacz()->prepare("SELECT id_roz, temat, miesiac, godz FROM rozklad WHERE id_pu = ? ORDER BY miesiac, id_roz")) {
				$stmt->bind_param("i",$this->_idPrzedmiotUser);
				$stmt->execute();
				$stmt->bind_result($this->_idRoz,$this->_temat,$this->_miesiac,$this->_godz);
				
				while ($stmt->fetch())
				{
					$this->dane[] = array($this->_idRoz, $this->_temat, $this->_miesiac, $this->_godz);
				}
				
				return $this->dane;
			}
		}
	}



	/**
	*	Przedstawia listę tematów
	*/
	public function pokazMsc($id_PrzedmiotUser,$miesiac){
		
		if(is_numeric($id_PrzedmiotUser) && $id_PrzedmiotUser > 0 && is_numeric($miesiac) && $miesiac > 0 ){

			$this->_idPrzedmiotUser = $id_PrzedmiotUser;
			$this->_miesiac = $miesiac;

			if($stmt = Connect::getPolacz()->prepare("SELECT id_roz, temat, miesiac, godz FROM rozklad WHERE id_pu = ? AND miesiac = ? ORDER BY miesiac, id_roz")) {
				$stmt->bind_param("ii",$this->_idPrzedmiotUser, $this->_miesiac);
				$stmt->execute();
				$stmt->bind_result($this->_idRoz,$this->_temat,$this->_miesiac,$this->_godz);
				
				while ($stmt->fetch())
				{
					$this->dane[] = array($this->_idRoz, $this->_temat, $this->_miesiac, $this->_godz);
				}
				
				return $this->dane;
			}
		}
	}
	/**
	*	Przedstawia temat
	*/
	public function pokazLekcja($id_Roz,$zm_2=NULL){
		
		if(is_numeric($id_Roz) && $id_Roz > 0 ){

			$this->_idRoz = $id_Roz;

			if($stmt = Connect::getPolacz()->prepare("SELECT id_pu, temat, miesiac, godz FROM rozklad WHERE id_roz = ? ORDER BY miesiac, id_roz")) {
				$stmt->bind_param("i",$this->_idRoz);
				$stmt->execute();
				$stmt->bind_result($this->_idPrzedmiotUser,$this->_temat,$this->_miesiac,$this->_godz);
				
				while ($stmt->fetch())
				{
					$this->wynik[] = array($this->_idPrzedmiotUser, $this->_temat, $this->_miesiac, $this->_godz);
				}
				
				return $this->wynik;
			}
		}
	}

	/**
	*	Dodaje temat zajęć
	*/
	public function dodaj($id_pu,$temat,$miesiac,$godz,$zm_5=NULL,$zm_6=NULL){

		if(is_numeric($id_pu) && is_string($temat) && is_numeric($miesiac) && is_numeric($godz)){

			if($id_pu > 0 && $temat != '' && $miesiac > 0 && $godz > 0){

				$this->_idPrzedmiotUser = $id_pu;
				$this->_temat = $temat;
				$this->_miesiac = $miesiac;
				$this->_godz = $godz;

				if($stmt = Connect::getPolacz()->prepare("SELECT id_pu, temat, miesiac, godz FROM rozklad WHERE id_pu = ? AND temat = ? AND miesiac = ? AND godz = ?")){
					$stmt->bind_param("isii",$this->_idPrzedmiotUser,$this->_temat,$this->_miesiac,$this->_godz);
					$stmt->execute();
					$stmt->store_result();

					if($stmt->num_rows > 0){
						$stmt->close();
					} else {

						$stmt = Connect::getPolacz()->prepare("INSERT INTO rozklad VALUE(NULL,?,?,?,?)");
						$stmt->bind_param("isii",$this->_idPrzedmiotUser,$this->_temat,$this->_miesiac,$this->_godz);
						$stmt->execute();
						$stmt->close();

					}
				}
			}
		}
	}

	/**
	*	Poprawia temat zajęć
	*/	
	public function popraw($id_roz,$temat,$miesiac,$godz,$zm_5=NULL,$zm_6=NULL,$zm_7=NULL){

		if(is_numeric($id_roz) && is_string($temat) && is_numeric($miesiac) && is_numeric($godz)){

			if($id_roz > 0 && $temat != '' && $miesiac > 0 && $godz > 0){

				$this->_idRoz = $id_roz;
				$this->_temat = $temat;
				$this->_miesiac = $miesiac;
				$this->_godz = $godz;

				if($stmt = Connect::getPolacz()->prepare("SELECT * FROM rozklad WHERE id_roz = ?")){
					
					$stmt->bind_param("i",$this->_idRoz);
					$stmt->execute();
					$stmt->store_result();

					if($stmt->num_rows > 0){

						$stmt = Connect::getPolacz()->prepare("UPDATE rozklad SET temat = ?, miesiac = ?, godz = ? WHERE id_roz = ?");
						$stmt->bind_param("siii",$this->_temat,$this->_miesiac,$this->_godz,$this->_idRoz);
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
	*	Usuwa temat zajęć
	*/	
	public function usun($id_roz){

		if(is_numeric($id_roz) && $id_roz > 0){

			$this->_idRoz = $id_roz;

			if($stmt = Connect::getPolacz()->prepare("SELECT * FROM rozklad WHERE id_roz = ?")){
				
				$stmt->bind_param("i",$this->_idRoz);
				$stmt->execute();
				$stmt->store_result();

				if($stmt->num_rows > 0){

					$stmt = Connect::getPolacz()->prepare("DELETE FROM rozklad WHERE id_roz = ?");
					$stmt->bind_param("i",$this->_idRoz);
					$stmt->execute();
					$stmt->close();

				} else {

					$stmt->close();
				}
			}			
		}
	}

	/**
	*	Oblicza ilość tematów z danego przedmiotu
	*/	
	public function oblicz($id_naucz,$zm_2=NULL){

		if(is_numeric($id_naucz) && $id_naucz > 0){
			
			$this->_idNaucz = $id_naucz;

			$stmt = Connect::getPolacz()->prepare("SELECT * FROM rozklad WHERE id_naucz = ?");
			$stmt->bind_param("i",$this->_idNaucz);
			$stmt->execute();
			$stmt->store_result();

			$this->ile = $stmt->num_rows;

			return $this->ile;

		}
	}

}
