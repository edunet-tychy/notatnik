<?php
	/*
	** automatyczne ładowanie klas
	*/
	function __autoload($class){
		include_once("class/class.{$class}.php");	
	}

	$Auth = new Auth();
	$Template = new Template();

	$Template->setAlertTypes(array('success','warning','error'));

	session_start();

	if(isset($_POST['submit'])){

		$Template->setData('input_user', $_POST['login']);
		$Template->setData('input_pass', $_POST['pass']);

		if($_POST['login'] == '' || $_POST['pass'] == ''){
			$Template->setAlert('Uzupełnij wymagane pola', 'error');
			$Template->load("login.php");
		} else if ($Auth->validateLogin($Template->getData('input_user'),$Template->getData('input_pass')) == FALSE) {
			$Template->setAlert('Nieprawidłowy login lub hasło','error');
			$Template->load("login.php");
		} else {
			$_SESSION['login'] = $Template->getData('input_user');
			$_SESSION['loggedin'] = TRUE;

			$Auth->validateUprawnienia($Template->getData('input_user'),$Template->getData('input_pass'));

			if($Auth->getRola() == 0) {
				$_SESSION['admin'] = TRUE;

				$_SESSION['imie'] = $Auth->getImie();
				$_SESSION['nazwisko'] =	$Auth->getNazwisko();

				$Template->redirect('admin/index.php');
			} else if($Auth->getRola() == 1) {

				$_SESSION['imie'] = $Auth->getImie();
				$_SESSION['nazwisko'] =	$Auth->getNazwisko();

				$Template->redirect('user/');
			}

		}
	} else {
		$Template->load("login.php");
	}