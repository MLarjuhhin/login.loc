<?


include 'conn.php';

if($_POST){
	if(!empty(trim($_POST['login_user'])) && !empty(trim($_POST['login_pass']))){
		if($_POST['act']=='loginReg'){
			$psw=md5($_POST['login_pass']);
			$user=FQuery("SELECT * FROM users where user=? and password=?",array(quote($_POST['login_user']),quote($psw)));
			if(!$user){
				if(isset($_POST['register'])){
					$insert=array(
					'user'=>$_POST['login_user'],
					'password'=>$psw,
					'date_create'=>date("Y-m-d H:i"),
					);
					if(Insert('users',$insert)){

						$id=getInsertID();
						$_SESSION['user_id']=$id;

					$_SESSION['success']='User added';
					refreshPage();
					}
				}else{
					$data['error']='User/Password not valid';
				}

			}else{
				$_SESSION['user_id']=$user['id'];
				refreshPage();
			}
		}elseif($_POST['act']=='update'){
			if(Update('users',array('user'=>$_POST['login_user'])," where id=".$_SESSION['user_id'])){
				$_SESSION['success']='User Updated';
			}else{
				$_SESSION['error']='User Update ERROR';
			}
			refreshPage();
		}
	}else{
		$data['error']='user or password is empty';

	}

}

if(isset($_GET['act'])){
	if($_GET['act']=='logout'){
		session_destroy();
		refreshPage('/');
	}
}
if(isset($_SESSION['user_id'])){
	$user=selectUser($_SESSION['user_id']);
}

print_rf($user);
print_rf($_POST);
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<a href="?act=logout" class="btn btn-danger">destroy</a>

<div class="container-fluid">

	<?if(!empty($data['error'])){?>
		<div class="alert alert-danger">
			<?=$data['error']?>
		</div>
	<?}?>
	<?if(!empty($data['success'])){?>
		<div class="alert alert-success">
			<?=$data['success']?>
		</div>
		<?}?>

   <div class="d-flex align-items-center justify-content-center mt-5" >
        <div class="mt-5 pt-5">


           <form method="post" >
              <div class="form-group">
                <label for="InputEmail "><p class="font-weight-bold m-0">Kasutajanimi</p></label>
                <input type="text" class="form-control" id="InputEmail"  placeholder="Kasutajanimi"  value="<?=empty($user)?'':$user['user']?>" name="login_user">
              </div>
              <div class="form-group">
                <label for="InputPassword "><p class="font-weight-bold m-0">Parool</p></label>
                <input type="password" class="form-control" id="InputPassword" placeholder="<?=empty($user)?'Password':'New Password'?>" name="login_pass" >
              </div>
			<? if(!$user){?>
			  <div class="form-check">
			    <input type="checkbox" class="form-check-input" id="register" name="register" >
                <label for="register " class="form-check-label">Register?</label>
              </div>
			  <input type="hidden" name="act" value="loginReg">
			   <button type="submit" class="btn btn-success" >Submit</button>
			<?}else{?>
				<input type="hidden" name="act" value="update">
			 <button type="submit" class="btn btn-warning" >Update</button>
		<?}?>

            </form>

        </div>

      </div>
</div>
</html>
