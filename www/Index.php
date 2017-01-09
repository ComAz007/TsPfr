<?php

header("Content-Type:text/html;charset=UTF-8");
define ('DIRSEP', DIRECTORY_SEPARATOR);

require_once("Lib/Function.php");

require_once 'Config.php';

include 'Classes/ald.php';

session_start();

If (isset($_GET['option']))
{
$class=  trim(htmlspecialchars(strip_tags($_GET['option'])));    
}
else 
{
$class='viewJurTS'; // Set default class 
}


if (file_exists("classes/".$class.".php"))
{
    include_once ("classes/".$class.".php");
    if (class_exists($class)){
        $obj=new $class;
    }
    else {
        exit("<p>Внутреняя ошибка приложения</p>");
    }
}
 else {
    exit("<p>Не верный адрес</p>");
}


?>