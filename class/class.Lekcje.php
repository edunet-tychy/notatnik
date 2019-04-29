<?php

// class.frekwencja.php
include_once("interface.database.php");

class Lekcje implements Database
{
	private $_idLek;
	private $_idPrzedUser;
	private $_idRoz;
	private $_data;
	private $_godz;
	public $dane;
	public $ile;

	public function pokaz($id_roz,$zm_2=NULL){

	}

	public function pokazLekcja($id_pu,$data,$godz){
		if(is_numeric($id_pu) && is_string($data) && is_numeric($godz)){

			if($id_pu > 0 && $data != '' && $godz >= 0){

				$this->_idPrzedUser = $id_pu;
				$this->_data = $data;
				$this->_godz = $godz;

				if($stmt = Connect::getPolacz()->prepare("SELECT id_lek, id_roz FROM lekcje WHERE id_pu = ? AND data = ? AND godz = ?")) {
					$stmt->bind_param("isi",$this->_idPrzedUser, $this->_data, $this->_godz);
					$stmt->execute();
					$stmt->bind_result($this->_idLek, $this->_idRoz);
					
					while ($stmt->fetch())
					{
						$this->_idLek;
						$this->dane[] = array($this->_idLek, $this->_idRoz);
					}
					
					return $this->dane;
				}
			}
		}
	}

	public function dodaj($id_pu,$id_roz,$data,$godz,$zm_5=NULL,$zm_6=NULL){

		if(is_numeric($id_pu) && is_numeric($id_roz) && is_string($data) && is_numeric($godz)){

			if($id_pu > 0 && $id_roz > 0 && $data != '' && $godz >= 0){

				$this->_idPrzedUser = $id_pu;
				$this->_idRoz = $id_roz;
				$this->_data = $data;
				$this->_godz = $godz;

				if($stmt = Connect::getPolacz()->prepare("SELECT id_lek FROM lekcje WHERE data = ? AND godz = ?")){
					$stmt->bind_param("si",$this->_data, $this->_godz);
					$stmt->execute();
					$stmt->store_result();

					if($stmt->num_rows > 0){
						$stmt->close();

					} else {

						$stmt = Connect::getPolacz()->prepare("INSERT INTO lekcje VALUE(NULL,?,?,?,?)");
						$stmt->bind_param("iisi",$this->_idPrzedUser,$this->_idRoz,$this->_data,$this->_godz);
						$stmt->execute();
						$stmt->close();
					}
				}
			}
		}
	}


	public function popraw($id_lek,$id_pu,$id_roz,$data,$godz,$zm_6=NULL,$zm_7=NULL){

		if(is_numeric($id_lek) && is_numeric($id_pu) && is_numeric($id_roz) && is_string($data) && is_numeric($godz)){

			if($id_lek > 0 && $id_pu > 0 && $id_roz > 0 && $data != '' && $godz > 0){

				$this->_idLek = $id_lek;
				$this->_idPrzedUser = $id_pu;
				$this->_idRoz = $id_roz;
				$this->_data = $data;
				$this->_godz = $godz;

				if($stmt = Connect::getPolacz()->prepare("SELECT * FROM lekcje WHERE id_lek = ?")){
					
					$stmt->bind_param("i",$this->_idLek);
					$stmt->execute();
					$stmt->store_result();

					if($stmt->num_rows > 0){

						$stmt = Connect::getPolacz()->prepare("UPDATE lekcje SET id_pu = ?, id_roz = ?, data = ?, godz = ? WHERE id_lek = ?");
						$stmt->bind_param("iisii",$this->_idPrzedUser,$this->_idRoz,$this->_data,$this->_godz,$this->_idLek);
						$stmt->execute();
						$stmt->close();

					} else {

						$stmt->close();
					}
				}
			}
		}

	}

	public function usun($id_lek){

	}

	public function oblicz($id_pu,$zm_2=NULL){

		if(is_numeric($id_pu) && $id_pu > 0) {

			$this->_idPrzedUser = $id_pu;

			if($stmt = Connect::getPolacz()->prepare("SELECT SUM(id_pu) FROM lekcje WHERE id_pu = ?")) {
				$stmt->bind_param("i",$this->_idPrzedUser);
				$stmt->execute();
				$stmt->bind_result($this->ile);

				while ($stmt->fetch())
					{
						$this->ile;
					}
								
				return $this->ile;
			}
		}

	}

}