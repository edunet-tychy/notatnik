<?php

	include_once("../../class/class.auth.php");
	include_once("../../class/class.template.php");	

	$Auth = new Auth();
	$Template = new Template();

	session_start();

	if(($Auth->checkLoginStatus() == FALSE)){
		$Template->setAlert('Brak dostępu','error');
		$Template->redirect('../../index.php');
		exit();
	}