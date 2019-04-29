<?php

	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}
	
	$Connect = new Connect();
	$Przedmioty = new Przedmioty();

	if(isset($_GET['id_przed'])){

		$id_przed = $_GET['id_przed'];

		$dane = 'Edycja przedmiotu';
		$Przedmiot = $Przedmioty->pokaz($id_przed);

		foreach($Przedmiot as $wiersz) {
			$nazwa = $wiersz[0];
			$skrot = $wiersz[1];
		}

	} else {
		$dane = 'Dodaj przedmiot';
	}

	include_once("../init.gora.php");
?>

	<h3><?php echo $dane; ?></h3>
	<form class="form-horizontal" action="../root/przedmioty.php" method="post">
		<input type="hidden" name="id_przed" value="<?php if(isset($id_przed)) echo $id_przed;?>">
		<div class="form-group">
			<label for="nazwa" class="col-sm-4 control-label">Nazwa:</label>
			<div class="col-sm-8">
				<input type="text" name="nazwa" id="nazwa" value="<?php if(isset($nazwa)) echo $nazwa;?>">
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