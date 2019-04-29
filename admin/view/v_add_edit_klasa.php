<?php

	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}
	
	$Connect = new Connect();
	$OddzialKlasowy = new OddzialKlasowy();

	if(isset($_GET['id_kl'])){

		$id_kl = $_GET['id_kl'];

		$dane = 'Edycja danych klasy';
		$Klasy = $OddzialKlasowy->pokaz($id_kl);

		foreach($Klasy as $wiersz) {
			
			$kl = $wiersz[0];
			$skrot = $wiersz[1];

		}

	} else {
		$dane = 'Dodaj klasę';
	}

	include_once("../init.gora.php");
?>

	<h3><?php echo $dane; ?></h3>
	<form class="form-horizontal" action="../root/klasa.php" method="post">
		<input type="hidden" name="id_kl" value="<?php if(isset($id_kl)) echo $id_kl;?>">
		<div class="form-group">
			<label for="kl" class="col-sm-4 control-label">Klasa:</label>
			<div class="col-sm-8">
				<input type="text" name="kl" value="<?php if(isset($kl)) echo $kl;?>">
			</div>
		</div>
		<div class="form-group">
			<label for="skrot" class="col-sm-4 control-label">skrot:</label>
			<div class="col-sm-8">
				<input type="text" name="skrot" value="<?php if(isset($skrot)) echo $skrot;?>">
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