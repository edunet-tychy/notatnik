<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>NOTES NAUCZYCIELA</title>
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/styl.css" rel="stylesheet">
	</head>

	<body>
		<div class="container">

			<header class="row">
				<div class="col-sm-4">
					<img src="image/01.png" alt="Notatnik" class="img-responsive visible-lg visible-md">
				</div>
				<div class="col-sm-8">
					<h1 id="tytul">NOTATNIK NAUCZYCIELA</h1>
				</div>
			</header>
			<article>
				<h3 class="col-sm-offset-5 col-sm-7">Logowanie</h3>
				<form class="form-horizontal" action="" method="post">
					<?php
						$alerts = $this->getAlerts();
						if($alerts != ''){
							echo '<ul class="alerts col-sm-offset-5 col-sm-7">'. $alerts .'</ul>';
						}
					?>
					<div class="form-group">
						<label for="login" class="col-sm-5 control-label">Login:</label>
						<div class="col-sm-7">
							<input type="text" name="login" value="<?php echo $this->getData('input_user'); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="pass" class="col-sm-5 control-label">Hasło:</label>
						<div class="col-sm-7">
							<input type="password" name="pass" value="<?php echo $this->getData('input_pass'); ?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-5 col-sm-7">
							<input type="submit" class="btn btn-default" name="submit" value="Wyślij">
						</div>
					</div>

				</form>
			</article>

			<hr>
			<footer>
		      <p><small>&copy; GS 2015</small></p>
		    </footer>

			<!-- javascript -->
			<script src="js/jquery.min.js"></script>
			<script src="js/bootstrap.min.js"></script>
		</div>
	</body>	

</html>