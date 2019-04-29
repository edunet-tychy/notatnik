<?php

class Data {
	private $_dni;
	private $_dzienTygodnia;
	private $_aktualnaData;
	private $_aktualnaDataBaza;
	private $_aktualnyMiesiac;


	function __construct(){
		$this->_dni = array('niedziela', 'poniedziałek', 'wtorek', 'środa', 'czwartek', 'piątek', 'sobota');
		$this->_dzienTygodnia = $this->_dni[date('w')];

		$this->_aktualnaData = date('d-m-Y');

	}

	public function getDzienTyg(){
		return $this->_dzienTygodnia;
	}

	public function getAktData(){
		return $this->_aktualnaData;
	}

	public function getAktDataBaza(){
		return $this->_aktualnaDataBaza = date('Y-m-d');
	}

		public function getAktMsc(){
		return $this->_aktualnyMiesiac = date('n');
	}
}