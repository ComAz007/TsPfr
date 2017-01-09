<?php

session_start();
require_once("Lib/Function.php");

If (isset($_GET['exit'])) {
header("location: /logout.php");
}

//If ($_SESSION['Id_user']=='')
//{
//  header("location: /Auth.php");
//}
?>


<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Служба поддержки пользователей УПФР в г. Азове</title>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
<!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css">-->
<script src="js/jquery.min.js"></script>
<script src="js/kickstart.js"></script> <!-- KICKSTART -->
<link rel="stylesheet" href="css/kickstart.css" media="all" />

</head>
<body>

    
<Div class="grid">

<?Php
 include 'menu.php';
  ?>

 <div class="col_12" >
     <?php
     echo "<div class='col_12'>";
               // Echo ('<div class="col_3 visible center" style="height: 25px;"> <a href="/Index.php">Главная</a>  </div> ');
                echo "<div class='col_3 visible center' style='height: 25px;'> <a href='UsersReg.php' title='Добавить Пользователя'>Добавить Пользователя</a></div>";
                If ($_SESSION['RegCompl']==1) {
                Echo '<div class="col_3 visible center" style="height: 25px; color: red;">'.$_SESSION['$Message'].'</div>';
                unset($_SESSION['RegCompl']);
                }
     echo "</div>";
     
 echo TableUsers(); 

 include 'ver.php';?>

</div>
<?php

//If ($_SESSION['Id_user']<>'') 
//    {
//    
    
//    }
//else{
//     header("location: /Auth.php");
//    }
    ?>
</div>
</body>
</html>