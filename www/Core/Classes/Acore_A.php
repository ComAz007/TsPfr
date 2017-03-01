<?php
session_start();

//!!!ЭТО АДМИНСКИЙ КЛАСС!!!!
/**
 * Description of Acore
 *
 * @author Я
 */
require_once 'ADB.php';

abstract class Acore_A extends ADB {
    public $class;
    public $table;
    public $TableHead;
    public $TableHeadLocal;
    public $StatusEnd;
    public $crosTable;
    public $IdForm;
    protected $IDUser;
    private $UserTable=[];

    // TO-DO пдумать как сделать красивей! Сейчас если 1 то работает Create Acore_A если 0 то Create Модуля!
    public $GLflagCreate=1;
    public $GLflagEdit=1;

    protected function Logging($Id_User, $Id_Razdela=1,$Id_Record,$id_Action,$Id_rezerv=0,$Action) {
    /* 
     * $Id_Razdela=0 - Журнал Тех поддержки
     * $Id_Razdela=1 - Журнал Випнет
     * $Id_Razdela=2 - Журнал ЕСИА
     * $Id_Razdela=3 - Журнал Карточек ПТК
     * $Id_Razdela=4 - Журнал Регистрации Запросов подтверждения стажа
      
     * 
     * $id_Action=1 Создание запроса
     * $id_Action=2 Принятие запроса
     * $id_Action=3 Отправка ответа
     * $id_Action=4 Пересылка
     * $id_Action=5 Контроль
     * $id_Action=6 Запрос отписан ИД ответственного в поле $Id_rezerv
     * $id_Action=7 Направление повторного запроса
     * $id_Action=8 Загружен ответ
     * $id_Action=10 Акты на уничтожение
     * $id_Action=11 Изменение параметров карт доступа
     * $id_Action=1000 Просмотр истории
          */
//Id,Id_User, Id_Razdela,Id_Record,id_Action,Id_rezerv,Action,Dates,Times
        $d=date("Y-m-d H:i:s");
        $t=date("H:i:s");
        $query="INSERT INTO logged (Id_User,Id_Razdela,Id_Record,id_Action,Id_rezerv,Action,Times)
                   VALUES('$Id_User','$Id_Razdela','$Id_Record','$id_Action','$Id_rezerv','$Action','$d')";
        $this->query($query);
    }
    
    public function __construct(){
   // echo 'Acore_A.php';
    if ($_SESSION['Id_user']=='')
        
        {header("Location: /Auth.php");}
 else {
    $this->IDUser = $_SESSION['Id_user'];
    parent::__construct();
    
    If (empty($this->UserTable)){
    $this->UserMas();}
    
    $this->get_Body();    
}

}

private function UserMas(){
    $query=" Select Id,FIO from user";
    $res=$this->query($query);
     while($data = $res->fetch_assoc()){
         $this->UserTable[$data["Id"]]=$data["FIO"];
     }      
}

protected function GetUserName($Id) {
    return $this->UserTable[$Id];
    }


protected function PrintMsg($MSG){
    If ($MSG<>'')
    echo '<p style="height: 25px; color: red;">'.$MSG.'</p> </BR>';
    unset($_SESSION['$Message']);
}

    function MergeArray()
    {
        $new_arr=array();
        if (!empty($this->TableHeadLocal)){
            foreach($this->TableHead as $key=>$value){
                if (in_array($key, $this->TableHeadLocal)) {
                    $new_arr[$key]=$value;
                }
            }
        }
        else
        {
            foreach($this->TableHead as $key=>$value){
                $new_arr[$key]=$value;
            }
         
        }
        $this->TableHeadLocal=$new_arr;
        //var_dump($this->TableHeadLocal);
    }


public function CreateZIP($fileNameArch=NULL){
 
//$folder = 'W:/_elArx/_ts'; //Папка с файлами
$folder=PathVremFiles;
$array_file = scandir($folder); //Масcив с именами файлов
//создание zip архива
$zip = new ZipArchive();
//имя файла архива
//$fileNameArx = "W:/_ElArx/test.zip";
$fileNameArx=$fileNameArch;

if ($zip->open($fileNameArx.'.zip', ZIPARCHIVE::CREATE) !== true) {
    fwrite(STDERR, "Error while creating archive file");
    exit(1);
}

foreach($array_file as $name_file){ // Наш цикл
    //if (!is_dir($folder.'/'.$name_file)){
    if (!is_dir($folder.$name_file)){
        //echo $folder.$name_file;
        
        //$zip->addFile($folder.$name_file, $name_file);
        $zip->addFile($folder.$name_file, iconv('windows-1251', 'CP866//TRANSLIT//IGNORE', $name_file));
        //$zip->addFile($folder.'/'.$name_file, $name_file);
    }
    
    }
    
    $zip->close();
 
//exit(0);
}
    

public function ochistit_papku($celevaya_papka){
  $spisok = scandir($celevaya_papka);
  unset($spisok[0], $spisok[1]);
  $spisok = array_values($spisok);
 
  foreach ($spisok as $failik) :
    if ( is_dir($celevaya_papka. $failik) ) :
    $this->ochistit_papku($celevaya_papka. $failik .'/');
    //$this->ochistit_papku($celevaya_papka. $failik);
      rmdir($celevaya_papka. $failik);
    else :
      unlink($celevaya_papka. $failik);
    endif;
  endforeach;
}



public function EPCreate(){
$folder = PathVremFiles; //Папка с файлами
$array_file = scandir($folder); //Масcив с именами файлов

//$array_file=iconv('utf-8','windows-1251', $array_file);

foreach ($array_file as $key => $value)
{
  $array_file[$key] = iconv("windows-1251","UTF-8",$value);
}

$Files = json_encode($array_file);
$PathTmp=json_encode(PathVremFiles);

print "<script language='javascript'> SendGet($Files,$PathTmp) </script>";

//Echo "<p><input type='submit' name='EP' value='Подписать Файлы' onClick='SendGet(obj,PathTmp)' >";

}
    
 
//Чудо функция организующая связб поля и справочника!!!
 protected function IdentData($TableName,$key,$data){
    
    $result='';
    If ($key=='IdUserCreate'){ $result= $this->GetUserName($data);}
    
    If ($key=='Id_User_Create'){ $result=$this->GetUserName($data);}
    If ($key=='Id_User_Vipoln'){ $result=$this->GetUserName($data);}
    If ($key=='Id_User_Get'){ $result=$this->GetUserName($data);}

    //If ($TableName=='juresia' AND $key=='Deistvie'){$result=Jurnals::getESIA($data); echo $result;}
    If ($TableName=='JurObrEVD' AND $key=='region'){ $result=$this->getRegion($data);}
    
    If ($TableName=='JurEsia' AND $key=='Deistvie'){ $result=$this->getESIA($data);}
    If ($TableName=='JurEsia' AND $key=='DateObr'){ $result=date("d.m.Y",strtotime($data));}

    If ($TableName=='JurOZIKD' AND $key=='IDPtk'){ $result=$this->getPTK($data);}
    //If ($TableName=='JurOZIKD' AND $key=='DataBeg'){ $resul=date("d.m.Y",strtotime($data));}
   
    If ($TableName=='JurOZIKD' AND $key=='DataBeg'){ $result=date("d.m.Y",strtotime($data));}
    If ($TableName=='JurOZIKD' AND $key=='DataEnd'){ $result=date("d.m.Y",strtotime($data));}
    If ($TableName=='JurOZIKD' AND $key=='DateAkt'){ $result=date("d.m.Y",strtotime($data));}

    If ($result=='')
        {return $data;}
    else 
        {return $result;}
    
}
    
  
// protected function CrossData($TableName,$key,$data){
//    
//    $result='';
//    If ($key=='IdUserCreate'){ $result=GetUserName($data);}
//    
//    //If ($TableName=='juresia' AND $key=='Deistvie'){$result=Jurnals::getESIA($data); echo $result;}
//    
//    If ($TableName=='JurEsia' AND $key=='Deistvie'){ $result=$this->getESIA($data);}
//    If ($TableName=='JurEsia' AND $key=='DateObr'){ $result=date("d.m.Y",strtotime($data));}
//
//
//    If ($result=='')
//        {return $data;}
//    else 
//        {return $result;}
//    
//}



    //protected function TablePrototype($Res,$Head,$TableName='',$Class='',$Access=0,$Edit=1,$delete=0,$Cheked=0){
    protected function TablePrototype($Res,$Head,$TableName='',$Class='',$AtribId=Array('Edit'),$CheckedFieldOnOff='1'){
        
    //`Id`, `DataReg`, `KodReg`, `KodUrLic`, `KodUpfr`, `FIOZL`, `IdUserCreate`, `TypeZapros`, `TypeZaprosId`, `TypeDeistv`, `FileZapr`, `Povtor`, `DatePovtor`, `DateOtveta`, `FileOtv`
     $str='';
        // выводим на страницу сайта заголовки HTML-таблицы
        $str=$str.'<table class="col_12  sortable" cellspacing="0" cellpadding="0">';
	//echo $col;
	$str=$str. '<thead><tr class="alt User">';
        
        $ii=0;
        $Select='';
        foreach ( $Head as $key=>$value ) {
        $str=$str. '<th value="User" rel="'.$key.'">'.$value.'</th>';
        $Select=$Select.$key.',';
        }       
        $Select=substr($Select, 0, -1);
        
        If ($CheckedFieldOnOff!=='1'){$Select.=','.$CheckedFieldOnOff;}
        
        $query='';
        $query='Select '.$Select.' From '.$TableName;
                If ($Access==1) {$query=$query.' Where IdUserCreate='.$_SESSION['Id_user'];};
                
                $query=$query.' Order By Id DESC LIMIT 20';
               
        $Res= $this->query($query,1);
	$str=$str. '</thead></tr>';
	//echo '</thead>';
	//echo '<tbody>';
	$str=$str.'<tbody> <tr class="alt">';
        
        //var_dump($query);
        
        //`Id`, `FIO`, `DocRekv`, `SNILS`, `DateObr`, `Deistvie`, `IdUserCreate`
        while($data = $Res->fetch_assoc()){ 
                foreach ( $Head as $key=>$value ) {
                    If ($key=='Id'){
                        $datav='';
                        If ($CheckedFieldOnOff!==1 and $data[$CheckedFieldOnOff]==0) {
                        If (in_array('Checked', $AtribId, true) or in_array('ALL', $AtribId, true)) {$datav.='<input id="iCheked" class="cCheked" type="checkbox" name="NCheked" value="'.$data[$key].'"></BR>';};
                        
                        If (in_array('Edit', $AtribId, true) or in_array('ALL', $AtribId, true)) 
                            {$datav.='<a id="Edit" href="?option='.$Class.'&Act=Edit&id='.$data[$key].'">'.$data[$key].'</a> </BR>';}
                        else
                            {$datav.='  '.$data[$key].' ';};
                       
                        $datav.='</Br>';
                        If ((in_array('EditStr', $AtribId, true) and (!in_array('Edit', $AtribId, true))) or in_array('ALL', $AtribId, true)) {$datav.='<a id="Edit" href="?option='.$Class.'&Act=Edit&id='.$data[$key].' ">Редактировать</a> </BR> ';};
                        If (in_array('PrnRec', $AtribId, true) or in_array('ALL', $AtribId, true)) {$datav.='<a id="PrintRecord" class="PointCursor" href="?option='.$Class.'&Act=PrintForm&id='.$data[$key].'" RecId='.$data[$key].'>Печать</a> </BR> ';};
                        //If (in_array('Copy', $AtribId, true) or in_array('ALL', $AtribId, true)) {$datav.='<a id="CopyRecords" href="?option='.$Class.'&Act=CopySL&id='.$data[$key].' ">Скопировать</a> </BR> ';};
                        If (in_array('Copy', $AtribId, true) or in_array('ALL', $AtribId, true)) {$datav.='<a id="CopyRecord" class="PointCursor" RecId='.$data[$key].' Module='.$Class.' Table='.$this->table.'>Скопировать</a> </BR> ';};                        
//If ($Cheked==0) {$datav.='<input id="iCheked" class="cCheked" type="checkbox" value="Select * From '.$TableName.' Where Id='.$data[$key].'">';};
                         }
                         else {$datav.='  '.$data[$key].' ';};
//                        $datav='</BR> <a href="?option=viewJurEsia&Act=Edit&id='.$data[$key].' ">Изменить</a>';
//                        $datav=$datav.'</BR> <a href="?option=viewJurEsia&Act=PrintForm&id='.$data[$key].' ">Печать</a>';
//                        $datav=$datav.'</BR> <a href="?option=viewJurEsia&Act=Delete&id='.$data[$key].' ">Удалить</a>';
                        $datav.='<a id="Historym" href="?option='.$Class.'&Act=History&id='.$data[$key].'"> История</a></BR> ';
                        $datav1=$data[$key];
                    }
                    else
                        {$datav=$this->IdentData($TableName,$key,$data[$key]);}
                        
                    
                    
                If ($key=='Id'){
                //$str=$str. '<td value="'.$datav1.'" >'.$datav1.' '. $datav. '</td>';
                $str=$str. '<td value="'.$data[$key].'" >'. $datav. '</td>';
                }
               else{$str=$str. '<td value="'.$datav.'" >' . $datav. '</td>';}
                }
               
                $str=$str. '</tr>';
                $datav=''; 
                $datav1='';

	}
        
      $str=$str.'</tbody></table>';
        
        return $str;
        //echo $str;
}
// TODO новая функция отрисовки таблиц(от 19/12/2016). Заменить во всех местах
//TODO $CheckedFieldOnOff - поле по которому определяется что обработка завершена
//                          доработат до состояния когда определяется Имя поля и значение
//TODO человеческий эрор если таблицы нет в БД!
    protected function TablePrototypeNew($AtribId=Array('Edit'),$CheckedFieldOnOff='1',$WhereString='',$Access=0){
        
    //`Id`, `DataReg`, `KodReg`, `KodUrLic`, `KodUpfr`, `FIOZL`, `IdUserCreate`, `TypeZapros`, `TypeZaprosId`, `TypeDeistv`, `FileZapr`, `Povtor`, `DatePovtor`, `DateOtveta`, `FileOtv`
     $str='';
        // выводим на страницу сайта заголовки HTML-таблицы
        $str=$str.'<table class="col_12  sortable" cellspacing="0" cellpadding="0">';
	//echo $col;
	$str=$str. '<thead><tr class="alt User">';
        
        $ii=0;
        $Select='';
        foreach ( $this->TableHead as $key=>$value ) {
        $str=$str. '<th value="User" rel="'.$key.'">'.$value.'</th>';
        $Select=$Select.$key.',';
        }       
        $Select=substr($Select, 0, -1);
        
        If ($CheckedFieldOnOff!=='1'){$Select.=','.$CheckedFieldOnOff;}
        
        $query='';
        $query='Select '.$Select.' From '.$this->table;
                If ($Access==1) {$query=$query.' Where IdUserCreate='.$_SESSION['Id_user'];};
                If ($Access!==1 and $WhereString!=='') { $query.=' Where '.$WhereString;};
                If ($Access==1 and $WhereString!=='') { $query.=' and '.$WhereString;};
                $query=$query.' Order By Id DESC LIMIT 20';
        $Res= $this->query($query,1);
	$str=$str. '</thead></tr>';
	//echo '</thead>';
	//echo '<tbody>';
	$str=$str.'<tbody> <tr class="alt">';
        
        //var_dump($query);
        
        //`Id`, `FIO`, `DocRekv`, `SNILS`, `DateObr`, `Deistvie`, `IdUserCreate`
        while($data = $Res->fetch_assoc()){ 
                foreach ( $this->TableHead as $key=>$value ) {
                    If ($key=='Id'){
                        $datav='';
                        If ($CheckedFieldOnOff!==1 and $data[$CheckedFieldOnOff]<$this->StatusEnd) {
                        If (in_array('Checked', $AtribId, true) or in_array('ALL', $AtribId, true)) {$datav.='<input id="iCheked" class="cCheked" type="checkbox" name="NCheked" value="'.$data[$key].'"></BR>';};
                        
                        If (in_array('Edit', $AtribId, true) or in_array('ALL', $AtribId, true)) 
                            {$datav.='<a id="Edit" href="?option='.$this->class.'&Act=Edit&id='.$data[$key].'">'.$data[$key].'</a> </BR>';}
                        else
                            {$datav.='  '.$data[$key].' ';};
                       
                        
                        If ((in_array('EditStr', $AtribId, true) and (!in_array('Edit', $AtribId, true))) or in_array('ALL', $AtribId, true)) {$datav.='<a id="Edit" href="?option='.$this->class.'&Act=Edit&id='.$data[$key].' ">Редактировать</a> </BR> ';};
                        If (in_array('PrnRec', $AtribId, true) or in_array('ALL', $AtribId, true)) {$datav.='<a id="PrintRecord" href="?option='.$this->class.'&Act=PrintForm&id='.$data[$key].' ">Печать</a> </BR> ';};
                        If (in_array('Copy', $AtribId, true) or in_array('ALL', $AtribId, true)) {$datav.='<a id="Copy" href="?option='.$this->class.'&Act=CopySL&id='.$data[$key].' ">Скопировать</a> </BR> ';};
                        //If ($Cheked==0) {$datav.='<input id="iCheked" class="cCheked" type="checkbox" value="Select * From '.$TableName.' Where Id='.$data[$key].'">';};
                         }
                         else {$datav.='  '.$data[$key].' ';};
//                        $datav='</BR> <a href="?option=viewJurEsia&Act=Edit&id='.$data[$key].' ">Изменить</a>';
//                        $datav=$datav.'</BR> <a href="?option=viewJurEsia&Act=PrintForm&id='.$data[$key].' ">Печать</a>';
//                        $datav=$datav.'</BR> <a href="?option=viewJurEsia&Act=Delete&id='.$data[$key].' ">Удалить</a>';
                        $datav.='<a id="Historym" href="?option='.$this->class.'&Act=History&id='.$data[$key].'"> История</a></BR> ';
                        $datav1=$data[$key];
                    }
                    else
                        {$datav=$this->IdentData($this->table,$key,$data[$key]);}
                        
                    
                    
                If ($key=='Id'){
                //$str=$str. '<td value="'.$datav1.'" >'.$datav1.' '. $datav. '</td>';
                $str=$str. '<td value="'.$data[$key].'" >'. $datav. '</td>';
                }
               else{$str=$str. '<td value="'.$datav.'" >' . $datav. '</td>';}
                }
               
                $str=$str. '</tr>';
                $datav=''; 
                $datav1='';

	}
        
      $str=$str.'</tbody></table>';
        
        //return $str;
        echo $str;
}





//
//protected function _EPCreate($Path){
//    if( $curl = curl_init() ) {
//    curl_setopt($curl, CURLOPT_URL, 'http://localhost:3573/CS-UPD/initModule?transDir=&keyDir=&password=&flag=0&serialNumbers=&serialsNumbersCA=&keyUsage=&extension=.p7s');
//    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
//    $out = curl_exec($curl);
//    echo $out;
//    
//    
//    curl_setopt($curl, CURLOPT_URL, 'http://localhost:3573/CS-UPD/signFile?fileName='.$Path.'&isSaveEP=true');
//    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
//    $out = curl_exec($curl);
//    echo $out;
//
//  } 
//}


//Чудо функция конвертирования DocX в строку! убогая но посмотреть содержимое можно
  public function readDocx($filePath) {
    // Create new ZIP archive
    $filePath="D:/_ElArx/test.docx";
    $zip = new ZipArchive;
    $dataFile = 'word/document.xml';
    // Open received archive file
    if (true === $zip->open($filePath)) {
        // If done, search for the data file in the archive'
        if (($index = $zip->locateName($dataFile)) !== false) {
            // If found, read it to the string
            $data = $zip->getFromIndex($index);

            //Close archive file
            $zip->close();
            // Load XML from a string
            // Skip errors and warnings
            var_dump($data);
            $xml = new DOMDocument();
            $xml->loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
            
            // Return data without XML formatting tags'
            $contents = explode('\n',strip_tags($xml->saveXML()));
         
            $text = '';
            foreach($contents as $i=>$content) {
                $text .= $contents[$i];
            }
            return $text;
        }
        $zip->close();
    }
    // In case of failure return empty string
    return "";
}
protected function get_Header()
        {
    include 'Header.php';
    include 'menu.php';
    
        }

protected function get_LeftBar()
        {

    }
    
    protected function get_Footer()
    {
        echo '
        <!-- End MainContent-->
</div >';
        
        include 'ver.php';
        echo '
         
    </body> 
    </html>';
        
    }
    public function get_Body()
    {
        //echo "<script language='javascript'>var module='".$_SESSION['Class']."' </script>";
        //echo "<script language='javascript'>var module='".$this->class."' </script>";
    //
//         if ($_POST{'ajax'}||$_GET{'ajax'}){
//             $this->MainContent();
//         }
// else {
       if ($_POST||$_GET){
//        var_dump($_REQUEST);
//        echo 'r';
//        var_dump($_POST);
//        echo 't';
//        var_dump($_GET);
          //if (!isset($_GET['SearchSTR']) and (($_REQUEST['Act'])!==Create) and (!$_REQUEST['Action'] == 'Create') and (!isset($_REQUEST['CreateButton']))) {
          //if (!isset($_GET['SearchSTR']) and (($_REQUEST['Act'])!==Create)) {
           if (!isset($_GET['SearchSTR'])) {
          include 'scripts.php';
          
          };
          $this->obr($_REQUEST);
          $this->obrGL($_REQUEST);
          if (!isset($_REQUEST['Act'])){
          $this->MainContent();}
          //$this->get_Header();
       
          
          //$this->get_Footer();
          
        }
 else {
////     if (!$_REQUEST['Action'] == 'Create'){
////     //include 'scripts.php';}
     //echo 'droch';
     IF ((!$_REQUEST['Action'] == 'Create') and (!isset($_POST['CreateButton']))) {
       //  echo 'droch1';
        $this->get_Header();
       
            $this->MainContent();
     $this->get_Footer();    }
        }
//     IF (isset($_POST['CreateButton'])) { 
//         $this->get_Header();
//            $this->MainContent();
//            $this->get_Footer(); 
//     }     
    
    //$this->get_LeftBar();
//    If ($_REQUEST['Act'] == 'Create') {
//       unset($_SESSION['NotAjax']);}

//var_dump($_SESSION);
        If ($_REQUEST['id']!==NULL){
            $_SESSION['IdRec'] = $_REQUEST['id'];
        }
   //If ((!isset($_REQUEST['Act'])) or $_SESSION['NotAjax']==1) {
   //If ($_SESSION['NotAjax']==1) {
//            $this->get_Header();
//            $this->MainContent();
//            $this->get_Footer();
         unset($_SESSION['NotAjax']);
       //}
       //else {include 'Header.php';};
    
    }
  //  }
    abstract function MainContent();
    
    protected function Edit($Caption,$data){
        $data .= $this->DynamicTableGenerated();
        $data .= $this->UIButtonSave(); 
        $data .= $this->UIButtonClose();
        $this->Form($Caption, $data);
        //var_dump($_SESSION);
    }
    
    protected function Create($Caption,$data){
        $data .= $this->DynamicTableGenerated();
        $data .= '</br> '.$this->UIButtonCreate();
        $this->Form($Caption, $data,'Create');
    }
    
    //создание формы почти повторяет private function Form
    //TO-DO рассмотреть вопрос об оптимизации соединив все в одну форму
    // TO-DO доработать до стадии когда из полей подставляются значения если они там есть!!!
    protected function CreateForm($Caption,$data,$Action){
        $this->Form($Caption, $data,$Action);
    }
    
    protected function CopyRecord($Caption,$data){
       $RecordData = $this->RecordZN($_REQUEST['Table'],'*',$_REQUEST['RecordId']);
       $data .= $this->DynamicTableGenerated($RecordData);
       $data .= $this->UIButtonCreate();
       $this->Form($Caption, $data,'Create');
    }
    
    private function Form($Caption,$data,$Action='')
    {
        //Echo "<Div class=grid>";
        Echo '<div id="dialog" title="'.$Caption.'# '.$_SESSION['IdRec'].'" >';

        //TO-DO ПОлНЫ БРЕД ИПО вот этастрока создана что бы проверить как оно рабоатет 
        //Echo "<form enctype='multipart/form-data' action='?option=viewJurTS' method='Post' class='create'>";
        // а вот это истинная ИСХОДНА СТРОКА
        If ($Action==''){
            Echo "<form enctype='multipart/form-data' action='' method='Post'>";
        }
        else {
            //$Action.='Form';
            Echo "<form enctype='multipart/form-data' action='$Action' method='post' class='UIForm'>";
           // $Classl="?option=".$_SESSION['Class'];
           // Echo "<form enctype='multipart/form-data' action='$Classl' method='post' class='$Action'>";
        }
        //echo "<script language='javascript'>var module='".$_SESSION['Class']."' </script>";
       
        
        echo $data;
        
        Echo '</form>';
        Echo '</Div>';
        //include 'scripts_1.php';
        //$_SESSION['IdRec']=$_SESSION['IdRec'];
       // Echo '</Div>';
        
        
    }

        protected function obr(){
        
    }
    
    
    
    protected function obrGL($request){
        //echo '----Main----';
        //var_dump($request);
        //var_dump();
        $pole='';
        $zn='';
        
        If (isset($request['exit'])) {
            header("location: /logout.php");
        }
        
//         If ($request['Act'] == 'UpdContt') {
//            $this->MainContent();
//            //exit();
//        }
        
        
        If (isset($request['Authorization'])) {
            require_once "Lib/Function.php";
            $login=$_POST['Loginname'];
            $pass=$_POST['PassText'];
            
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
        }
        
         If ($_REQUEST['Act'] == UMC) {
            $this->MainContent();
        }
        
//        If ($_REQUEST['Act'] == UCMT) {
//            Echo $this->MainTabelA();
//        }
        
        
        If ($this->GLflagCreate==1){
            //IF (isset($request['Save'])) {
          
//        exit();
            
            //IF (isset($request['CreateButton1'])) {
            IF ($request['Action'] == 'Create') {
                //var_dump($request);
                $this->MergeArray();
                foreach ($this->TableHeadLocal as $key=>$value ){
                    //echo 'nn_'.$value;
                    If($key<>'Id' and $key<>'IdUserCreate'){
                    $zn.='"'.$request[$key].'",';
                    $pole.=$key.',';}
                    
                    If($key=='IdUserCreate'){
                    $zn.='"'.$_SESSION['Id_user'].'",';
                    $pole.='IdUserCreate'.',';}
                
                }
                
                
                $zn=substr($zn, 0, -1);
                $pole=substr($pole, 0, -1);
                $query = "INSERT INTO ".$this->table." (".$pole.") VALUES(".$zn.")";
                //echo $query;
                //exit();
                $this->query($query);
                $this->Logging($_SESSION['Id_user'], $this->IdForm, $this->linkId,1,0,'Создание записи');
                
                If ($this->class=='viewJurObrEVD'){
                mail("071-040-0800", iconv('utf-8','windows-1251', "Новая задача загрузки ЭВД"), iconv('utf-8','windows-1251', "Новая задача загрузки ЭВД"));
                }
                //header("location: /?option=".$_SESSION['Class']);
                //header("location: /?option=".$this->class);
                //echo 'Xera sebe';
        }}
    }
  
    public function MainTabel($Table)  
    {
     $arr=$this->GetStructTable($Table);
        //var_dump($arr);
        //Name, Type Length Comment
        $str='';
        // выводим на страницу сайта заголовки HTML-таблицы
        $str=$str.'<table class="col_12  sortable" cellspacing="0" cellpadding="0">';
	//echo $col;
	$str=$str. '<thead><tr class="alt first last">';
        foreach ($arr as $key => $value) {
             
        $str=$str. '<th value="'.$value['Name'].'" rel="'.$key.'">'.$value['Comment'].'</th>';
       }
        //echo '<th>Завершена</th>';
	$str=$str. '</thead></tr>';
	//echo '</thead>';
	//echo '<tbody>';
	$str=$str.'<tbody>';
        $query="Select * from ".$Table;
        $Res=  $this->query($query);
        while($data = $Res->fetch_row()){ 
                $col--;
                //echo $COL.'</Br>';
                //echo $col.'</Br>';
                                 
                iF ($col1==1) {
                $str=$str. '<tr class="alt">';
                $col1--;
                } 
                Else
                {
		$str=$str. '<tr class="">';
		 $col1++;
                };
                
                foreach ($data as $key => $value){
                    If ($key==0){
                        $str=$str. '<td value="'.$value.'" >
                                <a href="?option=Defaul&Act=Edit&id='.$value.'">'.$value.'</a> </td>';
                    }
                    else {
                    $str=$str. '<td value="'.$value.'" >' . $value . '</td>';
                    
                    }
                }
                $str=$str. '</tr>';
                
        }
        
        
        
        $str=$str.'</tbody></table>';
        echo $str;
    //echo "Ключ: $key; Значение: $value<br />\n";
  // echo ; echo $value['Type']; echo $value['Length']; echo $value['Comment']; echo'</br>';

}
//TO-DO ниже полная хрень ИПО элементы можно выделить в отдельные строки т.е. уменишить дублирование использовать UI
    function UIDinamicTableFieldGenerate($Type,$Name,$Label,$Value='',$IdEdit=FALSE,$LinksField=Array()){
    //echo $Type.'</BR>';
        switch($Type){
           case 'varchar':
               return '<div class="col_6 center">'.$Label.'<BR> <input name="'.$Name.'" value="'.$Value.'"> </div>';
               break;
           case 'text':
               return $Label.'<BR> '.$this->UITextArea($Name,$Value).'</BR> </BR>'; // почти трушная реализаци To-DO вот так должно быть ВЕЗДЕ!!!
               break;
           case 'tinyint':
               return '<div class="col_6 center">'.$Label.'<BR> <input name="'.$Name.'" value="'.$Value.'"> </div>';
               break;
           case 'int':
               If ($Name<>'Id' or $IdEdit==True){
               return '<div class="col_6 center">'.$Label.'<BR> <input name="'.$Name.'" value="'.$Value.'"> </div>';}
               break;
            case 'date':
               return '<div class="col_6 center">'.$Label.'<BR> <input class="KalDates" name="'.$Name.'" value="'.$Value.'"> </div>';
               break;
           case 'datetime':
               return '<div class="col_6 center">'.$Label.'<BR> <input class="KalDatesTimes" name="'.$Name.'" value="'.$Value.'"> </div>';
               break;
        }
//<p> Поиск УПФР по классификатору: </BR> <input name="SearchField" placeholder="Поиск УПФР по справочнику" style="width: 100%" class="searchUPFR">
    }

    //TO-DO слишком все по тупому
    //TO-DO во первых все проверки ПОЛЯ вынести в отдельную функцию с возвратом труе или фалсе
    // проверки на названия полей и пустоту имени
    //TO-DO во вторых пусть юзер хоть пупок изорвет нужно объединить все массивы   
    // $StructTable, TableHeadLocal, TableHead на придмет названия полей
    private function DynamicTableGenerated($RecordData=''){
        $StructTable=$this->GetStructTable($this->table);
        $data='';
        //var_dump($this->TableHead);
        foreach ($StructTable as $key=>$Pole){
            $fieldValue='';
            If($RecordData!=='')
            {
                $fieldValue=$RecordData[$Pole['Name']];
            }
            
            If (($Pole['Name']!=='Id') and ($Pole['Name']!=='IdUserCreate')){
            if (!empty($this->TableHeadLocal)){
                    if (in_array($Pole['Name'], $this->TableHeadLocal)) {
                        If ($Pole['Comment']=='')
                           $data .=$this->UIDinamicTableFieldGenerate($Pole['Type'], $Pole['Name'], $this->TableHead[$Pole['Name']], $fieldValue);        
                        else
                           $data .=$this->UIDinamicTableFieldGenerate($Pole['Type'], $Pole['Name'], $Pole['Comment'],$fieldValue);
                    }
            }
            else
            {
                
                If (array_key_exists($Pole['Name'], $this->TableHead)){
                    
                        $data .=$this->UIDinamicTableFieldGenerate($Pole['Type'], $Pole['Name'], $this->TableHead[$Pole['Name']], $fieldValue);                
                    
                }    
                else {
                    If ($Pole['Comment']!==''){
                    $data .=$this->UIDinamicTableFieldGenerate($Pole['Type'], $Pole['Name'], $Pole['Comment'], $fieldValue);
                    }
                }
            }
            }
        }
        return $data;
    }





public function UIButtonAjax($ButtonType,$ButtonText){  
    return "<div class='col_3 ButtonUIAjax visible center' style='height: 25px;'> <a id='".$ButtonType."' title='".$ButtonText."'>".$ButtonText."</a></div>";
}


public function UIButtonActionAjax($ButtonAction,$ButtonLabel){  
    return "<div class='col_3 ButtonActionAjax visible center' Action='".$ButtonAction."' style='height: 25px;'> <a title='".$ButtonLabel."'>".$ButtonLabel."</a></div>";
}

public function UITextArea($Name,$Data,$cols=68,$Rows=5){  
    return '<textarea name="'.$Name.'" cols="68" rows="5">'.$Data.'</textarea>' ;
}

public function UILabel($Text){  
    return '<div>'.$Text.'</div>';
}

public function UIButtonSave(){
    return "<input type='submit' name='SaveButton' value='Сохранить изменения' >";
}

public function UIButtonCreate(){
    return "<input type='submit' name='CreateButton' value='Создать запись' >";
 
}

public function UIButtonClose(){
    return "<input type='submit' name='CloseButton' value='Закрыть' >";
}

}
