<?php

	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}

	$Connect = new Connect();
	$Plan = new Plan();

	/*
	** htmlentities - funkcja konwerteruje specjalne znaki na symbole
	** ENT_QUOTES - cudzysłowy oraz apostrofy podlegają konwerterowaniu
	*/
	@$id_user =  htmlentities($_POST['id_user'], ENT_QUOTES);

	$dzien=0;
	$godz=0;


	//Miejsce przekierowania
	$url = '../view/v_plan.php';

	function dzien($poz){

		switch ($poz) {
			case 1:
				$dzien = 1;
			break;
		    case 2:
				$dzien = 2;
			break;
			case 3:
				$dzien = 3;
			break;
			case 4:
				$dzien = 4;
			break;
			case 5:
				$dzien = 5;
			break;
		}

		return $dzien;
	}

	for($i=1; $i<=50; $i++){
		
		$id_pl =  htmlentities($_POST['id_pl_'.$i], ENT_QUOTES);

		if (is_string($id_pl) && $id_pl != ''){
			
			$dane = explode("; ", $id_pl);
			$poz = $dane[0];

			if($poz == 'usun') {

				$id_planu = $dane[1];
				$Plan->usun($id_planu);

			} else if ($poz == 'popraw') {

				echo $id_planu = $dane[1];
				echo $id_grPop = $dane[2];

				$Plan->popraw($id_planu, $id_grPop);

			} else if ($poz >= 1 && $poz <= 5){

				$godz = 1;
				$dzien = dzien($poz);
				$id_gr = $dane[1];

			} else if ($poz >= 6 && $poz <= 10) {
				
				$godz = 2;
				$dzien = dzien($poz-5);
				$id_gr = $dane[1];

			} else if ($poz >= 11 && $poz <= 15) {
				
				$godz = 3;
				$dzien = dzien($poz-10);
				$id_gr = $dane[1];

			} else if ($poz >= 16 && $poz <= 20) {
				
				$godz = 4;
				$dzien = dzien($poz-15);
				$id_gr = $dane[1];

			} else if ($poz >= 21 && $poz <= 25) {
				
				$godz = 5;
				$dzien = dzien($poz-20);
				$id_gr = $dane[1];

			} else if ($poz >= 26 && $poz <= 30) {
				
				$godz = 6;
				$dzien = dzien($poz-25);
				$id_gr = $dane[1];

			} else if ($poz >= 31 && $poz <= 35) {
				
				$godz = 7;
				$dzien = dzien($poz-30);
				$id_gr = $dane[1];

			} else if ($poz >= 36 && $poz <= 40) {
				
				$godz = 8;
				$dzien = dzien($poz-35);
				$id_gr = $dane[1];

			} else if ($poz >= 41 && $poz <= 45) {
				
				$godz = 9;
				$dzien = dzien($poz-40);
				$id_gr = $dane[1];

			} else if ($poz >= 46 && $poz <= 50) {
				
				$godz = 10;
				$dzien = dzien($poz-45);
				$id_gr = $dane[1];

			}

			if(isset($id_gr)) {
				$Plan->dodaj($id_user,$id_gr,$godz,$dzien);
			}
		} 
	}

	header("location: $url");
?>