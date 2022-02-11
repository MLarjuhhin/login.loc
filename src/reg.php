<?

include 'conn.php';

if($_POST){
    //login
    if(empty($_POST['login_user'])){
        $data['error'][]='Поле логин обязательное к заполнению';
    }else{
        if(strlen($_POST['login_user'])<3){
            $data['error'][]='Поле логин длинна минимум 3 символа';
        }
    }

    //pass
       if(empty($_POST['login_pass']) || empty($_POST['login_pass_confirm'])){
        $data['error'][]='Поле пароль обязательное к заполнению';
    }else{
        if(strlen($_POST['login_pass'])<3 || strlen($_POST['login_pass_confirm'])<3){
            $data['error'][]='Поле пароль длинна минимум 3 символа';
        }else{
            if($_POST['login_pass']!=$_POST['login_pass_confirm']){
                   $data['error'][]='Пароли должны быть одинаковые';
            }
        }
    }

    //phone
    if(empty($_POST['Phone'])){
        $data['error'][]='Поле телефон обязательное к заполнению';
    }else{
        if(!is_numeric($_POST['Phone'])){
             $data['error'][]='Поле телефон только цифры';
        }
    }

    //email
    if(empty($_POST['email'])){
        $data['error'][]='Поле email обязательное к заполнению';
    }else{
        if(!filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)){
             $data['error'][]='Поле email не валидый';
        }
    }
}
?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container-fluid">
    <?if(!empty($data['error'])){?>
        <div class="alert alert-danger">
            <?=showArray($data['error'])?>
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
                    <input type="text" class="form-control" id="InputEmail"  placeholder="Kasutajanimi"  value="<?=(isset($_POST['login_user'])?$_POST['login_user']:'')?>" name="login_user">
                </div>
                <div class="form-group">
                    <label for="InputPassword "><p class="font-weight-bold m-0">Parool</p></label>
                    <input type="password" class="form-control" id="InputPassword" placeholder="New Password" name="login_pass" >
                </div>
                <div class="form-group">
                    <label for="InputPasswordConfirm"><p class="font-weight-bold m-0">Parool Confirm</p></label>
                    <input type="password" class="form-control" id="InputPasswordConfirm" placeholder="Password confirm" name="login_pass_confirm" >
                </div>
                <div class="form-group">
                    <label for="Phone "><p class="font-weight-bold m-0">Phone</p></label>
                    <input type="text" class="form-control" id="Phone"  placeholder="Phone" value="<?=(isset($_POST['Phone'])?$_POST['Phone']:'')?>" name="Phone">
                </div>
                <div class="form-group">
                    <label for="email "><p class="font-weight-bold m-0">Email</p></label>
                    <input type="text" class="form-control" id="email"  placeholder="Email" value="<?=(isset($_POST['email'])?$_POST['email']:'')?>"   name="email">
                </div>

                    <input type="hidden" name="act" value="loginReg">
                    <button type="submit" class="btn btn-success" >Submit</button>


            </form>

        </div>

    </div>
</div>
</body>
</html>