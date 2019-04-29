<?php
	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}
	
	$Connect = new Connect();
	$Rozklad = new Rozklad();
	$PrzedmiotyUser = new PrzedmiotyUser();

	if(isset($_GET['id_pu'])){
		$Rozklad = $Rozklad->pokaz($_GET['id_pu']);
		$PrzedmiotyUser = $PrzedmiotyUser->pokazPrzedmiotUser($_GET['id_pu']);

		foreach($PrzedmiotyUser as $wiersz) {
			$przedmiot = $wiersz[2];
			$klasa = $wiersz[4];
			$sk = $wiersz[5];
		}
	}

	$nr = 1;

	include_once("../init.gora.php");
?>

	<h4>Rozkład materiału:</h4>
	<?php
		echo '<hr>
		<h5> '.$przedmiot. ' - ' .$klasa. ' ' .$sk. '</h5><hr>';
	?>
	<h5><a href="v_add_edit_rozklad.php?id_pu=<?php echo $_GET['id_pu'];?>">Dodaj materiał do rozkładu</a></h5>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Lp</th>
				<th>Temat</th>
				<th>Miesiąc</th>
				<th>Godz.</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				if(isset($Rozklad)) {
					foreach($Rozklad as $wiersz) {

						echo'<tr>';
						echo'<td>'.$nr.'</td>
						<td>'.$wiersz[1].'</td>
						<td>'.$wiersz[2].'</td>
						<td>'.$wiersz[3].'</td>
						<td><a href="v_add_edit_rozklad.php?id_roz='.$wiersz[0].'&id_pu='.$_GET['id_pu'].'">Popraw</a></td>
						<td><a href="../root/rozklad.php?id_roz='.$wiersz[0].'&id_pu='.$_GET['id_pu'].'">Usuń</a></td>';
						echo '</tr>';
						
						$nr++;
					}
				} else {
					echo'<td colspan="6">Brak danych</td>';
				}

			?>
		</tbody>
	</table>

<?php
	include_once("../init.dol.php");
?>