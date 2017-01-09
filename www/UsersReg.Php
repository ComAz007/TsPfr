 <?php
require_once("Lib/Function.php");
session_start();

unset($_SESSION['$Message']);
If (isset($_GET['exit'])) {
header("location: /logout.php");
}

If ($_SESSION['Id_user']=='')
{
  header("location: /Auth.php");
}
  if (isset($_POST['But_Reg_User']))
  {
    ConnectDB();
  $Loginname=htmlspecialchars($_POST['Loginname']);
  $FIO=htmlspecialchars($_POST['FIO']);
  $FIO=iconv('windows-1251','utf-8', $FIO);
  $Pass=htmlspecialchars($_POST['PassText']);
  $R_Pass=htmlspecialchars($_POST['R_PassText']);
  $Status=htmlspecialchars($_POST['Status']);
  $Admin=htmlspecialchars($_POST['Admin']);
  $Id_otdel=htmlspecialchars($_POST['OtdelSelect']);
  //$Bad= false;
  //$_SESSION['TruReg']=0;
  
  unset($_SESSION['TruReg']);
  If ($Pass===$R_Pass)
  {
  //$Zapros=mysql_query("Insert into user values('','$Loginname','$Nikname','$Pass','$Email','')");
  RegUser($Loginname,$FIO,$Pass,$Status,$Admin,$Id_otdel);
  $_SESSION['$Message']='Пользователь успешно добавлен';
  $_SESSION['TruReg']=1;
  //header("Location: http://www.tspfr.ru/");
  
  }
  Else 
  {
  //$bad=True;
  $_SESSION['TruReg']=0;
  $_SESSION['$Message']='Пароли не совпадают';
  }
  }

  If ($_SESSION['TruReg']==1)
  {
      unset($_SESSION['TruReg']);
      $_SESSION['RegCompl']=1;
      header("location: UsersMain.php");
  //header("location: index.php");
  }
?>

<html>
   <head>
<script src="js/jquery.min.js"></script>
<script src="js/kickstart.js"></script> <!-- KICKSTART -->
<link rel="stylesheet" href="css/kickstart.css" media="all" />
        <link href="/../css/LoginForm.css" rel="stylesheet">
    </head>
<Body>
<Div class="grid">

<?Php

include 'menu.php';
Echo $_SESSION['$Message'];
echo '<div class="col_12 ">';
echo "<div class='col_3 visible center' style='height: 25px;'> <a href='UsersMain.php' title='Пользователи'>Пользователи</a></div> </div>";
  ?>
<div class="col_12 ">
<form class="form-container" method="post" action="UsersReg.Php">
 <div class="form-title"><h2>Регистрация</h2></div>
 <div class="form-title">Логин</div>
 <input class="form-field" type="text" name="Loginname" Placeholder="Логин для входа" required/><br />
  <div class="form-title">ФИО</div>
 <input class="form-field" type="text" name="FIO" Placeholder="Имя будет отображаться под сообщениями" required/><br />
 <div class="form-title">Пароль</div>
 <input class="form-field" type="password" name="PassText" Placeholder="Пароль для входа" required/><br />
  <div class="form-title">Подтверждение пароля</div>
 <input class="form-field" type="password" name="R_PassText" Placeholder="Подтверждение пароля для входа" required/><br />
 <div class="form-title">Статус</div>
 <input class="form-field" type="text" name="Status" value="0" required/><br />
 <div class="form-title">Администратор</div>
 <input class="form-field" type="text" name="Admin" value="0" required/><br />
 <?php
Echo '<div class="form-title"> Отдел пользователя: </div>';
Echo selected(SetSpisok("Select Id, Name_Otdel From Otdely"), 'OtdelSelect','',0);
Echo '</BR>';

 // Вот так берется выбранное значение из Селекта
 //echo $_POST['MainSel'];
?>
 <div class="submit-container">
 <input class="submit-button" type="submit" name="But_Reg_User" value="Зарегистрироваться" />
 </div>
 </form>
</div>
<?Php
 include 'ver.php';
      ?>
 </div>
</body>
 </html>
 
