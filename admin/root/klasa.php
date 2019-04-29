<?php

	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}

	$Connect = new Connect();
	$OddzialKlasowy = new OddzialKlasowy();

	/*
	** htmlentities - funkcja konwerteruje specjalne znaki na symbole
	** ENT_QUOTES - cudzysłowy oraz apostrofy podlegają konwerterowaniu
	*/
	@$id_kl =  htmlentities($_POST['id_kl'], ENT_QUOTES);
	@$kl = htmlentities($_POST['kl'], ENT_QUOTES);
	@$skrot = htmlentities($_POST['skrot'], ENT_QUOTES);

	if(isset($_GET['id_kl'])){
		@$id_kl =  htmlentities($_GET['id_kl'], ENT_QUOTES);
	}


	//Miejsce przekierowania
	$url = '../view/v_klasa.php';

	if($id_kl== NULL && $kl != '' && $skrot != ''){	
		//Dodaj
		$OddzialKlasowy->dodaj($kl,$skrot);
		header("location: $url");

	} else if ($id_kl > 0 && $kl != '' && $skrot != ''){
		//Popraw
		$OddzialKlasowy->popraw($id_kl,$kl,$skrot);
		header("location: $url");

	} elseif ($id_kl > 0 && $kl == '' && $skrot == ''){
		//Usuń
		$OddzialKlasowy->usun($id_kl);
		header("location: $url");

	} else {		
		//Prezentacja
		header("location: $url");

	}

?>