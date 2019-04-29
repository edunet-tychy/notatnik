<?php

	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}
	
	$Connect = new Connect();
	$Nauczyciel = new Nauczyciel();
	$Przedmioty = new Przedmioty();
	$Grupy = new Grupy();

	$Naucz = $Nauczyciel->pokaz();
	$Przed = $Przedmioty->pokaz();
	$Klasa = $Grupy->grupyKlasy();

	if(isset($_GET['id_gr'])){

		$id_gr = $_GET['id_gr'];
		$id = $_GET['id'];
		$id_przed = $_GET['id_przed'];
		$id_naucz = $_GET['id_naucz'];
		$dane = 'Edycja: nauczyciel - przedmiot';

	} else {
		$dane = 'Dodaj nauczyciela i przedmiot';
	}
	
	include_once("../init.gora.php");
?>

	<h3><?php echo $dane; ?></h3>
	<form class="form-horizontal" action="../root/przed_nauczyciel.php" method="post">
		<input type="hidden" name="id" value="<?php if(isset($id)) echo $id;?>">
		<div class="form-group">
			<label for="id_naucz" class="col-sm-4 control-label">Nauczyciel:</label>
			<div class="col-sm-8">
				<select name="id_naucz">
					<option value=""></option>
					<?php
						if(isset($id_naucz)){
						
							foreach($Naucz as $wiersz) {
									if($wiersz[5] == 1) {
										if($wiersz[0] == $id_naucz) {
											echo'<option value="'.$wiersz[0].'" selected>'.$wiersz[1].' '.$wiersz[2].'</option>';
										} else {
											echo'<option value="'.$wiersz[0].'">'.$wiersz[1].' '.$wiersz[2].'</option>';
										}
									}
								}
						} else {
							
							foreach($Naucz as $wiersz) {
								if($wiersz[5] == 1) {
									echo'<option value="'.$wiersz[0].'">'.$wiersz[1].' '.$wiersz[2].'</option>';
								}
							}
						}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="id_przed" class="col-sm-4 control-label">Przedmiot:</label>
			<div class="col-sm-8">
				<select name="id_przed">
					<option value=""></option>
					<?php
						if(isset($id_przed)){
						
						foreach($Przed as $wiersz) {

							if($wiersz[0] == $id_przed) {
								echo'<option value="'.$wiersz[0].'" selected>'.$wiersz[1].'</option>';
							} else {
								echo'<option value="'.$wiersz[0].'">'.$wiersz[1].'</option>';
							}
						}

						} else {
							foreach($Przed as $wiersz) {
								echo'<option value="'.$wiersz[0].'">'.$wiersz[1].'</option>';
							}
						}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="id_gr" class="col-sm-4 control-label">Klasa</label>
			<div class="col-sm-8">
			<?php
				if(isset($id_gr)){
					
					echo'<select name="id_gr">';
					foreach($Klasa as $wiersz) {

						if($wiersz[1] == $id_gr) {
							echo'<option value="'.$wiersz[1].'" selected>'.$wiersz[2].' '.$wiersz[3].' Gr. '.$wiersz[4].'</option>';
						} else {
							echo'<option value="'.$wiersz[1].'">'.$wiersz[2].' '.$wiersz[3].' Gr. '.$wiersz[4].'</option>';
						}
					}
					echo'</select>';

				} else {
					echo'<select name="id_gr">';
					echo'<option value=""></option>';
					foreach($Klasa as $wiersz) {
						echo'<option value="'.$wiersz[1].'">'.$wiersz[2].' '.$wiersz[3].' Gr. '.$wiersz[4].'</option>';
					}
					echo'</select>';

				}
			?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-8">
				<input type="submit" class="btn btn-default" name="submit" value="Zapisz">
			</div>
		</div>
	</form>

<?php
	include_once("../init.dol.php");
?>