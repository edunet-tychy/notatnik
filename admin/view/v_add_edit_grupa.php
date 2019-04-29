<?php

	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}
	
	$Connect = new Connect();
	$Grupy = new Grupy();

	if(isset($_GET['id_gr'])){

		$id_gr = $_GET['id_gr'];

		$dane = 'Edycja danych grupy';
		$Grupa = $Grupy->grupyKlasy($id_gr);

		foreach($Grupa as $wiersz) {
			
			$id_kl = $wiersz[0];
			$klasa = $wiersz[1];
			$skrot = $wiersz[2];
			$grupa = $wiersz[3];

		}

	} else {
		$dane = 'Dodaj grupę';
		$Grupy = $Grupy->duplikaty();
		//$Grupy = $Grupy->grupyKlasy();

		if(isset($_GET['id_kl'])) {
			$gr = $_GET['id_kl'];
		};
	}

	include_once("../init.gora.php");
?>

	<h3><?php echo $dane; ?></h3>
	<form class="form-horizontal" action="../root/grupa.php" method="post">
		<input type="hidden" name="id_gr" value="<?php if(isset($id_gr)) echo $id_gr;?>">

		<?php

			if(isset($klasa)) {
				echo'<input type="hidden" name="id_kl" value="'. $id_kl .'">

				<div class="form-group">
					<label for="klasa" class="col-sm-4 control-label">Klasa:</label>
					<div class="col-sm-8">
						<input type="text" name="klasa" value="'. $klasa .' '. $skrot .'" disabled>
					</div>
				</div>
				<div class="form-group">
					<label for="grupa" class="col-sm-4 control-label">Grupa:</label>
					<div class="col-sm-8">
						<input type="text" name="grupa" value="'. $grupa .'">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<input type="submit" class="btn btn-default" name="submit" value="Zapisz">
					</div>
				</div>';
			} else {
				if($Grupy != NULL) {
					echo'
					<div class="form-group">
					<label for="id_gr" class="col-sm-4 control-label">Klasa</label>
						<div class="col-sm-8">
						<select name="id_kl">';

						foreach($Grupy as $wiersz) {
							if($gr == $wiersz[0]) {
								echo'<option value="'.$wiersz[0].'" selected>'.$wiersz[2].' '.$wiersz[3].'</option>';
							} else {
								echo'<option value="'.$wiersz[0].'">'.$wiersz[2].' '.$wiersz[3].'</option>';
							}	  
						}

						echo'</select>
						</div>
					</div>
					<div class="form-group">
						<label for="grupa" class="col-sm-4 control-label">Grupa:</label>
						<div class="col-sm-8">
							<input type="text" name="grupa" value="">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
							<input type="submit" class="btn btn-default" name="submit" value="Zapisz">
						</div>
					</div>';					
				} else {
					echo'<p>Brak danych</p>';
				}
			}

		?>
		
	</form>
<?php
	include_once("../init.dol.php");
?>