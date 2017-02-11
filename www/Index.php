<?php

header("Content-Type:text/html;charset=UTF-8");
define ('DIRSEP', DIRECTORY_SEPARATOR);

require_once("Lib/Function.php");

require_once 'Core/Config.php';

include 'Core/Classes/ald.php';

session_start();
//var_dump($_REQUEST);
If (isset($_GET['option']))
{
$class=  trim(htmlspecialchars(strip_tags($_GET['option'])));    
}
else 
{
$class='main'; // Set default class 
}
    

if (file_exists("Core/classes/".$class.".php"))
{
    include_once ("core/classes/".$class.".php");
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