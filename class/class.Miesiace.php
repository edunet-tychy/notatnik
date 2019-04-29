<?php

class Miesiace {
	private $_msc;

	function __construct(){
		$this->_msc = $arrayName = array(
			'1' => 'styczeń',
			'2' => 'luty',
			'3' => 'marzec',
			'4' => 'kwiecień',
			'5' => 'maj',
			'6' => 'czerwiec',
			'7' => 'lipiec',
			'8' => 'sierpień',		
			'9' => 'wrzesień',
			'10' => 'październik',
			'11' => 'listopad',
			'12' => 'grudzień');
	}

	public function getMsc($nr){
		return $this->_msc[$nr];
	}
}