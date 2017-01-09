<?php
require_once "Lib/Function.php";
?>

<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
<script src="js/jquery.min.js"></script>
<script src="js/kickstart.js"></script> <!-- KICKSTART -->
<link rel="stylesheet" href="css/kickstart.css" media="all" />
    </head>
    
    <body>
    <Div class="grid center" style='width: 300px;'>
        <?php
       // If ($_SESSION['Id_user']!=0 or $_SESSION['Id_user']!='')
        //{
            $id=$_GET['id'];
            $Zapros="SELECT Login, Password, FIO, Id_Otdel, otdely.name_Otdel FROM user, otdely WHERE (user.Id='$id') and (otdely.id=user.Id_Otdel) ";
            $result=SetSpisok($Zapros);
            $data = $result->fetch_row();
	Echo "<div class='col_12' >";
	Echo "	 <div class='col_12  center ' ><B> Парольная карточка СТП </BR> УПФР г. Азов</B>";
	Echo '		<div class="col_12  column center " >';
	Echo '			<div class="col_12  center " > <B>Пользователь:</B> '. $data['2'].'</BR> <B>Отдел:</B> '.$data['4'] .'</Div>';
	Echo '			<div class="col_6  center " ><B>Логин:</B></Div>';
	Echo '			<div class="col_6 left" >'.iconv('windows-1251','utf-8', $data['0']).'</Div>';
	Echo '			<div class="col_6 center " ><B>Пароль:</B></Div>';
	Echo '			<div class="col_6 left" >'.$data['1'].'</Div>';
	Echo '	</Div>';
	Echo '	</Div>';
	Echo '</Div>';
      //}
           ?>
    </Div>
    </body>
 </html>