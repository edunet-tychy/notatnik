<?php

// class.oceny.php
include_once("interface.database.php");

$Connect = new Connect();

class Oceny implements Database
{
	private $_idOc;
	private $_idPrzedUser;
	private $_idNaucz;
	private $_idGr;
	private $_ocena;
	private $_data;
	private $_idUcz;
	public $dane;
	public $srednia;

	private $_oceny = array('6','5+','5','5-','4+','4','4-','3+','3','3-','2+','2','2-','1+','1','+','-','0','np','nb','zw');
	private $_konwersja = array('6' => 6.0, '5+' => 5.5, '5' => 5.0, '5-' => 4.75, '4+' => 4.5, '4' => 4.0, '4-' => 3.75, '3+' => 3.5, '3' => 3.0, '3-' => 2.75, '2+' => 2.5, '2' => 2.0, '2-' => 1.75, '1+' => 1.5, '1' => 1.0, '0' => 0);

	/**
	* Pokazuje oceny ucznia z podanego przedmiotu
	* $id_naucz - z tabeli przedmiot_user
	*/
	public function pokaz($id_pu, $id_ucz){

		if(is_numeric($id_pu) && $id_pu > 0 && is_numeric($id_ucz) && $id_ucz > 0){

			$this->_idPrzedUser = $id_pu;
			$this->_idUcz = $id_ucz;

			if($stmt = Connect::getPolacz()->prepare("SELECT id_oc, ocena, data FROM oceny WHERE id_pu = ? AND id_ucz = ?")) {
				$stmt->bind_param("ii",$this->_idPrzedUser,$this->_idUcz);
				$stmt->execute();
				$stmt->bind_result($this->_idOc,$this->_ocena,$this->_data);
				
				while ($stmt->fetch())
				{
					$this->dane[] = array($this->_idOc, $this->_ocena, $this->_data, $this->_idUcz);
				}
				
				return $this->dane;
			}
		}	
	}

	/**
	* Dodaje ocenę z danego przedmiotu
	*/
	public function dodaj($id_pu,$ocena,$data,$id_ucz,$zm_5=NULL,$zm_6=NULL){

		if(is_numeric($id_pu) && is_string($ocena) && is_string($data) && is_numeric($id_ucz)){

			if($id_pu > 0 && $ocena !='' && $data !='' && $id_ucz > 0){

				if($this->verOceny($ocena)){

					$this->_idPrzedUser = $id_pu;
					$this->_ocena = $ocena;
					$this->_data = $data;
					$this->_idUcz = $id_ucz;

					$stmt = Connect::getPolacz()->prepare("INSERT INTO oceny VALUE(NULL,?,?,?,?)");
					$stmt->bind_param("issi",$this->_idPrzedUser,$this->_ocena,$this->_data,$this->_idUcz);
					$stmt->execute();
					$stmt->close();

				}
			}
		}
	}

	/**
	* Poprawia ocenę z danego przedmiotu
	*/
	public function popraw($id_oc,$id_gr,$ocena,$data,$id_ucz,$zm_6=NULL,$zm_7=NULL){

		if(is_numeric($id_oc) && is_numeric($id_gr) && is_string($ocena) && is_string($data) && is_numeric($id_ucz)){

			if($id_oc > 0 && $id_gr > 0 && $ocena != '' && $data != '' && $id_ucz > 0){

				if($this->verOceny($ocena)){

					$this->_idOc = $id_oc;
					$this->_idGr = $id_gr;
					$this->_ocena = $ocena;
					$this->_data = $data;
					$this->_idUcz = $id_ucz;

					if($stmt = Connect::getPolacz()->prepare("SELECT * FROM oceny WHERE id_oc = ?")){
						
						$stmt->bind_param("i",$this->_idOc);
						$stmt->execute();
						$stmt->store_result();

						if($stmt->num_rows > 0){

							$stmt = Connect::getPolacz()->prepare("UPDATE oceny SET id_gr = ?, ocena = ?, data = ?, id_ucz = ? WHERE id_oc = ?");
							$stmt->bind_param("issii",$this->_idGr,$this->_ocena,$this->_data,$this->_idUcz,$this->_idOc);
							$stmt->execute();
							$stmt->close();

						} else {

							$stmt->close();
						}
					}
				}
			}
		}	
	}

	/**
	* Usuwa ocenę z danego przedmiotu
	*/
	public function usun($id_oc){
	
		if(is_numeric($id_oc) && $id_oc > 0){

			$this->_idOc = $id_oc;

			if($stmt = Connect::getPolacz()->prepare("SELECT * FROM oceny WHERE id_oc = ?")){
				
				$stmt->bind_param("i",$this->_idOc);
				$stmt->execute();
				$stmt->store_result();

				if($stmt->num_rows > 0){

					$stmt = Connect::getPolacz()->prepare("DELETE FROM oceny WHERE id_oc = ?");
					$stmt->bind_param("i",$this->_idOc);
					$stmt->execute();
					$stmt->close();

				} else {

					$stmt->close();
				}
			}			
		}
	}

	/**
	* Oblicza średnią ocen z danego przedmiotu
	*/
	public function oblicz($id_naucz,$id_ucz){
		
		$suma = 0;
		$ile = 0;

		//Wywołanie funkcji prezentującej oceny
		$oceny = $this->pokaz(1,1);

		//Funkcja zwraca tablicę dwówymiarową
		foreach($oceny as $dane) {

			//Liczba "2" oznacza pozycję w tablicy z oceną
			$ocena = $dane[2];

			//Sprawdzenie, czy ocena może być zamieniona na wartość liczbową
			if(isset($this->_konwersja[$ocena])){

				$suma += $this->_konwersja[$ocena];
				$ile++;

			}
		}

		$this->srednia = $suma/$ile;
		//Określa ilość miejsc po przecinku
		$this->srednia = round($this->srednia, 2);

		return $this->srednia;
	}

	/**
	* Weryfikacja formatu oceny
	*/
	private function verOceny($ocena){
		foreach ($this->_oceny as $_ocena) {
			
			if($_ocena == $ocena){
				return True;
			}
		}
	}

	/**
	* Weryfikacja formatu oceny
	*/
	public function getOceny($poz){

		if(is_numeric($poz) && $poz >= 0 && $poz <=20){
			return $this->_oceny[$poz];
		}

	}

}
