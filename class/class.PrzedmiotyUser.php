<?php

// class.przedmiotyUser.php
include_once("interface.database.php");

class PrzedmiotyUser implements Database
{
	private $_id;
	private $_idUcz;
	private $_idNaucz;
	private $_idPrzed;
	private $_idPrzedUser;
	private $_idGr;
	private $_nazwisko;
	private $_imie;
	private $_nazwiskoUcz;
	private $_imieUcz;
	private $_przedmiot;
	private $_skPrzed;
	private $_klasa;
	private $_skKlasa;
	private $_grupa;
	public $dane;
	public $daneUcz;
	public $ile;

	/**
	*	Pokazuje nauczycieli oraz ich przedmioty
	*/
	public function pokaz($id=NULL,$zm_2=NULL){

		$sql = "SELECT pu.id, u.nazwisko, u.imie, p.nazwa, p.skrot, k.kl, k.skrot, g.grupa,
				pu.id_naucz, pu.id_przed, pu.id_gr
				FROM users AS u, przedmiot AS p, klasy AS k, grupy AS g, przedmiot_user AS pu
				WHERE u.id = pu.id_naucz AND p.id_przed = pu.id_przed AND g.id_gr = pu.id_gr
				AND k.id_kl = g.id_kl
				ORDER BY u.nazwisko, u.imie, k.kl, p.nazwa, g.grupa";

		if($stmt = Connect::getPolacz()->prepare($sql)) {
			$stmt->execute();
			$stmt->bind_result($this->_id, $this->_nazwisko, $this->_imie, $this->_przedmiot,
				$this->_skPrzed, $this->_klasa, $this->_skKlasa, $this->_grupa, $this->_idNaucz,
				$this->_idPrzed, $this->_idGr);
			
			while ($stmt->fetch())
			{
				$this->dane[] = array($this->_id, $this->_nazwisko, $this->_imie, $this->_przedmiot,
				$this->_skPrzed, $this->_klasa, $this->_skKlasa, $this->_grupa, $this->_idNaucz,
				$this->_idPrzed, $this->_idGr);
			}
			
			return $this->dane;
		}
	}

	public function pokazUser($id) {

		if($id != NULL) {

			$this->_id = $id;

			$sql = "SELECT u.nazwisko, u.imie, p.nazwa, p.skrot, k.kl, k.skrot, g.grupa, pu.id
					FROM users AS u, przedmiot AS p, klasy AS k, grupy AS g, przedmiot_user AS pu
					WHERE u.id = ? AND u.id = pu.id_naucz AND p.id_przed = pu.id_przed
					AND g.id_gr = pu.id_gr AND k.id_kl = g.id_kl
					ORDER BY k.kl, g.grupa";

			if($stmt = Connect::getPolacz()->prepare($sql)) {
				$stmt->bind_param("i",$this->_id);
				$stmt->execute();
				$stmt->bind_result($this->_nazwisko, $this->_imie, $this->_przedmiot,
					$this->_skPrzed, $this->_klasa, $this->_skKlasa, $this->_grupa, $_idPrzedUser);
				
				while ($stmt->fetch())
				{
					$this->dane[] = array($this->_nazwisko, $this->_imie, $this->_przedmiot,
					$this->_skPrzed, $this->_klasa, $this->_skKlasa, $this->_grupa, $_idPrzedUser);
				}
				
				return $this->dane;
			}
		}
	}

	public function pokazPrzedmiotUser($id_pu) {

		if($id_pu != NULL) {

			$this->_idPrzedUser = $id_pu;

			$sql = "SELECT u.nazwisko, u.imie, p.nazwa, p.skrot, k.kl, k.skrot, g.grupa
					FROM users AS u, przedmiot AS p, klasy AS k, grupy AS g, przedmiot_user AS pu
					WHERE pu.id = ? AND u.id = pu.id_naucz AND p.id_przed = pu.id_przed
					AND g.id_gr = pu.id_gr AND k.id_kl = g.id_kl
					ORDER BY k.kl, g.grupa";

			if($stmt = Connect::getPolacz()->prepare($sql)) {
				$stmt->bind_param("i",$this->_idPrzedUser);
				$stmt->execute();
				$stmt->bind_result($this->_nazwisko, $this->_imie, $this->_przedmiot,
					$this->_skPrzed, $this->_klasa, $this->_skKlasa, $this->_grupa);
				
				while ($stmt->fetch())
				{
					$this->dane[] = array($this->_nazwisko, $this->_imie, $this->_przedmiot,
					$this->_skPrzed, $this->_klasa, $this->_skKlasa, $this->_grupa);
				}
				
				return $this->dane;
			}
		}
	}

	/**
	*	Dodaje do bazy informację o nauczycielu oraz przedmiocie, który prowadzi
	*/
	public function dodaj($id_naucz,$id_przed,$id_gr,$zm_4=NULL,$zm_5=NULL,$zm_6=NULL){

		if(is_numeric($id_naucz) && is_numeric($id_przed) && is_numeric($id_gr)){

			if($id_naucz > 0 && $id_przed > 0){

				$this->_idNaucz = $id_naucz;
				$this->_idPrzed = $id_przed;
				$this->_idGr = $id_gr;

				if($stmt = Connect::getPolacz()->prepare("SELECT id_naucz, id_przed, id_gr FROM przedmiot_user WHERE id_naucz = ? AND id_przed = ? AND id_gr = ?")){
					$stmt->bind_param("iii",$this->_idNaucz,$this->_idPrzed,$this->_idGr);
					$stmt->execute();
					$stmt->store_result();

					if($stmt->num_rows > 0){
						$stmt->close();
					} else {

						$stmt = Connect::getPolacz()->prepare("INSERT INTO przedmiot_user VALUE(NULL,?,?,?)");
						$stmt->bind_param("iii",$this->_idNaucz,$this->_idPrzed,$this->_idGr);
						$stmt->execute();
						$stmt->close();
					}
				}
			}
		}
	}

	/**
	*	Poprawia informacje o nauczycielu oraz przedmiocie, który prowadzi
	*/
	public function popraw($id,$id_naucz,$id_przed,$id_gr,$zm_5=NULL,$zm_6=NULL,$zm_7=NULL){

		if(is_numeric($id) && is_numeric($id_naucz) && is_numeric($id_przed) && is_numeric($id_gr)){

			if($id > 0 && $id_naucz > 0 && $id_przed > 0 && $id_gr > 0){

				$this->_id = $id;
				$this->_idNaucz = $id_naucz;
				$this->_idPrzed = $id_przed;
				$this->_idGr = $id_gr;

				if($stmt = Connect::getPolacz()->prepare("SELECT * FROM przedmiot_user WHERE id = ?")){
					
					$stmt->bind_param("i",$this->_id);
					$stmt->execute();
					$stmt->store_result();

					if($stmt->num_rows > 0){

						$stmt = Connect::getPolacz()->prepare("UPDATE przedmiot_user SET id_naucz = ?, id_przed = ?, id_gr = ? WHERE id = ?");
						$stmt->bind_param("iiii",$this->_idNaucz,$this->_idPrzed,$this->_idGr,$this->_id);
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
	*	Usuwa powiązanie przedmiotu z nauczycielem
	*/
	public function usun($id){

		if(is_numeric($id) && $id > 0){

			$this->_id = $id;

			if($stmt = Connect::getPolacz()->prepare("SELECT * FROM przedmiot_user WHERE id = ?")){
				
				$stmt->bind_param("i",$this->_id);
				$stmt->execute();
				$stmt->store_result();

				if($stmt->num_rows > 0){

					$stmt = Connect::getPolacz()->prepare("DELETE FROM przedmiot_user WHERE id = ?");
					$stmt->bind_param("i",$this->_id);
					$stmt->execute();
					$stmt->close();

				} else {

					$stmt->close();
				}
			}			
		}
	}

	/**
	*	Oblicza ilość przedmiotów nauczanych przed określanego nauczyciela
	*/
	public function oblicz($id_naucz=NULL,$zm_2=NULL){

		if($id_naucz == NULL){

			$stmt = Connect::getPolacz()->prepare("SELECT * FROM przedmiot_user");
			$stmt->execute();
			$stmt->store_result();

			$this->ile = $stmt->num_rows;

			return $this->ile;

		} else {

			if(is_numeric($id_naucz) && $id_naucz > 0){
				
				$this->_idNaucz = $id_naucz;

				$stmt = Connect::getPolacz()->prepare("SELECT * FROM przedmiot_user WHERE id_naucz = ?");
				$stmt->bind_param("i",$this->_idNaucz);
				$stmt->execute();
				$stmt->store_result();

				$this->ile = $stmt->num_rows;

				return $this->ile;

			}
		}
	}
}