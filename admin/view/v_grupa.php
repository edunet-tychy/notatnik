<?php
	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}
	
	$Connect = new Connect();
	$Grupy = new Grupy();

	$Grupy = $Grupy->grupyKlasy();
	
	$lp = 1;

	include_once("../init.gora.php");
?>

	<h3>Grupy i klasy</h3>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Lp</th>
				<th>Klasa</th>
				<th>Grupa</th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				if(isset($Grupy)) {

					foreach($Grupy as $wiersz) {

						echo'<tr>';
						echo'<td>'.$lp.'</td>
						<td>'.$wiersz[2].' '.$wiersz[3].'</td>';
						
						if($wiersz[4] != NULL) {

							echo'<td>'.$wiersz[4].'</td>';
							$ile[] = $wiersz[0];
							$nr = 0;
							
							foreach ($ile as $poz) {
								if($poz == $wiersz[0]) $nr++;
							}

							if($nr == 1) {
								echo'<td><a href="v_add_edit_grupa.php?id_kl='.$wiersz[0].'">Dodaj</a></td>
								<td><a href="v_add_edit_grupa.php?id_gr='.$wiersz[1].'">Popraw</a></td>
								<td><a href="../rootgrupa.php?id_gr='.$wiersz[1].'">Usuń</a></td>';
							} else {
								echo'<td></td>
								<td><a href="v_add_edit_grupa.php?id_gr='.$wiersz[1].'">Popraw</a></td>
								<td><a href="../root/grupa.php?id_gr='.$wiersz[1].'">Usuń</a></td>';
							}

						} else {
							echo'<td>-</td>
							<td><a href="v_add_edit_grupa.php?id_kl='.$wiersz[0].'">Dodaj</a></td>
							<td>-</td>';
						}

						echo'</tr>';
						
						$lp++;
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