<?php

// class.grupy.php
include_once("interface.database.php");

class Grupy implements Database
{

	private $_idGr;
	private $_idKlasa;
	private $_klasa;
	private $_skrot;
	private $_grupa;
	private $_symbol;
	private $_tablica;
	public $wynik;
	public $dane;
	public $ile;

	/**
	*	Pokazuje grupy
	*/
	public function pokaz($id_kl=NULL,$zm_2=NULL){

		if($id_kl==NULL){
			if($stmt = Connect::getPolacz()->prepare("SELECT id_gr, id_kl, grupa FROM grupy ORDER BY id_kl, grupa")) {
				$stmt->execute();
				$stmt->bind_result($this->_idGr, $this->_idKlasa, $this->_grupa);
				
				while ($stmt->fetch())
				{
					$this->dane[] = array($this->_idGr, $this->_idKlasa, $this->_grupa);
				}
				
				return $this->dane;
			}

		} else {
			if(is_numeric($id_kl) && $id_kl > 0){
			
				$this->_idKlasa = $id_kl;

				if($stmt = Connect::getPolacz()->prepare("SELECT id_gr, grupa FROM grupy WHERE id_kl = ? ORDER BY grupa")) {
					$stmt->bind_param("i",$this->_idKlasa);
					$stmt->execute();
					$stmt->bind_result($this->_idGr, $this->_grupa);
					
					while ($stmt->fetch())
					{
						$this->dane[] = array($this->_idGr, $this->_grupa);
					}
					
					return $this->dane;
				}
			}
		}
	}

	/**
	* Pokazuje klasy oraz jej grupy
	*/

	public function grupyKlasy($id_gr=NULL){
		if($id_gr==NULL){
			$sql = "SELECT kl.id_kl, gr.id_gr, kl.kl, kl.skrot, gr.grupa 
					FROM klasy AS kl
					LEFT OUTER JOIN grupy AS gr
					ON kl.id_kl = gr.id_kl
					ORDER BY kl.kl, gr.grupa";

			if($stmt = Connect::getPolacz()->prepare($sql)) {
				$stmt->execute();
				$stmt->bind_result($this->_idKlasa, $this->_idGr, $this->_klasa, $this->_skrot, $this->_grupa);
				
				while ($stmt->fetch())
				{
					$this->dane[] = array($this->_idKlasa, $this->_idGr, $this->_klasa, $this->_skrot, $this->_grupa);
				}
				
				return $this->dane;
			}

		} else {
			if(is_numeric($id_gr) && $id_gr > 0){
				
				$this->_idGr = $id_gr;

				$sql = "SELECT gr.id_kl, kl.kl, kl.skrot, gr.grupa
						FROM grupy AS gr, klasy AS kl
						WHERE gr.id_gr = ? AND gr.id_kl = kl.id_kl";

				if($stmt = Connect::getPolacz()->prepare($sql)) {
					$stmt->bind_param("i",$this->_idGr);
					$stmt->execute();
					$stmt->bind_result($this->_idKlasa, $this->_klasa, $this->_skrot, $this->_grupa);
					
					while ($stmt->fetch())
					{
						$this->dane[] = array($this->_idKlasa, $this->_klasa, $this->_skrot, $this->_grupa);
					}
					
					return $this->dane;
				}
			}
		}
	
	}

	/**
	*	Usuwa duplikaty z tablicy dwuwymiarowej funkcji grupyKlasy, gdy id_gr == NULL
	*	wiersz[0] -> id_kl;
	*/
	public function duplikaty() {

		$sql = "SELECT kl.id_kl, gr.id_gr, kl.kl, kl.skrot, gr.grupa 
				FROM klasy AS kl
				LEFT OUTER JOIN grupy AS gr
				ON kl.id_kl = gr.id_kl
				GROUP BY kl.id_kl
				ORDER BY kl.kl, gr.grupa";

		if($stmt = Connect::getPolacz()->prepare($sql)) {
			$stmt->execute();
			$stmt->bind_result($this->_idKlasa, $this->_idGr, $this->_klasa, $this->_skrot, $this->_grupa);
			
			while ($stmt->fetch())
			{
				$this->wynik[] = array($this->_idKlasa, $this->_idGr, $this->_klasa, $this->_skrot, $this->_grupa);
			}
			
			return $this->wynik;
		}
	}

	/**
	*	Dodaje grupę do bazy
	*/
	public function dodaj($id_kl,$grupa,$zm_3=NULL,$zm_4=NULL,$zm_5=NULL,$zm_6=NULL){

		if(is_numeric($id_kl) && is_string($grupa)){

			if($id_kl > 0 && $grupa != ''){
	
				$this->_idKlasa = $id_kl;
				$this->_grupa = $grupa;
				
				if($stmt = Connect::getPolacz()->prepare("SELECT * FROM grupy WHERE id_kl = ? AND grupa = ?")){
					$stmt->bind_param("is",$this->_idKlasa,$this->_grupa);
					$stmt->execute();
					$stmt->store_result();

					if($stmt->num_rows > 0){
						$stmt->close();
					} else {

						$stmt = Connect::getPolacz()->prepare("INSERT INTO grupy VALUE(NULL,?,?)");
						$stmt->bind_param("is",$this->_idKlasa,$this->_grupa);
						$stmt->execute();
						$stmt->close();
					}
				}
			}
		}
	}

	/**
	*	Poprawia dane grupy w bazie
	*/
	public function popraw($id_gr,$id_kl,$grupa,$zm_4=NULL,$zm_5=NULL,$zm_6=NULL,$zm_7=NULL){

		if(is_numeric($id_gr) && is_numeric($id_kl) && is_string($grupa)){

			if($id_gr > 0 && $id_kl > 0 && $grupa != ''){

				$this->_idGr = $id_gr;
				$this->_idKlasa = $id_kl;
				$this->_grupa = $grupa;

				if($stmt = Connect::getPolacz()->prepare("SELECT * FROM grupy WHERE id_gr = ?")){

					$stmt->bind_param("i",$this->_idGr);
					$stmt->execute();
					$stmt->store_result();

					if($stmt->num_rows > 0){

						// Sprawdzenie, czy podana grupa w danej klasie istnieje
						if($stmt = Connect::getPolacz()->prepare("SELECT * FROM grupy WHERE id_kl = ? AND grupa = ?")){
						
							$stmt->bind_param("is",$this->_idKlasa,$this->_grupa);
							$stmt->execute();
							$stmt->store_result();

							if($stmt->num_rows == 0){

								$stmt = Connect::getPolacz()->prepare("UPDATE grupy SET id_kl = ?, grupa = ? WHERE id_gr = ?");
								$stmt->bind_param("isi",$this->_idKlasa,$this->_grupa,$this->_idGr);
								$stmt->execute();
								$stmt->close();

							}

						} else {

							$stmt->close();
						}

					} else {

						$stmt->close();
					}
				}
			}

		}

	}

	/**
	*	Usuwa grupę z bazy
	*/
	public function usun($id_gr){

		if(is_numeric($id_gr)) {
			
			$this->_idGr = $id_gr;

			if($stmt = Connect::getPolacz()->prepare("SELECT * FROM grupy WHERE id_gr = ?")){
				
				$stmt->bind_param("i",$this->_idGr);
				$stmt->execute();
				$stmt->store_result();

				if($stmt->num_rows > 0){

					$stmt = Connect::getPolacz()->prepare("DELETE FROM grupy WHERE id_gr = ?");
					$stmt->bind_param("i",$this->_idGr);
					$stmt->execute();
					$stmt->close();

				} else {

					$stmt->close();
				}
			}			
		}

	}

	/**
	*	Oblicza ilość grup w klasie oraz łączną ilość grup
	*/
	public function oblicz($id_kl=NULL,$zm_2=NULL){

		if($id_kl==NULL){

			$stmt = Connect::getPolacz()->prepare("SELECT * FROM grupy");
			$stmt->execute();
			$stmt->store_result();

			$this->ile = $stmt->num_rows;

			return $this->ile;

		} else {

			if(is_numeric($id_kl) && $id_kl > 0){
				
				$this->_idKlasa = $id_kl;

				$stmt = Connect::getPolacz()->prepare("SELECT * FROM grupy WHERE id_kl = ?");
				$stmt->bind_param("i",$this->_idKlasa);
				$stmt->execute();
				$stmt->store_result();

				$this->ile = $stmt->num_rows;

				return $this->ile;

			}
		}
	}
}