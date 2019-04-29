<?php

class Stan {

	/**
	*	Przyjęte oznaczenia
	*	o - obecny; n - nieobecny; s - spóźniony; z - zwolniony; d - delegowany
	*/	
	private $_stan;
	private $_symbol;
	private $_liczba;
	private $_oznaczenie;

	function __construct(){

		$this->_stan = array(
			'o' => 'obecny',
			'n' => 'nieobecny',
			's' => 'spóźniony',
			'z' => 'zwolniony',
			'd' => 'delegowany'
			);

		$this->_symbol = array('o','n','s','z','d');
	}

	public function getStan($oz){

		if(is_string($oz) && $oz != '') {
			$this->_oznaczenie = $oz;
			return $this->_stan[$this->_oznaczenie];
		}
	}

	public function getLiczba($li) {

		if(is_numeric($li) && $li >= 0) {
			$this->_liczba = $li;
			return $this->_symbol[$this->_liczba];
		}
	}
}
?>