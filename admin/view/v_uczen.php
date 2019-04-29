<?php
	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}
	
	$Connect = new Connect();
	$Grupy = new Grupy();

	$Grupy = $Grupy->duplikaty();
	
	if(isset($_POST['submit'])){
		
		$Uczen = new Uczen();
		$Uczen = $Uczen->pokazUczniowKlasy($_POST['id_kl']);
	} else if (isset($_GET['id_kl'])){
		$Uczen = new Uczen();
		$Uczen = $Uczen->pokazUczniowKlasy($_GET['id_kl']);
	}
	
	$nr = 0;

	include_once("../init.gora.php");
?>
	<h3>Uczniowie</h3>

	<form class="form-inline" action="#" method="post">
		<div class="form-group">
			<label for="klasa">Wybierz klasę:</label>
			<select name="id_kl" id="klasa">
				<option value=""></option>
				<?php
					foreach($Grupy as $wiersz) {
						echo'<option value="'.$wiersz[0].'">'.$wiersz[2].' '.$wiersz[3].'</option>';
					}
				?>
			</select>
		</div>
			<input type="submit" class="btn btn-default" name="submit" value="Pokaż">
	</form>

	<table class="table table-striped">
		<?php
			if(isset($Uczen)) {

			echo'<h4>Klasa '.$Uczen[0][3].' '.$Uczen[0][4].'</h4>';

			echo'
				<thead>
					<tr>
						<th>Lp</th>
						<th>Nazwisko</th>
						<th>Imię</th>
						<th>Grupa</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>';

				foreach($Uczen as $wiersz) {
					
					$lp = $nr + 1;
					
					echo'<tr>';
					echo'<td>'.$lp.'</td>
					<td>'.$wiersz[1].'</td>
					<td>'.$wiersz[2].'</td>
					<td>'.$wiersz[5].'</td>';
					
					echo'<td><a href="v_add_edit_uczen.php?id_ucz='.$wiersz[0].'">Popraw</a></td>
					<td><a href="../root/uczen.php?id_ucz='.$wiersz[0].'">Usuń</a></td>';
					echo'</tr>';
					
					$nr++;
				}

			} else {
				echo'<p>Brak danych</p>';
			}

		?>
			</tbody>
	</table>

<?php
	include_once("../init.dol.php");
?>