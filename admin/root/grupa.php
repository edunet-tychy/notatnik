<?php

	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}

	$Connect = new Connect();
	$Grupy = new Grupy();

	/*
	** htmlentities - funkcja konwerteruje specjalne znaki na symbole
	** ENT_QUOTES - cudzysłowy oraz apostrofy podlegają konwerterowaniu
	*/
	@$id_gr =  htmlentities($_POST['id_gr'], ENT_QUOTES);
	@$id_kl =  htmlentities($_POST['id_kl'], ENT_QUOTES);
	@$grupa = htmlentities($_POST['grupa'], ENT_QUOTES);

	if(isset($_GET['id_gr'])){
		@$id_gr =  htmlentities($_GET['id_gr'], ENT_QUOTES);
	}


	//Miejsce przekierowania
	$url = '../view/v_grupa.php';

	if($id_gr== NULL && $id_kl > 0 && $grupa != ''){	
		//Dodaj
		$Grupy->dodaj($id_kl,$grupa);
		header("location: $url");

	} else if ($id_gr > 0 && $id_kl > 0 && $grupa != ''){
		//Popraw
		$Grupy->popraw($id_gr,$id_kl,$grupa);
		header("location: $url");

	} elseif ($id_gr > 0 && $id_kl == NULL && $grupa == ''){
		//Usuń
		$Grupy->usun($id_gr);
		header("location: $url");

	} else {		
		//Prezentacja
		header("location: $url");

	}

?>