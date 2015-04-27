<?php 
session_start();
clearstatcache();

unset($_SESSION['idSelectPeriodistas']);
unset($_SESSION['idSelectPeriodistas2']);

if($_POST['periodistas']){
	$_SESSION['idSelectPeriodistas'] = $_POST['periodistas'];
}

if($_POST['periodistas2']){
	$_SESSION['idSelectPeriodistas2'] = $_POST['periodistas2'];
}



?>