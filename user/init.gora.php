<?php
	include_once("status.php");
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>NOTES NAUCZYCIELA</title>
		<link href="../../css/bootstrap.css" rel="stylesheet">
		<link href="../../css/styl.css" rel="stylesheet">
	</head>
	<body>
		<div class="container">
			
			<header class="row">
				<div class="col-lg-2">
					<img src="../../image/01.png" alt="Notatnik" class="img-responsive visible-lg visible-md">
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
							<li class="active"><a href="../index.php">Home</a></li>
							<li ><a href="v_plan.php">Plan zajęć</a></li>
							<li><a href="#">Realizacja zajęć</a></li>
							<li><a href="#">Frekwencja uczniów</a></li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
       						 <li><a href="../../logout.php"><span class="glyphicon glyphicon-off"></span> Wyloguj</a></li>
    					</ul>
					</div>
				</nav>
			</div>

			<article>