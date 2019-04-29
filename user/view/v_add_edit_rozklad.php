<?php

	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}
	
	$Connect = new Connect();
	$Rozklad = new Rozklad();
	$Miesiace = new Miesiace();
	$PrzedmiotyUser = new PrzedmiotyUser();

	$PrzedmiotyUser = $PrzedmiotyUser->pokazPrzedmiotUser($_GET['id_pu']);

	foreach($PrzedmiotyUser as $wiersz) {
		$przedmiot = $wiersz[2];
		$klasa = $wiersz[4];
		$sk = $wiersz[5];
	}

	if(isset($_GET['id_roz'])){
		$id_roz = $_GET['id_roz'];
		$dane = 'Edycja danych';
		$Rozklad = $Rozklad->pokazLekcja($id_roz);

		foreach($Rozklad as $wiersz) {
			
			$id_pu = $wiersz[0];
			$temat = $wiersz[1];
			$miesiac = $wiersz[2];
			$godz = $wiersz[3];

		}

	} else {
		$id_pu = $_GET['id_pu'];
		$dane = 'Dodaj materiał do rozkładu';

	}

	include_once("../init.gora.php");

	echo'<h4>'.$dane.'</h4>
		<hr>
		<h5> '.$przedmiot. ' - ' .$klasa. ' ' .$sk. '</h5>
		<hr>';


		if(isset($_GET['id_roz'])){

			echo'<form class="form-horizontal tematy" action="../root/rozklad.php" method="post">';
			echo'<input type="hidden" name="id_pu" value="' .$id_pu. '">';
			echo'<input type="hidden" name="id_roz" value="' .$id_roz. '">';
			echo'<div class="form-group">';
				echo'<label for="temat" class="col-sm-4 control-label">Temat:</label>';
				echo'<div class="col-sm-8">';
					echo'<input type="text" name="temat" value="' .$temat. '" class="temat">';
				echo'</div>';
				echo'</div>';
			echo'<div class="form-group">';
				echo'<label for="miesiac" class="col-sm-4 control-label">Miesiąc:</label>';
				echo'<div class="col-sm-8">';
					echo'<select name="miesiac">';
								for($nr=1; $nr <= 12; $nr++){
									if($nr == $miesiac) {
										echo '<option value="'.$nr.'" selected>'.$Miesiace->getMsc($nr).'</option>';
									} else {
										echo '<option value="'.$nr.'" >'.$Miesiace->getMsc($nr).'</option>';								
									}
								}
					echo'</select>';
				echo'</div>';
			echo'</div>';
			echo'<div class="form-group">';
				echo'<label for="godz" class="col-sm-4 control-label">Godzin:</label>';
				echo'<div class="col-sm-8">';
					echo'<select name="godz">';
								for($nr=1; $nr <= 6; $nr++){
									if($nr == $godz) {
										echo '<option value="'.$nr.'" selected>'.$nr.'</option>';
									} else {
										echo '<option value="'.$nr.'" >'.$nr.'</option>';								
									}
								}
					echo'</select>';
				echo'</div>';
			echo'</div>';
			echo'<div class="form-group">';
				echo'<div class="col-sm-offset-4 col-sm-8">';
					echo'<input type="submit" class="btn btn-default" name="submit" value="Zapisz">';
				echo'</div>';
			echo'</div>';
			echo'</form>';
		} else {
			echo'<form class="form-horizontal tematy" action="../root/rozklad.php" method="post">
				<input type="hidden" name="id_pu" value="' .$id_pu. '">
				<input type="hidden" name="zbior" value="1">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Nr</th>
							<th>Temat</th>
							<th>Godz.</th>
							<th>Miesiąc</th>
							<th><input type="submit" class="btn btn-default" name="submit" value="Zapisz"></th>
						</tr>
					</thead>
					<tbody>';
						for($lp=1; $lp <= 10; $lp++){
							echo'<tr>
								<td>'.$lp.'</td>
								<td><input type="text" name="temat_'.$lp.'" class="temat"></td>
								<td>
									<select name="godz_'.$lp.'" class="godz">';
									for($nr=1; $nr <= 6; $nr++){
										echo '<option value="'.$nr.'" >'.$nr.'</option>';
									}
								echo'</select>
								</td>
								<td>
									<select name="miesiac_'.$lp.'" class="miesiac">';
									for($nr=1; $nr <= 12; $nr++){
										echo '<option value="'.$nr.'" >'.$Miesiace->getMsc($nr).'</option>';
									}
								echo'</select>
								</td>
								<td></td>
							</tr>';
						}
				echo'</tbody>
				</table>';
			echo'</form>';
		}


	include_once("../init.dol.php");
?>