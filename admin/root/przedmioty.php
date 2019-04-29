<?php

	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}

	$Connect = new Connect();
	$Przedmioty = new Przedmioty();

	/*
	** htmlentities - funkcja konwerteruje specjalne znaki na symbole
	** ENT_QUOTES - cudzysłowy oraz apostrofy podlegają konwerterowaniu
	*/
	@$id_przed =  htmlentities($_POST['id_przed'], ENT_QUOTES);
	@$nazwa = htmlentities($_POST['nazwa'], ENT_QUOTES);
	@$skrot = htmlentities($_POST['skrot'], ENT_QUOTES);

	if(isset($_GET['id_przed'])){
		@$id_przed =  htmlentities($_GET['id_przed'], ENT_QUOTES);
	}


	//Miejsce przekierowania
	$url = '../view/v_przedmioty.php';

	if($id_przed== NULL && $nazwa != '' && $skrot != ''){	
		//Dodaj
		$Przedmioty->dodaj($nazwa,$skrot);
		header("location: $url");

	} else if ($id_przed > 0 && $nazwa != '' && $skrot != ''){
		//Popraw
		$Przedmioty->popraw($id_przed,$nazwa,$skrot);
		header("location: $url");

	} elseif ($id_przed > 0 && $nazwa == '' && $skrot == ''){
		//Usuń
		$Przedmioty->usun($id_przed);
		header("location: $url");

	} else {		
		//Prezentacja
		header("location: $url");

	}

?>