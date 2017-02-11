<?php
    
//http://blog.sklazer.com/865.html почитать для просветления!

class viewJurTechnical extends Technical {
    
   
    
    //private $Class='viewJurTechnical';
    //private $table='JurTechnical';
    
    public function __construct() {
        $this->class='viewJurTechnical';
        $this->table='JurTechnical';
        $this->head=Array("Id"=>"№п/п", "InvNom"=>"Инвентарный №",
          "Type"=>"Тип","Name"=>"Наименование, модель",
          "Deistvie"=>"Дейсвтие с техникой",
              "Datedeistv"=>"Дата", "Opisanie"=>"Краткое описание действия",
              "IdUserCreate"=>"Сотрудник внесший запись");
        
        $this->TableHead=Array("Id"=>"№п/п", "InvNom"=>"Инвентарный №",
          "Type"=>"Тип","Name"=>"Наименование, модель",
          "Deistvie"=>"Дейсвтие с техникой",
              "Datedeistv"=>"Дата", "Opisanie"=>"Краткое описание действия",
              "IdUserCreate"=>"Сотрудник внесший запись");
        
        
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

  public function MainContent()
  {
        //var_dump($this->GetStructTable($this->table));
         echo "<script language='javascript'>var opti='".$this->class."' </script>";
        // $this->SupperArray();
        // var_dump($this->TableHeadLocal);
        echo "<Center> <H6> Журнал  движения, обслуживания и ремонта техники</Center> </H6>";
        echo '<ul class="tabs left">
                <li><a href="#tabr1">Заявления</a></li>';
        echo '</ul>';
        
        Echo ('<div id="tabr1" class="tab-content">');
        $IDU = $_SESSION['Id_user'];
        echo "<div class='col_3 visible center' style='height: 25px;'> <a id='Create' title='Создать запись'>Создать запись</a></div>";
        //echo "<div class='col_3 visible center' id='Create' style='height: 25px;'> <a href='?option=viewJurEsia&Act=Create' title='Создать заявление'>Создать заявление</a></div>";
        echo '<div id="content">';
       Echo $this->MainTabelA();
        echo '</div>';
        //echo "<div class='col_3 visible center ' style='height: 25px;'> <a class='FormMini fancybox.ajax' href='?option=viewJurVipnet&Act=PZ'>Принять запрос</a></div>";
        //echo "<div class='col_3 visible center' style='height: 25px;'> <a href='?option=viewJurEsia&Act=PrintForm'>Print(test)</a></div>";
        //echo "<div class='col_3 visible center fik' style='height: 25px;'> <a href='#'>Фиктивный запрос</a></div>";
        //echo "<div class='col_3 visible center' style='height: 25px;'> <a href='?option=Statistics'>СТАТИСТИКА</a></div>";
        
//        If (($_SESSION['Admin']==1) or ($_SESSION['Status']==21))
//         {
//            $query="SELECT Id,DataReg,KodReg,KodUrLic,KodUpfr,FIOZL,IdUserCreate,TypeZapros,TypeDeistv,ZR,Povtor,DatePovtor,DateOtveta,Napravl,Otvetstv,SpNap,Kontrol FROM jurvipnetzapros Where DateOtveta is NULL Order By Id DESC LIMIT 20";             
//         }
//         
//        If ($_SESSION['Status']==20) 
//         {
//           $query="SELECT Id,DataReg,KodReg,KodUrLic,KodUpfr,FIOZL,IdUserCreate,TypeZapros,TypeDeistv,ZR,Povtor,DatePovtor,DateOtveta,Napravl,Otvetstv,SpNap,Kontrol FROM jurvipnetzapros Where ( (IdUserCreate='$IDU')  or  (Otvetstv='$IDU') ) and (DateOtveta is NULL)  Order By Id DESC LIMIT 20";             
//         }
//
//
//         If ($_SESSION['Status']==0)
//         {
//            $query="SELECT Id,DataReg,KodReg,KodUrLic,KodUpfr,FIOZL,IdUserCreate,TypeZapros,TypeDeistv,ZR,Povtor,DatePovtor,DateOtveta,Napravl,Otvetstv,SpNap FROM jurvipnetzapros Where (IdUserCreate='$IDU') and (DateOtveta is NULL) Order By Id DESC LIMIT 20";
//         }
//
//         If ($_SESSION['Status']==22)
//         {
//            $query="SELECT Id,DataReg,KodReg,KodUrLic,KodUpfr,FIOZL,IdUserCreate,TypeZapros,TypeDeistv,ZR,Povtor,DatePovtor,DateOtveta,Napravl,Otvetstv,SpNap FROM jurvipnetzapros Where (IdUserCreate='$IDU') and (Otvetstv=0) Order By Id DESC LIMIT 20"; 
//         }
//        $Res= $this->query($query);
//        
//        
//         If ($Res<>NULL){
          
   
//   If ($_SESSION['Status']==20) 
//         {
//   Echo ('<div id="tabr3" class="tab-content">');
//$Otd=$_SESSION['IdOtd'];
//   $query="SELECT jurvipnetzapros.Id,DataReg,KodReg,KodUrLic,KodUpfr,FIOZL,IdUserCreate,TypeZapros,TypeDeistv,ZR,Povtor,DatePovtor,DateOtveta,Napravl,Otvetstv,SpNap,Kontrol FROM jurvipnetzapros, user Where  (DateOtveta is NULL)  and (user.Id_Otdel='$Otd') and (jurvipnetzapros.IdUserCreate=user.id) Order By Id DESC LIMIT 100";             
//   //$query="SELECT Id,DataReg,KodReg,KodUrLic,KodUpfr,FIOZL,IdUserCreate,TypeZapros,TypeDeistv,ZR,Povtor,DatePovtor,DateOtveta,Napravl,Otvetstv,SpNap FROM jurvipnetzapros Where DateOtveta is NOT NULL Order By DateOtveta DESC";             
//   $Res=$this->query($query);
//   $this->Table($Res,0);
//   Echo '</div>';
//   }
//   
//   Echo ('<div id="tabr1" class="tab-content">');
//   $query="SELECT Id,DataReg,KodReg,KodUrLic,KodUpfr,FIOZL,IdUserCreate,TypeZapros,TypeDeistv,ZR,Povtor,DatePovtor,DateOtveta,Napravl,Otvetstv,SpNap FROM jurvipnetzapros Where DateOtveta is NOT NULL Order By DateOtveta DESC";             
//   $Res=$this->query($query);
//   $this->Table($Res,1);
//   Echo '</div>';
   
        
     
  }
  
  private function MainTabelA() {
      
          If (($_SESSION['Admin']==1) or ($_SESSION['Status']==20)){
              return $this->TablePrototype($Res,$this->head,$this->table,$this->class);
              }
          Else{return $this->TablePrototype($Res,$this->head,$this->table,$this->class,1);}
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

        Echo '<div id="dialog" title="История обработки Запроса">';
        Echo "<form enctype='multipart/form-data' action='?option=viewJurVipnet' method='Post'>";
        $query="SELECT Id_User,Action,Times,Id_rezerv,id_action FROM logged WHERE Id_Record=$id order by Times desc";
        $Res= $this->query($query);
        $Head=array("Пользователь","Действие","Дата/время");
        //$this->TablePrototype($Res, $Head, 1, 0);
        $this->TableHistory($Res);
      
        Echo "<p><input type='submit' name='HistoryClose' value='Закрыть' >";
        Echo "</form>";
        Echo '</div>';
 
    }
    

       private function printForm() {
           include 'Header.php';
          echo "<div class='col_3 visible NoPrint center' style='height: 25px;'> <a href='?option=viewJurEsia'>Закрыть форму(возврат в журнал)</a><br></div>";
       Echo '<BR> <BR> <div  class="col_12 center" style="font-size:15px; text-align:center; ">'
           .'
               ЗАЯВЛЕНИЕ № '.$_SESSION['IdRec'].'</BR >
            на регистрацию, подтверждение, удаление, восстановление доступа к учетной 
            записи пользователя в Единой системе идентификации и аутентификации 
            в инфраструктуре, обеспечивающей информационно-технологическое взаимодействие 
            информационных систем, используемых для предоставления государственных и муниципальных услуг 
            в электронной форме </div>';
       $query='SELECT * FROM juresia WHERE Id='.$_SESSION['IdRec'];
           
       $Res= $this->query($query,1);
       $data = $Res->fetch_assoc();
       
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
        
        If ($_REQUEST['Act'] == Create) {
            $this->Create('Создать запись','');
        }
        
        If ($_REQUEST['Act'] == PrintForm) {
            $_SESSION['IdRec'] = $_REQUEST['id'];
            $this->printForm();
        }
        
        If ($_REQUEST['Act'] == Edit) {
            $_SESSION['IdRec'] = $_REQUEST['id'];
            $this->Edit('Редактировать', $data);
        }
        
        If ($_REQUEST['Act'] == Update) {
            $this->MainTabelA();
        }
        
//        IF (isset($_POST['CreateButton'])) {
//            
//            $IdRec = $_SESSION['IdRec'];
//            $DC = date('Y-m-d');
//            $IDU = $_SESSION['Id_user'];
//            $FIO = $_POST['FIOZL'];
//            $DocRekv = $_POST['RekvDoc'];
//            $SNILS = $_POST['Snils'];
//            $Deistvie = $_POST['Usluga'];
//
//                $query = "INSERT INTO juresia (FIO, DocRekv, SNILS,DateObr, Deistvie , IdUserCreate)
//                 VALUES('$FIO','$DocRekv','$SNILS','$DC','$Deistvie','$IDU')";
//
//                
//            
//            //var_dump($query);
//            $this->query($query);
//            $this->Logging($_SESSION['Id_user'], $Id_Razdela=2,$this->linkId,1,0,'Создано заявление');
//            
//            
//          // header("location: /?option=viewJurEsia");
//        };
        
        //unset($_REQUEST);
        
    }
    
    public function Edit($Caption, $data) {
        $this->TableHeadLocal=array("InvNom","Name");
        parent::Edit($Caption, $data);
    }

    public function Create($Caption,$data) {
        $this->TableHeadLocal=array("InvNom","Name");
        parent::Create($Caption, $data);
        //echo "<div class='col_3 visible center' style='height: 25px;'> <a href='?option=viewJurVipnet&Action=Create' title='Создать'>Сохранить</a></div> </Br></Br></Br>";
    }

  
}
