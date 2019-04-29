<?php
	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}
	
	$Connect = new Connect();
	$Nauczyciel = new Nauczyciel();

	$nauczyciele = $Nauczyciel->pokaz();
	$nr = 1;

	include_once("../init.gora.php");
?>

	<h3>Nauczyciele systemu</h3>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Lp</th>
				<th>Nazwisko</th>
				<th>Imię</th>
				<th>Login</th>
				<th>Konto</th>
				<th>Uprawnienie</th>
				<th>Edycja</th>
				<th>Kasowanie</th>
			</tr>
		</thead>
		<tbody>
		<?php
			foreach($nauczyciele as $wiersz) {

				//Konwersja danych z bazy - kolumna "akt"
				if($wiersz[4] == 1){
					$konto = 'Aktywne';
				} else {
					$konto = 'Nieaktywne';
				}

				//Konwersja danych z bazy - kolumna "rola"
				if($wiersz[5] == 0){
					$rola = 'Administrator';
				} else {
					$rola = 'Nauczyciel';
				}

				
					echo'<tr>';
					echo'<td>'.$nr.'</td>
					<td>'.$wiersz[1].'</td>
					<td>'.$wiersz[2].'</td>
					<td>'.$wiersz[3].'</td>
					<td>'.$konto.'</td>
					<td>'.$rola.'</td>
					<td><a href="v_add_edit_nauczyciel.php?id='.$wiersz[0].'">Popraw</a></td>
					<td><a href="../root/nauczyciel.php?id='.$wiersz[0].'">Usuń</a></td>';
					echo'</tr>';
				
				$nr++;
			}

		?>
		</tbody>
	</table>

<?php
	include_once("../init.dol.php");
?>