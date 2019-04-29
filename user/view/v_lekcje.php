<?php

	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}
	
	$Connect = new Connect();
	$Frekwencja = new Frekwencja();
	$PrzedmiotyUser = new PrzedmiotyUser();
	$Rozklad = new Rozklad();
	$Lekcje = new Lekcje();
	$Uczen = new Uczen();
	$Stan = new Stan();
	$Godziny = new Godziny();
	$Data = new Data();
	$Miesiace = new Miesiace();

	$dzien = $Data->getDzienTyg();
	$data = $Data->getAktData();
	$dataBaza = $Data->getAktDataBaza();

	if (isset($_POST['msc_roz'])){
		$miesiac = $_POST['msc'];
	} else if(isset($_GET['msc'])) {
		$miesiac = $_GET['msc'];
	} else {
		$miesiac = $Data->getAktMsc();
	}

	$Rozklad_materialu = $Rozklad->pokazMsc($_GET['id_pu'],$miesiac);

	if(isset($_GET['godz'])){
		$godz = $_GET['godz'];
	} else {
		$godz = $Godziny->aktualnaGodzina();		
	}

	if(isset($_POST['godz'])){
		$godz =$_POST['godz'];
	}

	$id_pu = $_GET['id_pu'];

	$PrzedmiotyUser = $PrzedmiotyUser->pokazPrzedmiotUser($_GET['id_pu']);

		foreach($PrzedmiotyUser as $wiersz) {
			$przedmiot = $wiersz[2];
			$klasa = $wiersz[4];
			$sk = $wiersz[5];
			$gr = $wiersz[6];
		}

	$Uczen = $Uczen->pokazUczenGrupa($_GET['id_pu']);

	$nr = 0;
	$lp = 0;

	include_once("../init.gora.php");
?>
	<h4>Dziennik lekcyjny</h4>
	<?php
		echo '<hr>
		<h5> '.$przedmiot. ' - ' .$klasa. ' ' .$sk. ' Gr. ' .$gr. '
		[ <strong>'. $dzien .', '. $data .' rok </strong>]</h5>
		<hr>
		<form class="form-horizontal tematy" action="v_lekcje.php?id_pu='.$id_pu.'&msc='.$miesiac.'" method="post">
			<h5>
				<select name="godz" class="lekcje">';

					for($i=0; $i<=10; $i++)
					{
						if($i == $godz){
							echo'<option value="'.$i.'" selected>'.$i.' / '. $Godziny->getGodziny($i).'</option>';
						} else {
							echo'<option value="'.$i.'">'.$i.' / '. $Godziny->getGodziny($i).'</option>';
						}
					}

			echo'</select>
			<input type="submit" class="btn btn-default" value="Pokaż zajęcia">
		</form>
 		<strong id="prawy">Wybrana lekcja: [ '.$godz.' ] / [ '. $Godziny->getGodziny($godz).' ]</strong></h5>';
	?>
		<form class="form-horizontal tematy" action="../root/lekcje.php" method="post">
		<input type="hidden" name="id_pu" value="<?php echo $id_pu; ?>">
		<input type="hidden" name="data" value="<?php echo $dataBaza; ?>">
		<input type="hidden" name="godz" value="<?php echo $godz; ?>">
		<input type="hidden" name="id_roz" value="<?php echo $id_roz; ?>">
		<input type="hidden" name="miesiac" value="<?php echo $miesiac; ?>">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Lp</th>
					<th>Nazwisko i imię</th>
					<th>Stan</th>
					<th></th>
					<th><input type="submit" class="btn btn-default" name="submit" value="Zapisz"></th>
				</tr>
			</thead>
			<tbody>
				<?php
					if(isset($Uczen)) {
						foreach($Uczen as $wiersz) {
							
							$nr++;

							$id_ucz = $wiersz[0];
							$nazwisko = $wiersz[1];
							$imie = $wiersz[2];

							$dane = $Frekwencja->pokazUczenGodzina($id_ucz, $id_pu, $dataBaza, $godz);
							$id_frek = $dane[$lp][0];
							$ozBaza = $dane[$lp][1];

							echo'<tr>
									<input type="hidden" name="id_ucz_'.$nr.'" value="'. $id_ucz .'">
									<td>'. $nr .'</td>
									<td>'. $nazwisko .' '. $imie .'</td>
									<td><select name="stan_'.$nr.'" class="miesiac">';
										for($i=0; $i<=4; $i++)
										{ 
											$oz= $Stan->getliczba($i);

											if($ozBaza == $oz) {
												echo'<option value="'.$oz.'" selected>'. $Stan->getStan($oz).'</option>';
											} else {
												echo'<option value="'.$oz.'">'. $Stan->getStan($oz).'</option>';											
											}
										}

								echo'</select></td>
									<input type="hidden" name="id_frek_'.$nr.'" value="'.$id_frek .'">
									<td>'.$dane[$lp][1].'</td>
									<td></td>
								</tr>';
							$lp++;
						}						
					} else {
						echo'<tr><td colspan="5">Brak danych</td></tr>';
					}
				?>
			</tbody>
		</table>
		<input type="hidden" name="nr" value="<?php echo $nr; ?>">
		<?php
		
			$Lekcja = $Lekcje->pokazLekcja($id_pu,$dataBaza,$godz);
			$Wpis = $Rozklad->pokazLekcja($Lekcja[0][1]);

			if($Lekcje->oblicz($id_pu) > 0 && $Wpis[0][1] != '') {
				echo'<h5>
				Bieżących wpisów: <strong>' . $Lekcje->oblicz($id_pu) . '</strong>;
				Temat zajęć: <strong>' . $Wpis[0][1]  .'</strong>
				</h5><hr>';
			} else if($Lekcje->oblicz($id_pu) > 0 && $Wpis[0][1] == '') {
				echo'<h5>
				Bieżących wpisów: <strong>' . $Lekcje->oblicz($id_pu) . '</strong>;
				Temat zajęć: <strong>Brak tematu zajęć</strong>
				</h5><hr>';
			} else {
				echo'<h5>
				Bieżących wpisów: <strong> 0 </strong>;
				Temat zajęć: <strong>Brak tematu zajęć</strong>
				</h5><hr>'; 
			}

		?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Rozkład materiału</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<input type="hidden" name="id_lek" value="<?php echo $Lekcja[0][0]; ?>">
						<select name="id_roz" class="zajecia">
							<option value="">...</option>
						<?php
							if(isset($Uczen)) {

								if(isset($Rozklad_materialu)) {
									foreach($Rozklad_materialu as $wiersz) {
										if($Lekcja[0][1] == $wiersz[0]){
											echo'<option value="'.$wiersz[0].'" selected>'.$wiersz[1].'</option>';
										} else {
											echo'<option value="'.$wiersz[0].'">'.$wiersz[1].'</option>';										
										}
									}
								}

							}
						?>
						</select>
					</td>
		</form>
					<td>
						<?php
							echo'<form class="form-horizontal tematy" action="v_lekcje.php?id_pu='.$id_pu.'&godz='.$godz.'" method="post">
								<select name="msc" class="miesiac">';
									
										for($nr=1; $nr <= 12; $nr++){
											if($nr == $miesiac){
												echo '<option value="'.$nr.'" selected>'.$Miesiace->getMsc($nr).'</option>';
											} else {
												echo '<option value="'.$nr.'" >'.$Miesiace->getMsc($nr).'</option>';										
											}
										}
									
							echo'</select>
								<input type="submit" class="btn btn-default" name="msc_roz" value="Wybierz miesiąc">
							</form>';
						?>
					</td>
				</tr>
			</tbody>
		</table>

		

<?php
	include_once("../init.dol.php");
?>
