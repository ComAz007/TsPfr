<?php
    
//http://blog.sklazer.com/865.html почитать для просветления!

class viewJurEsia extends Jurnals {
    
   
    
    
    public function __construct() {
//        include 'Header.php';
//echo"";
        $this->class='viewJurEsia';
        $this->table='JurEsia';
        $this->TableHead=Array("Id"=>"№п/п", "FIO"=>"Фамилия Имя Отчество",
              "DocRekv"=>"Реквизиты документа, удостоверяющего личность", "SNILS"=>"СНИЛС",
              "DateObr"=>"Дата обращения", "Deistvie"=>"Услуга, за которой обратился заявитель",
              "IdUserCreate"=>"Сотрудник, принявший заявление");
        parent::__construct();
        
    }
    


    function sqldate2time($date) {
        list($y, $m, $d) = explode('-', $date);
        $res = mktime(3,0,0,$m,$d,$y);
        return($res);
    }//function
     
    //Добавляем к дате указанное кол-во дней
    function add_days($date, $days = 15) {
        $t = $this->sqldate2time($date);
        $t += (86400*$days);
     
        return(date('Y-m-d', $t));
    }//function
    
   

private function TableHistory($Res){
    //`Id`, `DataReg`, `KodReg`, `KodUrLic`, `KodUpfr`, `FIOZL`, `IdUserCreate`, `TypeZapros`, `TypeZaprosId`, `TypeDeistv`, `FileZapr`, `Povtor`, `DatePovtor`, `DateOtveta`, `FileOtv`
     $str='';
        // выводим на страницу сайта заголовки HTML-таблицы
        $str=$str.'<table class="col_12  sortable" cellspacing="0" cellpadding="0">';
	//echo $col;
	$str=$str. '<thead><tr class="alt User">';
        $str=$str. '<th value="User" rel="1">Пользователь</th>';
        $str=$str. '<th value="Action" rel="2">Действие</th>';
        $str=$str. '<th value="DateTime" rel="3">Дата/время</th>';

        
        //echo '<th>Завершена</th>';
	$str=$str. '</thead></tr>';
	//echo '</thead>';
	//echo '<tbody>';
	$str=$str.'<tbody> <tr class="alt">';
        
        
        while($data = $Res->fetch_row()){ 
                
                $str=$str. '<td value="'.GetUserName($data['0']).'" >' . GetUserName($data['0']). '</td>';
		If($data['4']==6){
	                $str=$str. '<td value="'.$data['1'].'" >' . $data['1'].': '. GetUserName($data['3']). '</td>';}
		else
{
	                $str=$str. '<td value="'.$data['1'].'" >' . $data['1']. '</td>';}

                $str=$str. '<td value="'.$data['2'].'" >' . $data['2'] . '</td>';
                
               
                $str=$str. '</tr>';
                 

	}
        
      $str=$str.'</tbody></table>';
        //return $str;
        echo $str;
}


//private function TablePrototype($Res,$Head,$TableName='',$Access=0,$AllEdit=1,$delete=0){
//    //`Id`, `DataReg`, `KodReg`, `KodUrLic`, `KodUpfr`, `FIOZL`, `IdUserCreate`, `TypeZapros`, `TypeZaprosId`, `TypeDeistv`, `FileZapr`, `Povtor`, `DatePovtor`, `DateOtveta`, `FileOtv`
//     $str='';
//        // выводим на страницу сайта заголовки HTML-таблицы
//        $str=$str.'<table class="col_12  sortable" cellspacing="0" cellpadding="0">';
//	//echo $col;
//	$str=$str. '<thead><tr class="alt User">';
//        
//        $ii=0;
//        $Select='';
//        foreach ( $Head as $key=>$value ) {
//        $str=$str. '<th value="User" rel="'.$key.'">'.$value.'</th>';
//        $Select=$Select.$key.',';
//        }       
//        $Select=substr($Select, 0, -1);
//        
//        $query='';
//        $query='Select '.$Select.' From '.$TableName;
//                If ($Access==1) {$query=$query.' Where IdUserCreate='.$_SESSION['Id_user'];};
//                
//                $query=$query.' Order By Id DESC LIMIT 20';
//               
//        $Res= $this->query($query,1);
//	$str=$str. '</thead></tr>';
//	//echo '</thead>';
//	//echo '<tbody>';
//	$str=$str.'<tbody> <tr class="alt">';
//        
//        
//        
//        //`Id`, `FIO`, `DocRekv`, `SNILS`, `DateObr`, `Deistvie`, `IdUserCreate`
//        while($data = $Res->fetch_assoc()){ 
//                foreach ( $Head as $key=>$value ) {
//                    
//                    If ($key=='Id'){
//                        
//                        $datav='</BR> <a id="print" href="?option=viewJurEsia&Act=PrintForm&id='.$data[$key].' ">Печать</a>';
//                        
////                        $datav='</BR> <a href="?option=viewJurEsia&Act=Edit&id='.$data[$key].' ">Изменить</a>';
////                        $datav=$datav.'</BR> <a href="?option=viewJurEsia&Act=PrintForm&id='.$data[$key].' ">Печать</a>';
////                        $datav=$datav.'</BR> <a href="?option=viewJurEsia&Act=Delete&id='.$data[$key].' ">Удалить</a>';
//                        
//                        $datav1=$data[$key];
//                    }
//                    else
//                        {$datav=$this->IdentData($TableName,$key,$data[$key]);}
//                        
//                    
//                If ($key=='Id'){
//                $str=$str. '<td value="'.$datav1.'" >'.$datav1.' '. $datav. '</td>';
//                }
//                else{$str=$str. '<td value="'.$datav.'" >' . $datav. '</td>';}
//                }
//               
//                $str=$str. '</tr>';
//                $datav=''; 
//                $datav1='';
//
//	}
//        
//      $str=$str.'</tbody></table>';
//    
//        return $str;
//        //echo $str;
//}





    public function MainContent()
  {
         echo "<script language='javascript'>var module='".$this->class."' </script>";
        echo "<script language='javascript'>var opti='".$this->class."' </script>";
        echo "<Center> <H6> Журнал регистрации заявлений на регистрацию, подтверждение, удаление, восстановление доступа к учетной записи пользователя в Единой системе идентификации и аутентификации в инфраструктуре, обеспечивающей информационно-технологическое взаимодействие информационных систем, используемых для предоставления государственных и муниципальных услуг в электронной форме </Center> </H6>";
        echo '<ul class="tabs left">
                <li><a href="#tabr1">Заявления</a></li>';
        echo '</ul>';
        
        Echo ('<div id="tabr1" class="tab-content">');
        $IDU = $_SESSION['Id_user'];
        $Button='';
        $Button .=$this->UIButtonAjax('Create', 'Создать заявление');
        echo $Button;
        echo '<div id="ContentMainTable">';
        Echo $this->MainTabelA();
        echo '</div>';
   
        
     
  }
  
  private function MainTabelA() {
      
          If (($_SESSION['Admin']==1) or ($_SESSION['Status']==20)){
              return $this->TablePrototype($Res,$this->TableHead,$this->table,$this->class,Array('PrnRec','Copy'));
              }
              
          Else{return $this->TablePrototype($Res,$this->TableHead,$this->table,$this->class,Array('PrnRec','Copy'));}
        //$this->Table($Res,0);
        //}
   //Echo '</div>';
  }






//    public function __construct() {
//        include 'Header.php';
//        parent::__construct();
//        
//    }
    
 
    
    
    private function getExtens($filename) {
        $path_info = pathinfo($filename);
        return $path_info;
    }

    
    
     private function history($id) {

        //Echo '<div id="dialog" title="История обработки Запроса # $id">';
        Echo "<div id='dialog' title='История обработки Запроса # $id'>";
        
        Echo "<form enctype='multipart/form-data' action='?option=viewJurVipnet' method='Post'>";
        $query="SELECT Id_User,Action,Times,Id_rezerv,id_action FROM logged WHERE Id_Record=$id and Id_Razdela=2 order by Times desc";
        $Res= $this->query($query);
        //$Head=array("Пользователь","Действие","Дата/время");
        //$this->TablePrototype($Res, $Head, 1, 0);
        $this->TableHistory($Res);
      
        Echo "<p><input type='submit' name='HistoryClose' value='Закрыть' >";
        Echo "</form>";
        Echo '</div>';
 
    }
    

       private function printForm() {
           include 'Header.php';
          echo "<div class='col_3 visible NoPrint center' Module='viewJurEsia' style='height: 25px;'> <a href='?option=viewJurEsia'>Закрыть форму(возврат в журнал)</a><br></div>";
       Echo '<BR> <BR> <div  class="col_12 center" style="font-size:15px; text-align:center; ">'
           .'
               ЗАЯВЛЕНИЕ № '.$_SESSION['IdRec'].'</BR >
            на регистрацию, подтверждение, удаление, восстановление доступа к учетной 
            записи пользователя в Единой системе идентификации и аутентификации 
            в инфраструктуре, обеспечивающей информационно-технологическое взаимодействие 
            информационных систем, используемых для предоставления государственных и муниципальных услуг 
            в электронной форме </div>';
       $query='SELECT * FROM juresia WHERE Id='.$_SESSION['IdRec'];
           
       $data= $this->query($query,1);
       //$data = $Res->fetch_assoc();
       
       $sel1='/../css/img/squera.jpg';
       $sel2='/../css/img/squera.jpg';
       $sel3='/../css/img/squera.jpg';
       $sel4='/../css/img/squera.jpg';
       If ($data['Deistvie']==1){$sel1='/../css/img/squeraSel.jpg';};
       If ($data['Deistvie']==2){$sel2='/../css/img/squeraSel.jpg';};
       If ($data['Deistvie']==3){$sel3='/../css/img/squeraSel.jpg';};
       If ($data['Deistvie']==4){$sel4='/../css/img/squeraSel.jpg';};
   
               
       Echo '<div> Я,'.$data['FIO'].', </div> <BR>';
       Echo '<div class="col_5 center"> _________________________, <BR> (дата рождения)</div>';
       Echo '<div class="col_3 center"> '.$data['SNILS'].', <BR> (СНИЛС)</div>';
       Echo '<div class="col_4 center"> ___________________ <BR> (Пол)</div>';
       Echo '<div class="col_12 center"> _________________________________________________________________________________<BR>'
       . '(место рождения) </div> ';
       Echo '<div class="col_12 center"> зарегистрирован по адресу: _______________________________________________________<BR> <BR>'
                                        . '_________________________________________________________________________________'
                                        . '<BR> (населенный пункт, улица, дом, корпус, строение, квартира, индекс) </div> ';
       Echo '<div class="col_12 center"> документ, удостоверяющий личность: паспорт '.$data['DocRekv'].' _________________________<BR><BR>'
                                        . '_________________________________________________________________________________'
                                        . '<BR> (серия, номер, кем выдан, дата выдачи, код подразделения)) </div> ';
       
       Echo '<div  class="col_12" style="font-size:15px; text-align: justify;">'
       .'в соответствии с Правилами использования простой электронной подписи при оказании 
           государственных и муниципальных услуг, утвержденных постановлением Правительства 
           Российской Федерации от 25.01.2013 № 33 прошу осуществить следующую операцию с 
           учетной записью в Единой системе идентификации и аутентификации в инфраструктуре, 
           обеспечивающей информационно-технологическое взаимодействие информационных систем, 
           используемых для предоставления государственных и муниципальных услуг в электронной форме:</div>';
       
       Echo '<div class="col_6"> <img src="'.$sel1. '" width="25" height="25" > Регистрация </div>';
       Echo '<div class="col_6"> <img src="'.$sel2. '" width="25" height="25" > Подтверждение </div>';
       Echo '<div class="col_6"> <img src="'.$sel4. '" width="25" height="25" > Удаление </div>';
       Echo '<div class="col_6"> <img src="'.$sel3. '" width="25" height="25" > Восстановление доступа </div>';
       
       
      Echo '<div class="col_12 center"> Контактная информация: _________________________________________________________'
       . '</br> (адрес электронной почты, мобильный телефон)</div>';
      Echo '<div class="col_12"> Способ получения пароля: </Div>';
      
      Echo '<div class="col_6 center"> <img src="/../css/img/squera.jpg" width="25" height="25" > на мобильный телефон; </div>';
      Echo '<div class="col_6 center"> <img src="/../css/img/squera.jpg" width="25" height="25" > на электронную почту; </div>';


      Echo '<div class="col_12" style="font-size:15px; text-align: justify;"> <img src="/../css/img/squera.jpg" width="25" height="25" >
         Согласен на обработку моих персональных данных, указанных в данном заявлении, 
      в соответствии с Федеральным законом от 27.07.2006 № 152-ФЗ «О персональных данных».
       <BR> <BR><BR> <BR></div> ';
       
      Echo '<div class="col_5 center">'.  $this->rdate("d M Y",strtotime($data['DateObr'])).' года <BR> (дата)</div> ';
      Echo '<div class="col_7 center"> _________________________________, <BR> (подпись субъекта персональных данных)</div>';
       
       Echo '</div>';
       exit();
    }
    
   
    
    protected function obr() {

         If ($_REQUEST['Act'] == UpdCont) {
            Echo $this->MainTabelA();
            
        }
        
         If ($_REQUEST['Action'] == Create) {
            Echo $this->MainTabelA();
            
        }
        
        If ($_REQUEST['Act'] == Create) {
            $_SESSION['IdRec'] = $_REQUEST['id'];
            $_SESSION['Class']=$this->class;
            $this->Create('Создание заявления', '');    
        }

        //If ($_REQUEST['Act'] == PrintForm) {
           
            If ($_REQUEST['Action'] == PrintForm) {
            $_SESSION['IdRec'] = $_REQUEST['RecordId'];
            $this->printForm();
            
        }
        
        //To-DO копирование реализаетс локально нужен перевод на ГЛОБАЛЬНЫЙ уровень.
        //If ($_REQUEST['Act'] == 'CopySL') {
        If ($_REQUEST['Action'] == CopyRecord) {
            $_SESSION['IdRec'] = $_REQUEST['id'];
            $this->Create('Новая запись через копирование', $data,1);  
        }

          If ($_REQUEST['Act'] == Historym) {
          $this->Logging($_SESSION['Id_user'], $Id_Razdela=2,$_REQUEST['id'],1000,0,'Просмотр истории');
          $this->history($_REQUEST['id']);
        }
        
       //IF (isset($_POST['CreateBut'])) {
        $this->GLflagCreate=0;
        IF ($_REQUEST['Action'] == 'Create') {    
            $IdRec = $_SESSION['IdRec'];
            $DC = date('Y-m-d');
            $IDU = $_SESSION['Id_user'];
            $FIO = $_POST['FIOZL'];
            $DocRekv = $_POST['RekvDoc'];
            $SNILS = $_POST['Snils'];
            $Deistvie = $_POST['Usluga'];

                $query = "INSERT INTO juresia (FIO, DocRekv, SNILS,DateObr, Deistvie , IdUserCreate)
                 VALUES('$FIO','$DocRekv','$SNILS','$DC','$Deistvie','$IDU')";

            $this->query($query);
            $this->Logging($_SESSION['Id_user'], $Id_Razdela=2,$this->linkId,1,0,'Создано заявление');

        };

    }

    public function Create($Caption, $data,$reg=0) {
        if ($reg==1){
            $z="Select FIO,DocRekv,SNILS from ".$this->table." Where id=".$_REQUEST['RecordId'];
            $res= $this->query($z);
           $res=$res->fetch_assoc();
        }
        $this->TableHeadLocal=array("False");
        $Usluga=$this->getESIA(0,2);

        $data .= ' ФИО обратившегося: <input name="FIOZL" size="50" value="'.$res['FIO'].'" required> </BR>  </BR></p>';
        $data .= ' <p> Реквизиты документа: <input name="RekvDoc" size="15"value="'.$res['DocRekv'].'" required> ';
        $data .= ' СНИЛС: <input name="Snils" size="15"value="'.$res['SNILS'].'" required> </BR>  </BR></p>';
       
        $data .= ' Вид действия(Услуга): <select name="Usluga">';
        foreach ($Usluga as $key=>$value ){
        $data .= ' <option value='.$key.'>'.$value.' </option>';
            }
        $data .= '  </select>'; 
        parent::Create($Caption, $data);
    }

  
}
