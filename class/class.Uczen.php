<?php

// class.uczen.php
include_once("interface.database.php");

/**
* Klasa
*/
class Uczen implements Database
{
	private $_idUcz;
	private $_imie;
	private $_nazwisko;
	private $_idGrupa;
	private $_idKlasa;
	private $_grupa;
	private $_klasa;
	private $_skrot;
	public $dane;
	public $wynik;

	function __construct(){
	
	}

	/**
	* Pokazuje wszystkich uczniów lub uczniów z wybranej grupy
	*/
	public function pokaz($idGrupa=NULL,$idUcz=NULL){

		if($idGrupa == NULL && $idUcz == NULL){

			$sql = "SELECT u.id_ucz, u.nazwisko, u.imie, kl.kl, kl.skrot, gr.grupa 
					FROM uczen AS u, grupy AS gr, klasy AS kl
					WHERE u.id_gr = gr.id_gr AND gr.id_kl = kl.id_kl
					ORDER BY kl.kl, gr.grupa, u.nazwisko, u.imie";

			if($stmt = Connect::getPolacz()->prepare($sql)) {
				$stmt->execute();
				$stmt->bind_result($this->_idUcz, $this->_nazwisko, $this->_imie, $this->_klasa, $this->_skrot, $this->_grupa);

				while ($stmt->fetch())
				{
					$this->dane[] = array($this->_idUcz, $this->_nazwisko, $this->_imie, $this->_klasa, $this->_skrot, $this->_grupa);
				}
				
				return $this->dane;
			}

		} else if(is_numeric($idGrupa) && $idGrupa > 0 && $idUcz == NULL){

			$this->_idGrupa = $idGrupa;

			$sql = "SELECT u.id_ucz, u.nazwisko, u.imie, kl.kl, kl.skrot, gr.grupa
					FROM grupy AS gr, klasy AS kl, uczen AS u
					WHERE gr.id_gr = ? AND gr.id_kl = kl.id_kl AND u.id_gr = gr.id_gr
					ORDER BY kl.kl, kl.skrot, u.nazwisko, u.imie";

				if($stmt = Connect::getPolacz()->prepare($sql)) {
					$stmt->bind_param("i",$this->_idGrupa);
					$stmt->execute();
					$stmt->bind_result($this->_idUcz, $this->_nazwisko, $this->_imie, $this->_klasa, $this->_skrot, $this->_grupa);

					while ($stmt->fetch())
					{
						$this->dane[] = array($this->_idUcz, $this->_nazwisko, $this->_imie, $this->_klasa, $this->_skrot, $this->_grupa);
					}
				return $this->dane;
			}

		} else if($idGrupa == NULL && is_numeric($idUcz) && $idUcz > 0){

			$this->_idUcz = $idUcz;

			if($stmt = Connect::getPolacz()->prepare("SELECT nazwisko, imie, id_gr FROM uczen WHERE id_ucz = ? ORDER BY nazwisko, imie")) {
				$stmt->bind_param("i",$this->_idUcz);
				$stmt->execute();
				$stmt->bind_result($this->_nazwisko, $this->_imie, $this->_idGrupa);
			
				while ($stmt->fetch())
				{
					$this->dane[] = array($this->_nazwisko, $this->_imie, $this->_idGrupa);
				}
			
				return $this->dane;	
			}
		}
	}

	public function pokazUczenGrupa($id_pu) {

		if($id_pu != NULL) {

			$this->_idPrzedUser = $id_pu;

			$sql = "SELECT u.id_ucz, u.nazwisko, u.imie
					FROM przedmiot_user AS pu, uczen AS u 
					WHERE pu.id = ? AND pu.id_gr = u.id_gr
					ORDER BY u.nazwisko, u.imie";

			if($stmt = Connect::getPolacz()->prepare($sql)) {
				$stmt->bind_param("i",$this->_idPrzedUser);
				$stmt->execute();
				$stmt->bind_result($this->_idUcz, $this->_nazwisko, $this->_imie);
				
				while ($stmt->fetch())
				{
					$this->dane[] = array($this->_idUcz, $this->_nazwisko, $this->_imie);
				}
				
				return $this->dane;
			}
		}
	}

	/**
	* Pokazuje uczniów klas
	*/
	public function pokazUczniowKlasy($id_kl){

		$this->_idKlasa = $id_kl;

		$sql = "SELECT u.id_ucz, u.nazwisko, u.imie, kl.kl, kl.skrot, gr.grupa
				FROM uczen AS u, grupy AS gr, klasy AS kl
				WHERE u.id_gr = gr.id_gr AND gr.id_kl = kl.id_kl AND kl.id_kl = ?
				ORDER BY gr.grupa, u.nazwisko, u.imie";

		if($stmt = Connect::getPolacz()->prepare($sql)) {
			$stmt->bind_param("i",$this->_idKlasa);
			$stmt->execute();
			$stmt->execute();
			$stmt->bind_result($this->_idUcz, $this->_nazwisko, $this->_imie, $this->_klasa, $this->_skrot, $this->_grupa);

			while ($stmt->fetch())
			{
				$this->wynik[] = array($this->_idUcz, $this->_nazwisko, $this->_imie, $this->_klasa, $this->_skrot, $this->_grupa);
			}
			
			return $this->wynik;
		}		
	}


	/**
	* Dodaje ucznia do bazy
	*/
	public function dodaj($nazwisko,$imie,$idGrupa,$zm_4=NULL,$zm_5=NULL,$zm_6=NULL){

		if(is_string($nazwisko) && is_string($imie) && is_numeric($idGrupa)){
		
			if($nazwisko != '' && $imie != '' && $idGrupa > 0){
			
				$this->_nazwisko = $nazwisko;
				$this->_imie = $imie;
				$this->_idGrupa = $idGrupa;

				if($stmt = Connect::getPolacz()->prepare("SELECT * FROM uczen WHERE nazwisko = ? AND imie = ? AND id_gr = ?")){
					$stmt->bind_param("ssi",$this->_nazwisko,$this->_imie,$this->_idGrupa);
					$stmt->execute();
					$stmt->store_result();

					if($stmt->num_rows > 0){
						$stmt->close();
					} else {

						$stmt = Connect::getPolacz()->prepare("INSERT INTO uczen VALUE(NULL,?,?,?)");
						$stmt->bind_param("ssi",$this->_nazwisko,$this->_imie,$this->_idGrupa);
						$stmt->execute();
						$stmt->close();
					}
				}
			}
		}
	}

	/**
	* Poprawia dane ucznia w bazie
	*/
	public function popraw($idUcz,$nazwisko,$imie,$idGrupa,$zm_5=NULL,$zm_6=NULL,$zm_7=NULL){

		if(is_numeric($idUcz) && is_string($nazwisko) && is_string($imie) && is_numeric($idGrupa)){

			if($idUcz > 0 && $nazwisko != '' && $imie != '' && $idGrupa > 0){

				$this->_idUcz = $idUcz;
				$this->_nazwisko = $nazwisko;
				$this->_imie = $imie;
				$this->_idGrupa= $idGrupa;

				if($stmt = Connect::getPolacz()->prepare("SELECT * FROM uczen WHERE id_ucz = ?")){
					
					$stmt->bind_param("i",$this->_idUcz);
					$stmt->execute();
					$stmt->store_result();

					if($stmt->num_rows > 0){

						$stmt = Connect::getPolacz()->prepare("UPDATE uczen SET nazwisko = ?, imie = ?, id_gr = ? WHERE id_ucz = ?");
						$stmt->bind_param("ssii",$this->_nazwisko,$this->_imie,$this->_idGrupa,$this->_idUcz);
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
	* Usuwa ucznia z bazy
	*/
	public function usun($idUcz){

		if(is_numeric($idUcz) && $idUcz > 0){

			$this->_idUcz = $idUcz;

			if($stmt = Connect::getPolacz()->prepare("SELECT * FROM uczen WHERE id_ucz = ?")){
				
				$stmt->bind_param("i",$this->_idUcz);
				$stmt->execute();
				$stmt->store_result();

				if($stmt->num_rows > 0){

					$stmt = Connect::getPolacz()->prepare("DELETE FROM uczen WHERE id_ucz = ?");
					$stmt->bind_param("i",$this->_idUcz);
					$stmt->execute();
					$stmt->close();

				} else {

					$stmt->close();
				}
			}			
		}
	}

	/**
	* Oblicza ilość uczniów w grupie
	*/
	public function oblicz($idGrupa=NULL,$zm_2=NULL){
		
		if(is_numeric($idGrupa) && $idGrupa > 0){

			$this->_idGrupa = $idGrupa;

			$stmt = Connect::getPolacz()->prepare("SELECT * FROM uczen WHERE id_gr = ?");
			$stmt->bind_param("i",$this->_idGrupa);
			$stmt->execute();
			$stmt->store_result();

			$ile = $stmt->num_rows;

			return $ile;

		} else {

			$stmt = Connect::getPolacz()->prepare("SELECT * FROM uczen");
			$stmt->execute();
			$stmt->store_result();

			$ile = $stmt->num_rows;

			return $ile;

		}
	}

	/**
	* Zmienne SET
	*/
	public function setImie($imie){
		$this->_imie = $imie;
	}

	public function setNazwisko($nazwisko){
		$this->_nazwisko = $nazwisko;
	}

	public function setIdGrupa($id){
		$this->_idGrupa = $id;
	}

	/**
	* Zmienne GET
	*/
	public function getImie(){
		return $this->_imie;
	}	

	public function getNazwisko(){
		return $this->_nazwisko;
	}

	public function getIdGrupa(){
		return $this->_idGrupa;
	}
}
