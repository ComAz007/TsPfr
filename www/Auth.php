<?Php
header("Content-Type:text/html;charset=UTF-8");
session_start();
require_once "Lib/Function.php";
$login=$_POST['Loginname'];
$pass=$_POST['PassText'];
//unset($_SESSION['err_autrh']);
If (chekUser($login, $pass))
{
$_SESSION['login']=$Login;
$_SESSION['pass']=$pass;
unset($_SESSION['err_autrh']);
header("location: index.php");
}
else{
$_SESSION['err_autrh']=1;

}
//header("Location: ".$_SERVER['HTTP_REFERER']);


?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Служба поддержки пользователей УПФР в г. Азове</title>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
<script src="js/jquery.min.js"></script>
<script src="js/kickstart.js"></script> <!-- KICKSTART -->
<link rel="stylesheet" href="css/kickstart.css" media="all" />
<link rel="stylesheet" type="text/css" href="css/main_style.css" />
<link rel="stylesheet" type="text/css" href="css/rezinka.css" />

</head>
<body>
 
    <Div class="grid" >
        <div class="col_12 visible center " >
            <h4>Техническая поддержка пользователя</h4>
        </div>
            <div class="col_12 center"> 
                    <?Php
                    If ($_SESSION['err_autrh']==1 and ($login!='' or $pass!=''))
                    {
                        Echo("<span style='color: red;'>Не верный Логин/Пароль </span>");
                        unset($_SESSION['err_autrh']);
                    }
                    ?>
                    
                <form id="Login"  method="post" action="Auth.php">
                    
                    <div><h5>Авторизация</h5></div>
                    <div  class="col_12 center" style="font-size:22px; color: Red;  text-align:center;">Внимание!!! ПОЛЬЗОВАТЕЛЬ программа подверглась сильной переаботке, с целью исключения не доразумений ОБРАЩАЕМСЯ к разработчику ОСОБЕННО в случае направления/получения ОСИД/ЗСИД и т.д. т.е. запросов VIP NET  </div>
                        <input id="text2" type="text" name="Loginname" placeholder="Введите Логин" /><br /> <br />
                        <input id="text2" type="password" name="PassText" placeholder="Введите Пароль" /><br />
                        </br>
                        <button class="Medium" name="Sends"> <i class="fa fa-sign-in"></i> Авторизоваться</button>
                </form>
            </Div>
    
   <!--<div style="clear:both;"></div>--> 
    <div class="col_12 visible column center"> 
        <?PHP
        include 'ver.php';
        ?>
    </div>

</div>    
</body>
</html>