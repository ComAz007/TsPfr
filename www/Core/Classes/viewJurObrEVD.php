<?php
class viewJurObrEVD extends Jurnals {
    public function __construct() {
        $this->class='viewJurObrEVD';
        $this->table='JurObrEVD';
        $this->IdForm=5;
        $this->StatusEnd=2;
        $this->TableHead=Array("Id"=>"№п/п", "FIO"=>"Фамилия Имя Отчество",
              "DateKS"=>"Дата загрузки в КС", "DateNVP"=>"Дата загрузки в НВП","region"=>"Регион прибытия");
        parent::__construct();
    }
    
    public function MainContent()
    {
        echo "<script language='javascript'>var module='".$this->class."' </script>";
        echo "<script language='javascript'>var opti='".$this->class."' </script>";
        echo "<Center> <H6> Журнал обработки запросов загрузки входящих ЭВД</Center> </H6>";
        echo '<ul class="tabs left">
                <li><a href="#tabr1">Запросы</a></li>';
        echo '</ul>';
        Echo ('<div id="tabr1" class="tab-content">');
        $IDU = $_SESSION['Id_user'];
        $Button='';
        $Button .=$this->UIButtonAjax('Create', 'Создать ЭВД');
        $Button .=$this->UIButtonAjax('Action1', 'Загружен КС');
        $Button .=$this->UIButtonAjax('Action2', 'Загружен НВП');
        $Button .=$this->UIButtonAjax('ObrabotkaEnd', 'Обработка завершена');
        echo $Button;
        echo '<div id="ContentMainTable">';
       Echo $this->MainTabelA();
        echo '</div>';
    }
  
  private function MainTabelA() {
          //If (($_SESSION['Admin']==1) or ($_SESSION['Status']==20)){
              return $this->TablePrototypeNew(array('Copy','Checked'),'status');
              //return $this->TablePrototype($Res,$this->TableHead,$this->table,$this->class,Array('Copy'));
              //}
          //Else{return $this->TablePrototype($Res,$this->TableHead,$this->table,$this->class,Array('Copy'));}
  }
    
    protected function obr() {
        $this->GLflagCreate=1;
        
         If (isset($_REQUEST['sl'])){
            If ($_REQUEST['Act'] == Action1) {
               $DTS = date("Y-m-d H:i:s");
               //$IDU = $_SESSION['Id_user'];
               foreach($_REQUEST['sl'] as $recordID):
                $NNAkt.=$product.' ';
                $query="UPDATE ".$this->table." SET DateKS='$DTS' Where Id='$recordID'";
                $this->query($query);
                $this->Logging($_SESSION['Id_user'], $this->IdForm,$recordID,10,0,'ЭВД загружен в КС ');
            endforeach;
            }
            
            If ($_REQUEST['Act'] == Action2) {
               $DTS = date("Y-m-d H:i:s");
               //$IDU = $_SESSION['Id_user'];
               foreach($_REQUEST['sl'] as $recordID):
                $NNAkt.=$product.' ';
                $query="UPDATE ".$this->table." SET DateNVP='$DTS' Where Id='$recordID'";
                $this->query($query);
                $this->Logging($_SESSION['Id_user'], $this->IdForm,$recordID,10,0,'ЭВД загружен в НВП');
            endforeach;
            }
            
            If ($_REQUEST['Action'] == OBE) {
               $DTS = date("Y-m-d H:i:s");
               //$IDU = $_SESSION['Id_user'];
               foreach($_REQUEST['sl'] as $recordID):
                $NNAkt.=$product.' ';
                $query="UPDATE ".$this->table." SET Status=".$this->StatusEnd." Where Id='$recordID'";
                $this->query($query);
                $this->Logging($_SESSION['Id_user'], $this->IdForm,$recordID,8,0,'Обработка заврешена');
            endforeach;
            }
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

    public function Create($Caption, $data,$reg=0) {
        $this->TableHeadLocal=Array("FIO","Region");
        $Oblast=$this->getRegion(0,2);
        $data.='Регион прибытия: <select name="region">';
        foreach ($Oblast as $key=>$value ){
            $data.=' <option value='.$key.'>'.$value.' </option>';
        }
        $data.='  </select> </BR>  </BR></p>';
        
        parent::Create($Caption, $data);      
    }
}
