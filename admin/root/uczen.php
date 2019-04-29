<?php

	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}

	$Connect = new Connect();
	$Uczen = new Uczen();

	/*
	** htmlentities - funkcja konwerteruje specjalne znaki na symbole
	** ENT_QUOTES - cudzysłowy oraz apostrofy podlegają konwerterowaniu
	*/
	$id_kl =  htmlentities($_POST['id_kl'], ENT_QUOTES);
	@$id_gr =  htmlentities($_POST['id_gr'], ENT_QUOTES);
	@$id_ucz =  htmlentities($_POST['id_ucz'], ENT_QUOTES);
	@$nazwisko =  htmlentities($_POST['nazwisko'], ENT_QUOTES);
	@$imie = htmlentities($_POST['imie'], ENT_QUOTES);

	if(isset($_GET['id_ucz'])){
		@$id_ucz =  htmlentities($_GET['id_ucz'], ENT_QUOTES);
	}

	//Miejsce przekierowania
	$url = '../view/v_uczen.php';

	if($nazwisko != '' && $imie != '' && $id_gr > 0 && $id_ucz == NULL){	
		//Dodaj
		$Uczen->dodaj($nazwisko,$imie,$id_gr);
		header("location: $url");

	} else if ($nazwisko != '' && $imie != '' && $id_gr > 0 && $id_ucz > 0){
		//Popraw
		$Uczen->popraw($id_ucz,$nazwisko,$imie,$id_gr);
		header("location: $url?id_kl=$id_kl");

	} else if ($nazwisko == '' && $imie == '' && $id_gr == NULL && $id_ucz > 0){
		//Usuń
		$Uczen->usun($id_ucz);
		header("location: $url");

	} else {		
		//Prezentacja
		header("location: $url");
	}

?>