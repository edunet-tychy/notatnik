<?php

	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}

	$Connect = new Connect();
	$Nauczyciel = new Nauczyciel();

	/*
	** htmlentities - funkcja konwerteruje specjalne znaki na symbole
	** ENT_QUOTES - cudzysłowy oraz apostrofy podlegają konwerterowaniu
	*/
	@$id =  htmlentities($_POST['id'], ENT_QUOTES);
	@$imie = htmlentities($_POST['name'], ENT_QUOTES);
	@$nazwisko = htmlentities($_POST['surname'], ENT_QUOTES);
	@$login = htmlentities($_POST['login'], ENT_QUOTES);
	@$pass = htmlentities($_POST['pass'], ENT_QUOTES);
	@$rola = htmlentities($_POST['rola'], ENT_QUOTES);
	@$akt = htmlentities($_POST['konto'], ENT_QUOTES);

	if(isset($_GET['id'])){
		@$id =  htmlentities($_GET['id'], ENT_QUOTES);
	}

	//Miejsce przekierowania
	$url = '../view/v_nauczyciel.php';

	if($id == NULL && $imie != '' && $nazwisko != '' && $login != '' && $pass != '' && $rola != '' && $akt != ''){	
		//Dodaj
		$Nauczyciel->dodaj($nazwisko,$imie,$login,$pass,$akt,$rola);
		header("location: $url");

	} else if ($id > 0 && $imie != '' && $nazwisko != '' && $login != '' && $pass != '' && $rola != ''
		&& $akt != ''){
		//Popraw
		$Nauczyciel->popraw($nazwisko,$imie,$login,$pass,$akt,$rola,$id);
		header("location: $url");

	} elseif ($id > 0 && $imie == '' && $nazwisko == '' && $login == '' && $pass == '' && $rola == ''
		&& $akt == ''){
		//Usuń
		$Nauczyciel->usun($id);
		header("location: $url");

	} else {		
		//Prezentacja
		header("location: $url");

	}

?>