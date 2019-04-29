<?php

	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}

	$Connect = new Connect();
	$PrzedmiotyUser = new PrzedmiotyUser();

	/*
	** htmlentities - funkcja konwerteruje specjalne znaki na symbole
	** ENT_QUOTES - cudzysłowy oraz apostrofy podlegają konwerterowaniu
	*/
	@$id =  htmlentities($_POST['id'], ENT_QUOTES);
	@$id_naucz =  htmlentities($_POST['id_naucz'], ENT_QUOTES);	
	@$id_przed =  htmlentities($_POST['id_przed'], ENT_QUOTES);	
	@$id_gr =  htmlentities($_POST['id_gr'], ENT_QUOTES);

	if(isset($_GET['id'])){
		@$id =  htmlentities($_GET['id'], ENT_QUOTES);
	}

	//Miejsce przekierowania
	$url = '../view/v_przed_nauczyciel.php';

	if($id == NULL && $id_naucz > 0 && $id_przed > 0 && $id_gr > 0){	
		//Dodaj
		$PrzedmiotyUser->dodaj($id_naucz,$id_przed,$id_gr);
		header("location: $url");

	} else if ($id > 0 && $id_naucz > 0 && $id_przed > 0 && $id_gr > 0){
		//Popraw
		$PrzedmiotyUser->popraw($id,$id_naucz,$id_przed,$id_gr);
		header("location: $url");

	} else if ($id > 0 && $id_naucz == NULL && $id_przed == NULL && $id_gr == NULL){
		//Usuń
		$PrzedmiotyUser->usun($id);
		header("location: $url");

	} else {
		//Prezentacja
		header("location: $url");
	}

?>