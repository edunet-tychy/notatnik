<?php

	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}

	$Connect = new Connect();
	$Oceny = new Oceny();

	/*
	** htmlentities - funkcja konwerteruje specjalne znaki na symbole
	** ENT_QUOTES - cudzysłowy oraz apostrofy podlegają konwerterowaniu
	*/
	@$id_pu =  htmlentities($_POST['id_pu'], ENT_QUOTES);
	@$data =  htmlentities($_POST['data'], ENT_QUOTES);
	@$ile =  htmlentities($_POST['ile'], ENT_QUOTES);
	@$id_oc =  htmlentities($_POST['id_oc'], ENT_QUOTES);

	if(isset($_GET['id_pu'])){
		echo $id_pu = $_GET['id_pu'];
	}

	if(isset($_GET['id_oc'])){
		echo $id_oc = $_GET['id_oc'];
	}	

	//Miejsce przekierowania
	$url = '../view/v_oceny.php?id_pu='.$id_pu;

	for($i = 1; $i <= $ile; $i++){

		@$id_ucz = htmlentities($_POST['id_ucz_'.$i], ENT_QUOTES);
		@$ocena = htmlentities($_POST['propOcena_'.$i], ENT_QUOTES);

		if($id_oc == NULL && $id_pu > 0 && $ocena != '' && $data != '' && $id_ucz > 0){

			$Oceny->dodaj($id_pu,$ocena,$data,$id_ucz);

		}	 
	}


 	if ($id_oc > 0 && $id_pu > 0) {
			$Oceny->usun($id_oc);
	}

	header("location: $url");
?>