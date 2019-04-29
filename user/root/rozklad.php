<?php

	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}

	$Connect = new Connect();
	$Rozklad = new Rozklad();

	/*
	** htmlentities - funkcja konwerteruje specjalne znaki na symbole
	** ENT_QUOTES - cudzysłowy oraz apostrofy podlegają konwerterowaniu
	*/
	@$id_roz =  htmlentities($_POST['id_roz'], ENT_QUOTES);
	@$id_pu =  htmlentities($_POST['id_pu'], ENT_QUOTES);
	@$temat = htmlentities($_POST['temat'], ENT_QUOTES);
	@$miesiac = htmlentities($_POST['miesiac'], ENT_QUOTES);
	@$godz = htmlentities($_POST['godz'], ENT_QUOTES);

	if(isset($_GET['id_roz'])){
		
		@$id_roz =  htmlentities($_GET['id_roz'], ENT_QUOTES);		
	}
	if(isset($_GET['id_pu'])){
		
		@$id_pu =  htmlentities($_GET['id_pu'], ENT_QUOTES);		
	}

	//Miejsce przekierowania
	$url = '../view/v_rozklad.php?id_pu='.$id_pu;

	if($id_roz == NULL && $id_pu > 0 && $temat != '' && $miesiac > 0 && $godz > 0){	
		//Dodaj
		$Rozklad->dodaj($id_pu,$temat,$miesiac,$godz);
		header("location: $url");

	} else if ($id_roz > 0 && $id_pu > 0 && $temat != '' && $miesiac > 0 && $godz > 0){
		//Popraw
		$Rozklad->popraw($id_roz,$temat,$miesiac,$godz);
		header("location: $url");

	} else if ($id_roz > 0 && $id_pu > 0 && $temat == NULL && $miesiac == NULL && $godz == NULL){
		//Usuń
		$Rozklad->usun($id_roz);
		header("location: $url");

	} else {		
		//Prezentacja
		
		if(isset($_POST['zbior'])){
			
			for($lp=1; $lp <= 10; $lp++){
				
				@$temat = htmlentities($_POST['temat_'.$lp], ENT_QUOTES);
				@$miesiac = htmlentities($_POST['miesiac_'.$lp], ENT_QUOTES);
				@$godz = htmlentities($_POST['godz_'.$lp], ENT_QUOTES);

				if($temat !=''){
					$Rozklad->dodaj($id_pu,$temat,$miesiac,$godz);
				}

			}
		}
		
		header("location: $url");
	}
