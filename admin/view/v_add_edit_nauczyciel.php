<?php

	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../../class/class.{$class}.php");	
	}
	
	$Connect = new Connect();
	$Nauczyciel = new Nauczyciel();

	if(isset($_GET['id'])){

		$id = $_GET['id'];

		$dane = 'Edycja danych nauczyciela';
		$nauczyciele = $Nauczyciel->pokaz($id);

		foreach($nauczyciele as $wiersz) {
			
			$surname = $wiersz[1];
			$name = $wiersz[2];
			$login = $wiersz[3];
			$konto = $wiersz[4];
			$rola = $wiersz[5];

		}

	} else {
		$dane = 'Dodaj nauczyciela do systemu';
	}

	include_once("../init.gora.php");
?>

	<h3><?php echo $dane; ?></h3>
	<form class="form-horizontal" action="../root/nauczyciel.php" method="post">
		<input type="hidden" name="id" value="<?php if(isset($id)) echo $id;?>">
		<div class="form-group">
			<label for="name" class="col-sm-4 control-label">Imię:</label>
			<div class="col-sm-8">
				<input type="text" name="name" value="<?php if(isset($name)) echo $name;?>">
			</div>
		</div>
		<div class="form-group">
			<label for="surname" class="col-sm-4 control-label">Nazwisko:</label>
			<div class="col-sm-8">
				<input type="text" name="surname" value="<?php if(isset($surname)) echo $surname;?>">
			</div>
		</div>
		<div class="form-group">
			<label for="login" class="col-sm-4 control-label">Login:</label>
			<div class="col-sm-8">
				<input type="text" name="login" value="<?php if(isset($login)) echo $login;?>">
			</div>
		</div>
		<div class="form-group">
			<label for="pass" class="col-sm-4 control-label">Hasło:</label>
			<div class="col-sm-8">
				<input type="password" name="pass" value="">
			</div>
		</div>
		<div class="form-group">
			<label for="rola" class="col-sm-4 control-label">Rola:</label>
			<div class="col-sm-8">
				<select name="rola">
					<option value=""></option>
					<?php
						if(isset($rola) && $rola == 0){
							echo'<option value="0" selected>Administrator</option>';
							echo'<option value="1">Nauczyciel</option>';
						}else{
							echo'<option value="0">Administrator</option>';
							echo'<option value="1" selected>Nauczyciel</option>';
						}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="konto" class="col-sm-4 control-label">Konto:</label>
			<div class="col-sm-8">
				<select name="konto">
					<option value=""></option>
					<?php
						if(isset($konto) && $konto == 1){
							echo'<option value="1" selected>Aktywne</option>';
							echo'<option value="0">Nieaktywne</option>';
						}elseif (isset($konto) && $konto == 0){
							echo'<option value="1">Aktywne</option>';
							echo'<option value="0" selected>Nieaktywne</option>';
						} else {
							echo'<option value="1" selected>Aktywne</option>';
							echo'<option value="0">Nieaktywne</option>';					
						}
					?>				
				</select>
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