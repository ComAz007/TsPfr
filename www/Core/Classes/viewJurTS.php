<?php
    
//http://blog.sklazer.com/865.html почитать для просветления!

class viewJurTS extends Jurnals {
    
    public function __construct() {
        $this->class='viewJurTS';
        $this->table='zadacha';
        $this->StatusEnd=2;
        $this->TableHead=Array("Id"=>"№п/п", "Opisanie"=>"Задача",
            "IdUserCreate"=>"Задача создана", "Id_User_Vipoln"=>"Задача назначена",
            "Id_User_Get"=>"Задача принята", "Date_Create"=>"Дата создания задачи", "Date_Set"=>"Дата принятия задачи в работу",
            "Date_Vipl"=>"Дата завершения задачи", "comment"=>"Комментарий");
        parent::__construct();
        
    }

//    private function TableHistory($Res){
//    //`Id`, `DataReg`, `KodReg`, `KodUrLic`, `KodUpfr`, `FIOZL`, `IdUserCreate`, `TypeZapros`, `TypeZaprosId`, `TypeDeistv`, `FileZapr`, `Povtor`, `DatePovtor`, `DateOtveta`, `FileOtv`
//        $str='';
//        // выводим на страницу сайта заголовки HTML-таблицы
//        $str=$str.'<table class="col_12  sortable" cellspacing="0" cellpadding="0">';
//	//echo $col;
//	$str=$str. '<thead><tr class="alt User">';
//        $str=$str. '<th value="User" rel="1">Пользователь</th>';
//        $str=$str. '<th value="Action" rel="2">Действие</th>';
//        $str=$str. '<th value="DateTime" rel="3">Дата/время</th>';
//	$str=$str. '</thead></tr>';
//	$str=$str.'<tbody> <tr class="alt">';
//        
//        while($data = $Res->fetch_row()){ 
//                
//                $str=$str. '<td value="'.GetUserName($data['0']).'" >' . GetUserName($data['0']). '</td>';
//		If($data['4']==6){
//	                $str=$str. '<td value="'.$data['1'].'" >' . $data['1'].': '. GetUserName($data['3']). '</td>';}
//		else
//            {
//	                $str=$str. '<td value="'.$data['1'].'" >' . $data['1']. '</td>';}
//            $str=$str. '<td value="'.$data['2'].'" >' . $data['2'] . '</td>';
//            $str=$str. '</tr>';
//                 
//
//	}
//        
//        $str=$str.'</tbody></table>';
//        //return $str;
//        echo $str;
//}



    public function MainContent(){
        echo "<script language='javascript'>var module='".$this->class."' </script>";
        echo "<script language='javascript'>var opti='".$this->class."' </script>";
        //echo "<Center> <H6> Журнал регистрации начала и конца действия Карточек доступа к ПТК </Center> </H6>";
        echo '<ul class="tabs left">
            <li><a href="#tabr1">Открытые задания</a></li>';
        echo '</ul>';
        Echo ('<div id="tabr1" class="tab-content">');
        $Button='';
        $Button .=$this->UIButtonAjax('Create', 'Создать задачу');
        $Button .=$this->UIButtonAjax('Action1', 'Принять задачу');
        $Button .=$this->UIButtonAjax('Action2', 'Завершить задачу');
        //$this->ButtonAjaxUI('TakeEndTask', 'Принять и завершить задачу');
        $Button .=$this->UIButtonAjax('DeleteRecord', 'Удалить задачу');
        echo $Button;
        echo '<div id="ContentMainTable">';
            Echo $this->MainTabelA();
        echo '</div>';
    }
  
    private function MainTabelA() {
        
        If (($_SESSION['Admin']==1)){
            return $this->TablePrototypeNew(array('Edit', 'Checked'),'Status', ' Status<>2');
        }
        else return $this->TablePrototypeNew(array('Edit', 'Checked'),'Status', ' Status<>2',1);
    }
    
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
    
   
    
    protected function obr() {
        //var_dump($_REQUEST);
        //var_dump($Action);
        If ($_REQUEST['Act'] == UMC) {
            $this->MainContent();
        }
//        
//        If ($_REQUEST['Act'] == UCMT) {
//            Echo $this->MainTabelA();
//        }
        
        
        
        If ($_REQUEST['Act'] == Create) {
            $_SESSION['IdRec'] = $_REQUEST['id'];
            $_SESSION['Class']=$this->class;
            $this->Create('Создание заявки','');    
        }
        
        If (isset($_REQUEST['sl'])){
            If ($_REQUEST['Act'] == Action1) {
               $DTS = date("Y-m-d H:i:s");
               //$IDU = $_SESSION['Id_user'];
               foreach($_REQUEST['sl'] as $product):
                $NNAkt.=$product.' ';
                $query=" UPDATE ".$this->table." SET Date_Set='$DTS',  Status='1', Id_User_Get='".$_SESSION['Id_user']."' Where Id='$product' and Date_Set='0000-00-00 00:00:00'";
                $this->query($query);
                $this->Logging($_SESSION['Id_user'], $Id_Razdela=0,$product,10,0,'Задача № '.$product.' принята');
            endforeach;
            }
            
            If ($_REQUEST['Act'] == Action2) {
                $DTS = date("Y-m-d H:i:s");
                foreach($_REQUEST['sl'] as $product):
                    $query=" UPDATE ".$this->table." SET Date_Vipl='$DTS',  Status='2' Where Id='$product' and Date_Vipl='0000-00-00 00:00:00'";
                    $this->query($query);
                    $this->Logging($_SESSION['Id_user'], $Id_Razdela=0,$product,12,0,'Задача закрыта');
                endforeach;
//                $this->MainTabelA();
//                header("location: /?option=".$this->class);
            }
            //$this->MainTabelA();
            //header("location: /?option=".$this->class);
        }
        
        If ($_REQUEST['Act'] == Edit) {
            $_SESSION['IdRec'] = $_REQUEST['id'];
            $this->Edit('Изменение задачи/заявки','');    
        }
        
        If ($_REQUEST['Action'] == EditRecord) {
            //$_SESSION['IdRec'] = $_REQUEST['id'];
            $_SESSION['IdRec'] = $_REQUEST['RecordId'];
            $this->Edit('Изменение задачи/заявки','');    
        }
       
        
        
        If ($_REQUEST['Act'] == 'CopySL') {
            $_SESSION['IdRec'] = $_REQUEST['id'];
            $this->Create(1);  
        }
     
 
       
        
//        IF (isset($_POST['B1Action1'])) {
//            $NNAkt='';
//            $query='';
//            $DAct = $_POST['DataAkt'];
//            $IAct = $_POST['NomAKT'];
//            
//            foreach($_SESSION['param'] as $product):
//                $NNAkt.=$product.' ';
//                $query=" UPDATE ".$this->table." SET IdAkt='$IAct', DateAkt='$DAct' Where Id='$product'";
//                $this->query($query);
//                $this->Logging($_SESSION['Id_user'], $Id_Razdela=3,$product,10,0,'Проставлена дата на акт №'.$product);
//            endforeach;
//
//            //$this->Logging($_SESSION['Id_user'], $Id_Razdela=3,$this->linkId,10,0,'Проставлены даты на акты №№'.$NNAkt);
//            //$this->MainTabelA();
//            header("location: /?option=".$this->class);
//        }

        
        //IF (isset($_POST['SaveButton'])) {
         IF ($_REQUEST['Action'] == 'Edit') {
            
             //$_SESSION['IdRec'] = $_REQUEST['id'];       
             //var_dump($_REQUEST['id']);
            $Zadacha=htmlspecialchars($_POST['Opisanie']);
  $UserId=htmlspecialchars($_POST['UserId']);
  $Comments=htmlspecialchars($_POST['comment']);
  //$Id=htmlspecialchars( $_POST['id']);
  If ($_SESSION['Status']==1)
  {
    If (isset($_POST['UserId']))
    {
       $UserId=htmlspecialchars($_POST['UserId']);
       If ($UserId==0)
        {
           $UserId=$_SESSION['Id_user'];
        }
     }  
  }
  //SetIzm_Zadan($Id,$Zadacha,$Comments);
            
            
            
            
            
            //$DAct = $_POST['DataAkt'];
            $query=" UPDATE ".$this->table." SET Opisanie='$Zadacha', comment='$Comments' Where Id=".$_SESSION['IdRec'];
           
            $this->query($query);
            $this->Logging($_SESSION['Id_user'], $Id_Razdela=0,$_SESSION['IdRec'],11,0,'Изменение задачи');
            $this->MainTabelA();
            //header("location: /?option=".$this->class);
        }
       
        $this->GLflagCreate=0;
       //IF (isset($_POST['CreateButton'])) {
       IF ($_REQUEST['Action'] == 'Create') {
            $Zadacha=htmlspecialchars($_POST['Opisanie']);
            $OtvUserId=htmlspecialchars($_POST['SpisSTS']);
            $DTS = date("Y-m-d H:i:s");
            $UserId = $_SESSION['Id_user'];
            If ($_SESSION['Status']==1)
                {
                    If (isset($_POST['UserId']))
                    {
                        $UserId=htmlspecialchars($_POST['UserId']);
                        If ($UserId==0)
                            {
                              $UserId=$_SESSION['Id_user'];
                            }
                    }
                }
            //RegZadan($Zadacha,$UserId,$OtvUserId,date("Y-m-d H:i:s"));
            $query = "INSERT INTO ".$this->table." (Opisanie,IdUserCreate, Id_User_Vipoln, Date_Create,Status)
                      VALUES('$Zadacha', '".$UserId."','$OtvUserId','$DTS','0')";
            $this->query($query);
            $this->Logging($_SESSION['Id_user'], $Id_Razdela=0,$this->linkId,1,0,'Создана задача');
            //$this->MainTabelA();
            mail("071-040-0802", iconv('utf-8','windows-1251', "Новая задача в ТС"), iconv('utf-8','windows-1251', "Новая задача в ТС"));
            //TO-DO возвращение к старому ИПО пока не понятно как реализовать апдейт при нажатии клавиши создать!!!
            //$this->MainContent();
           // include 'scripts.php';
            //header("location: /?option=viewJurTS");
            //header("location: /?option=".$this->class);
            
        };
    }

    public function Create($Caption,$data) {
       //echo $_SESSION['Class'];
        $this->TableHeadLocal=array("Opisanie");
                        $data .='<div class="col_3 visible">Кому заявка:';
                        $data .= selected(SetSpisok("Select Id, FIO From User Where Status=1"), 'SpisSTS','',0);
                        $data .= '</div>';
                        If ($_SESSION['Status']==1) 
                        {
                        $data .= '<div class="col_3 visible">От кого заявка:';
                        $data .= selected(SetSpisok("Select Id, FIO From User"), 'UserId','',0);
                        $data .= '</div> </BR> </BR> </BR> </BR>';
                        }
          parent::Create($Caption, $data);
    }

    
    public function Action1(){
        
        Echo "<Div class=grid>"; 
        Echo '<div id="dialog" title="Включение карточек в АКТ">';
        Echo "<form enctype='multipart/form-data' action='' method='Post'>";
        Echo ' Номер Акта <input name="NomAKT"> </BR>  </BR></p>';
        Echo ' Дата Акта <input class="KalDates"  name="DataAkt"> </BR>  </BR></p>';
        Echo "<p><input type='submit' name='B1Action1' value='Включить в АКТ' >";
        Echo '</form>';
        Echo '</Div>';
        Echo '</Div>';
    }
    
    protected function Edit($Caption,$data){
              $this->TableHeadLocal=array("Opisanie","comment"); //это тупо баг!!! суть в том, что массив не пустой но при этом и полей нужных нет!
              //$this->TableHeadLocal=array("false"); //это тупо баг!!! суть в том, что массив не пустой но при этом и полей нужных нет!
//            $SData=$data;
//            $Zapros="select Opisanie, Comment from zadacha Where zadacha.Id=".$_SESSION['IdRec'];
//            $result=SetSpisok($Zapros);
//            $data = $result->fetch_row();
//            If ($_SESSION['Id_user']==$data['2'] or $_SESSION['Admin']==1){
//                $SData .= $this->UILabel('Задача');
//                $SData .= $this->UITextArea('Opisanie', $data['0']);

//            }
//            $SData .= '<br/> <br/>';
//            $SData .= $this->UILabel('Комментарий');
//            $SData .= $this->UITextArea('comments', $data['1']);

        parent::Edit($Caption, $SData);
    }
  
}
