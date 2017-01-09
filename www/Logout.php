<?Php
    //require_once "Lib/Function.php";
    session_start();
    unset ($_SESSION['login']);
    unset ($_SESSION['pass']);
    unset ($_SESSION['Id_user']);
    unset ($_SESSION['FIO']);
    unset ($_SESSION['Status']);
    unset ($_SESSION['Admin']);
    unset ($_SESSION['Page']);
    unset ($_GET['page']);
    unset($_SESSION['err_autrh']);
    header("Location: ".$_SERVER['HTTP_REFERER']);
    
 ?>