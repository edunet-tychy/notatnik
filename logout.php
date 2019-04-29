<?php

include('class/class.Template.php');
include('class/class.Auth.php');

$Template = new Template();
$Template->setAlertTypes(array('success','warning','error'));
$Auth = new Auth();

session_start();

$Auth->logout();

$Template->setAlert('Wylogowałeś się','success');
$Template->redirect('index.php');