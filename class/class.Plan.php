<?php

// class.frekwencja.php
include_once("interface.database.php");

class Plan implements Database
{
	private $_idUser;
	private $_idGrupa;
	private $_idPlan;
	private $_dzien;
	private $_pDzien;
	private $_godz;
	private $_pGodz;
	private $_grupa;
	private $_kl;
	private $_skrot;
	public $dane;
	public $wynik;

	function __construct(){
	
	}

	/**
	* Pokazuje plan nauczyciela
	*/
	public function pokaz($id_user, $zm_2=NULL) {

		$this->_idUser = $id_user;

		$sql = "SELECT d.dzien, g.godz, gr.grupa, kl.kl, kl.skrot, p.id_gr, p.id_pl, p.godz, p.dzien
				FROM plan AS p, dni AS d, godziny AS g, grupy AS gr, klasy AS kl
				WHERE p.id_user = ? AND p.dzien = d.id_tyg AND p.godz = g.id_godz
				AND p.id_gr = gr.id_gr AND gr.id_kl = kl.id_kl
				ORDER BY d.dzien, g.godz";

		if($stmt = Connect::getPolacz()->prepare($sql)) {
			$stmt->bind_param("i",$this->_idUser);
			$stmt->execute();
			$stmt->bind_result($this->_dzien, $this->_godz, $this->_grupa, $this->_kl, $this->_skrot,
				$this->_idGrupa, $this->_idPlan, $this->_pDzien, $this->_pGodz);

			while ($stmt->fetch())
			{
				$this->dane[] = array($this->_dzien, $this->_godz, $this->_grupa, $this->_kl, $this->_skrot,
					$this->_idGrupa, $this->_idPlan, $this->_pDzien, $this->_pGodz);
			}
			
			return $this->dane;
		}
	}

	/**
	* Dodaje grupę do planu
	*/
	public function dodaj($id_user,$id_gr,$godz,$dzien,$zm_4=NULL,$zm_5=NULL,$zm_6=NULL){

		if(is_numeric($id_user) && is_numeric($id_gr) && is_numeric($godz) && is_numeric($dzien)){

			if($id_user > 0 && $id_gr > 0 && $godz > 0 && $dzien > 0){
	
				$this->_idUser = $id_user;
				$this->_idGrupa = $id_gr;
				$this->_godz = $godz;
				$this->_dzien = $dzien;
				
				if($stmt = Connect::getPolacz()->prepare("SELECT * FROM plan WHERE id_user = ? AND id_gr = ? AND godz = ? AND dzien = ?")){
					$stmt->bind_param("iiii",$this->_idUser,$this->_idGrupa,$this->_godz,$this->_dzien);
					$stmt->execute();
					$stmt->store_result();

					if($stmt->num_rows > 0){
						$stmt->close();
					} else {

						$stmt = Connect::getPolacz()->prepare("INSERT INTO plan VALUE(NULL,?,?,?,?)");
						$stmt->bind_param("iiii",$this->_idUser,$this->_idGrupa,$this->_godz,$this->_dzien);
						$stmt->execute();
						$stmt->close();
					}
				}
			}
		}
	}

	/**
	* Sprawdza, czy grupa jest na planie
	*/
	public function testID($id_user,$id_gr,$godz,$dzien){

		if(is_numeric($id_user) && is_numeric($id_gr) && is_numeric($godz) && is_numeric($dzien)){

			if($id_user > 0 && $id_gr > 0 && $godz > 0 && $dzien > 0){
	
				$this->_idUser = $id_user;
				$this->_idGrupa = $id_gr;
				$this->_godz = $godz;
				$this->_dzien = $dzien;
				
				if($stmt = Connect::getPolacz()->prepare("SELECT id_pl FROM plan WHERE id_user = ? AND id_gr = ? AND godz = ? AND dzien = ?")){
					$stmt->bind_param("iiii",$this->_idUser,$this->_idGrupa,$this->_godz,$this->_dzien);
					$stmt->execute();
					$stmt->bind_result($this->_idPlan);

					while ($stmt->fetch())
					{
						$this->_idPlan;
					}

					return $this->_idPlan;
				}
			}
		}	
	}

	/**
	* Poprawia grupę na planie
	*/
	public function popraw($id_pl,$id_gr,$zm_3=NULL,$zm_4=NULL,$zm_5=NULL,$zm_6=NULL,$zm_7=NULL){

		if(is_numeric($id_pl) && is_numeric($id_gr)){

			if($id_pl > 0 && $id_gr > 0){
	
				$this->_idPlan = $id_pl;
				$this->_idGrupa = $id_gr;
				
				if($stmt = Connect::getPolacz()->prepare("SELECT * FROM plan WHERE id_pl = ?")){
					$stmt->bind_param("i",$this->_idPlan);
					$stmt->execute();
					$stmt->store_result();

					if($stmt->num_rows > 0){

						$stmt = Connect::getPolacz()->prepare("UPDATE plan SET id_gr = ? WHERE id_pl = ?");
						$stmt->bind_param("ii",$this->_idGrupa, $this->_idPlan);
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
	*	Usuwa grupę z planu
	*/
	public function usun($id_pl){

		if(is_numeric($id_pl)) {
			
			$this->_idPlan = $id_pl;

			if($stmt = Connect::getPolacz()->prepare("SELECT * FROM plan WHERE id_pl = ?")){
				
				$stmt->bind_param("i",$this->_idPlan);
				$stmt->execute();
				$stmt->store_result();

				if($stmt->num_rows > 0){

					$stmt = Connect::getPolacz()->prepare("DELETE FROM plan WHERE id_pl = ?");
					$stmt->bind_param("i",$this->_idPlan);
					$stmt->execute();
					$stmt->close();

				} else {

					$stmt->close();
				}
			}			
		}

	}

	public function oblicz($zm_1,$zm_2){
	
	}
}