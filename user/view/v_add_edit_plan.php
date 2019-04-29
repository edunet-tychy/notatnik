<?php
	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}
	
	$Connect = new Connect();
	$Plan = new Plan();
	$Nauczyciel = new Nauczyciel();
	$Grupy = new Grupy();

	$klasy = $Grupy->grupyKlasy();

	include_once("../init.gora.php");

	$userId = $Nauczyciel->userId($_SESSION['nazwisko'], $_SESSION['imie'], $_SESSION['login']);
	$kto = $userId[0][0];

	$PlanTyg = $Plan->pokaz($kto);

	$godz = array('1' => '07:10 - 07:55', '2' => '08:00 - 08:45','3' => '08:55 - 09:40',
		'4' => '09:50 - 10:35','5' => '10:45 - 11:30','6' => '11:40 - 12:25','7' => '12:40 - 13:25',
		'8' => '13:35 - 14:20','9' => '14:25 - 15:10','10' => '15:15 - 16:00');

	$lp=0;

	echo'<form class="form-horizontal tematy" action="../root/plan.php" method="post">
	<input type="hidden" name="id_user" value="' .$kto. '">
	<h4>Plan lekcji - Edycja
		<input type="submit" class="btn btn-default prawy" name="submit" value="Zapisz plan zajęć">
	</h4><hr>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>LP</th>
				<th>Godzina</th>
				<th>Poniedziałek</th>
				<th>Wtorek</th>
				<th>Środa</th>
				<th>Czwartek</th>
				<th>Piątek</th>
			</tr>
		</thead>
		<tbody>';


				for($nr=1 ; $nr <= 10; $nr++){
					echo'<tr>';
						echo'<td>'.$nr.'</td>';
						echo'<td>'.$godz[$nr].'</td>';

						for($i = 1; $i <= 5; $i++)
						{
						$lp++;

							echo'<td>';
								echo'<select name="id_pl_'.$lp.'" class="plan">';
								
								$wpis = 0;

									foreach($PlanTyg as $wiersz) {
										$ile = count($PlanTyg);
										$grupa = $wiersz[2];
										$klasa = $wiersz[3];
										$skrot = $wiersz[4];
										$id_pl = $wiersz[6]; 
										$dzien = $wiersz[7];
										$godzina = $wiersz[8];

										if($nr == $dzien && $i == $godzina){

											echo'<option value="'.$id_pl.'" selected>'.$klasa.' '.$skrot.' Gr. '.$grupa.'</option>';
											echo'<option value="usun; '.$id_pl.'">Usuń wpis</option>';
											echo'<option value="">...</option>';
											foreach($klasy as $wiersz) {
												echo'<option value="popraw; '.$id_pl.'; '.$wiersz[1].'">'.$wiersz[2].' '.$wiersz[3].' Gr. '.$wiersz[4].'</option>';
											}

											$wpis = 1;										
										}
									}

									if($wpis == 0) {
										echo'<option value="">...</option>';
										foreach($klasy as $wiersz) {
											echo'<option value="'.$lp.'; '.$wiersz[1].'">'.$wiersz[2].' '.$wiersz[3].' Gr. '.$wiersz[4].'</option>';
										}										
									}

									
								echo'</select>';

							echo'</td>';
						}
					echo'</tr>';					
				}

			echo'</form>';
			?>
		</tbody>
	</table>

<?php
	include_once("../init.dol.php");
?>