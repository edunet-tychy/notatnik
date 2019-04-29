<?php
	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}
	
	$Connect = new Connect();
	$PrzedmiotyUser = new PrzedmiotyUser();

	$PrzedmiotyUser = $PrzedmiotyUser->pokaz();
	$nr = 1;

	include_once("../init.gora.php");
?>

	<h3>Nauczyciele</h3>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Lp</th>
				<th>Nazwisko</th>
				<th>Imię</th>
				<th>Przedmiot</th>
				<th>Klasa</th>
				<th>Grupa</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				if(isset($PrzedmiotyUser)) {
					foreach($PrzedmiotyUser as $wiersz) {

						echo'<tr>';
						echo'<td>'.$nr.'</td>
						<td>'.$wiersz[1].'</td>
						<td>'.$wiersz[2].'</td>
						<td>'.$wiersz[3].' - '.$wiersz[4].'</td>
						<td>'.$wiersz[5].' '.$wiersz[6].'</td>
						<td>'.$wiersz[7].'</td>
						<td><a href="v_add_edit_przed_nauczyciel.php?id='.$wiersz[0].'&id_naucz='.$wiersz[8].'&id_przed='.$wiersz[9].'&id_gr='.$wiersz[10].'">Popraw</a></td>
						<td><a href="../root/przed_nauczyciel.php?id='.$wiersz[0].'">Usuń</a></td>';
						echo '</tr>';
						
						$nr++;
					}
				} else {
					echo'<td colspan="3">Brak danych</td>';
				}

			?>
		</tbody>
	</table>

<?php
	include_once("../init.dol.php");
?>
