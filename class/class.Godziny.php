<?php

class Godziny {

	private $_godziny;
	private $_aktGodz;
	private $_aktMin;
	private $_lekcja = 0;

	function __construct(){
		$this->_godziny = array(
			'07:10 - 07:55',
			'08:00 - 08:45',
			'08:55 - 09:40',
			'09:50 - 10:35',
			'10:45 - 11:30',
			'11:40 - 12:25',
			'12:40 - 13:25',
			'13:35 - 14:20',
			'14:25 - 15:10',
			'15:15 - 16:00',
			'16:10 - 16:55'
		);
	}

	public function getGodziny($nr){
		if(is_numeric($nr) && $nr >= 0) {
			return $this->_godziny[$nr];
		}
	}

	public function aktualnaGodzina(){
		
		$this->_aktGodz = date('G');
		$this->_aktMin = date('i');

		if(($this->_aktGodz == 7 && $this->_aktMin >= 10) && ($this->_aktGodz == 7 && $this->_aktMin <= 59)){
			$this->_lekcja = '0';
		} else if ($this->_aktGodz == 8 && $this->_aktMin >= 0 && $this->_aktMin <= 54){
			$this->_lekcja = '1';
		} else if (($this->_aktGodz == 8 && $this->_aktMin >= 55) || ($this->_aktGodz == 9 && $this->_aktMin <= 49)){
			$this->_lekcja = '2';
		} else if (($this->_aktGodz == 9 && $this->_aktMin >= 50) || ($this->_aktGodz == 10 && $this->_aktMin <= 44)){
			$this->_lekcja = '3';
		} else if (($this->_aktGodz == 10 && $this->_aktMin >= 45) || ($this->_aktGodz == 11  && $this->_aktMin <= 39)){
			$this->_lekcja = '4';
		} else if (($this->_aktGodz == 11 && $this->_aktMin >= 40) || ($this->_aktGodz == 12 && $this->_aktMin <= 39)){
			$this->_lekcja = '5';
		} else if (($this->_aktGodz == 12 && $this->_aktMin >= 40) || ($this->_aktGodz == 13 && $this->_aktMin <= 34)){
			$this->_lekcja = '6';
		} else if (($this->_aktGodz == 13 && $this->_aktMin >= 35) || ($this->_aktGodz == 14 && $this->_aktMin <= 24)){
			$this->_lekcja = '7';
		} else if (($this->_aktGodz == 14 && $this->_aktMin >= 25) || ($this->_aktGodz == 15 && $this->_aktMin <= 14)){
			$this->_lekcja = '8';
		} else if (($this->_aktGodz == 15 && $this->_aktMin >= 15) || ($this->_aktGodz == 16 && $this->_aktMin <= 9)){
			$this->_lekcja = '9';
		} else if ($this->_aktGodz == 16 && $this->_aktMin >= 10 && $this->_aktMin <= 55){
			$this->_lekcja = '10';
		}

		return $this->_lekcja;
	}
}

?>