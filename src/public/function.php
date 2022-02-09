<?
function print_rf($data){
		echo "<pre>";
			print_r($data);
		echo "</pre>";	
}

function _pE($password){
		$passHash=hash('sha512',$password);
		$passEncr=password_hash($password,PASSWORD_DEFAULT);
		return $passEncr;
}

function _pD($password,$hash){
	$passHash=hash('sha512',$password);
	return password_verify($password,$passHash);
}

function refreshPage($url=false){
	if(!$url)$url=$_SERVER['REQUEST_URI'];
	header("Location:".$url);	
}

function selectUser($id){
	if(!$id)return false;
	$user=FQuery("SELECT * FROM users where id=?",array($id));
	if(empty($user)){
			return false;
	}else{
		return $user;
	}
}