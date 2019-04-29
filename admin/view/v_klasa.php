<?php
	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}
	
	$Connect = new Connect();
	$OddzialKlasowy = new OddzialKlasowy();

	$Klasy = $OddzialKlasowy->pokaz();
	$nr = 1;

	include_once("../init.gora.php");
?>

	<h3>Klasy</h3>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Lp</th>
				<th>Klasa</th>
				<th>Skrót</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				if(isset($Klasy)) {
					foreach($Klasy as $wiersz) {

						echo'<tr>';
						echo'<td>'.$nr.'</td>
						<td>'.$wiersz[1].'</td>
						<td>'.$wiersz[2].'</td>
						<td><a href="v_add_edit_klasa.php?id_kl='.$wiersz[0].'">Popraw</a></td>
						<td><a href="../root/klasa.php?id_kl='.$wiersz[0].'">Usuń</a></td>';
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