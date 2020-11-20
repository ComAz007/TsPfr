<?php

abstract class ADB {

    protected $link;
    protected $linkId;
 
//public function __construct(){
//     
//    $this->DB=mysqli_connect(HOST,USERS,PASSWORD);
//     if (!$this->DB){
//         exit("Ошибка соединения с БД".mysqli_error());
//     }
//     if (!mysqli_select_db($this->DB,DB)){
//         exit("Нет такой БД".mysqli_error());
//     }
//     
//     mysqli_query($this->DB,"SET NAMES 'UTF8'");
//
//}

public function __construct() {

 if (!$this->link = mysqli_connect(HOST,USERS,PASSWORD)) {
 trigger_error('Error: Could not make a database link using ' . DB_USER . '@' . DB_HOST);
 return FALSE;
 } else {
 if (!mysqli_select_db($this->link,DB)) {
 trigger_error('Error: Could not connect to database ' . DB);
 return FALSE;
 } else {
        mysqli_query($this->link,"SET NAMES 'UTF8'");
 return TRUE;
 }
 return TRUE;
 } 
 }

 // получаем ID последней вставленной записи в опред таблицу!
 private function setLastId($Link) {
     $this->linkId=mysqli_insert_id($Link);
     
 }
 
protected function ConstructSql($SqlCreate,$Table,$Param){
    
}
 
 
protected function query($query,$assoc=0) {
    if ($result = mysqli_prepare($this->link, $query)) {
        $result=mysqli_query($this->link,$query);
    //TO-DO посмотреть эти команды!
    //$res->execute();
    //$res = $res->affected_rows;
    //$res = $res->get_result();
    $this->setLastId($this->link);    
    }
    //$res=mysqli_query($this->link,$query);
    //return $res;
    If ($assoc==0) {
        return $result;
    }
    else {
        //$result=
        return mysqli_fetch_assoc($result);
    }
}


//возвращает 1-е поле в 1-ой записи
protected function resultOne($query)
{
    $Res=$this->query($query);
    $data = $Res->fetch_row();
    return $data['0'];
}

protected function FieldZN($Table,$Field,$Id) {
    $query="Select ".$Field." from ".$Table." Where Id=".$Id;
    
//    if ($res = mysqli_prepare($this->link, $Qu)) {
//        $res=mysqli_query($this->link,$Qu);
//        $res=mysqli_fetch_assoc($res);
//    }
//    //$res=mysqli_query($this->link,$query);
    
    //return $res[$Field]; 
    return $this->query($query,1)[$Field]; 
}

protected function getValueFieldRecord($Table,$Field,$Id) {
    $query="Select ".$Field." from ".$Table." Where Id=".$Id;
//    if ($result = mysqli_prepare($this->link, $query)) {
//        $result=mysqli_query($this->link,$query);
//        $result=mysqli_fetch_assoc($result);
//    }
//    //$res=mysqli_query($this->link,$query);
    return $this->query($query,1);
   // return $result; 
}


protected function structDB($param=0,$TableName='',$DBName='') {

    $result=array();
    $Table=$this->GetTable();
    
        foreach ($Table as $value) {
           $n = $this->GetStructTable($value);
           $result[]= ["Table"=>$value,"Fields"=>$n];
        }

If ($param==0) {return $result;}
If ($param==1) {return json_encode($result);}
        
}


protected function GetTable() {
        
	$result = array();
	$r = $this->query("SHOW TABLES");
	if (mysqli_num_rows($r)>0)
	{
		while($row = mysqli_fetch_array($r, MYSQL_NUM))
		{
			$result[] = $row[0];
		}
	}
        //var_dump($ret);
	return $result;
    
    //return mysqli_query($this->link,$query);
}

protected function GetStructTable($Table) {// Получаем данные о столбцах таблицы.
     
    $result=array();
    $r=$this->query("SHOW COLUMNS FROM $Table");
    //Получаем коммент к полю
    $r1=$this->query("
    SELECT column_comment, column_name
FROM information_schema.columns
WHERE 1=1
AND table_name = '$Table'
AND table_schema = 'ts'");
    if (mysqli_num_rows($r)>0)
	{
		while($row = mysqli_fetch_array($r, MYSQL_NUM))
		{
                    //парсим запрос содержащий комментарий к полю
                $row1 = mysqli_fetch_array($r1, MYSQL_NUM);
                $t=$row[1];   
                $p = explode("(", $t);
                $result[] = ["Name"=>$row[0],"Type"=>$p[0],"Length"=>substr($p[1],0,strlen($p[1])-1),"Comment"=>$row1[0]];
		}
	}


//Ниже второй вариант получения данныхо полях таблицы
//$query = "SELECT * from $Table LIMIT 0";
//if ($result = $this->query($query)) {
//
//    /* Получим информацию обо всех столбцах */
//    while ($finfo = $result->fetch_field()) {
//  
//        $ret[] = ["Name"=>$finfo->name,"Type"=>$this->GetMysqlType($finfo->type),"Length"=>$finfo->max_length,"TypeDig"=>  $finfo->type];
//    
//            
////        printf("Имя:         %s\n",$finfo->name );
////        printf("Таблица:     %s\n", $finfo->table);
////        printf("макс. длина: %d\n", $finfo->max_length);
////        printf("Флаги:       %d\n", $finfo->flags);
////        printf("Тип:         %d\n\n", $finfo->type);
//    }
//}
  
return $result;
}

private function GetMysqlType($Key){
 $mysql_data_type_hash = array(
    1=>'tinyint',
    2=>'smallint',
    3=>'int',
    4=>'float',
    5=>'double',
    7=>'timestamp',
    8=>'bigint',
    9=>'mediumint',
    10=>'date',
    11=>'time',
    12=>'datetime',
    13=>'year',
    16=>'bit',
    //252 is currently mapped to all text and blob types (MySQL 5.0.51a)
    252=>'BIG_TEXT', //Тип придуман ни факт что ПРАВИЛЬНО!!!!
    253=>'varchar',
    254=>'char',
    246=>'decimal'
); 
 
return $mysql_data_type_hash[$Key];
}
 
// контроль содержимого передаваемого в базу от пользователя
private function CQS($value) {
// Зафигарить функцию кторая будет проверять данные на различные кретерии ЧЕРЕ КЕЙС сейчас 
// проверка на всякие подлости В КОММЕНТЕ проверка на корректность введеного АДРЕСА МЫЛА!
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    
    //$value=filter_var($value, FILTER_VALIDATE_EMAIL);
    
    return $value;
}


}