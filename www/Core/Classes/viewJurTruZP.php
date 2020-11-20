<?php
class viewJurTruZp extends Jurnals {
    public function __construct() {
        $this->class='viewJurtruzp';
        $this->table='jurtruzp';
        $this->IdForm=5;
        $this->StatusEnd=1;
        $this->TableHead=Array("Id"=>"№п/п", "NamePFR_RO"=>"Наименование ПФР Ростовской области", "NomerKS"=>"Рег № КС",
              "DateKS"=>"Дата КС", "FIO"=>"ФИО застрахованного лица",
              "NamePFR"=>"Наименование ПФР куда запрос", "NomerISXD"=>"Исходящий №","DateISXD"=>"Дата исходящего",
              "IdUserCreate"=>"Сотрудник, инициировавший запрос",
            "DateOtv"=>"Дата ответа",
            "NomerOtv"=>"Номер ответа",
            "Rezult"=>"Результат исполнения запроса"
            );
        parent::__construct();
    }
    
    public function MainContent()
    {
        echo "<script language='javascript'>var module='".$this->class."' </script>";
        echo "<script language='javascript'>var opti='".$this->class."' </script>";
        echo "<Center> <H6> Журнал регистрации запросов  в целях подтверждения заработка </Center> </H6>";
        echo '<ul class="tabs left">
                <li><a href="#tabr1">Запросы</a></li>';
        echo '</ul>';
        Echo ('<div id="tabr1" class="tab-content">');
        $IDU = $_SESSION['Id_user'];
        $Button='';
        $Button .=$this->uiButtonAjax('Create', 'Создать запрос');
        $Button .=$this->uiButtonActionAjax('Rezult', 'Результат запроса');
        echo $Button;
        //echo "<div id='Action1' class='col_3 visible center' style='height: 25px;'> <a  title='Результат запроса'>Результат запроса</a></div>";
        echo '<div id="ContentMainTable">';
       Echo $this->MainTabelA();
        echo '</div>';
    }
  
  private function MainTabelA() {
          If (($_SESSION['Admin']==1) or ($_SESSION['Status']==20)){
              return $this->TablePrototypeNew(Array('Copy','Checked'),'status');
              //return $this->TablePrototype($Res,$this->TableHead,$this->table,$this->class,Array('Copy'));
              }
          Else{return $this->TablePrototype($Res,$this->TableHead,$this->table,$this->class,Array('Copy'));}
  }
    
  
  
  
    protected function obr() {
        $this->GLflagCreate=1;
       
        
        If ($_REQUEST['Action'] == Rezult) {
               $_SESSION['IdRec'] = $_REQUEST['id'];
               $_SESSION['param']=$_REQUEST['sl'];
               $this->Action1();
            }
        
        If ($_REQUEST['Action'] == RezultF) {
            $Dateotv = $_POST['DateOtv'];
            $NomerOtv = $_POST['NomerOtv'];
            $Rezult = $_POST['Rezult'];
            
            foreach($_SESSION['param'] as $RecordId):
                $query=" UPDATE ".$this->table." SET DateOtv='$Dateotv', NomerOtv='$NomerOtv' , Rezult='$Rezult', status=1 Where Id='$RecordId'";
                $this->query($query);
                $this->Logging($_SESSION['Id_user'], $this->IdForm,$RecordId,10,0,'Проставлены результаты на запрос №'.$RecordId);
            endforeach;
            
            }
            
            
            
        If (isset($_REQUEST['sl'])){
            If ($_REQUEST['Act'] == Action1) {
               $_SESSION['IdRec'] = $_REQUEST['id'];
               $_SESSION['param']=$_REQUEST['sl'];
               $this->Action1();
            }
        }
        
        IF (isset($_POST['B1Action1'])) {
            $NNAkt='';
            $query='';
            $DAct = $_POST['DataAkt'];
            $IAct = $_POST['NomAKT'];
            
            foreach($_SESSION['param'] as $product):
                $NNAkt.=$product.' ';
                $query=" UPDATE ".$this->table." SET IdAkt='$IAct', DateAkt='$DAct' Where Id='$product'";
                $this->query($query);
                $this->Logging($_SESSION['Id_user'], $Id_Razdela=3,$product,10,0,'Проставлена дата на акт №'.$product);
            endforeach;

            //$this->Logging($_SESSION['Id_user'], $Id_Razdela=3,$this->linkId,10,0,'Проставлены даты на акты №№'.$NNAkt);
            $this->MainTabelA();
            header("location: /?option=".$this->class);
        }
        
        
        
        If ($_REQUEST['Act'] == UpdCont) {
            Echo $this->MainTabelA();
        }
        
        If ($_REQUEST['Act'] == Create) {
            $_SESSION['IdRec'] = $_REQUEST['id'];
            //$_SESSION['Class']=$this->class;
            $this->Create('Создание запроса', '');    
        }
        
        
        If ($_REQUEST['Action'] == CopyRecord) {
            $_SESSION['IdRec'] = $_REQUEST['id'];
            $this->CopyRecord($Caption,$data);  
        }
        
    }
    
    public function Action1(){
        //include 'scripts_1.php';
        
        $data='';
        $data.=' Дата ответа <input class="KalDates"  name="DateOtv"> </BR>  </BR></p>';
        $data.=' Номер ответа <input name="NomerOtv"> </BR>  </BR></p>';
        $data.=' Результат рассмотрения'.$this->uiTextArea('Rezult');
        $data.="<p><input type='submit' value='Завершить обработку' >";
        
        $this->CreateForm('Результаты запроса', $data, 'RezultF');
    }

    public function Create($Caption, $data,$reg=0) {
        $this->TableHeadLocal=Array( "NamePFR_RO","FIO", "NamePFR", "NomerKS",
              "DateKS", "NomerISXD","DateISXD");
        parent::Create($Caption, $data);      
    }
}
