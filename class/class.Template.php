<?php

class Template {
	
	private $_data;
	private $_alertTypes;
	private $_setAlertTypes;

	public function __construct(){
	}

	/**
	*	Wczytanie zawartości strony spod adresu $url
	*/
	public function load($url){
		include($url);
	}

	/**
	*	Przekierowanie pod określony adres $url
	*/
	public function redirect($url){
		header("location: $url");
	}

	/**
	*	Utworzenie tablicy z Alertami
	*/
	public function setData($name,$value){
		$this->_data[$name] = htmlentities($value, ENT_QUOTES);
	}

	/**
	*	Utworzenie rodzaju Alertów
	*/
	public function setAlertTypes($types){
		$this->_setAlertTypes = $types;
	}

	/**
	*	Utworzenie Alertów
	*/
	public function setAlert($value, $type = null){
		
		if($type == ''){
			$type = $this->_alertTypes[0];
		}

		$_SESSION[$type][] = $value;
	}

	/**
	*	Pobranie Alertów
	*/
	public function getAlerts(){
		
		$data = '';

		foreach ($this->_setAlertTypes as $alert) {
			if(isset($_SESSION[$alert])){
				foreach ($_SESSION[$alert] as $value) {
					$data .= '<li class="'.$alert.'">'. $value .'</li>';
				}
				unset($_SESSION[$alert]);
			}
		}

		return $data;
	}

	/**
	*	Pobranie typu Alertu
	*/
	public function getData($name){
		
		if(isset($this->_data[$name])){
			return $this->_data[$name];
		} else {
			return '';
		}

	}

}