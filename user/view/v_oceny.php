<?php
	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}
	
	$Connect = new Connect();
	$Uczen = new Uczen();
	$Oceny = new Oceny();
	$Data = new Data();

	$Uczen = $Uczen->pokazUczenGrupa($_GET['id_pu']);
	$dataBaza = $Data->getAktDataBaza();


	$id_pu = $_GET['id_pu'];
	$nr = 0;

	include_once("../init.gora.php");

	echo'<form class="form-horizontal tematy" action="../root/oceny.php" method="post">
		<input type="hidden" name="data" value="'. $dataBaza .'">
		<input type="hidden" name="id_pu" value="'. $id_pu .'">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Lp</th>
					<th>Nazwisko i imię</th>
					<th>Oceny</th>
					<th>Dodaj ocenę</th>
					<th><input type="submit" class="btn btn-default" name="submit" value="Zapisz"></th>

				</tr>
			</thead>
			<tbody>
				<tr>';

					if(isset($Uczen)) {
						foreach($Uczen as $wiersz) {

						
						echo'<tr>';	
								$nr++;

								$id_ucz = $wiersz[0];
								$nazwisko = $wiersz[1];
								$imie = $wiersz[2];

								echo'<input type="hidden" name="id_ucz_'.$nr.'" value="'. $id_ucz .'">';

								echo'<td>'.$nr.'</td>';
								echo'<td>'.$nazwisko.' '.$imie.'</td>';

								$OcenyBaza = $Oceny->pokaz($id_pu, $id_ucz);

								echo'<td>';

								if(isset($OcenyBaza))
									foreach($OcenyBaza as $wiersz){
										if($wiersz[3] == $id_ucz)
										echo'<a href="../root/oceny.php?id_oc='.$wiersz[0].'&id_pu='.$id_pu.'" title="Usuń">'.$wiersz[1].'</a> ';
									}

								echo'</td>';

								echo'<td><select name="propOcena_'.$nr.'" class="oceny">';

								echo'<option value="">...</option>';

								for($i = 0; $i <= 20; $i++){

									$propOcena = $Oceny->getOceny($i);
									echo'<option value="'.$propOcena.'">'.$propOcena.'</option>';
								}

								echo'</select></td>';

								echo'<td></td>';


						echo'</tr>';
						}
					}
			
			echo'</tbody>
		</table>
		<input type="hidden" name="ile" value="'. $nr .'">
		</form>';

	include_once("../init.dol.php");
?>