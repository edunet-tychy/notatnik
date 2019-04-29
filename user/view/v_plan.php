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

	include_once("../init.gora.php");
	
	$userId = $Nauczyciel->userId($_SESSION['nazwisko'], $_SESSION['imie'], $_SESSION['login']);
	$kto = $userId[0][0];

	$PlanTyg = $Plan->pokaz($kto);

?>
	<h4>Plan lekcji</h4><hr>
	<h5><a href="v_add_edit_plan.php">Dodaj/Edytuj - Plan zajęć</a></h5>
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
		<tbody>
			<?php
			$godz = array('1' => '07:10 - 07:55', '2' => '08:00 - 08:45','3' => '08:55 - 09:40',
				'4' => '09:50 - 10:35','5' => '10:45 - 11:30','6' => '11:40 - 12:25','7' => '12:40 - 13:25',
				'8' => '13:35 - 14:20','9' => '14:25 - 15:10','10' => '15:15 - 16:00');

				for($nr=1 ; $nr <= 10; $nr++){
					echo'<tr>';
						echo'<td>'.$nr.'</td>';
						echo'<td>'.$godz[$nr].'</td>';

						for($i = 1; $i <= 5; $i++)
						{

							echo'<td>';

								if(isset($PlanTyg )) {
									foreach($PlanTyg as $wiersz) {
											
										$grupa = $wiersz[2];
										$klasa = $wiersz[3];
										$skrot = $wiersz[4];
										$dzien = $wiersz[7];
										$godzina = $wiersz[8];

											if($nr == $dzien && $i == $godzina){
												echo $wiersz[3].' '.$wiersz[4].' Gr. '.$wiersz[2];
											}
									}
								}
	
							echo'</td>';							
						}
					echo'</tr>';
				}
			
			?>
		</tbody>
	</table>

<?php
	include_once("../init.dol.php");
?>