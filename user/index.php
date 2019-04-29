<?php
	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("../class/class.{$class}.php");	
	}

	$Auth = new Auth();
	$Template = new Template();
	$Connect = new Connect();
	$Nauczyciel = new Nauczyciel();
	$PrzedmiotyUser = new PrzedmiotyUser();
	$Data = new Data();

	session_start();

	$userId = $Nauczyciel->userId($_SESSION['nazwisko'], $_SESSION['imie'], $_SESSION['login']);
	$Przedmioty = $PrzedmiotyUser->pokazUser($userId[0][0]);

	if(($Auth->checkLoginStatus() == FALSE)){
		$Template->setAlert('Brak dostępu','error');
		$Template->redirect('../index.php');
		exit();
	}

	$nr = 0;
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>NOTES NAUCZYCIELA</title>
		<link href="../css/bootstrap.css" rel="stylesheet">
		<link href="../css/styl.css" rel="stylesheet">
	</head>
	<body>
		<div class="container">
			
			<header class="row">
				<div class="col-lg-2">
					<img src="../image/01.png" alt="Notatnik" class="img-responsive visible-lg visible-md">
				</div>
				<div class="col-lg-10 text-center">
					<h1 id="tytul">NOTATNIK NAUCZYCIELA</h1>
				</div>
			</header>

			<div class="row">
				<nav class="navbar navbar-default" role="navigation">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse">
							<span class="sr-only">Nawigacja</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>
					<div class="collapse navbar-collapse" id="collapse">
						<ul class="nav navbar-nav">
							<li class="active"><a href="index.php">Home</a></li>
							<li ><a href="view/v_plan.php">Plan zajęć</a></li>
							<li><a href="#">Realizacja zajęć</a></li>
							<li><a href="#">Frekwencja uczniów</a></li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
       						 <li><a href="../logout.php"><span class="glyphicon glyphicon-off"></span> Wyloguj</a></li>
    					</ul>
					</div>
				</nav>
			</div>

			<article>
				
				<?php
					echo '<h4>Nauczyciel: '.$_SESSION['imie'] . ' ' . $_SESSION['nazwisko'].'</h4>';
					echo '<hr>';
					echo '<p> Dzisiaj jest '. $Data->getDzienTyg() .', '. $Data->getAktData() .' rok</p>';
					echo '<hr>';
					echo '<h4>Nauczane przedmioty</h4>';

					if(isset($Przedmioty)) {

						echo'
						<table class="table table-striped">
						<thead>
							<tr>
								<th>Lp</th>
								<th>Przedmiot</th>
								<th>Klasa</th>
								<th>Grupa</th>
								<th>Lekcje</th>
								<th>Oceny</th>
								<th>Rozkład</th>
							</tr>
						</thead>
						<tbody>';

						foreach($Przedmioty as $wiersz) {
							
							$lp = $nr + 1;
							
							echo'<tr>';
							echo'<td>'.$lp.'</td>
							<td>'.$wiersz[2].' - '.$wiersz[3].'</td>
							<td>'.$wiersz[4].' '.$wiersz[5].'</td>
							<td>'.$wiersz[6].'</td>';
							
							echo'
							<td><a href="view/v_lekcje.php?id_pu='.$wiersz[7].'">Pokaż</a></td>
							<td><a href="view/v_oceny.php?id_pu='.$wiersz[7].'">Pokaż</a></td>
							<td><a href="view/v_rozklad.php?id_pu='.$wiersz[7].'">Pokaż</a></td>';
							echo'</tr>';
							
							$nr++;
						}

					} else {
						echo'<p>Brak danych</p>';
					}
				?>
						</tbody>
					</table>
			</article>

			<hr>
			<footer>
		      <p><small>&copy; GS 2015</small></p>
		    </footer>

		</div>
	<!-- javascript -->
	<script src="../js/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>

	</body>
</html>