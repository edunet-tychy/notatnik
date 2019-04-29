<?php

	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}

	$Connect = new Connect();
	$Frekwencja = new Frekwencja();
	$Lekcje = new Lekcje();

	/*
	** htmlentities - funkcja konwerteruje specjalne znaki na symbole
	** ENT_QUOTES - cudzysłowy oraz apostrofy podlegają konwerterowaniu
	*/
	@$nr = htmlentities($_POST['nr'], ENT_QUOTES);
	@$id_pu =  htmlentities($_POST['id_pu'], ENT_QUOTES);
	@$id_roz =  htmlentities($_POST['id_roz'], ENT_QUOTES);
	@$id_lek =  htmlentities($_POST['id_lek'], ENT_QUOTES);
	@$data = htmlentities($_POST['data'], ENT_QUOTES);
	@$godz = htmlentities($_POST['godz'], ENT_QUOTES);
	@$miesiac = htmlentities($_POST['miesiac'], ENT_QUOTES);

	//Miejsce przekierowania
	$url = '../view/v_lekcje.php?id_pu='.$id_pu.'&godz='.$godz;

	for($i = 1; $i <= $nr; $i++)
	{
		$id_ucz =  htmlentities($_POST['id_ucz_'.$i], ENT_QUOTES);
		$stan = htmlentities($_POST['stan_'.$i], ENT_QUOTES);
		$id_frek =  htmlentities($_POST['id_frek_'.$i], ENT_QUOTES);

		if(isset($id_frek) && $id_frek > 0){
			$Frekwencja->popraw($id_frek,$id_pu,$data,$godz,$stan);
		} else {
			$Frekwencja->dodaj($id_ucz,$id_pu,$data,$godz,$stan);		
		}
	}

	if(isset($id_roz)) {
		$Lekcje->dodaj($id_pu,$id_roz,$data,$godz);
	}

	if(isset($id_lek) && isset($id_roz)) {
		$Lekcje->popraw($id_lek,$id_pu,$id_roz,$data,$godz);
	}

	if(isset($miesiac)) {
		$url = '../view/v_lekcje.php?id_pu='.$id_pu.'&godz='.$godz.'&msc='.$miesiac;
	}

	header("location: $url");
?>