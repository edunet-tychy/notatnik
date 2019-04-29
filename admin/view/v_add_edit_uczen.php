<?php

	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}
	
	$Connect = new Connect();
	$Uczen = new Uczen();
	$Grupy = new Grupy();


	if(isset($_GET['id_ucz'])){

		$id_ucz = $_GET['id_ucz'];

		$dane = 'Edycja danych ucznia';
		$Uczen = $Uczen->pokaz($id_gr=NULL,$id_ucz);
		$Klasa = $Grupy->grupyKlasy();

		foreach($Uczen as $wiersz) {
			
			$nazwisko = $wiersz[0];
			$imie = $wiersz[1];
			$id_gr = $wiersz[2];

		}

	} else {
		$dane = 'Dodaj ucznia';
		$Klasa = $Grupy->grupyKlasy();

	}
	
	include_once("../init.gora.php");
?>

	<h3><?php echo $dane; ?></h3>
	<form class="form-horizontal" action="../root/uczen.php" method="post">
		<input type="hidden" name="id_ucz" value="<?php if(isset($id_ucz)) echo $id_ucz;?>">
		<div class="form-group">
			<label for="nazwisko" class="col-sm-4 control-label">Nazwisko:</label>
			<div class="col-sm-8">
				<input type="text" name="nazwisko" value="<?php if(isset($nazwisko)) echo $nazwisko;?>">
			</div>
		</div>
		<div class="form-group">
			<label for="imie" class="col-sm-4 control-label">Imię:</label>
			<div class="col-sm-8">
				<input type="text" name="imie" value="<?php if(isset($imie)) echo $imie;?>">
			</div>
		</div>
		<div class="form-group">
			<label for="id_gr" class="col-sm-4 control-label">Klasa</label>
			<div class="col-sm-8">
			<?php
				if(isset($id_gr)){
					
					foreach($Klasa as $wiersz) {
					
						if($wiersz[1] == $id_gr) {
							$id_kl = $wiersz[0];
						}
					}

					echo'<input type="hidden" name="id_kl" value="'.$id_kl.'">';

					echo'<select name="id_gr">';
					foreach($Klasa as $wiersz) {
						
						$id_kl = $wiersz[0];

						if($wiersz[1] == $id_gr) {
							echo'<option value="'.$wiersz[1].'" selected>'.$wiersz[2].' '.$wiersz[3].' Gr. '.$wiersz[4].'</option>';
						} else {
							echo'<option value="'.$wiersz[1].'">'.$wiersz[2].' '.$wiersz[3].' Gr. '.$wiersz[4].'</option>';
						}
					}
					echo'</select>';

				} else {
					echo'<select name="id_gr">';
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