<?
session_start();

include 'function.php';

$DB['server']='198.38.82.92';
$DB['user']='mlar12_tondiraba_veeb';
$DB['password']='Tondiraba20';
$DB['DB']='mlar12_tondiraba_veeb';

include 'db.php';

if(!empty($_SESSION['error'])){
	$data['error']=$_SESSION['error'];
	unset($_SESSION['error']);
	unset($_SESSION['success']);
}elseif(!empty($_SESSION['success'])){
	$data['success']=$_SESSION['success'];
	unset($_SESSION['error']);
	unset($_SESSION['success']);
}
